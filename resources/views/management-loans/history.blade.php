@extends('master')

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            {{-- PAGE HEADING --}}
            <div class="d-flex align-items-center justify-content-between mb-7">
                <div>
                    <h1 class="page-heading text-gray-900 fw-bold fs-3 my-0">
                        Riwayat Peminjaman
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">Peminjaman</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Riwayat</li>
                    </ul>
                </div>
            </div>

            {{-- STATS --}}
            <div class="row g-5 mb-7">
                <div class="col-6 col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center gap-4 p-6">
                            <div class="symbol symbol-45px">
                                <span class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-document fs-2 text-primary">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-gray-800">{{ $loans->total() }}</div>
                                <div class="text-muted fs-7">Total Riwayat</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center gap-4 p-6">
                            <div class="symbol symbol-45px">
                                <span class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-check-circle fs-2 text-success">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-gray-800">
                                    {{ $loans->getCollection()->where('status', 'returned')->count() }}
                                </div>
                                <div class="text-muted fs-7">Dikembalikan</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center gap-4 p-6">
                            <div class="symbol symbol-45px">
                                <span class="symbol-label bg-light-danger">
                                    <i class="ki-duotone ki-cross-circle fs-2 text-danger">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-gray-800">
                                    {{ $loans->getCollection()->where('status', 'rejected')->count() }}
                                </div>
                                <div class="text-muted fs-7">Ditolak</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center gap-4 p-6">
                            <div class="symbol symbol-45px">
                                <span class="symbol-label bg-light-warning">
                                    <i class="ki-duotone ki-warning-2 fs-2 text-warning">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-gray-800">
                                    {{ $loans->getCollection()->filter(fn($l) => ($l->return?->late_days ?? 0) > 0)->count() }}
                                </div>
                                <div class="text-muted fs-7">Pernah Terlambat</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE CARD --}}
            <div class="card">

                {{-- CARD HEADER: search + filter --}}
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <form method="GET" action="{{ request()->url() }}"
                            class="d-flex align-items-center gap-3 flex-wrap">
                            <div class="d-flex align-items-center position-relative">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-solid w-250px ps-13"
                                    placeholder="Cari kode atau nama alat...">
                            </div>

                            <select name="status" class="form-select form-select-solid w-150px">
                                <option value="">Semua Status</option>
                                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>
                                    Dikembalikan</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                    Ditolak</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>

                            <select name="condition" class="form-select form-select-solid w-150px">
                                <option value="">Semua Kondisi</option>
                                <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Baik
                                </option>
                                <option value="damaged" {{ request('condition') == 'damaged' ? 'selected' : '' }}>
                                    Rusak</option>
                                <option value="lost" {{ request('condition') == 'lost' ? 'selected' : '' }}>Hilang
                                </option>
                            </select>

                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="ki-duotone ki-filter fs-4 me-1">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                Filter
                            </button>

                            @if (request()->hasAny(['search', 'status', 'condition']))
                                <a href="{{ request()->url() }}" class="btn btn-light btn-sm">
                                    <i class="ki-duotone ki-cross fs-4 me-1">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    Reset
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                {{-- CARD BODY: table --}}
                <div class="card-body py-4">
                    @if ($loans->isEmpty())
                        <div class="text-center py-15">
                            <div class="symbol symbol-60px mb-5">
                                <span class="symbol-label bg-light">
                                    <i class="ki-duotone ki-document fs-1 text-muted">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <h5 class="fw-bold text-gray-700 mb-2">Belum Ada Riwayat</h5>
                            <p class="text-muted fs-7 mb-0">
                                Riwayat peminjaman akan muncul setelah Anda mengembalikan alat.
                            </p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="ps-4 rounded-start">Alat</th>
                                        <th>Kode Pinjam</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Dikembalikan</th>
                                        <th>Keterlambatan</th>
                                        <th>Kondisi</th>
                                        <th>Status</th>
                                        <th class="pe-4 rounded-end text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $loan)
                                        @php
                                            $condition = $loan->return?->unitConditions?->first()?->conditions;
                                            $lateDays = $loan->return?->late_days ?? 0;
                                            $returnDate = $loan->return?->return_date;
                                        @endphp
                                        <tr>
                                            {{-- Alat --}}
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="symbol symbol-40px">
                                                        @if (!empty($loan->tool?->photo_path) && file_exists(public_path($loan->tool->photo_path)))
                                                            <img src="{{ asset($loan->tool->photo_path) }}"
                                                                alt="{{ $loan->tool->name }}"
                                                                class="symbol-label object-fit-cover">
                                                        @else
                                                            <span
                                                                class="symbol-label bg-light-warning fw-bold text-warning">
                                                                {{ strtoupper(substr($loan->tool->name ?? 'T', 0, 2)) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-800 fw-bold fs-6 d-block">
                                                            {{ $loan->tool?->name ?? '-' }}
                                                        </span>
                                                        <span class="text-muted fs-8">{{ $loan->unit_code }}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Kode --}}
                                            <td>
                                                <span class="badge badge-light fw-semibold fs-8"
                                                    style="font-family: monospace; letter-spacing: .03em;">
                                                    {{ $loan->loan_code }}
                                                </span>
                                            </td>

                                            {{-- Tanggal Pinjam --}}
                                            <td>
                                                <span class="text-gray-800 fw-semibold fs-7 d-block">
                                                    {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}
                                                </span>
                                                <span class="text-muted fs-8">
                                                    Tempo:
                                                    {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                                </span>
                                            </td>

                                            {{-- Tanggal Kembali --}}
                                            <td>
                                                @if ($returnDate)
                                                    <span class="text-gray-800 fw-semibold fs-7">
                                                        {{ \Carbon\Carbon::parse($returnDate)->format('d M Y') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted fs-7">—</span>
                                                @endif
                                            </td>

                                            {{-- Keterlambatan --}}
                                            <td>
                                                @if ($lateDays > 0)
                                                    <span class="badge badge-light-danger">
                                                        <i class="ki-duotone ki-warning fs-8 me-1">
                                                            <span class="path1"></span><span class="path2"></span>
                                                        </i>
                                                        {{ $lateDays }} hari
                                                    </span>
                                                @elseif ($returnDate)
                                                    <span class="badge badge-light-success">
                                                        <i class="ki-duotone ki-check fs-8 me-1"></i>
                                                        Tepat waktu
                                                    </span>
                                                @else
                                                    <span class="text-muted fs-7">—</span>
                                                @endif
                                            </td>

                                            {{-- Kondisi --}}
                                            <td>
                                                @if ($condition === 'good')
                                                    <span class="badge badge-light-success">Baik</span>
                                                @elseif ($condition === 'broken')
                                                    <span class="badge badge-light-danger">Rusak</span>
                                                @elseif ($condition === 'lost')
                                                    <span class="badge badge-light-danger">Hilang</span>
                                                @else
                                                    <span class="text-muted fs-7">—</span>
                                                @endif
                                            </td>

                                            {{-- Status --}}
                                            <td>
                                                @if ($loan->status === 'returned')
                                                    <span class="badge badge-light-info">Dikembalikan</span>
                                                @elseif ($loan->status === 'rejected')
                                                    <span class="badge badge-light-danger">Ditolak</span>
                                                @elseif ($loan->status === 'cancelled')
                                                    <span class="badge badge-light-secondary">Dibatalkan</span>
                                                @endif
                                            </td>

                                            {{-- Aksi --}}
                                            <td class="text-end pe-4">
                                                <button class="btn btn-icon btn-light-primary btn-sm" title="Lihat Detail"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $loan->id }}">
                                                    <i class="ki-duotone ki-eye fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="detailModal{{ $loan->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered mw-500px">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <div>
                                                            <h5 class="modal-title fw-bold">{{ $loan->loan_code }}</h5>
                                                            <span class="text-muted fs-7">Detail Riwayat Peminjaman</span>
                                                        </div>
                                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                            data-bs-dismiss="modal">
                                                            <i class="ki-duotone ki-cross fs-2x">
                                                                <span class="path1"></span><span class="path2"></span>
                                                            </i>
                                                        </div>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="d-flex flex-column gap-4 mb-5">

                                                            <div
                                                                class="d-flex justify-content-between align-items-center border-bottom pb-3">
                                                                <span class="text-muted fs-7">Nama Alat</span>
                                                                <span
                                                                    class="fw-bold fs-7 text-gray-800">{{ $loan->tool?->name ?? '-' }}</span>
                                                            </div>

                                                            <div
                                                                class="d-flex justify-content-between align-items-center border-bottom pb-3">
                                                                <span class="text-muted fs-7">Kode Unit</span>
                                                                <span class="fw-bold fs-7 text-gray-800"
                                                                    style="font-family:monospace;">{{ $loan->unit_code }}</span>
                                                            </div>

                                                            <div
                                                                class="d-flex justify-content-between align-items-center border-bottom pb-3">
                                                                <span class="text-muted fs-7">Tanggal Pinjam</span>
                                                                <span
                                                                    class="fw-bold fs-7 text-gray-800">{{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('d F Y') }}</span>
                                                            </div>

                                                            <div
                                                                class="d-flex justify-content-between align-items-center border-bottom pb-3">
                                                                <span class="text-muted fs-7">Jatuh Tempo</span>
                                                                <span
                                                                    class="fw-bold fs-7 text-gray-800">{{ \Carbon\Carbon::parse($loan->due_date)->translatedFormat('d F Y') }}</span>
                                                            </div>

                                                            <div
                                                                class="d-flex justify-content-between align-items-center border-bottom pb-3">
                                                                <span class="text-muted fs-7">Tanggal Kembali</span>
                                                                <span class="fw-bold fs-7 text-gray-800">
                                                                    {{ $returnDate ? \Carbon\Carbon::parse($returnDate)->translatedFormat('d F Y') : '—' }}
                                                                </span>
                                                            </div>

                                                            <div
                                                                class="d-flex justify-content-between align-items-center border-bottom pb-3">
                                                                <span class="text-muted fs-7">Keterlambatan</span>
                                                                @if ($lateDays > 0)
                                                                    <span
                                                                        class="badge badge-light-danger">{{ $lateDays }}
                                                                        hari</span>
                                                                @else
                                                                    <span class="badge badge-light-success">Tepat
                                                                        waktu</span>
                                                                @endif
                                                            </div>

                                                            <div
                                                                class="d-flex justify-content-between align-items-center border-bottom pb-3">
                                                                <span class="text-muted fs-7">Kondisi Alat</span>
                                                                @if ($condition === 'good')
                                                                    <span class="badge badge-light-success">Baik</span>
                                                                @elseif ($condition === 'broken')
                                                                    <span class="badge badge-light-warning">Rusak</span>
                                                                @elseif ($condition === 'lost')
                                                                    <span class="badge badge-light-danger">Hilang</span>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </div>

                                                            <div
                                                                class="d-flex justify-content-between align-items-center border-bottom pb-3">
                                                                <span class="text-muted fs-7">Status</span>
                                                                @if ($loan->status === 'returned')
                                                                    <span
                                                                        class="badge badge-light-info">Dikembalikan</span>
                                                                @elseif ($loan->status === 'rejected')
                                                                    <span class="badge badge-light-danger">Ditolak</span>
                                                                @elseif ($loan->status === 'cancelled')
                                                                    <span
                                                                        class="badge badge-light-secondary">Dibatalkan</span>
                                                                @endif
                                                            </div>

                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <span class="text-muted fs-7">Keperluan</span>
                                                                <span class="fw-bold fs-7 text-gray-800 text-end"
                                                                    style="max-width:60%;">{{ $loan->purpose ?? '—' }}</span>
                                                            </div>

                                                        </div>

                                                        {{-- Violation notice --}}
                                                        @php
                                                            $loanViolations = $loan->violations ?? collect();
                                                            $violations = [];
                                                            if ($lateDays > 0) {
                                                                $violations[] = "Terlambat {$lateDays} hari";
                                                            }
                                                            if ($condition === 'broken') {
                                                                $violations[] = 'Alat dikembalikan rusak';
                                                            }
                                                            if ($condition === 'lost') {
                                                                $violations[] = 'Alat hilang';
                                                            }
                                                        @endphp
                                                        @if (count($violations) > 0)
                                                            <div
                                                                class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-4 mb-4">
                                                                <i
                                                                    class="ki-duotone ki-warning-2 fs-2tx text-danger me-4 mt-1">
                                                                    <span class="path1"></span><span
                                                                        class="path2"></span>
                                                                </i>
                                                                <div class="d-flex flex-column w-100">
                                                                    <h5 class="mb-3 text-danger">Ada Pelanggaran</h5>
                                                                    <div class="d-flex flex-column gap-2">

                                                                        @if ($lateDays > 0)
                                                                            @php $lateViolation = $loanViolations->where('type', 'late_return')->first(); @endphp
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center bg-white rounded px-3 py-2 border border-danger border-opacity-25">
                                                                                <div
                                                                                    class="d-flex align-items-center gap-2">
                                                                                    <i
                                                                                        class="ki-duotone ki-time fs-5 text-warning">
                                                                                        <span class="path1"></span><span
                                                                                            class="path2"></span>
                                                                                    </i>
                                                                                    <div>
                                                                                        <span
                                                                                            class="fw-bold fs-7 text-gray-800 d-block">Keterlambatan</span>
                                                                                        <span
                                                                                            class="text-muted fs-8">Terlambat
                                                                                            {{ $lateDays }} hari</span>
                                                                                    </div>
                                                                                </div>
                                                                                @if ($lateViolation)
                                                                                    <span
                                                                                        class="badge badge-light-danger">{{ $lateViolation->points }}
                                                                                        poin</span>
                                                                                @endif
                                                                            </div>
                                                                        @endif

                                                                        @if ($condition === 'broken')
                                                                            @php $damageViolation = $loanViolations->where('type', 'damage')->first(); @endphp
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center bg-white rounded px-3 py-2 border border-danger border-opacity-25">
                                                                                <div
                                                                                    class="d-flex align-items-center gap-2">
                                                                                    <i
                                                                                        class="ki-duotone ki-wrench fs-5 text-danger">
                                                                                        <span class="path1"></span><span
                                                                                            class="path2"></span>
                                                                                    </i>
                                                                                    <div>
                                                                                        <span
                                                                                            class="fw-bold fs-7 text-gray-800 d-block">Kerusakan
                                                                                            Alat</span>
                                                                                        <span
                                                                                            class="text-muted fs-8">{{ $damageViolation?->description ?? 'Alat dikembalikan dalam kondisi rusak' }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                @if ($damageViolation)
                                                                                    <span
                                                                                        class="badge badge-light-danger">{{ $damageViolation->points }}
                                                                                        poin</span>
                                                                                @endif
                                                                            </div>
                                                                        @endif

                                                                        @if ($condition === 'lost')
                                                                            @php $lossViolation = $loanViolations->where('type', 'loss')->first(); @endphp
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center bg-white rounded px-3 py-2 border border-danger border-opacity-25">
                                                                                <div
                                                                                    class="d-flex align-items-center gap-2">
                                                                                    <i
                                                                                        class="ki-duotone ki-cross-circle fs-5 text-danger">
                                                                                        <span class="path1"></span><span
                                                                                            class="path2"></span>
                                                                                    </i>
                                                                                    <div>
                                                                                        <span
                                                                                            class="fw-bold fs-7 text-gray-800 d-block">Kehilangan
                                                                                            Alat</span>
                                                                                        <span
                                                                                            class="text-muted fs-8">{{ $lossViolation?->description ?? 'Alat tidak dikembalikan' }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                @if ($lossViolation)
                                                                                    <span
                                                                                        class="badge badge-light-danger">{{ $lossViolation->points }}
                                                                                        poin</span>
                                                                                @endif
                                                                            </div>
                                                                        @endif

                                                                        {{-- Total --}}
                                                                        @php $totalPoints = $loanViolations->sum('points'); @endphp
                                                                        @if ($totalPoints > 0)
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center pt-1 mt-1 border-top border-danger border-opacity-25">
                                                                                <span
                                                                                    class="fw-bold fs-7 text-danger">Total
                                                                                    Poin</span>
                                                                                <span
                                                                                    class="badge badge-danger">{{ $totalPoints }}
                                                                                    poin</span>
                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        {{-- Notes --}}
                                                        @if (!empty($loan->return?->notes))
                                                            <div>
                                                                <label
                                                                    class="fs-7 fw-semibold text-muted text-uppercase mb-2">Catatan
                                                                    Pengembalian</label>
                                                                <div
                                                                    class="form-control form-control-solid fs-7 text-gray-700">
                                                                    {{ $loan->return->notes }}</div>
                                                            </div>
                                                        @endif

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                            <span class="text-muted fs-7">
                                Menampilkan {{ $loans->firstItem() }}–{{ $loans->lastItem() }}
                                dari {{ $loans->total() }} data
                            </span>
                            {{ $loans->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const detailModal = document.getElementById('detailModal');

                detailModal.addEventListener('show.bs.modal', function(e) {
                    const btn = e.relatedTarget;
                    const d = btn.dataset;

                    document.getElementById('modalLoanCode').textContent = d.loanCode;
                    document.getElementById('dTool').textContent = d.tool;
                    document.getElementById('dUnit').textContent = d.unit;
                    document.getElementById('dLoanDate').textContent = d.loanDate;
                    document.getElementById('dDueDate').textContent = d.dueDate;
                    document.getElementById('dReturnDate').textContent = d.returnDate;
                    document.getElementById('dPurpose').textContent = d.purpose;

                    // Keterlambatan
                    const late = parseInt(d.late) || 0;
                    document.getElementById('dLate').innerHTML = late > 0 ?
                        `<span class="badge badge-light-danger">${late} hari</span>` :
                        `<span class="badge badge-light-success">Tepat waktu</span>`;

                    // Kondisi
                    const condMap = {
                        good: '<span class="badge badge-light-success">Baik</span>',
                        damaged: '<span class="badge badge-light-warning">Rusak</span>',
                        lost: '<span class="badge badge-light-danger">Hilang</span>',
                    };
                    document.getElementById('dCondition').innerHTML =
                        condMap[d.condition] ?? '<span class="text-muted">—</span>';

                    // Status
                    const statMap = {
                        returned: '<span class="badge badge-light-info">Dikembalikan</span>',
                        rejected: '<span class="badge badge-light-danger">Ditolak</span>',
                        cancelled: '<span class="badge badge-light-secondary">Dibatalkan</span>',
                    };
                    document.getElementById('dStatus').innerHTML =
                        statMap[d.status] ?? `<span>${d.status}</span>`;

                    // Violation
                    const vWrap = document.getElementById('dViolation');
                    const violations = [];
                    if (late > 0) violations.push(`Terlambat ${late} hari`);
                    if (d.condition === 'damaged') violations.push('Alat dikembalikan rusak');
                    if (d.condition === 'lost') violations.push('Alat hilang');

                    if (violations.length > 0) {
                        document.getElementById('dViolationText').textContent = violations.join(' · ');
                        vWrap.classList.remove('d-none');
                    } else {
                        vWrap.classList.add('d-none');
                    }

                    // Notes
                    const notesWrap = document.getElementById('dNotesWrap');
                    const notesEl = document.getElementById('dNotes');
                    if (d.notes && d.notes !== '-') {
                        notesEl.textContent = d.notes;
                        notesWrap.classList.remove('d-none');
                    } else {
                        notesWrap.classList.add('d-none');
                    }
                });
            });
        </script>
    @endpush
@endsection
