@extends('master')

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            {{-- PAGE HEADING --}}
            <div class="d-flex align-items-center justify-content-between mb-7">
                <div>
                    <h1 class="page-heading text-gray-900 fw-bold fs-3 my-0">Laporan</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">Dashboard</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Laporan</li>
                    </ul>
                </div>
            </div>

            {{-- SUMMARY STATS --}}
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
                                <div class="fs-2 fw-bold text-gray-800">{{ $stats['total_loans'] }}</div>
                                <div class="text-muted fs-7">Total Peminjaman</div>
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
                                <div class="fs-2 fw-bold text-gray-800">{{ $stats['total_returned'] }}</div>
                                <div class="text-muted fs-7">Dikembalikan</div>
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
                                <div class="fs-2 fw-bold text-gray-800">{{ $stats['total_late'] }}</div>
                                <div class="text-muted fs-7">Terlambat</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center gap-4 p-6">
                            <div class="symbol symbol-45px">
                                <span class="symbol-label bg-light-danger">
                                    <i class="ki-duotone ki-shield-cross fs-2 text-danger">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-gray-800">{{ $stats['total_violations'] }}</div>
                                <div class="text-muted fs-7">Pelanggaran</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAIN CARD WITH TABS --}}
            <div class="card">
                <div class="card-header border-0 pt-6 pb-0">

                    {{-- TAB NAV --}}
                    <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-semibold" id="reportTabs">
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'loans' ? 'active text-primary' : 'text-muted' }}"
                                href="{{ request()->fullUrlWithQuery(['tab' => 'loans', 'page' => 1]) }}">
                                <i class="ki-duotone ki-document fs-4 me-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                Peminjaman
                                <span class="badge badge-light-primary ms-2">{{ $stats['total_loans'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'returns' ? 'active text-primary' : 'text-muted' }}"
                                href="{{ request()->fullUrlWithQuery(['tab' => 'returns', 'page' => 1]) }}">
                                <i class="ki-duotone ki-arrow-circle-left fs-4 me-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                Pengembalian
                                <span class="badge badge-light-success ms-2">{{ $stats['total_returned'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'violations' ? 'active text-primary' : 'text-muted' }}"
                                href="{{ request()->fullUrlWithQuery(['tab' => 'violations', 'page' => 1]) }}">
                                <i class="ki-duotone ki-shield-cross fs-4 me-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                Pelanggaran
                                <span class="badge badge-light-danger ms-2">{{ $stats['total_violations'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'users' ? 'active text-primary' : 'text-muted' }}"
                                href="{{ request()->fullUrlWithQuery(['tab' => 'users', 'page' => 1]) }}">
                                <i class="ki-duotone ki-people fs-4 me-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                User
                            </a>
                        </li>
                    </ul>

                </div>

                {{-- FILTER + EXPORT BAR --}}
                <div class="card-header border-0 pt-5">
                    <div class="card-title w-100">
                        <form method="GET" action="{{ request()->url() }}"
                            class="d-flex align-items-center gap-3 flex-wrap w-100">

                            {{-- Pertahankan tab aktif --}}
                            <input type="hidden" name="tab" value="{{ $activeTab }}">

                            {{-- Search --}}
                            <div class="d-flex align-items-center position-relative">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-solid w-250px ps-13" placeholder="Cari...">
                            </div>

                            {{-- Date From --}}
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="form-control form-control-solid w-150px" placeholder="Dari tanggal">

                            {{-- Date To --}}
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="form-control form-control-solid w-150px" placeholder="Sampai tanggal">

                            {{-- Filter Peminjaman --}}
                            @if ($activeTab === 'loans')
                                <select name="status" class="form-select form-select-solid w-175px">
                                    <option value="">Semua Status</option>
                                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>
                                        Dikembalikan</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        Ditolak</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        Menunggu</option>
                                </select>
                                <select name="user_id" class="form-select form-select-solid w-200px">
                                    <option value="">Semua User</option>
                                    @foreach ($sharedUsers ?? [] as $u)
                                        <option value="{{ $u->id }}"
                                            {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                            {{ $u->detail?->name ?? $u->email }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif

                            {{-- Filter Pengembalian --}}
                            @if ($activeTab === 'returns')
                                <select name="condition" class="form-select form-select-solid w-175px">
                                    <option value="">Semua Kondisi</option>
                                    <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="damaged" {{ request('condition') == 'damaged' ? 'selected' : '' }}>
                                        Rusak</option>
                                    <option value="lost" {{ request('condition') == 'lost' ? 'selected' : '' }}>
                                        Hilang</option>
                                </select>
                                <label class="form-check form-switch form-check-custom form-check-solid ms-2">
                                    <input class="form-check-input" type="checkbox" name="late_only" value="1"
                                        {{ request('late_only') ? 'checked' : '' }}>
                                    <span class="form-check-label fw-semibold text-gray-700 fs-7">Hanya Terlambat</span>
                                </label>
                            @endif

                            {{-- Filter Pelanggaran --}}
                            @if ($activeTab === 'violations')
                                <select name="type" class="form-select form-select-solid w-175px">
                                    <option value="">Semua Tipe</option>
                                    <option value="late_return" {{ request('type') == 'late_return' ? 'selected' : '' }}>
                                        Keterlambatan</option>
                                    <option value="damage" {{ request('type') == 'damage' ? 'selected' : '' }}>
                                        Kerusakan</option>
                                    <option value="loss" {{ request('type') == 'loss' ? 'selected' : '' }}>
                                        Kehilangan</option>
                                </select>
                                <select name="status" class="form-select form-select-solid w-175px">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Belum
                                        Selesai</option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>
                                        Selesai</option>
                                </select>
                                <select name="user_id" class="form-select form-select-solid w-200px">
                                    <option value="">Semua User</option>
                                    @foreach ($sharedUsers ?? [] as $u)
                                        <option value="{{ $u->id }}"
                                            {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                            {{ $u->detail?->name ?? $u->email }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif

                            {{-- Filter User --}}
                            @if ($activeTab === 'users')
                                <input type="number" name="min_points" value="{{ request('min_points') }}"
                                    class="form-control form-control-solid w-150px" placeholder="Min. poin">
                                <label class="form-check form-switch form-check-custom form-check-solid ms-2">
                                    <input class="form-check-input" type="checkbox" name="is_restricted" value="1"
                                        {{ request('is_restricted') ? 'checked' : '' }}>
                                    <span class="form-check-label fw-semibold text-gray-700 fs-7">Hanya Direstriksi</span>
                                </label>
                            @endif

                            {{-- Action Buttons --}}
                            <div class="d-flex gap-2 ms-auto">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="ki-duotone ki-filter fs-4 me-1">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    Filter
                                </button>

                                @if (request()->hasAny([
                                        'search',
                                        'status',
                                        'condition',
                                        'type',
                                        'user_id',
                                        'late_only',
                                        'is_restricted',
                                        'min_points',
                                        'date_from',
                                        'date_to',
                                    ]))
                                    <a href="{{ request()->url() }}?tab={{ $activeTab }}"
                                        class="btn btn-light btn-sm">
                                        <i class="ki-duotone ki-cross fs-4 me-1">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Reset
                                    </a>
                                @endif

                                {{-- Export --}}
                                @php
                                    $exportParams = array_merge(request()->except(['page', 'format']), [
                                        'tab' => $activeTab,
                                    ]);
                                    $xlsxUrl =
                                        route('reports.export', ['type' => $activeTab]) .
                                        '?format=xlsx&' .
                                        http_build_query($exportParams);
                                    $csvUrl =
                                        route('reports.export', ['type' => $activeTab]) .
                                        '?format=csv&' .
                                        http_build_query($exportParams);
                                @endphp
                                <div class="btn-group">
                                    <a href="{{ $xlsxUrl }}" class="btn btn-light-success btn-sm">
                                        <i class="ki-duotone ki-file-down fs-4 me-1">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Excel
                                    </a>
                                    <a href="{{ $csvUrl }}" class="btn btn-light-info btn-sm">
                                        <i class="ki-duotone ki-file-down fs-4 me-1">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        CSV
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                {{-- CARD BODY --}}
                <div class="card-body py-4">

                    {{-- ══════════════════════════════════════════════════
                     TAB: PEMINJAMAN
                ══════════════════════════════════════════════════ --}}
                    @if ($activeTab === 'loans')
                        @if ($loans->isEmpty())
                            <div class="text-center py-15">
                                <div class="symbol symbol-60px mb-5">
                                    <span class="symbol-label bg-light">
                                        <i class="ki-duotone ki-document fs-1 text-muted"><span
                                                class="path1"></span><span class="path2"></span></i>
                                    </span>
                                </div>
                                <h5 class="fw-bold text-gray-700 mb-2">Tidak Ada Data</h5>
                                <p class="text-muted fs-7 mb-0">Belum ada data peminjaman.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="ps-4 rounded-start">Alat</th>
                                            <th>Kode Pinjam</th>
                                            <th>Peminjam</th>
                                            <th>Tgl Pinjam</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Status</th>
                                            <th class="pe-4 rounded-end text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($loans as $loan)
                                            <tr>
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
                                                            <span
                                                                class="text-gray-800 fw-bold fs-6 d-block">{{ $loan->tool?->name ?? '-' }}</span>
                                                            <span class="text-muted fs-8">{{ $loan->unit_code }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-light fw-semibold fs-8"
                                                        style="font-family:monospace;letter-spacing:.03em;">
                                                        {{ $loan->loan_code }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fw-semibold fs-7">
                                                        {{ $loan->user?->detail?->name ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fw-semibold fs-7 d-block">
                                                        {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php $overdue = \Carbon\Carbon::parse($loan->due_date)->isPast() && $loan->status === 'approved'; @endphp
                                                    <span
                                                        class="fw-semibold fs-7 {{ $overdue ? 'text-danger' : 'text-gray-800' }}">
                                                        {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                                    </span>
                                                    @if ($overdue)
                                                        <span class="badge badge-light-danger ms-1 fs-9">Lewat</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $statusMap = [
                                                            'returned' => [
                                                                'class' => 'badge-light-info',
                                                                'label' => 'Dikembalikan',
                                                            ],
                                                            'rejected' => [
                                                                'class' => 'badge-light-danger',
                                                                'label' => 'Ditolak',
                                                            ],
                                                            'cancelled' => [
                                                                'class' => 'badge-light-secondary',
                                                                'label' => 'Dibatalkan',
                                                            ],
                                                            'approved' => [
                                                                'class' => 'badge-light-success',
                                                                'label' => 'Disetujui',
                                                            ],
                                                            'pending' => [
                                                                'class' => 'badge-light-warning',
                                                                'label' => 'Menunggu',
                                                            ],
                                                        ];
                                                        $s = $statusMap[$loan->status] ?? [
                                                            'class' => 'badge-light',
                                                            'label' => $loan->status,
                                                        ];
                                                    @endphp
                                                    <span class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <button class="btn btn-icon btn-light-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#loanDetailModal{{ $loan->id }}"
                                                        title="Lihat Detail">
                                                        <i class="ki-duotone ki-eye fs-4">
                                                            <span class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span>
                                                        </i>
                                                    </button>
                                                </td>
                                            </tr>

                                            {{-- Modal Detail Peminjaman --}}
                                            <div class="modal fade" id="loanDetailModal{{ $loan->id }}"
                                                tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered mw-500px">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div>
                                                                <h5 class="modal-title fw-bold">{{ $loan->loan_code }}
                                                                </h5>
                                                                <span class="text-muted fs-7">Detail Peminjaman</span>
                                                            </div>
                                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                data-bs-dismiss="modal">
                                                                <i class="ki-duotone ki-cross fs-2x"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span></i>
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            @php
                                                                $lateDays = $loan->return?->late_days ?? 0;
                                                                $returnDate = $loan->return?->return_date;
                                                                $condition = $loan->return?->unitConditions?->first()
                                                                    ?->conditions;
                                                            @endphp
                                                            <div class="d-flex flex-column gap-4">
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom pb-3">
                                                                    <span class="text-muted fs-7">Peminjam</span>
                                                                    <span
                                                                        class="fw-bold fs-7">{{ $loan->user?->detail?->name ?? '-' }}</span>
                                                                </div>
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom pb-3">
                                                                    <span class="text-muted fs-7">Alat</span>
                                                                    <span
                                                                        class="fw-bold fs-7">{{ $loan->tool?->name ?? '-' }}</span>
                                                                </div>
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom pb-3">
                                                                    <span class="text-muted fs-7">Kode Unit</span>
                                                                    <span class="fw-bold fs-7"
                                                                        style="font-family:monospace">{{ $loan->unit_code }}</span>
                                                                </div>
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom pb-3">
                                                                    <span class="text-muted fs-7">Tanggal Pinjam</span>
                                                                    <span
                                                                        class="fw-bold fs-7">{{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('d F Y') }}</span>
                                                                </div>
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom pb-3">
                                                                    <span class="text-muted fs-7">Jatuh Tempo</span>
                                                                    <span
                                                                        class="fw-bold fs-7">{{ \Carbon\Carbon::parse($loan->due_date)->translatedFormat('d F Y') }}</span>
                                                                </div>
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom pb-3">
                                                                    <span class="text-muted fs-7">Tanggal Kembali</span>
                                                                    <span class="fw-bold fs-7">
                                                                        {{ $returnDate ? \Carbon\Carbon::parse($returnDate)->translatedFormat('d F Y') : '—' }}
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom pb-3">
                                                                    <span class="text-muted fs-7">Keterlambatan</span>
                                                                    @if ($lateDays > 0)
                                                                        <span
                                                                            class="badge badge-light-danger">{{ $lateDays }}
                                                                            hari</span>
                                                                    @elseif ($returnDate)
                                                                        <span class="badge badge-light-success">Tepat
                                                                            waktu</span>
                                                                    @else
                                                                        <span class="text-muted">—</span>
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom pb-3">
                                                                    <span class="text-muted fs-7">Kondisi</span>
                                                                    @if ($condition === 'good')
                                                                        <span class="badge badge-light-success">Baik</span>
                                                                    @elseif ($condition === 'broken' || $condition === 'damaged')
                                                                        <span
                                                                            class="badge badge-light-warning">Rusak</span>
                                                                    @elseif ($condition === 'lost')
                                                                        <span
                                                                            class="badge badge-light-danger">Hilang</span>
                                                                    @else
                                                                        <span class="text-muted">—</span>
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom pb-3">
                                                                    <span class="text-muted fs-7">Status</span>
                                                                    <span
                                                                        class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                                                                </div>
                                                                @if (!empty($loan->purpose))
                                                                    <div class="d-flex justify-content-between">
                                                                        <span class="text-muted fs-7">Keperluan</span>
                                                                        <span class="fw-bold fs-7 text-end"
                                                                            style="max-width:60%">{{ $loan->purpose }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            {{-- Violation notice --}}
                                                            @php $loanViolations = $loan->violations ?? collect(); @endphp
                                                            @if ($lateDays > 0 || in_array($condition, ['broken', 'damaged', 'lost']))
                                                                <div
                                                                    class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-4 mt-5">
                                                                    <i
                                                                        class="ki-duotone ki-warning-2 fs-2tx text-danger me-4 mt-1">
                                                                        <span class="path1"></span><span
                                                                            class="path2"></span>
                                                                    </i>
                                                                    <div class="w-100">
                                                                        <h5 class="mb-3 text-danger">Ada Pelanggaran</h5>
                                                                        <div class="d-flex flex-column gap-2">
                                                                            @if ($lateDays > 0)
                                                                                @php $lv = $loanViolations->where('type', 'late_return')->first(); @endphp
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center bg-white rounded px-3 py-2 border border-danger border-opacity-25">
                                                                                    <div
                                                                                        class="d-flex align-items-center gap-2">
                                                                                        <i
                                                                                            class="ki-duotone ki-time fs-5 text-warning"><span
                                                                                                class="path1"></span><span
                                                                                                class="path2"></span></i>
                                                                                        <div>
                                                                                            <span
                                                                                                class="fw-bold fs-7 d-block">Keterlambatan</span>
                                                                                            <span
                                                                                                class="text-muted fs-8">Terlambat
                                                                                                {{ $lateDays }}
                                                                                                hari</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    @if ($lv)
                                                                                        <span
                                                                                            class="badge badge-light-danger">{{ $lv->points }}
                                                                                            poin</span>
                                                                                    @endif
                                                                                </div>
                                                                            @endif
                                                                            @if (in_array($condition, ['broken', 'damaged']))
                                                                                @php $dv = $loanViolations->where('type', 'damage')->first(); @endphp
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center bg-white rounded px-3 py-2 border border-danger border-opacity-25">
                                                                                    <div
                                                                                        class="d-flex align-items-center gap-2">
                                                                                        <i
                                                                                            class="ki-duotone ki-wrench fs-5 text-danger"><span
                                                                                                class="path1"></span><span
                                                                                                class="path2"></span></i>
                                                                                        <div>
                                                                                            <span
                                                                                                class="fw-bold fs-7 d-block">Kerusakan
                                                                                                Alat</span>
                                                                                            <span
                                                                                                class="text-muted fs-8">{{ $dv?->description ?? 'Alat dikembalikan rusak' }}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    @if ($dv)
                                                                                        <span
                                                                                            class="badge badge-light-danger">{{ $dv->points }}
                                                                                            poin</span>
                                                                                    @endif
                                                                                </div>
                                                                            @endif
                                                                            @if ($condition === 'lost')
                                                                                @php $losv = $loanViolations->where('type', 'loss')->first(); @endphp
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center bg-white rounded px-3 py-2 border border-danger border-opacity-25">
                                                                                    <div
                                                                                        class="d-flex align-items-center gap-2">
                                                                                        <i
                                                                                            class="ki-duotone ki-cross-circle fs-5 text-danger"><span
                                                                                                class="path1"></span><span
                                                                                                class="path2"></span></i>
                                                                                        <div>
                                                                                            <span
                                                                                                class="fw-bold fs-7 d-block">Kehilangan
                                                                                                Alat</span>
                                                                                            <span
                                                                                                class="text-muted fs-8">{{ $losv?->description ?? 'Alat tidak dikembalikan' }}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    @if ($losv)
                                                                                        <span
                                                                                            class="badge badge-light-danger">{{ $losv->points }}
                                                                                            poin</span>
                                                                                    @endif
                                                                                </div>
                                                                            @endif
                                                                            @php $totalPts = $loanViolations->sum('points'); @endphp
                                                                            @if ($totalPts > 0)
                                                                                <div
                                                                                    class="d-flex justify-content-between pt-1 mt-1 border-top border-danger border-opacity-25">
                                                                                    <span
                                                                                        class="fw-bold fs-7 text-danger">Total
                                                                                        Poin</span>
                                                                                    <span
                                                                                        class="badge badge-danger">{{ $totalPts }}
                                                                                        poin</span>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if (!empty($loan->return?->notes))
                                                                <div class="mt-5">
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
                            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                                <span class="text-muted fs-7">
                                    Menampilkan {{ $loans->firstItem() }}–{{ $loans->lastItem() }} dari
                                    {{ $loans->total() }} data
                                </span>
                                {{ $loans->withQueryString()->links() }}
                            </div>
                        @endif
                    @endif

                    {{-- ══════════════════════════════════════════════════
                     TAB: PENGEMBALIAN
                ══════════════════════════════════════════════════ --}}
                    @if ($activeTab === 'returns')
                        @if ($returns->isEmpty())
                            <div class="text-center py-15">
                                <div class="symbol symbol-60px mb-5">
                                    <span class="symbol-label bg-light">
                                        <i class="ki-duotone ki-document fs-1 text-muted"><span
                                                class="path1"></span><span class="path2"></span></i>
                                    </span>
                                </div>
                                <h5 class="fw-bold text-gray-700 mb-2">Tidak Ada Data</h5>
                                <p class="text-muted fs-7 mb-0">Belum ada data pengembalian.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="ps-4 rounded-start">Kode Pinjam</th>
                                            <th>Peminjam</th>
                                            <th>Alat</th>
                                            <th>Tgl Kembali</th>
                                            <th>Keterlambatan</th>
                                            <th>Kondisi</th>
                                            <th class="pe-4 rounded-end">Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($returns as $ret)
                                            @php
                                                $retCondition = $ret->unitConditions?->first()?->conditions;
                                            @endphp
                                            <tr>
                                                <td class="ps-4">
                                                    <span class="badge badge-light fw-semibold fs-8"
                                                        style="font-family:monospace;letter-spacing:.03em;">
                                                        {{ $ret->loan?->loan_code ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fw-semibold fs-7">
                                                        {{ $ret->loan?->user?->detail?->name ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-gray-800 fw-semibold fs-7 d-block">{{ $ret->loan?->tool?->name ?? '-' }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fw-semibold fs-7">
                                                        {{ \Carbon\Carbon::parse($ret->return_date)->format('d M Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if (($ret->late_days ?? 0) > 0)
                                                        <span class="badge badge-light-danger">
                                                            <i class="ki-duotone ki-warning fs-8 me-1"><span
                                                                    class="path1"></span><span class="path2"></span></i>
                                                            {{ $ret->late_days }} hari
                                                        </span>
                                                    @else
                                                        <span class="badge badge-light-success">Tepat waktu</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($retCondition === 'good')
                                                        <span class="badge badge-light-success">Baik</span>
                                                    @elseif (in_array($retCondition, ['broken', 'damaged']))
                                                        <span class="badge badge-light-danger">Rusak</span>
                                                    @elseif ($retCondition === 'lost')
                                                        <span class="badge badge-light-danger">Hilang</span>
                                                    @else
                                                        <span class="text-muted fs-7">—</span>
                                                    @endif
                                                </td>
                                                <td class="pe-4">
                                                    <span class="text-gray-700 fs-7">{{ $ret->notes ?? '—' }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                                <span class="text-muted fs-7">
                                    Menampilkan {{ $returns->firstItem() }}–{{ $returns->lastItem() }} dari
                                    {{ $returns->total() }} data
                                </span>
                                {{ $returns->withQueryString()->links() }}
                            </div>
                        @endif
                    @endif

                    {{-- ══════════════════════════════════════════════════
                     TAB: PELANGGARAN
                ══════════════════════════════════════════════════ --}}
                    @if ($activeTab === 'violations')
                        @if ($violations->isEmpty())
                            <div class="text-center py-15">
                                <div class="symbol symbol-60px mb-5">
                                    <span class="symbol-label bg-light">
                                        <i class="ki-duotone ki-document fs-1 text-muted"><span
                                                class="path1"></span><span class="path2"></span></i>
                                    </span>
                                </div>
                                <h5 class="fw-bold text-gray-700 mb-2">Tidak Ada Data</h5>
                                <p class="text-muted fs-7 mb-0">Belum ada data pelanggaran.</p>
                            </div>
                        @else
                            {{-- Total Points Banner --}}
                            <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-4 mb-5">
                                <i class="ki-duotone ki-shield-cross fs-2tx text-danger me-4">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <span class="fw-bold fs-6 text-gray-800 d-block">Total Poin Pelanggaran</span>
                                        <span class="text-muted fs-7">Akumulasi dari semua pelanggaran pada filter saat
                                            ini</span>
                                    </div>
                                    <span class="badge badge-danger fs-4 ms-5 px-4 py-3">{{ $totalPoints }} poin</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="ps-4 rounded-start">User</th>
                                            <th>Kode Pinjam</th>
                                            <th>Alat</th>
                                            <th>Tipe</th>
                                            <th>Poin</th>
                                            <th>Terlambat</th>
                                            <th>Status</th>
                                            <th class="pe-4 rounded-end">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($violations as $violation)
                                            <tr>
                                                <td class="ps-4">
                                                    <span class="text-gray-800 fw-bold fs-7">
                                                        {{ $violation->user?->detail?->name ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-light fw-semibold fs-8"
                                                        style="font-family:monospace;letter-spacing:.03em;">
                                                        {{ $violation->loan?->loan_code ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-gray-700 fs-7">{{ $violation->loan?->tool?->name ?? '-' }}</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $typeMap = [
                                                            'late_return' => [
                                                                'class' => 'badge-light-warning',
                                                                'label' => 'Keterlambatan',
                                                            ],
                                                            'damage' => [
                                                                'class' => 'badge-light-danger',
                                                                'label' => 'Kerusakan',
                                                            ],
                                                            'loss' => [
                                                                'class' => 'badge-light-danger',
                                                                'label' => 'Kehilangan',
                                                            ],
                                                        ];
                                                        $t = $typeMap[$violation->type] ?? [
                                                            'class' => 'badge-light',
                                                            'label' => $violation->type,
                                                        ];
                                                    @endphp
                                                    <span class="badge {{ $t['class'] }}">{{ $t['label'] }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-danger">{{ $violation->points }} poin</span>
                                                </td>
                                                <td>
                                                    @if (($violation->days_late ?? 0) > 0)
                                                        <span
                                                            class="text-danger fw-semibold fs-7">{{ $violation->days_late }}
                                                            hari</span>
                                                    @else
                                                        <span class="text-muted fs-7">—</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($violation->status === 'pending')
                                                        <span class="badge badge-light-warning">Belum Selesai</span>
                                                    @else
                                                        <span class="badge badge-light-success">Selesai</span>
                                                    @endif
                                                </td>
                                                <td class="pe-4">
                                                    <span class="text-gray-700 fs-7">
                                                        {{ \Carbon\Carbon::parse($violation->created_at)->format('d M Y') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                                <span class="text-muted fs-7">
                                    Menampilkan {{ $violations->firstItem() }}–{{ $violations->lastItem() }} dari
                                    {{ $violations->total() }} data
                                </span>
                                {{ $violations->withQueryString()->links() }}
                            </div>
                        @endif
                    @endif

                    {{-- ══════════════════════════════════════════════════
                     TAB: USER
                ══════════════════════════════════════════════════ --}}
                    @if ($activeTab === 'users')
                        @if ($users->isEmpty())
                            <div class="text-center py-15">
                                <div class="symbol symbol-60px mb-5">
                                    <span class="symbol-label bg-light">
                                        <i class="ki-duotone ki-document fs-1 text-muted"><span
                                                class="path1"></span><span class="path2"></span></i>
                                    </span>
                                </div>
                                <h5 class="fw-bold text-gray-700 mb-2">Tidak Ada Data</h5>
                                <p class="text-muted fs-7 mb-0">Belum ada data user.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="ps-4 rounded-start">Nama</th>
                                            <th>Email</th>
                                            <th>Total Poin</th>
                                            <th>Pelanggaran</th>
                                            <th class="pe-4 rounded-end">Status Akun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="symbol symbol-40px">
                                                            <span
                                                                class="symbol-label bg-light-primary fw-bold text-primary">
                                                                {{ strtoupper(substr($user->detail?->name ?? $user->email, 0, 2)) }}
                                                            </span>
                                                        </div>
                                                        <span class="text-gray-800 fw-bold fs-7">
                                                            {{ $user->detail?->name ?? '-' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-gray-700 fs-7">{{ $user->email }}</span>
                                                </td>
                                                <td>
                                                    @if ($user->penalty_points > 0)
                                                        <span class="badge badge-danger">{{ $user->penalty_points }}
                                                            poin</span>
                                                    @else
                                                        <span class="badge badge-light-success">0 poin</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="text-gray-700 fw-semibold fs-7">
                                                        {{ $user->violations->count() }} pelanggaran
                                                    </span>
                                                </td>
                                                <td class="pe-4">
                                                    @if ($user->is_restricted)
                                                        <span class="badge badge-light-danger">
                                                            <i class="ki-duotone ki-lock-2 fs-8 me-1"><span
                                                                    class="path1"></span><span class="path2"></span></i>
                                                            Direstriksi
                                                        </span>
                                                    @else
                                                        <span class="badge badge-light-success">
                                                            <i class="ki-duotone ki-check fs-8 me-1"></i>
                                                            Aktif
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                                <span class="text-muted fs-7">
                                    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari
                                    {{ $users->total() }} data
                                </span>
                                {{ $users->withQueryString()->links() }}
                            </div>
                        @endif
                    @endif

                </div>
            </div>

        </div>
    </div>
@endsection
