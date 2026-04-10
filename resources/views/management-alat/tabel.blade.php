@extends('master')
@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Card-->
            <div class="card shadow-sm">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" class="form-control form-control-solid w-250px ps-13"
                                placeholder="Search users..." />
                        </div>
                        <!--end::Search-->
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Filter-->
                            <button type="button" class="btn btn-light-primary me-3">
                                <i class="ki-duotone ki-filter fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Filter
                            </button>
                            <!--end::Filter-->

                            <!--begin::Export-->
                            <button type="button" class="btn btn-light-primary me-3">
                                <i class="ki-duotone ki-exit-up fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Export
                            </button>
                            <!--end::Export-->

                            <!--begin::Add user-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_tool">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add Tools
                            </button>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table id="kt_table_tools" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" />
                                        </div>
                                    </th>
                                    <th class="min-w-200px">Alat</th>
                                    <th class="min-w-150px">kode</th>
                                    <th class="min-w-150px">Kategori</th>
                                    <th class="min-w-100px">Tipe</th>
                                    <th class="min-w-150px">Deskripsi</th>
                                    <th class="min-w-100px">Tanggal</th>
                                    <th class="min-w-100px">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($tools as $tool)
                                    <tr>

                                        <!-- Checkbox -->
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" />
                                            </div>
                                        </td>

                                        <!-- Nama Alat + Foto -->
                                        <td class="d-flex align-items-center">
                                            <!-- Ganti bagian ini -->
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                @if ($tool->photo_path && file_exists(public_path($tool->photo_path)))
                                                    <!-- Tampilkan foto jika ada -->
                                                    <div class="symbol-label">
                                                        <img src="{{ asset($tool->photo_path) }}" alt="{{ $tool->name }}"
                                                            class="w-100">
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 mb-1">
                                                    {{ $tool->name }}
                                                </span>
                                                <span class="text-muted fs-7">
                                                    ID: #TL-{{ str_pad($tool->id, 3, '0', STR_PAD_LEFT) }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Kode -->
                                        <td>
                                            <span class="badge badge-light-primary">
                                                {{ $tool->code_slug }}
                                            </span>
                                        </td>

                                        <!-- Kategori -->
                                        <td>
                                            <span class="badge badge-light-info">
                                                {{ $tool->category->name ?? '-' }}
                                            </span>
                                        </td>

                                        <!-- Tipe -->
                                        <td>
                                            @if ($tool->item_type == 'single')
                                                <span class="badge badge-light-success">Single</span>
                                            @else
                                                <span class="badge badge-light-warning">Bundle</span>
                                            @endif
                                        </td>

                                        <!-- Deskripsi -->
                                        <td>
                                            {{ $tool->description ?? '-' }}
                                        </td>

                                        <!-- Tanggal -->
                                        <td>
                                            {{ date('d M Y', strtotime($tool->created_at)) }}
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <!-- VIEW DETAIL -->
                                            <a href="#" class="btn btn-icon btn-info btn-sm me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_detail_tool{{ $tool->id }}"
                                                title="Lihat Detail">
                                                <i class="ki-duotone ki-eye"></i>
                                            </a>
                                            <!-- EDIT -->
                                            <a href="#" class="btn btn-icon btn-warning btn-sm me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_edit_tool{{ $tool->id }}">
                                                <i class="ki-duotone ki-pencil"></i>
                                            </a>

                                            <!-- DELETE -->
                                            <a href="#" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_delete_tool{{ $tool->id }}">
                                                <i class="ki-duotone ki-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="kt_modal_edit_tool{{ $tool->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered mw-700px">
                                            <div class="modal-content">

                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h2 class="fw-bold">Edit Alat</h2>
                                                    <div class="btn btn-icon btn-sm" data-bs-dismiss="modal">
                                                        <i class="ki-duotone ki-cross fs-1"></i>
                                                    </div>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body px-5 py-10">

                                                    <form method="POST" action="{{ route('tools.update', $tool->id) }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="d-flex flex-column">

                                                            <!-- Foto -->
                                                            <div class="fv-row mb-6">
                                                                <label class="fw-semibold fs-6 mb-3">Foto Alat</label>
                                                                <input type="file" name="photo"
                                                                    class="form-control form-control-solid">
                                                                @if ($tool->photo)
                                                                    <small class="text-muted">Foto saat ini:
                                                                        {{ $tool->photo }}</small>
                                                                @endif
                                                            </div>

                                                            <!-- Nama -->
                                                            <div class="fv-row mb-6">
                                                                <label class="required fw-semibold fs-6 mb-3">Nama
                                                                    Alat</label>
                                                                <input type="text" name="name"
                                                                    class="form-control form-control-solid"
                                                                    value="{{ $tool->name }}" required>
                                                            </div>

                                                            <!-- Kategori -->
                                                            <div class="fv-row mb-6">
                                                                <label
                                                                    class="required fw-semibold fs-6 mb-3">Kategori</label>
                                                                <select name="category_id"
                                                                    class="form-select form-select-solid" required>
                                                                    @foreach ($categories as $cat)
                                                                        <option value="{{ $cat->id }}"
                                                                            {{ $tool->category_id == $cat->id ? 'selected' : '' }}>
                                                                            {{ $cat->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- Tipe -->
                                                            <div class="fv-row mb-6">
                                                                <label class="required fw-semibold fs-6 mb-3">Tipe
                                                                    Alat</label>
                                                                <select name="item_type"
                                                                    class="form-select form-select-solid" required>
                                                                    <option value="single"
                                                                        {{ $tool->item_type == 'single' ? 'selected' : '' }}>
                                                                        Single</option>
                                                                    <option value="bundle"
                                                                        {{ $tool->item_type == 'bundle' ? 'selected' : '' }}>
                                                                        Bundle</option>
                                                                </select>
                                                            </div>

                                                            <!-- Deskripsi -->
                                                            <div class="fv-row mb-6">
                                                                <label class="fw-semibold fs-6 mb-3">Deskripsi</label>
                                                                <textarea name="description" class="form-control form-control-solid" rows="3">{{ $tool->description }}</textarea>
                                                            </div>

                                                        </div>

                                                        <!-- Actions -->
                                                        <div class="text-center pt-5">
                                                            <button type="button" class="btn btn-light me-3"
                                                                data-bs-dismiss="modal">
                                                                Batal
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                Update
                                                            </button>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="kt_modal_delete_tool{{ $tool->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered mw-500px">
                                            <div class="modal-content">

                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h2 class="fw-bold text-danger">Hapus Alat</h2>
                                                    <div class="btn btn-icon btn-sm" data-bs-dismiss="modal">
                                                        <i class="ki-duotone ki-cross fs-1"></i>
                                                    </div>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body p-10 text-center">

                                                    <p class="fs-5 mb-8">
                                                        Apakah kamu yakin ingin menghapus alat:
                                                    </p>

                                                    <h3 class="fw-bold mb-8">
                                                        {{ $tool->name }}
                                                    </h3>

                                                    <form method="POST" action="{{ route('tools.delete', $tool->id) }}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <div class="d-flex justify-content-center gap-3">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">
                                                                Batal
                                                            </button>

                                                            <button type="submit" class="btn btn-danger">
                                                                Ya, Hapus
                                                            </button>
                                                        </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        @foreach ($tools as $tool)
                            <!-- Modal Detail Tool -->
                            <div class="modal fade" id="kt_modal_detail_tool{{ $tool->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-900px">
                                    <div class="modal-content">

                                        <!-- Header -->
                                        <div class="modal-header">
                                            <h2 class="fw-bold">Detail Alat</h2>
                                            <div class="btn btn-icon btn-sm" data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </div>
                                        </div>

                                        <!-- Body -->
                                        <div class="modal-body px-5 py-10">

                                            <!-- Card Info Alat -->
                                            <div class="card card-flush mb-8">
                                                <div class="card-body p-8">
                                                    <div class="d-flex align-items-start">

                                                        <!-- Foto Alat -->
                                                        <div class="me-7">
                                                            @if ($tool->photo_path && file_exists(public_path($tool->photo_path)))
                                                                <div class="symbol symbol-150px symbol-fixed">
                                                                    <img src="{{ asset($tool->photo_path) }}"
                                                                        alt="{{ $tool->name }}" class="rounded"
                                                                        style="object-fit: cover; width: 150px; height: 150px;">
                                                                </div>
                                                            @else
                                                                <div class="symbol symbol-150px symbol-fixed">
                                                                    <div class="symbol-label bg-light-primary text-primary fw-bold fs-1 rounded"
                                                                        style="width: 150px; height: 150px; display: flex; align-items: center; justify-content: center;">
                                                                        {{ strtoupper(substr($tool->name, 0, 2)) }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Detail Info -->
                                                        <div class="flex-grow-1">

                                                            <!-- Nama Alat -->
                                                            <div class="mb-5">
                                                                <h3 class="fw-bold text-gray-800 mb-1">
                                                                    {{ $tool->name }}</h3>
                                                                <span class="text-muted fs-6">
                                                                    ID:
                                                                    #TL-{{ str_pad($tool->id, 3, '0', STR_PAD_LEFT) }}
                                                                </span>
                                                            </div>

                                                            <!-- Info Grid -->
                                                            <div class="row g-5">

                                                                <!-- Kategori -->
                                                                <div class="col-md-6">
                                                                    <div class="d-flex flex-column">
                                                                        <span class="text-muted fs-7 mb-1">Kategori</span>
                                                                        <span
                                                                            class="badge badge-light-info align-self-start">
                                                                            {{ $tool->category->name ?? '-' }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <!-- Tipe -->
                                                                <div class="col-md-6">
                                                                    <div class="d-flex flex-column">
                                                                        <span class="text-muted fs-7 mb-1">Tipe
                                                                            Alat</span>
                                                                        @if ($tool->item_type == 'single')
                                                                            <span
                                                                                class="badge badge-light-success align-self-start">Single</span>
                                                                        @else
                                                                            <span
                                                                                class="badge badge-light-warning align-self-start">Bundle</span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <!-- Deskripsi -->
                                                                <div class="col-12">
                                                                    <div class="d-flex flex-column">
                                                                        <span class="text-muted fs-7 mb-1">Deskripsi</span>
                                                                        <span class="text-gray-800 fs-6">
                                                                            {{ $tool->description ?? 'Tidak ada deskripsi' }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <!-- Tanggal Dibuat -->
                                                                <div class="col-md-6">
                                                                    <div class="d-flex flex-column">
                                                                        <span class="text-muted fs-7 mb-1">Tanggal
                                                                            Dibuat</span>
                                                                        <span class="text-gray-800 fw-semibold">
                                                                            {{ date('d M Y', strtotime($tool->created_at)) }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <!-- Total Unit -->
                                                                <div class="col-md-6">
                                                                    <div class="d-flex flex-column">
                                                                        <span class="text-muted fs-7 mb-1">Total
                                                                            Unit</span>
                                                                        <span class="text-gray-800 fw-semibold">
                                                                            {{ $tool->units?->count() ?? 0 }} Unit
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Separator -->
                                            <div class="separator my-8"></div>

                                            <!-- Header Tabel Unit -->
                                            <div class="d-flex justify-content-between align-items-center mb-5">
                                                <h3 class="fw-bold">Daftar Unit Alat</h3>

                                                <!-- Button Tambah Unit -->
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_add_unit{{ $tool->id }}">
                                                    <i class="ki-duotone ki-plus fs-2"></i>
                                                    Tambah Unit
                                                </button>
                                            </div>

                                            <!-- Tabel Unit -->
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-row-bordered table-row-gray-300 align-middle gs-0 gy-4">
                                                    <thead>
                                                        <tr class="fw-bold text-muted bg-light">
                                                            <th class="ps-4 min-w-50px rounded-start">No</th>
                                                            <th class="min-w-150px">Kode Unit</th>
                                                            <th class="min-w-100px">Status</th>
                                                            <th class="min-w-100px">Kondisi</th>
                                                            <th class="min-w-100px text-end rounded-end pe-4">Aksi</th>
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
                                                                        <span
                                                                            class="badge badge-light-success">Tersedia</span>
                                                                    @elseif($unit->status == 'borrowed')
                                                                        <span
                                                                            class="badge badge-light-warning">Dipinjam</span>
                                                                    @elseif($unit->status == 'maintenance')
                                                                        <span
                                                                            class="badge badge-light-info">Maintenance</span>
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
                                                                        <i class="fas fa-eye"></i> Detail
                                                                    </button>

                                                                    <button class="btn btn-sm btn-light-warning"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_edit_unit{{ $unit->id }}">
                                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                                    </button>

                                                                    <button class="btn btn-sm btn-light-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_delete_unit{{ $unit->id }}">
                                                                        <i class="fas fa-trash-alt"></i> Hapus
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
                                                                        <span class="text-muted fs-5">Belum ada unit
                                                                            untuk alat ini</span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Modal Tambah Unit -->
                            <div class="modal fade" id="kt_modal_add_unit{{ $tool->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        <!-- Header -->
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Unit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Form -->
                                        <form action="{{ route('tools.units-store') }}" method="POST">
                                            @csrf

                                            <div class="modal-body">

                                                <!-- hidden tool id -->
                                                <input type="hidden" name="tool_id" value="{{ $tool->id }}">

                                                <!-- Code -->
                                                <div class="mb-3">
                                                    <label class="form-label">Kode Unit</label>
                                                    <input type="text" name="code" class="form-control"
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
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                            @foreach ($tool->units ?? [] as $unit)
                                <div class="modal fade" id="kt_modal_detail_unit{{ $unit->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered mw-700px">
                                        <div class="modal-content">

                                            {{-- Header --}}
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-info-circle me-2 text-primary"></i>Detail Unit
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
                                                            <i class="fas fa-box me-2 text-primary"></i>Informasi Unit
                                                        </h6>
                                                    </div>
                                                    <div class="card-body py-4">
                                                        <table class="table table-borderless mb-0 fs-6">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-muted fw-semibold py-2"
                                                                        style="width:40%">Kode Unit</th>
                                                                    <td class="py-2">
                                                                        <span
                                                                            class="badge badge-light-primary fs-7">{{ $unit->code }}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-muted fw-semibold py-2">Nama Alat</th>
                                                                    <td class="py-2">{{ $unit->tool->name ?? '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-muted fw-semibold py-2">Status</th>
                                                                    <td class="py-2">
                                                                        @php
                                                                            $statusMap = [
                                                                                'available' => [
                                                                                    'label' => 'Available',
                                                                                    'class' => 'badge-light-success',
                                                                                ],
                                                                                'borrowed' => [
                                                                                    'label' => 'Borrowed',
                                                                                    'class' => 'badge-light-warning',
                                                                                ],
                                                                                'maintenance' => [
                                                                                    'label' => 'Maintenance',
                                                                                    'class' => 'badge-light-info',
                                                                                ],
                                                                                'damaged' => [
                                                                                    'label' => 'Damaged',
                                                                                    'class' => 'badge-light-danger',
                                                                                ],
                                                                            ];
                                                                            $s = $statusMap[$unit->status] ?? [
                                                                                'label' => ucfirst($unit->status),
                                                                                'class' => 'badge-light-secondary',
                                                                            ];
                                                                        @endphp
                                                                        <span
                                                                            class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-muted fw-semibold py-2">Catatan</th>
                                                                    <td class="py-2">{{ $unit->notes ?: '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-muted fw-semibold py-2">Dibuat</th>
                                                                    <td class="py-2">
                                                                        {{ $unit->created_at->format('d M Y, H:i') }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                {{-- ===== KONDISI SAAT INI ===== --}}
                                                <div class="card card-flush border">
                                                    <div class="card-header min-h-45px">
                                                        <h6 class="card-title fw-bold text-gray-700">
                                                            <i class="fas fa-clipboard-list me-2 text-warning"></i>
                                                            Kondisi Unit Saat Ini
                                                        </h6>
                                                        <div class="card-toolbar">
                                                            <span class="badge badge-light-secondary fs-8">
                                                                {{ $unit->conditions->count() ?? 0 }} Catatan
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="card-body py-4 px-0">
                                                        <div class="table-responsive">
                                                            <table
                                                                class="table table-row-bordered table-row-gray-200 align-middle gs-5 gy-3 mb-0">
                                                                <thead>
                                                                    <tr
                                                                        class="fw-bold text-muted bg-light fs-7 text-uppercase">
                                                                        <th class="ps-5 min-w-30px">No</th>
                                                                        <th class="min-w-120px">Kondisi</th>
                                                                        <th class="min-w-150px">Catatan</th>
                                                                        <th class="min-w-120px">Dicatat Pada</th>
                                                                        <th class="min-w-100px pe-5">Return ID</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="text-gray-600 fw-semibold">
                                                                    @forelse ($unit->conditions ?? [] as $i => $condition)
                                                                        <tr>
                                                                            <td class="ps-5">{{ $i + 1 }}</td>
                                                                            <td>
                                                                                @php
                                                                                    $condMap = [
                                                                                        'good' => [
                                                                                            'label' => 'Baik',
                                                                                            'class' =>
                                                                                                'badge-light-success',
                                                                                        ],
                                                                                        'minor' => [
                                                                                            'label' => 'Minor',
                                                                                            'class' =>
                                                                                                'badge-light-warning',
                                                                                        ],
                                                                                        'damaged' => [
                                                                                            'label' => 'Rusak',
                                                                                            'class' =>
                                                                                                'badge-light-danger',
                                                                                        ],
                                                                                        'lost' => [
                                                                                            'label' => 'Hilang',
                                                                                            'class' =>
                                                                                                'badge-light-dark',
                                                                                        ],
                                                                                    ];
                                                                                    $c = $condMap[
                                                                                        $condition->conditions
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
                                                                                <span class="text-gray-700">
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
                                                                                    <span class="text-muted">-</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="5" class="text-center py-8">
                                                                                <div
                                                                                    class="d-flex flex-column align-items-center">
                                                                                    <i
                                                                                        class="ki-duotone ki-information fs-3x text-muted mb-3">
                                                                                        <span class="path1"></span>
                                                                                        <span class="path2"></span>
                                                                                        <span class="path3"></span>
                                                                                    </i>
                                                                                    <span class="text-muted fs-6">Belum ada
                                                                                        kondisi saat ini</span>
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
                                                            <i class="fas fa-clipboard-list me-2 text-warning"></i>Riwayat
                                                            Kondisi Unit
                                                        </h6>
                                                        <div class="card-toolbar">
                                                            <span class="badge badge-light-secondary fs-8">
                                                                {{ $unit->conditions->count() ?? 0 }} Catatan
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="card-body py-4 px-0">
                                                        <div class="table-responsive">
                                                            <table
                                                                class="table table-row-bordered table-row-gray-200 align-middle gs-5 gy-3 mb-0">
                                                                <thead>
                                                                    <tr
                                                                        class="fw-bold text-muted bg-light fs-7 text-uppercase">
                                                                        <th class="ps-5 min-w-30px">No</th>
                                                                        <th class="min-w-120px">Kondisi</th>
                                                                        <th class="min-w-150px">Catatan</th>
                                                                        <th class="min-w-120px">Dicatat Pada</th>
                                                                        <th class="min-w-100px pe-5">Return ID</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="text-gray-600 fw-semibold">
                                                                    @forelse ($unit->conditions ?? [] as $i => $condition)
                                                                        <tr>
                                                                            <td class="ps-5">{{ $i + 1 }}</td>
                                                                            <td>
                                                                                @php
                                                                                    $condMap = [
                                                                                        'good' => [
                                                                                            'label' => 'Baik',
                                                                                            'class' =>
                                                                                                'badge-light-success',
                                                                                        ],
                                                                                        'minor' => [
                                                                                            'label' => 'Minor',
                                                                                            'class' =>
                                                                                                'badge-light-warning',
                                                                                        ],
                                                                                        'damaged' => [
                                                                                            'label' => 'Rusak',
                                                                                            'class' =>
                                                                                                'badge-light-danger',
                                                                                        ],
                                                                                        'lost' => [
                                                                                            'label' => 'Hilang',
                                                                                            'class' =>
                                                                                                'badge-light-dark',
                                                                                        ],
                                                                                    ];
                                                                                    $c = $condMap[
                                                                                        $condition->conditions
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
                                                                                <span class="text-gray-700">
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
                                                                                    <span class="text-muted">-</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="5" class="text-center py-8">
                                                                                <div
                                                                                    class="d-flex flex-column align-items-center">
                                                                                    <i
                                                                                        class="ki-duotone ki-information fs-3x text-muted mb-3">
                                                                                        <span class="path1"></span>
                                                                                        <span class="path2"></span>
                                                                                        <span class="path3"></span>
                                                                                    </i>
                                                                                    <span class="text-muted fs-6">Belum ada
                                                                                        riwayat kondisi</span>
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
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="kt_modal_edit_unit{{ $unit->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">

                                            {{-- Header --}}
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-pencil-alt me-2 text-warning"></i>Edit Unit
                                                </h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            {{-- Form --}}
                                            <form action="{{ route('tools.units-update', $unit->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">

                                                    {{-- Hidden tool id --}}
                                                    <input type="hidden" name="tool_id" value="{{ $unit->tool_id }}">

                                                    {{-- Kode Unit (readonly) --}}
                                                    <div class="mb-3">
                                                        <label class="form-label">Kode Unit</label>
                                                        <input type="text" name="code" class="form-control"
                                                            value="{{ $unit->code }}" readonly>
                                                        <div class="form-text text-muted">Kode unit tidak dapat diubah.
                                                        </div>
                                                    </div>

                                                    {{-- Status --}}
                                                    <div class="mb-3">
                                                        <label class="form-label required">Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="">Pilih Status</option>
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
                                                    <button type="submit" class="btn btn-warning text-white">
                                                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="kt_modal_delete_unit{{ $unit->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">

                                            {{-- Header --}}
                                            <div class="modal-header border-0 pb-0">
                                                <button type="button" class="btn-close ms-auto"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            {{-- Body --}}
                                            <div class="modal-body text-center pt-0 pb-4 px-4">

                                                {{-- Icon --}}
                                                <div class="mb-4">
                                                    <span class="svg-icon svg-icon-5tx svg-icon-danger">
                                                        <i class="fas fa-trash-alt fa-3x text-danger"></i>
                                                    </span>
                                                </div>

                                                <h4 class="fw-bold mb-2">Hapus Unit?</h4>
                                                <p class="text-muted mb-0">
                                                    Anda akan menghapus unit <strong>{{ $unit->code }}</strong>.
                                                    Tindakan ini <span class="text-danger fw-semibold">tidak dapat
                                                        dibatalkan</span>.
                                                </p>

                                            </div>

                                            {{-- Footer --}}
                                            <div class="modal-footer justify-content-center border-0 pt-0">
                                                <button type="button" class="btn btn-light px-5"
                                                    data-bs-dismiss="modal">Batal</button>

                                                <form action="{{ route('tools.units-delete', $unit->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-5">
                                                        <i class="fas fa-trash-alt me-1"></i>Ya, Hapus
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <div class="modal fade" id="kt_modal_add_tool" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-700px">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah Alat</h2>
                    <div class="btn btn-icon btn-sm" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"></i>
                    </div>
                </div>

                <!-- Body -->
                <div class="modal-body px-5 py-10">

                    <form method="POST" action="{{ route('tools.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="d-flex flex-column">

                            <div class="fv-row mb-6">
                                <label class="fw-semibold fs-6 mb-3">Foto Alat</label>
                                <input type="file" name="photo" class="form-control form-control-solid">
                            </div>

                            <div class="fv-row mb-6">
                                <label class="required fw-semibold fs-6 mb-3">Kode Awal</label>
                                <input type="text" name="code_prefix" class="form-control form-control-solid"
                                    placeholder="Contoh: ALAT" required>
                            </div>

                            <!-- Nama Alat -->
                            <div class="fv-row mb-6">
                                <label class="required fw-semibold fs-6 mb-3">Nama Alat</label>
                                <input type="text" name="name" class="form-control form-control-solid"
                                    placeholder="Contoh: Laptop" required>
                            </div>

                            <!-- Kategori -->
                            <div class="fv-row mb-6">
                                <label class="required fw-semibold fs-6 mb-3">Kategori</label>
                                <select name="category_id" class="form-select form-select-solid" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tipe -->
                            <div class="fv-row mb-6">
                                <label class="required fw-semibold fs-6 mb-3">Tipe Alat</label>
                                <select name="item_type" class="form-select form-select-solid" required>
                                    <option value="single">Single</option>
                                    <option value="bundle">Bundle</option>
                                </select>
                            </div>

                            <!-- Deskripsi -->
                            <div class="fv-row mb-6">
                                <label class="fw-semibold fs-6 mb-3">Deskripsi</label>
                                <textarea name="description" class="form-control form-control-solid" rows="3"
                                    placeholder="Deskripsi alat (opsional)"></textarea>
                            </div>

                        </div>

                        <!-- Actions -->
                        <div class="text-center pt-5">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
