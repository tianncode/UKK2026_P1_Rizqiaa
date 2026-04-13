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
                                            <a href="{{ route('tools.detail', $tool->id) }}"
                                                class="btn btn-icon btn-info btn-sm me-2" title="Lihat Detail">
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

                                                <div class="modal-header">
                                                    <h2 class="fw-bold">Edit Alat</h2>
                                                    <div class="btn btn-icon btn-sm" data-bs-dismiss="modal">
                                                        <i class="ki-duotone ki-cross fs-1"></i>
                                                    </div>
                                                </div>

                                                <div class="modal-body px-5 py-10">
                                                    <form method="POST" action="{{ route('tools.update', $tool->id) }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="d-flex flex-column">

                                                            <!-- Foto -->
                                                            <div class="fv-row mb-6">
                                                                <label class="fw-semibold fs-6 mb-3">Foto Alat</label>

                                                                <!-- Preview -->
                                                                <div class="mb-3 text-center">
                                                                    <img id="preview-image-edit-{{ $tool->id }}"
                                                                        src="{{ $tool->photo_path ? asset($tool->photo_path) : 'https://via.placeholder.com/150x150?text=Preview' }}"
                                                                        class="rounded shadow-sm"
                                                                        style="max-height:150px; object-fit:cover;">
                                                                </div>

                                                                <input type="file" name="photo"
                                                                    id="photo-input-edit-{{ $tool->id }}"
                                                                    class="form-control form-control-solid"
                                                                    accept="image/*">
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
                                                                    id="item_type_edit_{{ $tool->id }}"
                                                                    class="form-select form-select-solid" required>
                                                                    <option value="single"
                                                                        {{ $tool->item_type == 'single' ? 'selected' : '' }}>
                                                                        Single</option>
                                                                    <option value="bundle"
                                                                        {{ $tool->item_type == 'bundle' ? 'selected' : '' }}>
                                                                        Bundle</option>
                                                                </select>
                                                            </div>

                                                            <!-- Bundle Fields -->
                                                            <div id="bundle-fields-edit-{{ $tool->id }}"
                                                                style="{{ $tool->item_type === 'bundle' ? 'display:block' : 'display:none' }}">
                                                                <div class="fv-row mb-6">
                                                                    <label class="fw-semibold fs-6 mb-3">Isi Bundle</label>

                                                                    <div
                                                                        id="bundle-items-wrapper-edit-{{ $tool->id }}">
                                                                        @if ($tool->item_type === 'bundle' && $tool->bundleItems->count() > 0)
                                                                            @foreach ($tool->bundleItems as $index => $item)
                                                                                <div
                                                                                    class="bundle-item-row d-flex gap-3 mb-3 align-items-center">
                                                                                    <select
                                                                                        name="bundle_items[{{ $index }}][tool_id]"
                                                                                        class="form-select form-select-solid">
                                                                                        <option value="">Pilih Alat
                                                                                        </option>
                                                                                        @foreach ($singleTools as $single)
                                                                                            <option
                                                                                                value="{{ $single->id }}"
                                                                                                {{ $item->tool_id == $single->id ? 'selected' : '' }}>
                                                                                                {{ $single->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <input type="number"
                                                                                        name="bundle_items[{{ $index }}][qty]"
                                                                                        class="form-control form-control-solid w-100px"
                                                                                        placeholder="Qty" min="1"
                                                                                        value="{{ $item->qty }}">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-light-danger remove-bundle-item">
                                                                                        <i
                                                                                            class="ki-duotone ki-trash fs-4"></i>
                                                                                    </button>
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            <div
                                                                                class="bundle-item-row d-flex gap-3 mb-3 align-items-center">
                                                                                <select name="bundle_items[0][tool_id]"
                                                                                    class="form-select form-select-solid">
                                                                                    <option value="">Pilih Alat
                                                                                    </option>
                                                                                    @foreach ($singleTools as $single)
                                                                                        <option
                                                                                            value="{{ $single->id }}">
                                                                                            {{ $single->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <input type="number"
                                                                                    name="bundle_items[0][qty]"
                                                                                    class="form-control form-control-solid w-100px"
                                                                                    placeholder="Qty" min="1"
                                                                                    value="1">
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-light-danger remove-bundle-item">
                                                                                    <i
                                                                                        class="ki-duotone ki-trash fs-4"></i>
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    <button type="button"
                                                                        class="btn btn-sm btn-light-primary mt-2 add-bundle-item-edit"
                                                                        data-tool-id="{{ $tool->id }}">
                                                                        <i class="ki-duotone ki-plus fs-4"></i> Tambah Item
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <!-- Deskripsi -->
                                                            <div class="fv-row mb-6">
                                                                <label class="fw-semibold fs-6 mb-3">Deskripsi</label>
                                                                <textarea name="description" class="form-control form-control-solid" rows="3">{{ $tool->description }}</textarea>
                                                            </div>

                                                        </div>

                                                        <div class="text-center pt-5 pb-5">
                                                            <button type="button" class="btn btn-light me-3"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
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

                                                        <div class="text-center pt-5 pb-5">
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
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <div class="modal fade" id="kt_modal_add_tool" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;">
            <div class="modal-content border-0 shadow-lg">

                {{-- ===== HEADER ===== --}}
                <div class="modal-header px-8 py-5 border-bottom border-gray-200">
                    <div class="d-flex align-items-center gap-3">
                        <span class="bullet bullet-dot bg-primary h-8px w-8px"></span>
                        <h2 class="fw-bold fs-4 mb-0">Tambah Alat</h2>
                    </div>
                    <div class="btn btn-sm btn-icon btn-active-light-danger" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>

                {{-- ===== BODY ===== --}}
                <div class="modal-body px-8 py-7">
                    <form method="POST" action="{{ route('tools.store') }}" enctype="multipart/form-data"
                        id="form_add_tool">
                        @csrf

                        {{-- === FOTO === --}}
                        <div class="fv-row mb-6">
                            <label class="fw-semibold fs-7 text-gray-600 mb-2 d-block">Foto Alat</label>
                            <div class="d-flex align-items-center gap-5">
                                <div class="flex-shrink-0">
                                    <img id="preview-image" src="https://via.placeholder.com/80x80?text=Photo"
                                        class="rounded-3 border border-gray-200"
                                        style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="photo" id="photo-input"
                                        class="form-control form-control-solid form-control-sm" accept="image/*">
                                    <span class="text-muted fs-8 mt-1 d-block">Format: JPG, PNG. Maks 2MB.</span>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-dashed mb-6"></div>

                        {{-- === ROW 1: Kode Awal & Nama Alat === --}}
                        <div class="row g-5 mb-6">
                            <div class="col-md-4">
                                <label class="required fw-semibold fs-7 text-gray-600 mb-2 d-block">Kode Awal</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-0 text-muted fw-bold fs-8"
                                        id="code_prefix_label" style="display: none; letter-spacing: 0.5px;">BDL-</span>
                                    <input type="text" name="code_prefix" id="code_prefix"
                                        class="form-control form-control-solid form-control-sm" placeholder="Contoh: ALAT"
                                        required style="text-transform: uppercase;">
                                </div>
                                <span class="text-muted fs-8 mt-1 d-block" id="code_preview"></span>
                            </div>
                            <div class="col-md-8">
                                <label class="required fw-semibold fs-7 text-gray-600 mb-2 d-block">Nama Alat</label>
                                <input type="text" name="name"
                                    class="form-control form-control-solid form-control-sm"
                                    placeholder="Contoh: Laptop ASUS" required>
                            </div>
                        </div>

                        {{-- === ROW 2: Kategori & Tipe === --}}
                        <div class="row g-5 mb-6">
                            <div class="col-md-6">
                                <label class="required fw-semibold fs-7 text-gray-600 mb-2 d-block">Kategori</label>
                                <select name="category_id" class="form-select form-select-solid form-select-sm" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="required fw-semibold fs-7 text-gray-600 mb-2 d-block">Tipe Alat</label>
                                <select name="item_type" id="item_type"
                                    class="form-select form-select-solid form-select-sm" required>
                                    <option value="single">Single</option>
                                    <option value="bundle">Bundle</option>
                                </select>
                            </div>
                        </div>

                        {{-- === ROW 3: Harga === --}}
                        <div class="fv-row mb-6">
                            <label class="required fw-semibold fs-7 text-gray-600 mb-2 d-block">Price</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0 text-muted fw-semibold">Rp</span>
                                {{-- Input display (formatted) --}}
                                <input type="text" id="price_display"
                                    class="form-control form-control-solid form-control-sm" placeholder="0"
                                    autocomplete="off">
                                {{-- Input hidden (raw value) --}}
                                <input type="hidden" name="price" id="price_raw">
                            </div>
                            <span class="text-muted fs-8 mt-1 d-block" id="price_terbilang"></span>
                        </div>

                        {{-- === BUNDLE FIELDS (hidden by default) === --}}
                        <div id="bundle-fields" style="display: none;">
                            <div class="separator separator-dashed mb-6"></div>

                            <div class="fv-row mb-2">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <span class="fw-semibold fs-7 text-gray-600 d-block">Isi Bundle</span>
                                        <span class="text-muted fs-8">Tulis komponen / item yang ada di dalam bundle
                                            ini</span>
                                    </div>
                                    <button type="button" id="add-bundle-item" class="btn btn-sm btn-light-primary">
                                        <i class="ki-duotone ki-plus fs-4 me-1"></i> Tambah
                                    </button>
                                </div>

                                {{-- Header kolom --}}
                                <div class="d-flex gap-3 align-items-center mb-2 px-1">
                                    <span class="text-muted fs-8 fw-semibold" style="min-width: 18px;"></span>
                                    <span class="text-muted fs-8 fw-semibold flex-grow-1">Nama Komponen</span>
                                    <span class="text-muted fs-8 fw-semibold text-center" style="width: 65px;">Qty</span>
                                    <span class="text-muted fs-8 fw-semibold text-center" style="width: 110px;">Harga
                                        Satuan</span>
                                    <span style="width: 32px;"></span>
                                </div>

                                <div id="bundle-items-wrapper" class="d-flex flex-column gap-2">
                                    {{-- Row pertama (default) --}}
                                    <div class="bundle-item-row d-flex gap-3 align-items-center">
                                        <div
                                            class="d-flex align-items-center gap-3 flex-grow-1 bg-light rounded-2 px-4 py-2">
                                            <span class="text-muted fs-8 fw-bold bundle-number"
                                                style="min-width: 18px;">1.</span>

                                            {{-- Nama komponen --}}
                                            <input type="text" name="bundle_items[0][name]"
                                                class="form-control form-control-flush form-control-sm bg-transparent border-0 p-0"
                                                placeholder="Nama komponen, contoh: Kabel HDMI">

                                            {{-- Qty --}}
                                            <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                <input type="number" name="bundle_items[0][qty]"
                                                    class="form-control form-control-flush form-control-sm bg-transparent border-0 p-0 text-center fw-semibold"
                                                    style="width: 45px;" placeholder="1" min="1" value="1">
                                                <span class="text-muted fs-8">pcs</span>
                                            </div>

                                            {{-- Divider --}}
                                            <div class="border-start border-gray-300 mx-1" style="height: 20px;"></div>

                                            {{-- Harga Satuan --}}
                                            <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                <span class="text-muted fs-8 fw-semibold">Rp</span>
                                                <input type="text" name="bundle_items[0][price_display]"
                                                    class="form-control form-control-flush form-control-sm bg-transparent border-0 p-0 text-end bundle-price-display"
                                                    style="width: 90px;" placeholder="0" autocomplete="off">
                                                <input type="hidden" name="bundle_items[0][price]"
                                                    class="bundle-price-raw">
                                            </div>
                                        </div>

                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-light-danger flex-shrink-0 remove-bundle-item">
                                            <i class="ki-duotone ki-trash fs-4">
                                                <span class="path1"></span><span class="path2"></span>
                                                <span class="path3"></span><span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- === DESKRIPSI === --}}
                        <div class="separator separator-dashed my-6"></div>
                        <div class="fv-row mb-2">
                            <label class="fw-semibold fs-7 text-gray-600 mb-2 d-block">Deskripsi</label>
                            <textarea name="description" class="form-control form-control-solid form-control-sm" rows="3"
                                placeholder="Deskripsi alat (opsional)"></textarea>
                        </div>

                    </form>
                </div>

                {{-- ===== FOOTER ===== --}}
                <div class="modal-footer px-8 py-4 border-top border-gray-200 justify-content-end gap-3">
                    <button type="button" class="btn btn-sm btn-light px-7" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="form_add_tool" class="btn btn-sm btn-primary px-7">
                        <i class="ki-duotone ki-check fs-4 me-1"></i> Simpan
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
