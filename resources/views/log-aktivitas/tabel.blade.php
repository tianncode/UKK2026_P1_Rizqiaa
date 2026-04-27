@extends('master')

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            {{-- PAGE HEADING --}}
            <div class="d-flex align-items-center justify-content-between mb-7">
                <div>
                    <h1 class="page-heading text-gray-900 fw-bold fs-3 my-0">Log Aktivitas</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">Admin</li>
                        <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                        <li class="breadcrumb-item text-muted">Log Aktivitas</li>
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
                                    <i class="ki-duotone ki-calendar-tick fs-2 text-primary">
                                        <span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span><span class="path4"></span><span
                                            class="path5"></span><span class="path6"></span>
                                    </i>
                                </span>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-gray-800">{{ $stats['total_today'] }}</div>
                                <div class="text-muted fs-7">Aktivitas Hari Ini</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center gap-4 p-6">
                            <div class="symbol symbol-45px">
                                <span class="symbol-label bg-light-info">
                                    <i class="ki-duotone ki-calendar fs-2 text-info">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-gray-800">{{ $stats['total_week'] }}</div>
                                <div class="text-muted fs-7">Minggu Ini</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center gap-4 p-6">
                            <div class="symbol symbol-45px">
                                <span class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-people fs-2 text-success">
                                        <span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span><span class="path4"></span><span class="path5"></span>
                                    </i>
                                </span>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-gray-800">{{ $stats['unique_users'] }}</div>
                                <div class="text-muted fs-7">User Aktif Hari Ini</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center gap-4 p-6">
                            <div class="symbol symbol-45px">
                                <span class="symbol-label bg-light-warning">
                                    <i class="ki-duotone ki-abstract-26 fs-2 text-warning">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-gray-800">{{ number_format($stats['total_all']) }}</div>
                                <div class="text-muted fs-7">Total Semua Log</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE CARD --}}
            <div class="card">

                {{-- FILTER --}}
                <div class="card-header border-0 pt-6">
                    <div class="card-title w-100">
                        <form method="GET" action="{{ request()->url() }}"
                            class="d-flex align-items-center gap-3 flex-wrap w-100">

                            {{-- Search --}}
                            <div class="d-flex align-items-center position-relative">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-solid w-250px ps-13"
                                    placeholder="Cari nama atau deskripsi...">
                            </div>

                            {{-- User --}}
                            <select name="user_id" class="form-select form-select-solid w-200px">
                                <option value="">Semua User</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}"
                                        {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                        {{ $u->detail?->name ?? $u->email }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Module --}}
                            <select name="module" class="form-select form-select-solid w-150px">
                                <option value="">Semua Modul</option>
                                @foreach ($modules as $mod)
                                    <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>
                                        {{ ucfirst($mod) }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Action --}}
                            <select name="action" class="form-select form-select-solid w-150px">
                                <option value="">Semua Aksi</option>
                                @foreach ($actions as $act)
                                    <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>
                                        {{ ucfirst($act) }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Date range --}}
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="form-control form-control-solid w-150px">
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="form-control form-control-solid w-150px">

                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="ki-duotone ki-filter fs-4 me-1">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                Filter
                            </button>

                            @if (request()->hasAny(['search', 'user_id', 'module', 'action', 'date_from', 'date_to']))
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

                {{-- TABLE --}}
                <div class="card-body py-4">
                    @if ($logs->isEmpty())
                        <div class="text-center py-15">
                            <div class="symbol symbol-60px mb-5">
                                <span class="symbol-label bg-light">
                                    <i class="ki-duotone ki-abstract-26 fs-1 text-muted">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <h5 class="fw-bold text-gray-700 mb-2">Tidak Ada Log</h5>
                            <p class="text-muted fs-7 mb-0">Belum ada aktivitas yang sesuai filter.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="ps-4 rounded-start">User</th>
                                        <th>Aksi</th>
                                        <th>Modul</th>
                                        <th>Deskripsi</th>
                                        <th>IP Address</th>
                                        <th class="pe-4 rounded-end">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        <tr>
                                            {{-- User --}}
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="symbol symbol-35px">
                                                        <span
                                                            class="symbol-label bg-light-primary fw-bold text-primary fs-7">
                                                            {{ strtoupper(substr($log->user?->detail?->name ?? ($log->user?->email ?? '?'), 0, 2)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-800 fw-bold fs-7 d-block">
                                                            {{ $log->user?->detail?->name ?? '-' }}
                                                        </span>
                                                        <span
                                                            class="text-muted fs-8">{{ $log->user?->email ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Aksi --}}
                                            <td>
                                                @php
                                                    $actionConfig = match ($log->action) {
                                                        'login' => [
                                                            'bg' => 'badge-light-success',
                                                            'icon' => 'ki-entrance-right',
                                                            'label' => 'Login',
                                                        ],
                                                        'logout' => [
                                                            'bg' => 'badge-light-secondary',
                                                            'icon' => 'ki-entrance-left',
                                                            'label' => 'Logout',
                                                        ],
                                                        'create' => [
                                                            'bg' => 'badge-light-primary',
                                                            'icon' => 'ki-plus-circle',
                                                            'label' => 'Tambah',
                                                        ],
                                                        'update' => [
                                                            'bg' => 'badge-light-info',
                                                            'icon' => 'ki-pencil',
                                                            'label' => 'Edit',
                                                        ],
                                                        'delete' => [
                                                            'bg' => 'badge-light-danger',
                                                            'icon' => 'ki-trash',
                                                            'label' => 'Hapus',
                                                        ],
                                                        'approve' => [
                                                            'bg' => 'badge-light-success',
                                                            'icon' => 'ki-check-circle',
                                                            'label' => 'Approve',
                                                        ],
                                                        'reject' => [
                                                            'bg' => 'badge-light-danger',
                                                            'icon' => 'ki-cross-circle',
                                                            'label' => 'Reject',
                                                        ],
                                                        'export' => [
                                                            'bg' => 'badge-light-warning',
                                                            'icon' => 'ki-file-down',
                                                            'label' => 'Export',
                                                        ],
                                                        default => [
                                                            'bg' => 'badge-light',
                                                            'icon' => 'ki-information',
                                                            'label' => ucfirst($log->action),
                                                        ],
                                                    };
                                                @endphp
                                                <span
                                                    class="badge {{ $actionConfig['bg'] }} d-inline-flex align-items-center gap-1">
                                                    <i class="ki-duotone {{ $actionConfig['icon'] }} fs-8">
                                                        <span class="path1"></span><span class="path2"></span>
                                                    </i>
                                                    {{ $actionConfig['label'] }}
                                                </span>
                                            </td>

                                            {{-- Modul --}}
                                            <td>
                                                @php
                                                    $moduleConfig = match ($log->module) {
                                                        'auth' => ['bg' => 'bg-light-dark', 'label' => 'Auth'],
                                                        'loans' => [
                                                            'bg' => 'bg-light-primary',
                                                            'label' => 'Peminjaman',
                                                        ],
                                                        'returns' => [
                                                            'bg' => 'bg-light-info',
                                                            'label' => 'Pengembalian',
                                                        ],
                                                        'violations' => [
                                                            'bg' => 'bg-light-danger',
                                                            'label' => 'Pelanggaran',
                                                        ],
                                                        'tools' => ['bg' => 'bg-light-warning', 'label' => 'Alat'],
                                                        'users' => ['bg' => 'bg-light-success', 'label' => 'User'],
                                                        'categories' => [
                                                            'bg' => 'bg-light-info',
                                                            'label' => 'Kategori',
                                                        ],
                                                        'reports' => ['bg' => 'bg-light-warning', 'label' => 'Laporan'],
                                                        default => [
                                                            'bg' => 'bg-light',
                                                            'label' => ucfirst($log->module),
                                                        ],
                                                    };
                                                @endphp
                                                <span
                                                    class="badge {{ $moduleConfig['bg'] }} text-gray-700 fw-semibold fs-8 px-3 py-2">
                                                    {{ $moduleConfig['label'] }}
                                                </span>
                                            </td>

                                            {{-- Deskripsi --}}
                                            <td>
                                                <span class="text-gray-700 fs-7">{{ $log->description }}</span>
                                                @if (!empty($log->meta))
                                                    <button class="btn btn-icon btn-light btn-xs ms-2"
                                                        data-bs-toggle="popover" data-bs-trigger="click"
                                                        data-bs-html="true"
                                                        data-bs-content="<pre class='mb-0 fs-8'>{{ e(json_encode($log->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) }}</pre>"
                                                        title="Detail Meta">
                                                        <i class="ki-duotone ki-information fs-6 text-muted">
                                                            <span class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span>
                                                        </i>
                                                    </button>
                                                @endif
                                            </td>

                                            {{-- IP --}}
                                            <td>
                                                <span class="text-muted fs-8" style="font-family:monospace">
                                                    {{ $log->ip_address ?? '-' }}
                                                </span>
                                            </td>

                                            {{-- Waktu --}}
                                            <td class="pe-4">
                                                <span class="text-gray-800 fw-semibold fs-7 d-block">
                                                    {{ $log->created_at->format('d M Y') }}
                                                </span>
                                                <span class="text-muted fs-8">
                                                    {{ $log->created_at->format('H:i:s') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @endif
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Init semua popover
                document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => {
                    new bootstrap.Popover(el, {
                        sanitize: false
                    });
                });
            });
        </script>
    @endpush
@endsection
