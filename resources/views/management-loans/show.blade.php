@extends('master')

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            <div class="d-flex align-items-center justify-content-between mb-7">
                <div>
                    <h1 class="page-heading text-gray-900 fw-bold fs-3 my-0">
                        Status Pengajuan Peminjaman
                    </h1>

                    @if ($loans)
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                            <li class="breadcrumb-item text-muted">Peminjaman</li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">{{ $loans->loan_code }}</li>
                        </ul>
                    @endif
                </div>
            </div>

            @if (!$loans)
                <div class="alert alert-info">
                    Kamu belum memiliki pengajuan peminjaman.
                </div>
            @endif

            @if ($loans)
                @php
                    $isOverdue = $loans->status === 'approved' && \Carbon\Carbon::parse($loans->due_date)->isPast();

                    $statusBadge = match ($loans->status) {
                        'pending' => ['class' => 'badge-light-warning', 'label' => 'Menunggu Persetujuan'],
                        'approved' => ['class' => 'badge-light-success', 'label' => 'Disetujui'],
                        'returned' => ['class' => 'badge-light-info', 'label' => 'Dikembalikan'],
                        'rejected' => ['class' => 'badge-light-danger', 'label' => 'Ditolak'],
                        default => ['class' => 'badge-light', 'label' => ucfirst($loans->status)],
                    };
                @endphp

                <div class="row g-7">

                    <div class="col-xl-8">
                        {{-- STATUS --}}
                        <div class="card mb-7">
                            <div class="card-body p-7">

                                <div class="d-flex align-items-center justify-content-between mb-6">
                                    <div>
                                        <h4 class="fw-bold text-gray-800 mb-1">{{ $loans->loan_code }}</h4>
                                        <span class="text-muted fs-7">
                                            Diajukan {{ \Carbon\Carbon::parse($loans->created_at)->diffForHumans() }}
                                        </span>
                                    </div>

                                    <span class="badge {{ $statusBadge['class'] }} fs-6 px-4 py-3">
                                        {{ $statusBadge['label'] }}
                                    </span>

                                </div>

                                {{-- TIMELINE --}}
                                <div class="d-flex align-items-center w-100">

                                    @php
                                        $steps = [
                                            ['key' => 'pending', 'label' => 'Diajukan'],
                                            ['key' => 'approved', 'label' => 'Disetujui'],
                                            ['key' => 'returned', 'label' => 'Dikembalikan'],
                                        ];
                                    @endphp

                                    @foreach ($steps as $step)
                                        <div class="d-flex flex-column align-items-center">

                                            <div class="symbol symbol-40px mb-2">
                                                <span
                                                    class="symbol-label {{ $loans->status == $step['key'] || $loans->status == 'returned' ? 'bg-light-primary' : 'bg-light' }}">
                                                    <i
                                                        class="ki-duotone ki-check fs-3 {{ $loans->status == $step['key'] || $loans->status == 'returned' ? 'text-primary' : 'text-gray-400' }}"></i>
                                                </span>
                                            </div>

                                            <span class="fs-8 fw-semibold">
                                                {{ $step['label'] }}
                                            </span>

                                        </div>

                                        @if (!$loop->last)
                                            <div class="flex-grow-1 border-top border-dashed border-gray-300 mx-3 mb-5">
                                            </div>
                                        @endif
                                    @endforeach

                                    @if ($loans->status == 'rejected')
                                        <div class="flex-grow-1 border-top border-dashed border-gray-300 mx-3 mb-5"></div>

                                        <div class="d-flex flex-column align-items-center">
                                            <div class="symbol symbol-40px mb-2">
                                                <span class="symbol-label bg-light-danger">
                                                    <i class="ki-duotone ki-cross fs-3 text-danger"></i>
                                                </span>
                                            </div>

                                            <span class="fs-8 fw-semibold text-danger">
                                                Ditolak
                                            </span>

                                        </div>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- SIDEBAR --}}
                    <div class="col-xl-4">
                        <div class="card sticky-top">
                            <div class="card-body">

                                <h6 class="fw-bolder text-gray-600 fs-7 mb-16 text-uppercase">
                                    Ringkasan
                                </h6>

                                <div class="d-flex flex-column gap-4">

                                    <div class="d-flex justify-content-between">
                                        <span>Status</span>
                                        <span class="badge {{ $statusBadge['class'] }}">
                                            {{ $statusBadge['label'] }}
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span>Kode Pinjam</span>
                                        <span class="fw-bold">
                                            {{ $loans->loan_code }}
                                        </span>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-xl-12">
                    <!--begin::Card Info Alat-->
                    <div class="card card-flush mb-8">
                        <div class="card-body p-0">
                            <div class="d-flex">

                                <!--begin::Foto-->
                                <div class="flex-shrink-0" style="width: 180px; min-height: 180px;">
                                    @if (!empty($loans->tool->photo_path) && file_exists(public_path($loans->tool->photo_path)))
                                        <img src="{{ asset($loans->tool->photo_path) }}" alt="{{ $loans->tool->name }}"
                                            style="width: 180px; height: 100%; min-height: 180px; object-fit: cover;
                        border-radius: var(--bs-card-border-radius) 0 0 var(--bs-card-border-radius);">
                                    @else
                                        <div class="bg-light-primary text-primary fw-bold fs-1 d-flex align-items-center justify-content-center h-100"
                                            style="width: 180px; min-height: 180px;
                        border-radius: var(--bs-card-border-radius) 0 0 var(--bs-card-border-radius);">
                                            {{ strtoupper(substr($loans->tool->name ?? 'T', 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                <!--end::Foto-->

                                <!--begin::Info-->
                                <div class="flex-grow-1 p-7" style="min-width:0;">

                                    <div class="d-flex align-items-start justify-content-between mb-5">

                                        <div>
                                            <h3 class="fw-bold text-gray-800 mb-1">
                                                {{ $loans->tool->name ?? '-' }}
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
                                        {{ $loans->tool->description ?? 'Tidak ada deskripsi.' }}
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
                                <!--end::Info-->

                            </div>
                        </div>
                    </div>
                    <!--end::Card Info Alat-->

                    {{-- DETAIL PEMINJAMAN --}}
                    <div class="card mb-7">

                        <div class="card-header">
                            <h4 class="card-title">Detail Peminjaman</h4>
                        </div>

                        <div class="card-body">

                            <div class="row g-5">

                                <div class="col-md-4">
                                    <div class="border border-dashed p-4 rounded">

                                        <span class="text-muted fs-8">Tanggal Pinjam</span>

                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($loans->loan_date)->translatedFormat('d F Y') }}
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border border-dashed p-4 rounded">

                                        <span class="text-muted fs-8">Jatuh Tempo</span>

                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($loans->due_date)->translatedFormat('d F Y') }}
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border border-dashed p-4 rounded">

                                        <span class="text-muted fs-8">Durasi</span>

                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($loans->loan_date)->diffInDays($loans->due_date) }}
                                            hari
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="border border-dashed p-4 rounded">

                                        <span class="text-muted fs-8">Keperluan</span>

                                        <div class="text-gray-700">
                                            {{ $loans->purpose }}
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

        </div>
        @endif

    </div>
    </div>
    </div>
@endsection
