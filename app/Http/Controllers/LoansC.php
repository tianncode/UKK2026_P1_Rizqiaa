<?php

namespace App\Http\Controllers;

use App\Models\ActivityLogs;
use App\Models\Loans;
use App\Models\Returns;
use App\Models\Tools;
use App\Models\ToolUnits;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoansC extends Controller
{
  public function index()
  {
    // data loan
    $loans = Loans::with(['tool', 'user'])->latest()->get();

    // hanya tool single
    $singleTools = Tools::where('item_type', 'single')
      ->with('units')
      ->get();

    // data user
    $users = User::all();

    return view('management-loans.tabel', compact(
      'loans',
      'singleTools',
      'users'
    ));
  }

  public function create($toolId)
  {
    // Get tool dengan semua relasi
    $tool = Tools::with([
      'category',
      'bundleItems.tools',
      'units.conditions',
      'units.tool'
    ])->findOrFail($toolId);

    // Get data returns untuk dropdown
    $returns = Returns::latest()->get();

    return view('management-loans.form', compact('tool', 'returns'));
  }

  public function store(Request $request)
  {
    // ── 1. Validasi ──────────────────────────────────────────────────────
    $validated = $request->validate([
      'tool_id'    => ['required', 'integer', 'exists:tools,id'],
      'unit_code'  => ['required', 'string', 'exists:tool_units,code'],
      'loan_date'  => ['required', 'date', 'after_or_equal:today'],
      'due_date'   => ['required', 'date', 'after:loan_date'],
      'purpose'    => ['required', 'string', 'min:10', 'max:1000'],
      'notes'      => ['nullable', 'string', 'max:1000'],
    ]);

    $user = Auth::user();

    // ── 2. Cek apakah user diblokir ──────────────────────────────────────
    if ($user->is_restricted) {
      return back()
        ->withInput()
        ->with('error', 'Akun Anda sedang dibatasi. Selesaikan pelanggaran aktif terlebih dahulu.');
    }

    // ── 3. Cek ulang ketersediaan unit (guard dari race-condition) ────────
    $unitBusy = Loans::where('unit_code', $validated['unit_code'])
      ->conflictingDates($validated['loan_date'], $validated['due_date'])
      ->exists();

    if ($unitBusy) {
      return back()
        ->withInput()
        ->with('error', 'Unit yang Anda pilih baru saja dipinjam oleh pengguna lain. Silakan pilih unit lain atau ubah tanggal.');
    }

    // Pastikan unit yang dipilih benar-benar milik tool yang dimaksud
    $unit = ToolUnits::where('code', $validated['unit_code'])
      ->where('tool_id', $validated['tool_id'])
      ->where('status', ToolUnits::STATUS_AVAILABLE)
      ->firstOrFail();

    // ── 4. Simpan dalam transaksi ─────────────────────────────────────────
    $loan = DB::transaction(function () use ($validated, $user) {
      return Loans::create([
        'user_id'   => $user->id,
        'tool_id'   => $validated['tool_id'],
        'unit_code' => $validated['unit_code'],
        'loan_date' => $validated['loan_date'],
        'due_date'  => $validated['due_date'],
        'purpose'   => $validated['purpose'],
        'notes'     => $validated['notes'] ?? null,
        'status'    => Loans::STATUS_PENDING,
        // loan_code di-generate otomatis via model booted()
      ]);
    });

    // ── 5. Log aktivitas ──────────────────────────────────────────────────
    ActivityLogs::create([
      'user_id'     => $user->id,
      'action'      => 'create',
      'module'      => 'loans',
      'description' => "Mengajukan peminjaman alat #{$validated['tool_id']} (unit: {$validated['unit_code']})",
      'meta'        => json_encode(['loan_id' => $loan->id, 'loan_code' => $loan->loan_code]),
      'ip_address'  => $request->ip(),
    ]);

    // ── 6. Redirect ───────────────────────────────────────────────────────
    return redirect()
      ->route('loans.show', $loan)
      ->with('success', "Pengajuan peminjaman <strong>{$loan->loan_code}</strong> berhasil dikirim. Tunggu konfirmasi dari petugas.");
  }

  public function cancel(Loans $loan)
  {
    abort_unless($loan->user_id === Auth::id(), 403);
    abort_unless($loan->status === Loans::STATUS_PENDING, 422, 'Hanya peminjaman berstatus pending yang dapat dibatalkan.');

    $loan->update(['status' => Loans::STATUS_CANCELLED]);

    ActivityLogs::create([
      'user_id'     => Auth::id(),
      'action'      => 'cancel',
      'module'      => 'loans',
      'description' => "Membatalkan peminjaman {$loan->loan_code}",
      'ip_address'  => request()->ip(),
    ]);

    return back()->with('success', 'Peminjaman berhasil dibatalkan.');
  }

  public function monitoring(Request $request)
  {
    // ── Statistik ─────────────────────────────────────────────────────
    $stats = [
      'total'    => Loans::count(),
      'pending'  => Loans::where('status', 'pending')->count(),
      'approved' => Loans::where('status', 'approved')->count(),
      'returned' => Loans::where('status', 'returned')->count(),
      'rejected' => Loans::where('status', 'rejected')->count(),
      'canceled' => Loans::where('status', 'canceled')->count(),
      'overdue'  => Loans::where('status', 'approved')
        ->where('due_date', '<', Carbon::today())
        ->count(),
    ];

    // ── Query dengan filter ───────────────────────────────────────────
    $query = Loans::with(['tool', 'user.detail'])->latest();

    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('loan_code', 'like', "%{$search}%")
          ->orWhereHas(
            'user.detail',
            fn($q) =>
            $q->where('name', 'like', "%{$search}%")
          );
      });
    }

    if ($request->filled('date_from')) {
      $query->whereDate('loan_date', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
      $query->whereDate('loan_date', '<=', $request->date_to);
    }

    $loans = $query->paginate(15)->withQueryString();

    // ── Loan terlambat (5 teratas untuk alert) ────────────────────────
    $overdueLoans = Loans::with(['user.detail', 'tool'])
      ->where('status', 'approved')
      ->where('due_date', '<', Carbon::today())
      ->orderBy('due_date')
      ->take(5)
      ->get();

    return view('management-loans.monitoring', compact('stats', 'loans', 'overdueLoans'));
  }

  // ── Method approve ────────────────────────────────────────────────────────
  public function approve(Request $request, $id)
  {
    $loan = Loans::where('status', 'pending')->findOrFail($id);
    $loan->update([
      'status'      => 'approved',
      'employee_id' => Auth::id(),
    ]);

    // ← Update status unit menjadi borrowed
    ToolUnits::where('id', $loan->tool_id)
      ->update(['status' => 'borrowed']);

    return redirect()->back()->with('success', "Peminjaman #{$loan->loan_code} berhasil di-approve.");
  }

  // ── Method reject ─────────────────────────────────────────────────────────
  public function reject(Request $request, $id)
  {
    $request->validate(['notes' => 'nullable|string|max:500']);
    $loan = Loans::where('status', 'pending')->findOrFail($id);
    $loan->update([
      'status'      => 'rejected',
      'employee_id' => Auth::id(),
      'notes'       => $request->notes,
    ]);

    // Saat returned/canceled → kembalikan unit ke available
    ToolUnits::where('id', $loan->tool_id)
      ->update(['status' => 'available']);

    return redirect()->back()->with('success', "Peminjaman #{$loan->loan_code} ditolak.");
  }

  public function show()
  {
    $loans = Loans::with(['tool', 'user'])
      ->where('user_id', Auth::id())
      ->latest()
      ->first();


    return view('management-loans.show', compact('loans'));
  }
}
