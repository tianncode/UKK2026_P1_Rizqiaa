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
                                data-bs-target="#kt_modal_add_category">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add Category
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
                        <table id="kt_table_categories" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" />
                                        </div>
                                    </th>
                                    <th class="min-w-125px">Nama Kategori</th>
                                    <th class="min-w-250px">Deskripsi</th>
                                    <th class="min-w-150px">Tanggal Dibuat</th>
                                    <th class="min-w-100px">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($categories as $category)
                                    <tr>
                                        <!-- Checkbox -->
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" />
                                            </div>
                                        </td>

                                        <!-- Nama Kategori -->
                                        <td class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <div class="symbol-label bg-light-primary text-primary fw-bold">
                                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 mb-1">
                                                    {{ $category->name }}
                                                </span>
                                                <span class="text-muted fs-7">
                                                    ID: #CAT-{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Deskripsi -->
                                        <td>
                                            <span class="text-gray-700">
                                                {{ $category->description ?? '-' }}
                                            </span>
                                        </td>

                                        <!-- Tanggal -->
                                        <td>
                                            <span class="text-gray-800">
                                                {{ date('d M Y', strtotime($category->created_at)) }}
                                            </span>
                                        </td>

                                        <!-- Aksi -->
                                        <td>
                                            <!-- EDIT -->
                                            <a href="#" class="btn btn-icon btn-warning btn-sm me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_edit_category{{ $category->id }}">
                                                <i class="ki-duotone ki-pencil"></i>
                                            </a>
                                            <!-- DELETE -->
                                            <a href="#" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_delete_category{{ $category->id }}">
                                                <i class="ki-duotone ki-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="kt_modal_edit_category{{ $category->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered mw-600px">
                                            <div class="modal-content">

                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h2 class="fw-bold">Edit Kategori</h2>
                                                    <div class="btn btn-icon btn-sm" data-bs-dismiss="modal">
                                                        <i class="ki-duotone ki-cross fs-1"></i>
                                                    </div>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body px-5 py-10">
                                                    <form method="POST"
                                                        action="{{ route('categories.update', $category->id) }}">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Nama -->
                                                        <div class="fv-row mb-6">
                                                            <label class="required fw-semibold fs-6 mb-3">Nama
                                                                Kategori</label>
                                                            <input type="text" name="name"
                                                                class="form-control form-control-solid"
                                                                value="{{ $category->name }}" required />
                                                        </div>

                                                        <!-- Deskripsi -->
                                                        <div class="fv-row mb-6">
                                                            <label class="fw-semibold fs-6 mb-3">Deskripsi</label>
                                                            <textarea name="description" class="form-control form-control-solid" rows="3">{{ $category->description }}</textarea>
                                                        </div>

                                                        <!-- Actions -->
                                                        <div class="text-center">
                                                            <button type="button" class="btn btn-light me-3"
                                                                data-bs-dismiss="modal">
                                                                Batal
                                                            </button>
                                                            <button type="submit" class="btn btn-warning">
                                                                Update
                                                            </button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="kt_modal_delete_category{{ $category->id }}"
                                        tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered mw-500px">
                                            <div class="modal-content">

                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h2 class="fw-bold text-danger">Hapus Kategori</h2>
                                                    <div class="btn btn-icon btn-sm" data-bs-dismiss="modal">
                                                        <i class="ki-duotone ki-cross fs-1"></i>
                                                    </div>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body text-center px-5 py-10">

                                                    <p class="fs-5 mb-5">
                                                        Yakin ingin menghapus kategori:
                                                    </p>

                                                    <h4 class="fw-bold text-gray-800 mb-5">
                                                        {{ $category->name }}
                                                    </h4>

                                                    <form method="POST"
                                                        action="{{ route('categories.delete', $category->id) }}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="button" class="btn btn-light me-3"
                                                            data-bs-dismiss="modal">
                                                            Batal
                                                        </button>

                                                        <button type="submit" class="btn btn-danger">
                                                            Hapus
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>

    <!--begin::Modal - Add User-->
    <div class="modal fade" id="kt_modal_add_category" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah Kategori</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"></i>
                    </div>
                </div>

                <!-- Body -->
                <div class="modal-body px-5 py-10">

                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf

                        <div class="d-flex flex-column">

                            <!-- Nama -->
                            <div class="fv-row mb-6">
                                <label class="required fw-semibold fs-6 mb-3 text-gray-700">
                                    Nama Kategori
                                </label>
                                <input type="text" name="name" class="form-control form-control-solid"
                                    placeholder="Contoh: Elektronik" required />
                            </div>

                            <!-- Deskripsi -->
                            <div class="fv-row mb-6">
                                <label class="fw-semibold fs-6 mb-3 text-gray-700">
                                    Deskripsi
                                </label>
                                <textarea name="description" class="form-control form-control-solid" rows="3"
                                    placeholder="Deskripsi kategori (opsional)"></textarea>
                            </div>

                        </div>

                        <!-- Actions -->
                        <div class="text-center pt-5">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">
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
    <!--end::Modal - Add User-->
@endsection
