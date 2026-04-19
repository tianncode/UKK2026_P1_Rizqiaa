<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use App\Models\Returns;
use App\Models\Violations;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ReportC extends Controller
{
  // ═══════════════════════════════════════════
  // INDEX — Satu halaman dengan tab per laporan
  // ═══════════════════════════════════════════
  public function index(Request $request)
  {
    $activeTab = $request->get('tab', 'loans');

    // ── Stats global (untuk summary card atas) ──
    $dateFrom = $request->date_from ? Carbon::parse($request->date_from)->startOfDay() : null;
    $dateTo   = $request->date_to   ? Carbon::parse($request->date_to)->endOfDay()     : null;

    $stats = [
      'total_loans'      => Loans::when($dateFrom, fn($q) => $q->whereDate('loan_date', '>=', $dateFrom))
        ->when($dateTo,   fn($q) => $q->whereDate('loan_date', '<=', $dateTo))
        ->count(),
      'total_returned'   => Loans::where('status', 'returned')
        ->when($dateFrom, fn($q) => $q->whereDate('loan_date', '>=', $dateFrom))
        ->when($dateTo,   fn($q) => $q->whereDate('loan_date', '<=', $dateTo))
        ->count(),
      'total_late'       => Returns::where('late_days', '>', 0)
        ->when($dateFrom, fn($q) => $q->whereDate('return_date', '>=', $dateFrom))
        ->when($dateTo,   fn($q) => $q->whereDate('return_date', '<=', $dateTo))
        ->count(),
      'total_violations' => Violations::when($dateFrom, fn($q) => $q->whereDate('created_at', '>=', $dateFrom))
        ->when($dateTo,   fn($q) => $q->whereDate('created_at', '<=', $dateTo))
        ->count(),
      'total_points'     => Violations::when($dateFrom, fn($q) => $q->whereDate('created_at', '>=', $dateFrom))
        ->when($dateTo,   fn($q) => $q->whereDate('created_at', '<=', $dateTo))
        ->sum('points'),
    ];

    // ── Data per tab (hanya query tab aktif) ──
    $loans      = collect();
    $returns    = collect();
    $violations = collect();
    $users      = collect();
    $totalPoints = 0;
    $sharedUsers = collect(); // untuk dropdown filter user

    if ($activeTab === 'loans') {
      $loans       = $this->queryLoans($request)->paginate(15)->withQueryString();
      $sharedUsers = User::with('detail')->get();
    } elseif ($activeTab === 'returns') {
      $returns = $this->queryReturns($request)->paginate(15)->withQueryString();
    } elseif ($activeTab === 'violations') {
      $violationQuery = $this->queryViolations($request);
      $totalPoints    = $violationQuery->sum('points');
      $violations     = $violationQuery->paginate(15)->withQueryString();
      $sharedUsers    = User::with('detail')->get();
    } elseif ($activeTab === 'users') {
      $users = $this->queryUsers($request)->paginate(15)->withQueryString();
    }

    return view('laporan.tabel', compact(
      'activeTab',
      'stats',
      'loans',
      'returns',
      'violations',
      'users',
      'totalPoints',
      'sharedUsers',
      'dateFrom',
      'dateTo',
    ));
  }

  // ═══════════════════════════════════════════
  // QUERY BUILDERS (reusable di index & export)
  // ═══════════════════════════════════════════
  private function queryLoans(Request $request)
  {
    return Loans::with(['tool', 'user.detail', 'unit', 'return.unitConditions', 'violations'])
      ->when($request->date_from, fn($q) => $q->whereDate('loan_date', '>=', $request->date_from))
      ->when($request->date_to,   fn($q) => $q->whereDate('loan_date', '<=', $request->date_to))
      ->when($request->status,    fn($q) => $q->where('status', $request->status))
      ->when($request->user_id,   fn($q) => $q->where('user_id', $request->user_id))
      ->when($request->search,    fn($q) => $q->where(function ($q) use ($request) {
        $q->where('loan_code', 'like', "%{$request->search}%")
          ->orWhereHas('tool', fn($q) => $q->where('name', 'like', "%{$request->search}%"))
          ->orWhereHas('user.detail', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
      }))
      ->latest('loan_date');
  }

  private function queryReturns(Request $request)
  {
    return Returns::with(['loan.tool', 'loan.user.detail', 'unitConditions'])
      ->when($request->date_from, fn($q) => $q->whereDate('return_date', '>=', $request->date_from))
      ->when($request->date_to,   fn($q) => $q->whereDate('return_date', '<=', $request->date_to))
      ->when($request->condition, fn($q) => $q->whereHas('unitConditions', fn($q) => $q->where('conditions', $request->condition)))
      ->when($request->late_only, fn($q) => $q->where('late_days', '>', 0))
      ->when($request->search,    fn($q) => $q->whereHas('loan', fn($q) => $q
        ->where('loan_code', 'like', "%{$request->search}%")
        ->orWhereHas('tool', fn($q) => $q->where('name', 'like', "%{$request->search}%"))))
      ->latest('return_date');
  }

  private function queryViolations(Request $request)
  {
    return Violations::with(['loan.tool', 'user.detail'])
      ->when($request->date_from,        fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
      ->when($request->date_to,          fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
      ->when($request->query('type'),    fn($q) => $q->where('type', $request->query('type')))
      ->when($request->query('status'),  fn($q) => $q->where('status', $request->query('status')))
      ->when($request->user_id,          fn($q) => $q->where('user_id', $request->user_id))
      ->when($request->search,           fn($q) => $q->whereHas('user.detail', fn($q) => $q->where('name', 'like', "%{$request->search}%")))
      ->latest();
  }

  private function queryUsers(Request $request)
  {
    return User::with(['detail', 'violations'])
      ->when($request->is_restricted, fn($q) => $q->where('is_restricted', true))
      ->when($request->min_points,    fn($q) => $q->where('penalty_points', '>=', $request->min_points))
      ->when($request->search,        fn($q) => $q
        ->whereHas('detail', fn($q) => $q->where('name', 'like', "%{$request->search}%"))
        ->orWhere('email', 'like', "%{$request->search}%"))
      ->orderByDesc('penalty_points');
  }

  // ═══════════════════════════════════════════
  // EXPORT — entry point
  // ═══════════════════════════════════════════
  public function export(Request $request, string $type)
  {
    $format = $request->format ?? 'xlsx';

    return match ($type) {
      'loans'      => $this->exportLoans($request, $format),
      'returns'    => $this->exportReturns($request, $format),
      'violations' => $this->exportViolations($request, $format),
      'users'      => $this->exportUsers($request, $format),
      default      => abort(404),
    };
  }

  private function exportLoans(Request $request, string $format)
  {
    $data     = $this->queryLoans($request)->get();
    $filename = 'laporan-peminjaman-' . now()->format('Ymd');
    $headers  = ['Kode Pinjam', 'Nama User', 'Alat', 'Kode Unit', 'Tgl Pinjam', 'Jatuh Tempo', 'Status'];
    $mapper   = fn($row) => [
      $row->loan_code,
      $row->user?->detail?->name ?? '-',
      $row->tool?->name ?? '-',
      $row->unit_code,
      Carbon::parse($row->loan_date)->format('d M Y'),
      Carbon::parse($row->due_date)->format('d M Y'),
      $row->status,
    ];

    return match ($format) {
      'xlsx'  => $this->exportXlsx($data, $filename, $mapper, $headers),
      'csv'   => $this->exportCsv($data, $filename, $mapper, $headers),
      default => abort(400),
    };
  }

  private function exportReturns(Request $request, string $format)
  {
    $data     = $this->queryReturns($request)->get();
    $filename = 'laporan-pengembalian-' . now()->format('Ymd');
    $headers  = ['Kode Pinjam', 'Nama User', 'Alat', 'Tgl Kembali', 'Hari Terlambat', 'Kondisi', 'Catatan'];
    $mapper   = fn($row) => [
      $row->loan?->loan_code ?? '-',
      $row->loan?->user?->detail?->name ?? '-',
      $row->loan?->tool?->name ?? '-',
      Carbon::parse($row->return_date)->format('d M Y'),
      $row->late_days ?? 0,
      $row->unitConditions?->first()?->conditions ?? '-',
      $row->notes ?? '-',
    ];

    return match ($format) {
      'xlsx'  => $this->exportXlsx($data, $filename, $mapper, $headers),
      'csv'   => $this->exportCsv($data, $filename, $mapper, $headers),
      default => abort(400),
    };
  }

  private function exportViolations(Request $request, string $format)
  {
    $data     = $this->queryViolations($request)->get();
    $filename = 'laporan-pelanggaran-' . now()->format('Ymd');
    $headers  = ['Nama User', 'Kode Pinjam', 'Alat', 'Tipe', 'Poin', 'Hari Terlambat', 'Deskripsi', 'Status', 'Tanggal'];
    $mapper   = fn($row) => [
      $row->user?->detail?->name ?? '-',
      $row->loan?->loan_code ?? '-',
      $row->loan?->tool?->name ?? '-',
      match ($row->type) {
        'late_return' => 'Keterlambatan',
        'damage'      => 'Kerusakan',
        'loss'        => 'Kehilangan',
        default       => $row->type,
      },
      $row->points,
      $row->days_late ?? 0,
      $row->description ?? '-',
      $row->status === 'pending' ? 'Belum Selesai' : 'Selesai',
      Carbon::parse($row->created_at)->format('d M Y'),
    ];

    return match ($format) {
      'xlsx'  => $this->exportXlsx($data, $filename, $mapper, $headers),
      'csv'   => $this->exportCsv($data, $filename, $mapper, $headers),
      default => abort(400),
    };
  }

  private function exportUsers(Request $request, string $format)
  {
    $data     = $this->queryUsers($request)->get();
    $filename = 'laporan-user-' . now()->format('Ymd');
    $headers  = ['Nama', 'Email', 'Total Poin', 'Direstriksi', 'Jumlah Pelanggaran'];
    $mapper   = fn($row) => [
      $row->detail?->name ?? '-',
      $row->email,
      $row->penalty_points,
      $row->is_restricted ? 'Ya' : 'Tidak',
      $row->violations->count(),
    ];

    return match ($format) {
      'xlsx'  => $this->exportXlsx($data, $filename, $mapper, $headers),
      'csv'   => $this->exportCsv($data, $filename, $mapper, $headers),
      default => abort(400),
    };
  }

  // ═══════════════════════════════════════════
  // HELPER — Export XLSX
  // ═══════════════════════════════════════════
  private function exportXlsx($data, string $filename, callable $rowMapper, array $headers)
  {
    $spreadsheet = new Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();
    $totalCols   = count($headers);
    $lastCol     = Coordinate::stringFromColumnIndex($totalCols);

    $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
      'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
      'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '3699FF']],
      'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
    ]);
    $sheet->getRowDimension(1)->setRowHeight(20);

    foreach ($headers as $i => $header) {
      $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 1) . '1', $header);
    }

    $rowNum = 2;
    foreach ($data as $row) {
      foreach ($rowMapper($row) as $i => $value) {
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 1) . $rowNum, $value);
      }
      if ($rowNum % 2 === 0) {
        $sheet->getStyle("A{$rowNum}:{$lastCol}{$rowNum}")
          ->getFill()->setFillType('solid')
          ->getStartColor()->setRGB('F3F6F9');
      }
      $rowNum++;
    }

    for ($i = 1; $i <= $totalCols; $i++) {
      $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
    }

    $writer = new XlsxWriter($spreadsheet);

    return response()->streamDownload(function () use ($writer) {
      $writer->save('php://output');
    }, "{$filename}.xlsx", [
      'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      'Content-Disposition' => "attachment; filename=\"{$filename}.xlsx\"",
    ]);
  }

  // ═══════════════════════════════════════════
  // HELPER — Export CSV
  // ═══════════════════════════════════════════
  private function exportCsv($data, string $filename, callable $rowMapper, array $headers)
  {
    $callback = function () use ($data, $rowMapper, $headers) {
      $handle = fopen('php://output', 'w');
      fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
      fputcsv($handle, $headers);
      foreach ($data as $row) {
        fputcsv($handle, $rowMapper($row));
      }
      fclose($handle);
    };

    return response()->stream($callback, 200, [
      'Content-Type'        => 'text/csv; charset=UTF-8',
      'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
    ]);
  }
}
