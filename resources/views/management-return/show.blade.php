@extends('master')

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            {{-- PAGE HEADING --}}
            <div class="d-flex align-items-center justify-content-between mb-7">
                <div>
                    <h1 class="page-heading text-gray-900 fw-bold fs-3 my-0">
                        Pengajuan Pengembalian
                    </h1>

                    @if ($loans)
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                            <li class="breadcrumb-item text-muted">Pengembalian</li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">{{ $loans->loan_code }}</li>
                        </ul>
                    @endif
                </div>
            </div>

            @if (!$loans)
                <div class="alert alert-info d-flex align-items-center gap-3">
                    <i class="ki-duotone ki-information-5 fs-2tx text-info">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                    <div>
                        <h5 class="mb-1 text-info">Tidak Ada Peminjaman Aktif</h5>
                        <span class="fs-7 text-gray-700">Kamu belum memiliki pengajuan pengembalian.</span>
                    </div>
                </div>

                {{-- Cek violation dari peminjaman terakhir --}}
                @if ($lastReturn && $lastReturn->violations->isNotEmpty())
                    @php
                        $totalPoints = $lastReturn->violations->sum('points');
                        $lastCondition = $lastReturn->return?->unitConditions?->first()?->conditions;
                    @endphp
                    <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-4 mt-4">
                        <i class="ki-duotone ki-warning-2 fs-2tx text-danger me-4 mt-1">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        <div class="d-flex flex-column w-100">
                            <h5 class="mb-3 text-danger">Peminjaman Terakhir Memiliki Pelanggaran</h5>
                            <div class="d-flex flex-column gap-2">

                                @foreach ($lastReturn->violations as $v)
                                    <div
                                        class="d-flex justify-content-between align-items-center bg-white rounded px-3 py-2 border border-danger border-opacity-25">
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($v->type === 'late_return')
                                                <i class="ki-duotone ki-time fs-5 text-warning">
                                                    <span class="path1"></span><span class="path2"></span>
                                                </i>
                                                <div>
                                                    <span class="fw-bold fs-7 text-gray-800 d-block">Keterlambatan</span>
                                                    <span class="text-muted fs-8">{{ $v->description }}</span>
                                                </div>
                                            @elseif ($v->type === 'damage')
                                                <i class="ki-duotone ki-wrench fs-5 text-danger">
                                                    <span class="path1"></span><span class="path2"></span>
                                                </i>
                                                <div>
                                                    <span class="fw-bold fs-7 text-gray-800 d-block">Kerusakan Alat</span>
                                                    <span
                                                        class="text-muted fs-8">{{ $v->description ?? 'Alat dikembalikan dalam kondisi rusak' }}</span>
                                                </div>
                                            @elseif ($v->type === 'loss')
                                                <i class="ki-duotone ki-cross-circle fs-5 text-danger">
                                                    <span class="path1"></span><span class="path2"></span>
                                                </i>
                                                <div>
                                                    <span class="fw-bold fs-7 text-gray-800 d-block">Kehilangan Alat</span>
                                                    <span
                                                        class="text-muted fs-8">{{ $v->description ?? 'Alat tidak dikembalikan' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="badge badge-light-danger">{{ $v->points }} poin</span>
                                    </div>
                                @endforeach

                                <div
                                    class="d-flex justify-content-between align-items-center pt-2 border-top border-danger border-opacity-25">
                                    <span class="fw-bold fs-7 text-danger">Total Poin Pelanggaran</span>
                                    <span class="badge badge-danger">{{ $totalPoints }} poin</span>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if ($loans)
                @php
                    $isOverdue = $loans->status === 'approved' && \Carbon\Carbon::parse($loans->due_date)->isPast();

                    $statusBadge = match ($loans->status) {
                        'pending_return' => ['class' => 'badge-light-warning', 'label' => 'Menunggu Verifikasi'],
                        'approved' => ['class' => 'badge-light-primary', 'label' => 'Siap Dikembalikan'],
                        'returned' => ['class' => 'badge-light-success', 'label' => 'Selesai'],
                        default => ['class' => 'badge-light', 'label' => ucfirst($loans->status)],
                    };
                @endphp

                <div class="row g-7">

                    {{-- MAIN CONTENT --}}
                    <div class="col-xl-8">

                        {{-- STATUS + TIMELINE CARD --}}
                        <div class="card mb-7">
                            <div class="card-body p-7">

                                {{-- Header --}}
                                <div class="d-flex align-items-center justify-content-between mb-6">
                                    <div>
                                        <h4 class="fw-bold text-gray-800 mb-1">{{ $loans->loan_code }}</h4>
                                        <span class="text-muted fs-7">
                                            Dipinjam {{ \Carbon\Carbon::parse($loans->created_at)->diffForHumans() }}
                                        </span>
                                    </div>

                                    <span class="badge {{ $statusBadge['class'] }} fs-6 px-4 py-3">
                                        {{ $statusBadge['label'] }}
                                    </span>
                                </div>

                                {{-- TIMELINE --}}
                                @php
                                    $steps = [
                                        ['key' => 'pending', 'label' => 'Pengajuan'],
                                        ['key' => 'approved', 'label' => 'Menunggu Verifikasi'],
                                        ['key' => 'returned', 'label' => 'Dikembalikan'],
                                    ];
                                    $statusOrder = ['pending' => 0, 'approved' => 1, 'returned' => 2];
                                    $currentStatus = 'approved';
                                @endphp

                                <div class="d-flex align-items-center w-100">

                                    @foreach ($steps as $step)
                                        @php
                                            $isActive = $statusOrder[$currentStatus] >= $statusOrder[$step['key']];
                                        @endphp

                                        <div class="d-flex flex-column align-items-center">
                                            <div class="symbol symbol-40px mb-2">
                                                <span
                                                    class="symbol-label {{ $isActive ? 'bg-light-primary' : 'bg-light' }}">
                                                    <i
                                                        class="ki-duotone ki-check fs-3 {{ $isActive ? 'text-primary' : 'text-gray-400' }}"></i>
                                                </span>
                                            </div>
                                            <span class="fs-8 fw-semibold {{ $isActive ? '' : 'text-gray-400' }}">
                                                {{ $step['label'] }}
                                            </span>
                                        </div>

                                        @if (!$loop->last)
                                            <div class="flex-grow-1 border-top border-dashed border-gray-300 mx-3 mb-5">
                                            </div>
                                        @endif
                                    @endforeach

                                </div>

                            </div>
                        </div>

                        {{-- CARD INFO ALAT --}}
                        <div class="card card-flush mb-7">
                            <div class="card-body p-0">
                                <div class="d-flex">

                                    {{-- Foto --}}
                                    <div class="flex-shrink-0" style="width: 180px; min-height: 180px;">
                                        @if (!empty($loans->tool->photo_path) && file_exists(public_path($loans->tool->photo_path)))
                                            <img src="{{ asset($loans->tool->photo_path) }}"
                                                alt="{{ $loans->tool->name }}"
                                                style="width: 180px; height: 100%; min-height: 180px; object-fit: cover;
                                                   border-radius: var(--bs-card-border-radius) 0 0 var(--bs-card-border-radius);">
                                        @else
                                            <div class="bg-light-warning text-warning fw-bold fs-1 d-flex align-items-center justify-content-center h-100"
                                                style="width: 180px; min-height: 180px;
                                                   border-radius: var(--bs-card-border-radius) 0 0 var(--bs-card-border-radius);">
                                                {{ strtoupper(substr($loans->tool->name ?? 'T', 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex-grow-1 p-7" style="min-width: 0;">

                                        <div class="d-flex align-items-start justify-content-between mb-5">
                                            <div>
                                                <h3 class="fw-bold text-gray-800 mb-1">
                                                    {{ $loans->tool?->name ?? '-' }}
                                                </h3>
                                                <span class="text-muted fs-7">
                                                    Kode Pinjam : {{ $loans->loan_code }}
                                                </span>
                                            </div>

                                            <div class="d-flex gap-2">
                                                @if ($loans->tool?->item_type == 'single')
                                                    <span class="badge badge-light-success">Single</span>
                                                @else
                                                    <span class="badge badge-light-warning">Bundle</span>
                                                @endif

                                                <span class="badge badge-light-info">
                                                    {{ $loans->tool->category->name ?? '-' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="text-gray-600 fs-6 mb-5">
                                            {{ $loans->tool?->description ?? 'Tidak ada deskripsi.' }}
                                        </div>

                                        <div class="d-flex gap-6 pt-4 border-top">

                                            <div class="d-flex flex-column">
                                                <span class="text-muted fs-8 mb-1">Unit Dipinjam</span>
                                                <span class="text-gray-800 fw-semibold fs-7">
                                                    {{ $loans->unit_code }}
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column">
                                                <span class="text-muted fs-8 mb-1">Tanggal Pinjam</span>
                                                <span class="text-gray-800 fw-semibold fs-7">
                                                    {{ \Carbon\Carbon::parse($loans->loan_date)->format('d M Y') }}
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column">
                                                <span class="text-muted fs-8 mb-1">Jatuh Tempo</span>
                                                <span class="text-warning fw-semibold fs-7">
                                                    {{ \Carbon\Carbon::parse($loans->due_date)->format('d M Y') }}
                                                </span>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- SIDEBAR --}}
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">

                                <h6 class="fw-bolder text-gray-600 fs-7 mb-16 text-uppercase">
                                    Ringkasan
                                </h6>

                                <div class="d-flex flex-column gap-4">

                                    <div class="d-flex justify-content-between">
                                        <span>Status</span>
                                        <span class="badge {{ $statusBadge['class'] }} fs-6 px-4 py-3">
                                            {{ $statusBadge['label'] }}
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span>Kode Pinjam</span>
                                        <span class="fw-bold">
                                            {{ $loans->loan_code }}
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span>Alat</span>
                                        <span class="fw-bold text-end" style="max-width: 60%;">
                                            {{ $loans->tool?->name ?? '-' }}
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span>Unit</span>
                                        <span class="fw-bold">
                                            {{ $loans->unit_code }}
                                        </span>
                                    </div>

                                    <div class="separator separator-dashed my-2"></div>

                                    @php
                                        $isOverdue = \Carbon\Carbon::parse($loans->due_date)->isPast();
                                        $daysLeft = \Carbon\Carbon::now()->diffInDays($loans->due_date, false);
                                    @endphp

                                    <div class="d-flex justify-content-between">
                                        <span>Jatuh Tempo</span>
                                        <span class="fw-bold {{ $isOverdue ? 'text-danger' : 'text-warning' }}">
                                            {{ \Carbon\Carbon::parse($loans->due_date)->format('d M Y') }}
                                        </span>
                                    </div>

                                    @if ($isOverdue)
                                        <div
                                            class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-4">
                                            <i class="ki-duotone ki-warning-2 fs-2tx text-danger me-4">
                                                <span class="path1"></span><span class="path2"></span>
                                            </i>
                                            <div>
                                                <h6 class="mb-1 text-danger">Terlambat!</h6>
                                                <span class="fs-7">Sudah melewati jatuh tempo {{ abs($daysLeft) }}
                                                    hari.</span>
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-4">
                                            <i class="ki-duotone ki-time fs-2tx text-warning me-4">
                                                <span class="path1"></span><span class="path2"></span>
                                            </i>
                                            <div>
                                                <h6 class="mb-1 text-warning">Segera Kembalikan</h6>
                                                <span class="fs-7">
                                                    Sisa {{ $timeLeft }} sebelum jatuh tempo.
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">

                        <div class="row g-7">

                            {{-- DETAIL PEMINJAMAN --}}
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h4 class="card-title">Detail Peminjaman</h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-5">

                                            <div class="col-12">
                                                <div class="border border-dashed p-4 rounded">
                                                    <span class="text-muted fs-8">Tanggal Pinjam</span>
                                                    <div class="fw-bold">
                                                        {{ \Carbon\Carbon::parse($loans->loan_date)->translatedFormat('d F Y') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="border border-dashed p-4 rounded">
                                                    <span class="text-muted fs-8">Jatuh Tempo</span>
                                                    <div class="fw-bold">
                                                        {{ \Carbon\Carbon::parse($loans->due_date)->translatedFormat('d F Y') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="border border-dashed p-4 rounded">
                                                    <span class="text-muted fs-8">Durasi</span>
                                                    <div class="fw-bold">
                                                        {{ \Carbon\Carbon::parse($loans->loan_date)->diffInDays($loans->due_date) }}
                                                        hari
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- FORM PENGEMBALIAN --}}
                            <div class="col-md-6">
                                @if ($loans && $loans->status === 'approved')
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h4 class="card-title">Form Pengembalian</h4>
                                        </div>

                                        <div class="card-body">
                                            <form action="{{ route('return.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="loan_id" value="{{ $loans->id }}">

                                                <div class="mb-5">
                                                    <label class="form-label">Catatan</label>
                                                    <textarea name="notes" class="form-control" rows="3"
                                                        placeholder="Contoh: alat dikembalikan dalam kondisi baik"></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-warning">
                                                    <i class="ki-duotone ki-arrow-up-right fs-4"></i>
                                                    Ajukan Pengembalian
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="card h-100">
                                        <div class="card-body text-center p-10">
                                            @if ($loans)
                                                <i class="ki-duotone ki-time fs-1 text-warning mb-5 d-block"></i>
                                                <h5 class="text-warning mb-3">Menunggu Verifikasi</h5>
                                                <p class="text-muted mb-0">
                                                    Anda sudah melakukan <strong>pengajuan pengembalian</strong>.
                                                    <br>Silakan tunggu petugas melakukan pemeriksaan dan persetujuan
                                                    pengembalian.
                                                </p>
                                            @else
                                                <i class="ki-duotone ki-inbox fs-1 text-muted mb-5 d-block"></i>
                                                <h5 class="text-muted mb-3">Belum Ada Pinjaman</h5>
                                                <p class="text-muted mb-0">Silakan ajukan peminjaman terlebih dahulu.</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>

                    </div>
                </div>
        </div>
        @endif
    </div>
@endsection
