@extends('master')

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            {{-- ══ Header ═══════════════════════════════════════════════════════ --}}
            <div class="d-flex align-items-center justify-content-between mb-7">
                <div>
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 my-0">
                        Monitoring Peminjaman
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">Manajemen</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Monitoring Peminjaman</li>
                    </ul>
                </div>
            </div>

            {{-- ══ Alert sukses / error ══════════════════════════════════════════ --}}
            @if (session('success'))
                <div class="alert alert-dismissible bg-light-success d-flex align-items-center p-5 mb-7">
                    <i class="ki-duotone ki-check-circle fs-2hx text-success me-4">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                    <div class="d-flex flex-column">
                        <span class="text-gray-700">{{ session('success') }}</span>
                    </div>
                    <button type="button"
                        class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                        data-bs-dismiss="alert">
                        <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span
                                class="path2"></span></i>
                    </button>
                </div>
            @endif

            {{-- ══ Alert Terlambat ══════════════════════════════════════════════ --}}
            @if ($overdueLoans->isNotEmpty())
                <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-5 mb-7">
                    <i class="ki-duotone ki-information-5 fs-2tx text-danger me-4 flex-shrink-0">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                    <div class="d-flex flex-column w-100">
                        <h4 class="mb-2 text-danger">{{ $overdueLoans->count() }} Peminjaman Melewati Batas Pengembalian!
                        </h4>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($overdueLoans as $ol)
                                <span class="badge badge-light-danger fs-8 py-2 px-3">
                                    <i class="ki-duotone ki-time fs-7 text-danger me-1"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    {{ $ol->loan_code }} — {{ $ol->user->userDetail->name ?? 'N/A' }}
                                    ({{ \Carbon\Carbon::parse($ol->due_date)->diffForHumans() }})
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- ══ Statistik Cards ══════════════════════════════════════════════ --}}
            <div class="row g-5 mb-7">
                @php
                    $cards = [
                        [
                            'label' => 'Total Peminjaman',
                            'key' => 'total',
                            'icon' => 'ki-document',
                            'color' => 'primary',
                        ],
                        ['label' => 'Pending', 'key' => 'pending', 'icon' => 'ki-time', 'color' => 'warning'],
                        ['label' => 'Approved', 'key' => 'approved', 'icon' => 'ki-check-circle', 'color' => 'success'],
                        [
                            'label' => 'Returned',
                            'key' => 'returned',
                            'icon' => 'ki-arrow-circle-left',
                            'color' => 'info',
                        ],
                        ['label' => 'Rejected', 'key' => 'rejected', 'icon' => 'ki-cross-circle', 'color' => 'danger'],
                        ['label' => 'Terlambat', 'key' => 'overdue', 'icon' => 'ki-warning-2', 'color' => 'danger'],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div class="col-6 col-md-4 col-xl-2">
                        <a href="{{ route('loans.monitoring', ['status' => !in_array($card['key'], ['total', 'overdue']) ? $card['key'] : '']) }}"
                            class="card bg-light-{{ $card['color'] }} hoverable text-decoration-none h-100">
                            <div class="card-body p-5">
                                <i class="ki-duotone {{ $card['icon'] }} fs-2x text-{{ $card['color'] }} mb-3">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <div class="text-{{ $card['color'] }} fw-bold fs-2x mb-1">
                                    {{ $stats[$card['key']] }}
                                </div>
                                <div class="fw-semibold text-gray-500 fs-7">{{ $card['label'] }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- ══ Card Utama ═══════════════════════════════════════════════════ --}}
            <div class="card">

                {{-- ── Card Header + Filter ──────────────────────────────────── --}}
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            <form method="GET" action="{{ route('loans.monitoring') }}" id="searchForm">
                                <input type="text" name="search" class="form-control form-control-solid w-250px ps-13"
                                    placeholder="Cari nama / kode pinjam..." value="{{ request('search') }}"
                                    onchange="document.getElementById('searchForm').submit()">
                            </form>
                        </div>
                    </div>

                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end align-items-center gap-3">

                            {{-- Filter Status --}}
                            <form method="GET" action="{{ route('loans.monitoring') }}" id="filterForm">
                                @if (request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                @if (request('date_from'))
                                    <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                                @endif
                                @if (request('date_to'))
                                    <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                                @endif

                                <select name="status" class="form-select form-select-solid w-150px"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Status</option>
                                    @foreach (['pending', 'approved', 'returned', 'rejected', 'canceled'] as $s)
                                        <option value="{{ $s }}" @selected(request('status') === $s)>
                                            {{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </form>

                            {{-- Filter Tanggal --}}
                            <button type="button" class="btn btn-light-primary btn-sm" data-bs-toggle="collapse"
                                data-bs-target="#filterDate">
                                <i class="ki-duotone ki-filter fs-3"><span class="path1"></span><span
                                        class="path2"></span></i>
                                Filter Tanggal
                            </button>

                            @if (request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                                <a href="{{ route('loans.monitoring') }}" class="btn btn-light-danger btn-sm">
                                    <i class="ki-duotone ki-cross fs-3"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    Reset
                                </a>
                            @endif

                        </div>
                    </div>
                </div>

                {{-- ── Filter Tanggal Collapsible ─────────────────────────────── --}}
                <div class="collapse {{ request()->hasAny(['date_from', 'date_to']) ? 'show' : '' }}" id="filterDate">
                    <div class="card-body pt-0 pb-5">
                        <form method="GET" action="{{ route('loans.monitoring') }}" class="d-flex align-items-end gap-3">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if (request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <div>
                                <label class="form-label fs-7 text-gray-600 mb-1">Dari Tanggal</label>
                                <input type="date" name="date_from" class="form-control form-control-solid w-175px"
                                    value="{{ request('date_from') }}">
                            </div>
                            <div>
                                <label class="form-label fs-7 text-gray-600 mb-1">Sampai Tanggal</label>
                                <input type="date" name="date_to" class="form-control form-control-solid w-175px"
                                    value="{{ request('date_to') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
                        </form>
                    </div>
                </div>

                {{-- ── Tabel ─────────────────────────────────────────────────── --}}
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">No</th>
                                    <th class="min-w-125px">Kode</th>
                                    <th class="min-w-200px">Peminjam</th>
                                    <th class="min-w-175px">Alat / Unit</th>
                                    <th class="min-w-100px">Tgl Pinjam</th>
                                    <th class="min-w-110px">Jatuh Tempo</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="min-w-100px text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse($loans as $loan)
                                    @php
                                        $isOverdue =
                                            $loan->status === 'approved' &&
                                            \Carbon\Carbon::parse($loan->due_date)->isPast();
                                    @endphp
                                    <tr class="{{ $isOverdue ? 'bg-light-danger' : '' }}">
                                        <td class="text-gray-500">
                                            {{ $loans->firstItem() + $loop->index }}
                                        </td>
                                        <td>
                                            <span class="text-gray-800 fw-bold text-hover-primary">
                                                {{ $loan->loan_code }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-35px me-3">
                                                    <span class="symbol-label bg-light-primary text-primary fw-bold fs-6">
                                                        {{ strtoupper(substr($loan->user->detail->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 fw-bold">
                                                        {{ $loan->user->detail->name ?? '-' }}
                                                    </span>
                                                    <span class="text-muted fs-7">{{ $loan->user->email ?? '' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="text-gray-800 fw-bold d-block">{{ $loan->tool->name ?? '-' }}</span>
                                            <span class="text-muted fs-7">Unit: {{ $loan->unit_code }}</span>
                                        </td>
                                        <td class="text-gray-600 fs-7">
                                            {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}
                                        </td>
                                        <td>
                                            @if ($isOverdue)
                                                <span class="text-danger fw-bold d-block fs-7">
                                                    {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                                </span>
                                                <span class="badge badge-light-danger fs-8">Terlambat</span>
                                            @else
                                                <span class="text-gray-600 fs-7">
                                                    {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $badge = match ($loan->status) {
                                                    'pending' => 'badge-light-warning',
                                                    'approved' => 'badge-light-success',
                                                    'returned' => 'badge-light-info',
                                                    'rejected' => 'badge-light-danger',
                                                    'canceled' => 'badge-light-secondary',
                                                    default => 'badge-light',
                                                };
                                            @endphp
                                            <span
                                                class="badge {{ $badge }} fs-8">{{ ucfirst($loan->status) }}</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">

                                                {{-- Detail --}}
                                                <button type="button" class="btn btn-icon btn-light btn-sm"
                                                    title="Detail" data-bs-toggle="modal"
                                                    data-bs-target="#modalDetailPeminjaman{{ $loan->id }}">
                                                    <i class="ki-duotone ki-eye fs-4 text-gray-600">
                                                        <span class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span>
                                                    </i>
                                                </button>

                                                @if ($loan->status === 'pending')
                                                    {{-- Approve --}}
                                                    <form action="{{ route('loans.monitoring.approve', $loan->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Approve peminjaman {{ $loan->loan_code }}?')">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-icon btn-light-success btn-sm" title="Approve">
                                                            <i class="ki-duotone ki-check fs-4 text-success">
                                                                <span class="path1"></span>
                                                            </i>
                                                        </button>
                                                    </form>

                                                    {{-- Reject --}}
                                                    <button type="button" class="btn btn-icon btn-light-danger btn-sm"
                                                        title="Reject" data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal" data-loan-id="{{ $loan->id }}"
                                                        data-loan-code="{{ $loan->loan_code }}">
                                                        <i class="ki-duotone ki-cross fs-4 text-danger">
                                                            <span class="path1"></span><span class="path2"></span>
                                                        </i>
                                                    </button>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-10">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ki-duotone ki-document fs-3x text-gray-300 mb-3">
                                                    <span class="path1"></span><span class="path2"></span>
                                                </i>
                                                <span class="text-muted fs-6">Tidak ada data peminjaman.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @foreach ($loans as $loan)
                            <div class="modal fade" id="modalDetailPeminjaman{{ $loan->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-800px">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="symbol symbol-40px">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-calendar-add fs-2 text-primary">
                                                            <span class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span>
                                                        </i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h2 class="fw-bold mb-0">Detail Peminjaman</h2>
                                                    <span
                                                        class="text-muted fs-8">#LN-{{ str_pad($loan->id, 4, '0', STR_PAD_LEFT) }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                @php
                                                    $statusMap = [
                                                        'pending' => [
                                                            'label' => 'Menunggu',
                                                            'class' => 'badge-light-warning',
                                                        ],
                                                        'approved' => [
                                                            'label' => 'Disetujui',
                                                            'class' => 'badge-light-success',
                                                        ],
                                                        'rejected' => [
                                                            'label' => 'Ditolak',
                                                            'class' => 'badge-light-danger',
                                                        ],
                                                        'returned' => [
                                                            'label' => 'Dikembalikan',
                                                            'class' => 'badge-light-info',
                                                        ],
                                                        'active' => [
                                                            'label' => 'Aktif',
                                                            'class' => 'badge-light-primary',
                                                        ],
                                                    ];
                                                    $s = $statusMap[$loan->status] ?? [
                                                        'label' => $loan->status,
                                                        'class' => 'badge-light-secondary',
                                                    ];
                                                @endphp
                                                <span class="badge {{ $s['class'] }} fs-7">{{ $s['label'] }}</span>
                                                <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                    data-bs-dismiss="modal">
                                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                            class="path2"></span></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-body px-7 py-8">

                                            {{-- Tool Info --}}
                                            <div class="d-flex align-items-center gap-4 p-5 rounded mb-6"
                                                style="background: var(--bs-gray-100);">
                                                <div class="symbol symbol-50px flex-shrink-0">
                                                    <span class="symbol-label bg-light-primary text-primary fw-bold fs-4">
                                                        {{ strtoupper(substr($loan->tool->name ?? 'NA', 0, 2)) }}
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-bold text-gray-800 fs-6 mb-1">
                                                        {{ $loan->tool->name ?? '-' }}</div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span
                                                            class="text-muted fs-8">#TL-{{ str_pad($loan->tool->id ?? 0, 3, '0', STR_PAD_LEFT) }}</span>
                                                        <span class="bullet bullet-dot bg-gray-400"></span>
                                                        <span class="text-muted fs-8">Unit: <strong
                                                                class="text-gray-700">{{ $loan->unit->code ?? '-' }}</strong></span>
                                                    </div>
                                                </div>
                                                @if (($loan->tool->item_type ?? 'single') === 'bundle')
                                                    <span class="badge badge-light-warning fs-8">Bundle</span>
                                                @else
                                                    <span class="badge badge-light-success fs-8">Single</span>
                                                @endif
                                            </div>

                                            {{-- Date Grid --}}
                                            <div class="row g-4 mb-6">
                                                <div class="col-6 col-md-3">
                                                    <div
                                                        class="d-flex flex-column p-4 rounded border border-dashed border-gray-300 h-100">
                                                        <span class="text-muted fs-8 mb-1">Tanggal Pinjam</span>
                                                        <span
                                                            class="fw-bold text-gray-800 fs-7">{{ $loan->loan_date?->format('d M Y') ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div
                                                        class="d-flex flex-column p-4 rounded border border-dashed border-gray-300 h-100">
                                                        <span class="text-muted fs-8 mb-1">Rencana Kembali</span>
                                                        <span
                                                            class="fw-bold text-gray-800 fs-7">{{ $loan->due_date?->format('d M Y') ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div
                                                        class="d-flex flex-column p-4 rounded border border-dashed border-gray-300 h-100">
                                                        <span class="text-muted fs-8 mb-1">Durasi</span>
                                                        <span class="fw-bold text-gray-800 fs-7">
                                                            {{ $loan->loan_date && $loan->due_date ? $loan->loan_date->diffInDays($loan->due_date) . ' Hari' : '-' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div
                                                        class="d-flex flex-column p-4 rounded border border-dashed border-gray-300 h-100">
                                                        <span class="text-muted fs-8 mb-1">Diajukan</span>
                                                        <span
                                                            class="fw-bold text-gray-800 fs-7">{{ $loan->created_at->format('d M Y, H:i') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Profil Peminjam --}}
                                            <div class="d-flex align-items-center mb-5">
                                                <span
                                                    class="fw-bold text-gray-500 fs-8 text-uppercase ls-1 me-3 text-nowrap">Profil
                                                    Peminjam</span>
                                                <div class="flex-grow-1 border-bottom border-dashed border-gray-300"></div>
                                            </div>

                                            <div
                                                class="d-flex align-items-center gap-4 p-5 rounded border border-dashed border-gray-300 mb-5">
                                                <div class="symbol symbol-50px flex-shrink-0">
                                                    <span class="symbol-label bg-light-success text-success fw-bold fs-5">
                                                        {{ strtoupper(substr($loan->user->detail->name ?? ($loan->user->name ?? 'NA'), 0, 2)) }}
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-bold text-gray-800 fs-6 mb-1">
                                                        {{ $loan->user->detail->name ?? ($loan->user->name ?? '-') }}</div>
                                                    <span
                                                        class="badge badge-light-info fs-8">{{ ucfirst($loan->user->role ?? 'Pengguna') }}</span>
                                                </div>
                                            </div>

                                            <div class="row g-3 mb-6">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center gap-3 p-4 rounded"
                                                        style="background: var(--bs-gray-100);">
                                                        <i class="ki-duotone ki-sms fs-3 text-gray-500"><span
                                                                class="path1"></span><span class="path2"></span></i>
                                                        <div>
                                                            <div class="text-muted fs-8 mb-1">Email</div>
                                                            <div class="fw-semibold text-gray-700 fs-7">
                                                                {{ $loan->user->email ?? '-' }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center gap-3 p-4 rounded"
                                                        style="background: var(--bs-gray-100);">
                                                        <i class="ki-duotone ki-phone fs-3 text-gray-500"><span
                                                                class="path1"></span><span class="path2"></span></i>
                                                        <div>
                                                            <div class="text-muted fs-8 mb-1">No. Telepon</div>
                                                            <div class="fw-semibold text-gray-700 fs-7">
                                                                {{ $loan->user->detail->no_hp ?? '-' }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Keperluan & Catatan --}}
                                            <div class="d-flex align-items-center mb-5">
                                                <span
                                                    class="fw-bold text-gray-500 fs-8 text-uppercase ls-1 me-3 text-nowrap">Keperluan
                                                    & Catatan</span>
                                                <div class="flex-grow-1 border-bottom border-dashed border-gray-300"></div>
                                            </div>

                                            <div class="mb-4">
                                                <div class="text-muted fs-8 mb-2">Keperluan</div>
                                                <div class="text-gray-800 fs-7 fw-semibold">{{ $loan->purpose ?? '-' }}
                                                </div>
                                            </div>

                                            @if ($loan->notes)
                                                <div class="mb-2">
                                                    <div class="text-muted fs-8 mb-2">Catatan Tambahan</div>
                                                    <div
                                                        class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-4">
                                                        <i class="ki-duotone ki-information fs-2 text-warning me-3">
                                                            <span class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span>
                                                        </i>
                                                        <div class="text-gray-700 fs-7">{{ $loan->notes }}</div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>

                                        <div
                                            class="modal-footer py-4 px-7 border-top border-gray-200 d-flex justify-content-between">
                                            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-4"><span class="path1"></span><span
                                                        class="path2"></span></i>
                                                Tutup
                                            </button>

                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-success"
                                                    data-bs-dismiss="modal" data-bs-toggle="modal"
                                                    data-bs-target="#approveModal" data-loan-id="{{ $loan->id }}"
                                                    data-loan-code="{{ $loan->loan_code }}">
                                                    <i class="ki-duotone ki-check-circle fs-4"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                    Setujui
                                                </button>

                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-bs-dismiss="modal" data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal" data-loan-id="{{ $loan->id }}"
                                                    data-loan-code="{{ $loan->loan_code }}">
                                                    <i class="ki-duotone ki-cross-circle fs-4"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                    Tolak
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($loans->hasPages())
                        <div class="d-flex justify-content-between align-items-center pt-5">
                            <div class="text-muted fs-7">
                                Menampilkan {{ $loans->firstItem() }}–{{ $loans->lastItem() }}
                                dari {{ $loans->total() }} data
                            </div>
                            {{ $loans->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tolak Peminjaman</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-4 mb-5">
                            <i class="ki-duotone ki-information-5 fs-2tx text-warning me-4">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                            <div class="d-flex flex-column">
                                <h5 class="mb-1">Konfirmasi Penolakan</h5>
                                <span class="text-gray-600 fs-7">
                                    Kode peminjaman: <strong id="rejectLoanCode"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="fv-row">
                            <label class="fs-6 fw-semibold form-label mb-2">
                                Alasan Penolakan
                                <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <textarea name="notes" class="form-control form-control-solid" rows="4"
                                placeholder="Tulis alasan penolakan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="ki-duotone ki-cross-circle fs-3 me-1"><span class="path1"></span><span
                                    class="path2"></span></i>
                            Tolak Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const rejectModal = document.getElementById('rejectModal');
        rejectModal.addEventListener('show.bs.modal', function(e) {
            const btn = e.relatedTarget;
            const loanId = btn.dataset.loanId;
            const loanCode = btn.dataset.loanCode;
            document.getElementById('rejectLoanCode').textContent = loanCode;
            document.getElementById('rejectForm').action = `/management-loans/${loanId}/reject`;
        });
    </script>


@endsection
