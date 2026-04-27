@extends('master')
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">

        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Tool Detail main-->
            <div class="card">
                <!--begin::Body-->
                <div class="card-body p-lg-20">
                    <!--begin::Layout-->
                    <div class="d-flex flex-column flex-xl-row">
                        <!--begin::Content-->
                        <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                            <!--begin::Tool Detail content-->
                            <div class="mt-n1">

                                <!--begin::Wrapper-->
                                <div class="m-0">
                                    <!--begin::Label-->
                                    <div class="fw-bold fs-3 text-gray-800 mb-8">Detail Alat</div>
                                    <!--end::Label-->

                                    <!--begin::Card Info Alat-->
                                    <div class="card card-flush mb-8">
                                        <div class="card-body p-0">
                                            <div class="d-flex">
                                                <!--begin::Foto-->
                                                <div class="flex-shrink-0" style="width: 180px; min-height: 180px;">
                                                    @if (!empty($tool->photo_path) && file_exists(public_path($tool->photo_path)))
                                                        <img src="{{ asset($tool->photo_path) }}" alt="{{ $tool->name }}"
                                                            style="width: 180px; height: 100%; min-height: 180px; object-fit: cover; border-radius: var(--bs-card-border-radius) 0 0 var(--bs-card-border-radius);">
                                                    @else
                                                        <div class="bg-light-primary text-primary fw-bold fs-1 d-flex align-items-center justify-content-center h-100"
                                                            style="width: 180px; min-height: 180px; border-radius: var(--bs-card-border-radius) 0 0 var(--bs-card-border-radius);">
                                                            {{ strtoupper(substr($tool->name, 0, 2)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <!--end::Foto-->

                                                <!--begin::Info-->
                                                <div class="flex-grow-1 p-7" style="min-width: 0;">
                                                    <div class="d-flex align-items-start justify-content-between mb-5">
                                                        <div>
                                                            <h3 class="fw-bold text-gray-800 mb-1">{{ $tool->name }}</h3>
                                                            <span class="text-muted fs-7">ID:
                                                                #TL-{{ str_pad($tool->id, 3, '0', STR_PAD_LEFT) }}</span>
                                                        </div>
                                                        <div class="d-flex gap-2">
                                                            @if ($tool->item_type == 'single')
                                                                <span class="badge badge-light-success">Single</span>
                                                            @else
                                                                <span class="badge badge-light-warning">Bundle</span>
                                                            @endif
                                                            <span
                                                                class="badge badge-light-info">{{ $tool->category->name ?? '-' }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="text-gray-600 fs-6 mb-5">
                                                        {{ $tool->description ?? 'Tidak ada deskripsi.' }}
                                                    </div>

                                                    @if ($tool->item_type === 'bundle')
                                                        <div class="mb-5">
                                                            <span class="text-muted fs-7 d-block mb-2">Isi Bundle</span>
                                                            <div class="d-flex flex-wrap gap-2">
                                                                @forelse ($tool->bundleItems as $item)
                                                                    <span class="badge badge-light-primary fs-7 px-3 py-2">
                                                                        {{ $item->tools->name ?? '-' }}
                                                                        <span
                                                                            class="badge badge-primary ms-1">{{ $item->qty }}x</span>
                                                                    </span>
                                                                @empty
                                                                    <span class="text-muted fs-7">Belum ada isi
                                                                        bundle</span>
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="d-flex gap-6 pt-4 border-top">
                                                        <div class="d-flex flex-column">
                                                            <span class="text-muted fs-8 mb-1">Tanggal Dibuat</span>
                                                            <span
                                                                class="text-gray-800 fw-semibold fs-7">{{ date('d M Y', strtotime($tool->created_at)) }}</span>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <span class="text-muted fs-8 mb-1">Total Unit</span>
                                                            <span
                                                                class="text-gray-800 fw-semibold fs-7">{{ $tool->units?->count() ?? 0 }}
                                                                Unit</span>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <span class="text-muted fs-8 mb-1">Unit Tersedia</span>
                                                            <span
                                                                class="text-success fw-semibold fs-7">{{ $tool->units?->where('status', 'available')->count() ?? 0 }}
                                                                Unit</span>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <span class="text-muted fs-8 mb-1">Sedang Dipinjam</span>
                                                            <span
                                                                class="text-warning fw-semibold fs-7">{{ $tool->units?->where('status', 'borrowed')->count() ?? 0 }}
                                                                Unit</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Card Info Alat-->

                                    <!--begin::Separator-->
                                    <div class="separator my-8"></div>
                                    <!--end::Separator-->

                                    <!--begin::Header Tabel Unit-->
                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        <h3 class="fw-bold">Daftar Unit Alat</h3>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_add_unit{{ $tool->id }}">
                                            <i class="ki-duotone ki-plus fs-2"></i>
                                            Tambah Unit
                                        </button>
                                    </div>
                                    <!--end::Header Tabel Unit-->

                                    <!--begin::Content-->
                                    <div class="flex-grow-1">
                                        <!--begin::Table-->
                                        <div class="table-responsive border-bottom mb-9">
                                            <table
                                                class="table table-row-bordered table-row-gray-300 align-middle gs-0 gy-4">
                                                <thead>
                                                    <tr class="fw-bold text-muted bg-light">
                                                        <th class="ps-4 min-w-50px">No</th>
                                                        <th class="min-w-150px">Kode Unit</th>
                                                        <th class="min-w-100px">Status</th>
                                                        <th class="min-w-100px">Kondisi</th>
                                                        <th class="min-w-100px text-end pe-4">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($tool->units ?? [] as $index => $unit)
                                                        <tr>
                                                            <td class="ps-4">
                                                                <span
                                                                    class="text-gray-800 fw-semibold">{{ $index + 1 }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-gray-800 fw-bold">
                                                                    {{ $unit->code ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if ($unit->status == 'available')
                                                                    <span class="badge badge-light-success">Tersedia</span>
                                                                @elseif($unit->status == 'borrowed')
                                                                    <span class="badge badge-light-warning">Dipinjam</span>
                                                                @elseif($unit->status == 'maintenance')
                                                                    <span class="badge badge-light-info">Maintenance</span>
                                                                @elseif($unit->status == 'returned')
                                                                    <span class="badge badge-light-primary">Returned</span>
                                                                @elseif($unit->status == 'overdue')
                                                                    <span class="badge badge-light-danger">overdue</span>
                                                                @elseif($unit->status == 'lost')
                                                                    <span class="badge badge-light-danger">Lost</span>
                                                                @else
                                                                    <span class="badge badge-light-danger">Rusak</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-light">
                                                                    {{ $unit->notes ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td class="text-end pe-4">
                                                                <button class="btn btn-sm btn-light-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_detail_unit{{ $unit->id }}">
                                                                    <i class="ki-duotone ki-eye"></i> Detail
                                                                </button>

                                                                <button class="btn btn-sm btn-light-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_edit_unit{{ $unit->id }}">
                                                                    <i class="ki-duotone ki-pencil"></i> Edit
                                                                </button>

                                                                <button class="btn btn-sm btn-light-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_delete_unit{{ $unit->id }}">
                                                                    <i class="ki-duotone ki-trash"></i> Hapus
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center py-8">
                                                                <div class="d-flex flex-column align-items-center">
                                                                    <i
                                                                        class="ki-duotone ki-information fs-3x text-muted mb-3">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                    </i>
                                                                    <span class="text-muted fs-5">Belum ada unit untuk alat
                                                                        ini</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            <!-- Modal Tambah Unit -->
                                            <div class="modal fade" id="kt_modal_add_unit{{ $tool->id }}"
                                                tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">

                                                        <!-- Header -->
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tambah Unit</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <!-- Form -->
                                                        <form action="{{ route('tools.units-store') }}" method="POST">
                                                            @csrf

                                                            <div class="modal-body">

                                                                <!-- hidden tool id -->
                                                                <input type="hidden" name="tool_id"
                                                                    value="{{ $tool->id }}">

                                                                <!-- Code -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">Kode Unit</label>
                                                                    <input type="text" name="code"
                                                                        class="form-control"
                                                                        value="{{ $tool->code_slug }}-{{ str_pad($tool->units->count() + 1, 3, '0', STR_PAD_LEFT) }}"
                                                                        readonly>
                                                                </div>

                                                                <!-- Status -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">Status</label>
                                                                    <select name="status" class="form-select" required>
                                                                        <option value="">Pilih Status</option>
                                                                        <option value="available">Available</option>
                                                                        <option value="borrowed">Borrowed</option>
                                                                        <option value="maintenance">Maintenance</option>
                                                                        <option value="damaged">Damaged</option>
                                                                    </select>
                                                                </div>

                                                                <!-- Notes -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">Catatan</label>
                                                                    <textarea name="notes" class="form-control" rows="3" placeholder="Opsional"></textarea>
                                                                </div>

                                                            </div>

                                                            <!-- Footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach ($tool->units ?? [] as $unit)
                                                <div class="modal fade" id="kt_modal_detail_unit{{ $unit->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered mw-700px">
                                                        <div class="modal-content">

                                                            {{-- Header --}}
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    <i
                                                                        class="bi bi-info-circle-fill me-2 text-primary"></i>Detail
                                                                    Unit
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>

                                                            {{-- Body --}}
                                                            <div class="modal-body px-5 py-8">

                                                                {{-- ===== INFO UNIT ===== --}}
                                                                <div class="card card-flush border mb-6">
                                                                    <div class="card-header min-h-45px">
                                                                        <h6 class="card-title fw-bold text-gray-700">
                                                                            <i
                                                                                class="bi bi-box-seam me-2 text-primary"></i>Informasi
                                                                            Unit
                                                                        </h6>
                                                                    </div>
                                                                    <div class="card-body py-4">
                                                                        <table class="table table-borderless mb-0 fs-6">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th class="text-muted fw-semibold py-2"
                                                                                        style="width:40%">Kode
                                                                                        Unit</th>
                                                                                    <td class="py-2">
                                                                                        <span
                                                                                            class="badge badge-light-primary fs-7">{{ $unit->code }}</span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th
                                                                                        class="text-muted fw-semibold py-2">
                                                                                        Nama Alat</th>
                                                                                    <td class="py-2">
                                                                                        {{ $unit->tool->name ?? '-' }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th
                                                                                        class="text-muted fw-semibold py-2">
                                                                                        Status</th>
                                                                                    <td class="py-2">
                                                                                        @php
                                                                                            $statusMap = [
                                                                                                'available' => [
                                                                                                    'label' =>
                                                                                                        'Available',
                                                                                                    'class' =>
                                                                                                        'badge-light-success',
                                                                                                ],
                                                                                                'borrowed' => [
                                                                                                    'label' =>
                                                                                                        'Borrowed',
                                                                                                    'class' =>
                                                                                                        'badge-light-warning',
                                                                                                ],
                                                                                                'maintenance' => [
                                                                                                    'label' =>
                                                                                                        'Maintenance',
                                                                                                    'class' =>
                                                                                                        'badge-light-info',
                                                                                                ],
                                                                                                'damaged' => [
                                                                                                    'label' =>
                                                                                                        'Damaged',
                                                                                                    'class' =>
                                                                                                        'badge-light-danger',
                                                                                                ],
                                                                                            ];
                                                                                            $s = $statusMap[
                                                                                                $unit->status
                                                                                            ] ?? [
                                                                                                'label' => ucfirst(
                                                                                                    $unit->status,
                                                                                                ),
                                                                                                'class' =>
                                                                                                    'badge-light-secondary',
                                                                                            ];
                                                                                        @endphp
                                                                                        <span
                                                                                            class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th
                                                                                        class="text-muted fw-semibold py-2">
                                                                                        Catatan</th>
                                                                                    <td class="py-2">
                                                                                        {{ $unit->notes ?: '-' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th
                                                                                        class="text-muted fw-semibold py-2">
                                                                                        Dibuat</th>
                                                                                    <td class="py-2">
                                                                                        {{ $unit->created_at->format('d M Y, H:i') }}
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                {{-- ===== KONDISI SAAT INI ===== --}}
                                                                <div class="card card-flush border mb-6">
                                                                    <div class="card-header min-h-45px">
                                                                        <h6 class="card-title fw-bold text-gray-700">
                                                                            <i
                                                                                class="bi bi-clipboard-check me-2 text-warning"></i>
                                                                            Kondisi Unit Saat Ini
                                                                        </h6>
                                                                        <div class="card-toolbar">
                                                                            <span
                                                                                class="badge badge-light-secondary fs-8 me-2">
                                                                                {{ $unit->conditions->count() ?? 0 }}
                                                                                Catatan
                                                                            </span>
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-primary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_add_condition{{ $unit->id }}">
                                                                                <i class="bi bi-plus-circle me-1"></i>Catat
                                                                                Kondisi
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-body py-4 px-0">
                                                                        <div class="table-responsive">
                                                                            <table
                                                                                class="table table-row-bordered table-row-gray-200 align-middle gs-5 gy-3 mb-0">
                                                                                <thead>
                                                                                    <tr
                                                                                        class="fw-bold text-muted bg-light fs-7 text-uppercase">
                                                                                        <th class="ps-5 min-w-30px">No
                                                                                        </th>
                                                                                        <th class="min-w-120px">Kondisi
                                                                                        </th>
                                                                                        <th class="min-w-150px">Catatan
                                                                                        </th>
                                                                                        <th class="min-w-120px">Dicatat
                                                                                            Pada</th>
                                                                                        <th class="min-w-100px pe-5">
                                                                                            Return
                                                                                            ID</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="text-gray-600 fw-semibold">
                                                                                    @forelse ($unit->conditions ?? [] as $i => $condition)
                                                                                        <tr>
                                                                                            <td class="ps-5">
                                                                                                {{ $i + 1 }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @php
                                                                                                    $condMap = [
                                                                                                        'good' => [
                                                                                                            'label' =>
                                                                                                                'Baik',
                                                                                                            'class' =>
                                                                                                                'badge-light-success',
                                                                                                        ],
                                                                                                        'minor' => [
                                                                                                            'label' =>
                                                                                                                'Minor',
                                                                                                            'class' =>
                                                                                                                'badge-light-warning',
                                                                                                        ],
                                                                                                        'damaged' => [
                                                                                                            'label' =>
                                                                                                                'Rusak',
                                                                                                            'class' =>
                                                                                                                'badge-light-danger',
                                                                                                        ],
                                                                                                        'lost' => [
                                                                                                            'label' =>
                                                                                                                'Hilang',
                                                                                                            'class' =>
                                                                                                                'badge-light-dark',
                                                                                                        ],
                                                                                                    ];
                                                                                                    $c = $condMap[
                                                                                                        $condition
                                                                                                            ->conditions
                                                                                                    ] ?? [
                                                                                                        'label' => ucfirst(
                                                                                                            $condition->conditions,
                                                                                                        ),
                                                                                                        'class' =>
                                                                                                            'badge-light-secondary',
                                                                                                    ];
                                                                                                @endphp
                                                                                                <span
                                                                                                    class="badge {{ $c['class'] }}">{{ $c['label'] }}</span>
                                                                                            </td>
                                                                                            <td>
                                                                                                <span
                                                                                                    class="text-gray-700">
                                                                                                    {{ $condition->notes ?: '-' }}
                                                                                                </span>
                                                                                            </td>
                                                                                            <td>
                                                                                                {{ \Carbon\Carbon::parse($condition->recorded_at)->format('d M Y, H:i') }}
                                                                                            </td>
                                                                                            <td class="pe-5">
                                                                                                @if ($condition->return_id)
                                                                                                    <span
                                                                                                        class="badge badge-light-info">#{{ $condition->return_id }}</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="text-muted">-</span>
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                    @empty
                                                                                        <tr>
                                                                                            <td colspan="5"
                                                                                                class="text-center py-8">
                                                                                                <div
                                                                                                    class="d-flex flex-column align-items-center">
                                                                                                    <i
                                                                                                        class="bi bi-info-circle fs-3x text-muted mb-3"></i>
                                                                                                    <span
                                                                                                        class="text-muted fs-6">Belum
                                                                                                        ada
                                                                                                        kondisi saat
                                                                                                        ini</span>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforelse
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- ===== RIWAYAT KONDISI ===== --}}
                                                                <div class="card card-flush border">
                                                                    <div class="card-header min-h-45px">
                                                                        <h6 class="card-title fw-bold text-gray-700">
                                                                            <i
                                                                                class="bi bi-clock-history me-2 text-info"></i>Riwayat
                                                                            Kondisi Unit
                                                                        </h6>
                                                                        <div class="card-toolbar">
                                                                            <span
                                                                                class="badge badge-light-secondary fs-8 me-2">
                                                                                {{ $unit->conditions->count() ?? 0 }}
                                                                                Catatan
                                                                            </span>
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-light-primary">
                                                                                <i class="bi bi-eye me-1"></i>Lihat
                                                                                Semua
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-body py-4 px-0">
                                                                        <div class="table-responsive">
                                                                            <table
                                                                                class="table table-row-bordered table-row-gray-200 align-middle gs-5 gy-3 mb-0">
                                                                                <thead>
                                                                                    <tr
                                                                                        class="fw-bold text-muted bg-light fs-7 text-uppercase">
                                                                                        <th class="ps-5 min-w-30px">No
                                                                                        </th>
                                                                                        <th class="min-w-120px">Kondisi
                                                                                        </th>
                                                                                        <th class="min-w-150px">Catatan
                                                                                        </th>
                                                                                        <th class="min-w-120px">Dicatat
                                                                                            Pada</th>
                                                                                        <th class="min-w-100px pe-5">
                                                                                            Return
                                                                                            ID</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="text-gray-600 fw-semibold">
                                                                                    @forelse ($unit->conditions ?? [] as $i => $condition)
                                                                                        <tr>
                                                                                            <td class="ps-5">
                                                                                                {{ $i + 1 }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @php
                                                                                                    $condMap = [
                                                                                                        'good' => [
                                                                                                            'label' =>
                                                                                                                'Baik',
                                                                                                            'class' =>
                                                                                                                'badge-light-success',
                                                                                                        ],
                                                                                                        'minor' => [
                                                                                                            'label' =>
                                                                                                                'Minor',
                                                                                                            'class' =>
                                                                                                                'badge-light-warning',
                                                                                                        ],
                                                                                                        'damaged' => [
                                                                                                            'label' =>
                                                                                                                'Rusak',
                                                                                                            'class' =>
                                                                                                                'badge-light-danger',
                                                                                                        ],
                                                                                                        'lost' => [
                                                                                                            'label' =>
                                                                                                                'Hilang',
                                                                                                            'class' =>
                                                                                                                'badge-light-dark',
                                                                                                        ],
                                                                                                    ];
                                                                                                    $c = $condMap[
                                                                                                        $condition
                                                                                                            ->conditions
                                                                                                    ] ?? [
                                                                                                        'label' => ucfirst(
                                                                                                            $condition->conditions,
                                                                                                        ),
                                                                                                        'class' =>
                                                                                                            'badge-light-secondary',
                                                                                                    ];
                                                                                                @endphp
                                                                                                <span
                                                                                                    class="badge {{ $c['class'] }}">{{ $c['label'] }}</span>
                                                                                            </td>
                                                                                            <td>
                                                                                                <span
                                                                                                    class="text-gray-700">
                                                                                                    {{ $condition->notes ?: '-' }}
                                                                                                </span>
                                                                                            </td>
                                                                                            <td>
                                                                                                {{ \Carbon\Carbon::parse($condition->recorded_at)->format('d M Y, H:i') }}
                                                                                            </td>
                                                                                            <td class="pe-5">
                                                                                                @if ($condition->return_id)
                                                                                                    <span
                                                                                                        class="badge badge-light-info">#{{ $condition->return_id }}</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="text-muted">-</span>
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                    @empty
                                                                                        <tr>
                                                                                            <td colspan="5"
                                                                                                class="text-center py-8">
                                                                                                <div
                                                                                                    class="d-flex flex-column align-items-center">
                                                                                                    <i
                                                                                                        class="bi bi-info-circle fs-3x text-muted mb-3"></i>
                                                                                                    <span
                                                                                                        class="text-muted fs-6">Belum
                                                                                                        ada
                                                                                                        riwayat
                                                                                                        kondisi</span>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforelse
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            {{-- Footer --}}
                                                            <div class="modal-footer">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- Modal Form Catat Kondisi --}}
                                                <div class="modal fade" id="kt_modal_add_condition{{ $unit->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered mw-650px">
                                                        <div class="modal-content">
                                                            <form id="form_add_condition{{ $unit->id }}"
                                                                method="POST"
                                                                action="{{ route('tools.unit-conditions.store') }}">
                                                                @csrf

                                                                {{-- Hidden Input --}}
                                                                <input type="hidden" name="unit_code"
                                                                    value="{{ $unit->code }}">

                                                                {{-- Header --}}
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">
                                                                        <i
                                                                            class="bi bi-clipboard-plus me-2 text-primary"></i>Catat
                                                                        Kondisi Unit
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>

                                                                {{-- Body --}}
                                                                <div class="modal-body px-7 py-5">

                                                                    {{-- Info Unit --}}
                                                                    <div
                                                                        class="alert alert-primary d-flex align-items-center mb-7">
                                                                        <i class="bi bi-box-seam fs-2x me-4"></i>
                                                                        <div class="d-flex flex-column">
                                                                            <h5 class="mb-1">
                                                                                {{ $unit->tool->name ?? '-' }}</h5>
                                                                            <span class="text-muted">Kode:
                                                                                <strong>{{ $unit->code }}</strong></span>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Form Fields --}}
                                                                    <div class="row g-5">

                                                                        {{-- Kondisi --}}
                                                                        <div class="col-12">
                                                                            <label class="form-label required">Kondisi
                                                                                Unit</label>
                                                                            <select name="conditions" class="form-select"
                                                                                required>
                                                                                <option value="">Pilih Kondisi
                                                                                </option>
                                                                                <option value="good"
                                                                                    {{ old('conditions') == 'good' ? 'selected' : '' }}>
                                                                                    Baik</option>
                                                                                <option value="maintenance"
                                                                                    {{ old('conditions') == 'maintenance' ? 'selected' : '' }}>
                                                                                    Perbaikan</option>
                                                                                <option value="broken"
                                                                                    {{ old('conditions') == 'broken' ? 'selected' : '' }}>
                                                                                    Rusak</option>
                                                                            </select>
                                                                            <div class="form-text">Pilih kondisi unit
                                                                                saat
                                                                                ini</div>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label class="form-label">Return
                                                                                (Opsional)
                                                                            </label>
                                                                            <select name="return_id" class="form-select">
                                                                                <option value="">-- Pilih Return
                                                                                    --
                                                                                </option>
                                                                                @foreach ($returns as $return)
                                                                                    <option value="{{ $return->id }}">
                                                                                        {{ $return->id }} -
                                                                                        {{ $return->loan_code ?? 'No Code' }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="form-text">Pilih jika kondisi
                                                                                ini
                                                                                terkait
                                                                                pengembalian</div>
                                                                        </div>

                                                                        {{-- Catatan --}}
                                                                        <div class="col-12">
                                                                            <label class="form-label">Catatan</label>
                                                                            <textarea name="notes" class="form-control" rows="4"
                                                                                placeholder="Tulis catatan detail mengenai kondisi unit..."></textarea>
                                                                            <div class="form-text">Jelaskan detail
                                                                                kondisi
                                                                                atau
                                                                                kerusakan yang ditemukan</div>
                                                                        </div>

                                                                        {{-- Tanggal Pencatatan --}}
                                                                        <div class="col-12">
                                                                            <label class="form-label required">Tanggal
                                                                                &
                                                                                Waktu
                                                                                Pencatatan</label>
                                                                            <input type="datetime-local"
                                                                                name="recorded_at" class="form-control"
                                                                                value="{{ now()->format('Y-m-d\TH:i') }}"
                                                                                required>
                                                                            <div class="form-text">Waktu ketika kondisi
                                                                                dicatat</div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                {{-- Footer --}}
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">
                                                                        <i class="bi bi-x-circle me-1"></i>Batal
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary">
                                                                        <i class="bi bi-check-circle me-1"></i>Simpan
                                                                        Kondisi
                                                                    </button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="kt_modal_edit_unit{{ $unit->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">

                                                            {{-- Header --}}
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    <i cl
                                                                        ass="fas fa-pencil-alt me-2 text-warning"></i>Edit
                                                                    Unit
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>

                                                            {{-- Form --}}
                                                            <form action="{{ route('tools.units-update', $unit->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="modal-body">

                                                                    {{-- Hidden tool id --}}
                                                                    <input type="hidden" name="tool_id"
                                                                        value="{{ $unit->tool_id }}">

                                                                    {{-- Kode Unit (readonly) --}}
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Kode Unit</label>
                                                                        <input type="text" name="code"
                                                                            class="form-control"
                                                                            value="{{ $unit->code }}" readonly>
                                                                        <div class="form-text text-muted">Kode unit
                                                                            tidak
                                                                            dapat diubah.
                                                                        </div>
                                                                    </div>

                                                                    {{-- Status --}}
                                                                    <div class="mb-3">
                                                                        <label class="form-label required">Status</label>
                                                                        <select name="status" class="form-select"
                                                                            required>
                                                                            <option value="">Pilih Status
                                                                            </option>
                                                                            <option value="available"
                                                                                {{ $unit->status === 'available' ? 'selected' : '' }}>
                                                                                Available</option>
                                                                            <option value="borrowed"
                                                                                {{ $unit->status === 'borrowed' ? 'selected' : '' }}>
                                                                                Borrowed</option>
                                                                            <option value="maintenance"
                                                                                {{ $unit->status === 'maintenance' ? 'selected' : '' }}>
                                                                                Maintenance</option>
                                                                            <option value="damaged"
                                                                                {{ $unit->status === 'damaged' ? 'selected' : '' }}>
                                                                                Damaged</option>
                                                                            <option value="returned"
                                                                                {{ $unit->status === 'returned' ? 'selected' : '' }}>
                                                                                Returned</option>
                                                                            <option value="overdue"
                                                                                {{ $unit->status === 'overdue' ? 'selected' : '' }}>
                                                                                Overdue</option>
                                                                            <option value="lost"
                                                                                {{ $unit->status === 'lost' ? 'selected' : '' }}>
                                                                                Lost</option>
                                                                        </select>
                                                                    </div>

                                                                    {{-- Catatan --}}
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Catatan</label>
                                                                        <textarea name="notes" class="form-control" rows="3" placeholder="Opsional">{{ $unit->notes }}</textarea>
                                                                    </div>

                                                                </div>

                                                                {{-- Footer --}}
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-warning text-white">
                                                                        Simpan
                                                                        Perubahan
                                                                    </button>
                                                                </div>

                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="kt_modal_delete_unit{{ $unit->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                                        <div class="modal-content">

                                                            {{-- Header --}}
                                                            <div class="modal-header border-0 pb-0">
                                                                <button type="button" class="btn-close ms-auto"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>

                                                            {{-- Body --}}
                                                            <div class="modal-body text-center pt-0 pb-4 px-4">

                                                                <h4 class="fw-bold mb-2">Hapus Unit?</h4>
                                                                <p class="text-muted mb-0">
                                                                    Anda akan menghapus unit
                                                                    <strong>{{ $unit->code }}</strong>.
                                                                    Tindakan ini <span
                                                                        class="text-danger fw-semibold">tidak dapat
                                                                        dibatalkan</span>.
                                                                </p>

                                                            </div>

                                                            {{-- Footer --}}
                                                            <div class="modal-footer justify-content-center border-0 pt-0">
                                                                <button type="button" class="btn btn-light px-5"
                                                                    data-bs-dismiss="modal">Batal</button>

                                                                <form
                                                                    action="{{ route('tools.units-delete', $unit->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger px-5">
                                                                        Ya, Hapus
                                                                    </button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Tool Detail content-->
                        </div>
                        <!--end::Content-->

                        <!--begin::Sidebar-->
                        <div class="m-0">
                            <div
                                class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">

                                <div class="d-flex gap-2 mb-8">
                                    @if ($tool->item_type == 'single')
                                        <span class="badge badge-light-success">Single</span>
                                    @else
                                        <span class="badge badge-light-warning">Bundle</span>
                                    @endif
                                    @if ($tool->units?->count() > 0)
                                        <span class="badge badge-light-primary">{{ $tool->units->count() }} Unit</span>
                                    @else
                                        <span class="badge badge-light-danger">Tidak Ada Unit</span>
                                    @endif
                                </div>

                                <h6 class="mb-5 fw-bolder text-gray-600 text-hover-primary">INFORMASI ALAT</h6>
                                <div class="mb-4">
                                    <div class="fw-semibold text-gray-600 fs-7">Kategori</div>
                                    <div class="fw-bold text-gray-800 fs-6">{{ $tool->category->name ?? '-' }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="fw-semibold text-gray-600 fs-7">Kode Alat</div>
                                    <div class="fw-bold text-gray-800 fs-6">
                                        #TL-{{ str_pad($tool->id, 3, '0', STR_PAD_LEFT) }}</div>
                                </div>
                                <div class="mb-8">
                                    <div class="fw-semibold text-gray-600 fs-7">Tanggal Dibuat</div>
                                    <div class="fw-bold text-gray-800 fs-6">
                                        {{ date('d M Y', strtotime($tool->created_at)) }}</div>
                                </div>

                                <h6 class="mb-5 fw-bolder text-gray-600 text-hover-primary">STATUS UNIT</h6>

                                @php
                                    $total = $tool->units?->count() ?? 0;
                                    $tersedia = $tool->units?->where('status', 'available')->count() ?? 0;
                                    $dipinjam = $tool->units?->where('status', 'borrowed')->count() ?? 0;
                                    $dikembalikan = $tool->units?->where('status', 'primary')->count() ?? 0;
                                    $terlambat = $tool->units?->where('status', 'terlambat')->count() ?? 0;
                                    $hilang = $tool->units?->where('status', 'hilang')->count() ?? 0;
                                    $rusak = $total - $tersedia - $dipinjam;
                                    $pctTersedia = $total > 0 ? round(($tersedia / $total) * 100) : 0;
                                @endphp

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-semibold text-gray-600 fs-7">Ketersediaan</span>
                                        <span class="fw-bold text-gray-800 fs-7">{{ $pctTersedia }}%</span>
                                    </div>
                                    <div class="h-6px rounded" style="background: var(--bs-gray-200);">
                                        <div class="h-6px rounded bg-success" style="width: {{ $pctTersedia }}%;"></div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column gap-3 mb-8">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="bullet bullet-dot bg-gray-400"></span>
                                            <span class="text-gray-600 fs-7">Total Unit</span>
                                        </div>
                                        <span class="fw-bold text-gray-800 fs-7">{{ $total }} Unit</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="bullet bullet-dot bg-success"></span>
                                            <span class="text-gray-600 fs-7">Tersedia</span>
                                        </div>
                                        <span class="fw-bold text-success fs-7">{{ $tersedia }} Unit</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="bullet bullet-dot bg-warning"></span>
                                            <span class="text-gray-600 fs-7">Dipinjam</span>
                                        </div>
                                        <span class="fw-bold text-warning fs-7">{{ $dipinjam }} Unit</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="bullet bullet-dot bg-primary"></span>
                                            <span class="text-gray-600 fs-7">Dikembalikan</span>
                                        </div>
                                        <span class="fw-bold text-primary fs-7">{{ $dikembalikan }} Unit</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="bullet bullet-dot bg-danger"></span>
                                            <span class="text-gray-600 fs-7">Terlambat</span>
                                        </div>
                                        <span class="fw-bold text-danger fs-7">{{ $terlambat }} Unit</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="bullet bullet-dot bg-danger"></span>
                                            <span class="text-gray-600 fs-7">Hilang</span>
                                        </div>
                                        <span class="fw-bold text-danger fs-7">{{ $hilang }} Unit</span>
                                    </div>
                                    @if ($rusak > 0)
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="bullet bullet-dot bg-danger"></span>
                                                <span class="text-gray-600 fs-7">Tidak Tersedia</span>
                                            </div>
                                            <span class="fw-bold text-danger fs-7">{{ $rusak }} Unit</span>
                                        </div>
                                    @endif
                                </div>

                                @if ($tersedia > 0)
                                    <div
                                        class="notice d-flex bg-light-success rounded border-success border border-dashed p-4">
                                        <i class="ki-duotone ki-check-circle fs-2tx text-success me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <div>
                                            <div class="fw-bold text-gray-800 fs-7">Alat Tersedia</div>
                                            <div class="text-gray-600 fs-8">{{ $tersedia }} unit siap dipinjam
                                                sekarang</div>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-4">
                                        <i class="ki-duotone ki-information-5 fs-2tx text-danger me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div>
                                            <div class="fw-bold text-gray-800 fs-7">Tidak Tersedia</div>
                                            <div class="text-gray-600 fs-8">Semua unit sedang dipinjam</div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <!--end::Sidebar-->
                    </div>
                    <!--end::Layout-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Tool Detail main-->
        </div>
        <!--end::Content container-->
    </div>
@endsection
