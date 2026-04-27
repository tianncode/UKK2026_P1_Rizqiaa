<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use App\Models\Returns;
use App\Models\ToolUnits;
use App\Models\UnitConditions;
use App\Models\Violations;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReturnC extends Controller
{
  public function index(Request $request)
  {
    $query = Loans::with(['user', 'unit.tool'])
      ->where('status', 'pending_return');

    if ($request->search) {
      $query->where(function ($q) use ($request) {
        $q->where('loan_code', 'like', "%{$request->search}%")
          ->orWhereHas(
            'user',
            fn($u) =>
            $u->where('email', 'like', "%{$request->search}%")
          );
      });
    }

    $loans = $query->latest()->paginate(10);

    $overdueLoans = Loans::with(['user', 'toolUnit.tool'])
      ->where('status', 'approved')
      ->whereDate('due_date', '<', now())
      ->get();

    $stats = [
      'total' => Loans::count(),

      'pending' => Loans::where('status', 'pending')->count(),

      'verified' => Loans::where('status', 'returned')->count(), // atau 'approved' sesuai alur kamu

      'late' => Loans::where('status', 'approved')
        ->whereDate('due_date', '<', now())
        ->count(),
    ];

    $returns = Returns::with([
      'loan.user.detail',
      'loan.tool',
      'unitConditions'
    ])
      ->latest()
      ->paginate(10);

    return view('management-return.monitoring', compact('loans', 'overdueLoans', 'stats', 'returns'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'loan_id' => ['required', 'integer', 'exists:loans,id', function ($attribute, $value, $fail) {
        $loan = Loans::where('id', $value)
          ->where('user_id', Auth::id())
          ->where('status', 'approved')
          ->first();
        if (!$loan) {
          $fail('Pinjaman tidak ditemukan, bukan milik Anda, atau belum berstatus disetujui.');
        }
      }],
      'notes'   => 'nullable|string|max:500',
    ]);

    $loan = Loans::findOrFail($request->loan_id);

    // update status → pending
    $loan->update([
      'status' => 'pending_return',
      'notes'  => $request->notes,
    ]);

    Returns::create([
      'loan_id'     => $loan->id,
      'employee_id' => $loan->employee_id,
      'return_date' => now(),
      'notes'       => $request->notes,
    ]);

    return back()->with('success', 'Pengajuan pengembalian berhasil dikirim.');
  }

  public function show()
  {
    $loans = Loans::with(['tool', 'user', 'unit'])
      ->where('user_id', Auth::id())
      ->whereIn('status', ['approved', 'pending_return'])
      ->latest()
      ->first();

    // Ambil loan terakhir yang returned untuk cek violation
    $lastReturn = Loans::with(['violations', 'return.unitConditions'])
      ->where('user_id', Auth::id())
      ->where('status', 'returned')
      ->latest()
      ->first();

    $lateDays = 0;
    $timeLeft = null;

    if ($loans) {
      $now     = Carbon::now();
      $dueDate = Carbon::parse($loans->due_date);

      if ($now->gt($dueDate)) {
        $lateDays = $now->diffInDays($dueDate);
        $timeLeft = "Terlambat {$lateDays} hari";
      } else {
        $diff  = $now->diff($dueDate);
        $parts = [];
        if ($diff->d > 0) $parts[] = $diff->d . ' hari';
        if ($diff->h > 0) $parts[] = $diff->h . ' jam';
        if ($diff->i > 0 && $diff->d == 0) $parts[] = $diff->i . ' menit';
        $timeLeft = implode(' ', $parts);
      }
    }

    return view('management-return.show', compact('loans', 'lateDays', 'timeLeft', 'lastReturn'));
  }

  public function process(Request $request, Loans $loan)
  {
    $request->validate([
      'return_date'     => 'required|date',
      'condition'       => 'required|in:good,damaged,lost',
      'condition_notes' => 'nullable|string|max:500',
      'return_notes'    => 'nullable|string|max:500',
    ]);

    $condition  = $request->input('condition');
    $dueDate    = Carbon::parse($loan->due_date);
    $returnDate = Carbon::parse($request->return_date);
    $lateDays   = $returnDate->gt($dueDate) ? $returnDate->diffInDays($dueDate) : 0;

    $return = Returns::where('loan_id', $loan->id)->firstOrFail();

    $return->update([
      'employee_id' => auth()->id(),
      'return_date' => $request->return_date,
      'late_days'   => $lateDays,
      'notes'       => $request->return_notes,
    ]);

    UnitConditions::create([
      'unit_code'   => $loan->unit_code,
      'return_id'   => $return->id,
      'conditions'  => $condition,
      'notes'       => $request->condition_notes,
      'recorded_at' => now(),
    ]);

    if ($lateDays > 0) {
      Violations::create([
        'loan_id'     => $loan->id,
        'user_id'     => $loan->user_id,
        'return_id'   => $return->id,
        'type'        => 'late',
        'points'      => $lateDays * 5,
        'days_late'   => $lateDays,
        'description' => "Terlambat {$lateDays} hari",
        'status'      => 'pending',
      ]);
    }

    if (in_array($condition, ['damaged', 'lost'])) {
      Violations::create([
        'loan_id'     => $loan->id,
        'user_id'     => $loan->user_id,
        'return_id'   => $return->id,
        'type'        => $condition, // ⬅️
        'points'      => $condition === 'lost' ? 50 : 20,
        'days_late'   => 0,
        'description' => $request->condition_notes,
        'status'      => 'pending',
      ]);
    }

    $loan->update(['status' => 'returned']);

    ToolUnits::where('code', $loan->unit_code)
      ->update(['status' => 'available', 'lost']);

    return redirect()->route('return.index')
      ->with('success', 'Pengembalian berhasil diproses!');
  }

  public function verify(Request $request, Returns $return)
  {
    $request->validate([
      'condition'        => 'required|in:good,damaged,lost',
      'notes'            => 'nullable|string|max:500',
      'violation_points' => 'nullable|integer|min:1|max:100',
    ]);

    $condition  = $request->input('condition');
    $loan       = $return->loan;
    $dueDate    = Carbon::parse($loan->due_date);
    $returnDate = Carbon::parse($return->return_date);
    $lateDays   = $returnDate->gt($dueDate) ? $returnDate->diffInDays($dueDate) : 0;

    // Update late_days & employee yang memverifikasi
    $return->update([
      'employee_id' => auth()->id(),
      'late_days'   => $lateDays,
      'notes'       => $request->notes,
    ]);

    // Catat kondisi unit
    UnitConditions::create([
      'unit_code'   => $loan->unit_code,
      'return_id'   => $return->id,
      'conditions'  => match ($condition) {
        'damaged' => 'broken',
        'lost'    => 'lost',
        default   => 'good',
      },
      'notes'       => $request->notes,
      'recorded_at' => now(),
    ]);

    // Violation: terlambat
    if ($lateDays > 0) {
      Violations::create([
        'loan_id'     => $loan->id,
        'user_id'     => $loan->user_id,
        'return_id'   => $return->id,
        'type'        => 'late_return',
        'points'      => $lateDays * 5,
        'days_late'   => $lateDays,
        'description' => "Terlambat {$lateDays} hari",
        'status'      => 'pending',
      ]);
    }

    // Violation: kondisi rusak / hilang
    if (in_array($condition, ['damaged', 'lost'])) {
      Violations::create([
        'loan_id'     => $loan->id,
        'user_id'     => $loan->user_id,
        'return_id'   => $return->id,
        'type'        => $condition === 'damaged' ? 'damage' : 'loss',
        'points'      => $request->violation_points ?? ($condition === 'lost' ? 50 : 20),
        'days_late'   => 0,
        'description' => $request->notes,
        'status'      => 'pending',
      ]);
    }

    // Selesaikan loan & kembalikan unit ke available
    $loan->update(['status' => 'returned']);

    ToolUnits::where('code', $loan->unit_code)
      ->update(['status' => $condition === 'lost' ? 'lost' : 'available']);

    return back()->with('success', 'Pengembalian berhasil diverifikasi.');
  }
}
