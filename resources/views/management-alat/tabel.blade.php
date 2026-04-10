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
                                data-bs-target="#kt_modal_add_user">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add User
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
                        <table id="kt_table_users" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" />
                                        </div>
                                    </th>
                                    <th class="min-w-125px">User</th>
                                    <th class="min-w-125px">Contact</th>
                                    <th class="min-w-125px">Role</th>
                                    <th class="min-w-125px">Penalty Points</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="min-w-100px">Joined Date</th>
                                    <th class="min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" />
                                            </div>
                                        </td>

                                        <!-- Nama + ID -->
                                        <td class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <div class="symbol-label bg-light-primary text-primary fw-bold">
                                                    {{ strtoupper(substr($user->detail->name ?? 'U', 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                    {{ $user->detail->name ?? '-' }}
                                                </a>
                                                <span class="text-muted fs-7">
                                                    ID: #USR-{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Email + HP -->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 mb-1">{{ $user->email }}</span>
                                                <span class="text-muted fs-7">
                                                    {{ $user->detail->no_hp ?? '-' }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Role -->
                                        <td>
                                            @php
                                                $roleClass = match ($user->role) {
                                                    'admin' => 'badge-light-danger',
                                                    'manager' => 'badge-light-info',
                                                    'employee' => 'badge-light-primary',
                                                    'peminjam' => 'badge-light-warning',
                                                    default => 'badge-light-secondary',
                                                };
                                            @endphp

                                            <div class="badge {{ $roleClass }} fw-bold">
                                                {{ ucfirst($user->role) }}
                                            </div>
                                        </td>

                                        <!-- Penalty Points -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress h-6px w-100px me-2">
                                                    <div class="progress-bar bg-success"
                                                        style="width: {{ $user->penalty_points }}%">
                                                    </div>
                                                </div>
                                                <span class="text-muted fs-7">
                                                    {{ $user->penalty_points }}/100
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @if ($user->is_restricted)
                                                <div class="badge badge-light-danger fw-bold">Restricted</div>
                                            @else
                                                <div class="badge badge-light-success fw-bold">Active</div>
                                            @endif
                                        </td>

                                        <!-- Tanggal -->
                                        <td>
                                            <span class="text-gray-800">
                                                {{ date('d M Y', strtotime($user->created_at)) }}
                                            </span>
                                        </td>

                                        <td>
                                            <!-- VIEW -->
                                            <a href="#" class="btn btn-icon btn-light btn-sm me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_view_user{{ $user->id }}">
                                                <i class="ki-duotone ki-eye"></i>
                                            </a>

                                            <!-- EDIT -->
                                            <a href="#" class="btn btn-icon btn-warning btn-sm me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_edit_user{{ $user->id }}">
                                                <i class="ki-duotone ki-pencil"></i>
                                            </a>

                                            <!-- DELETE -->
                                            <a href="#" class="btn btn-icon btn-danger btn-sm me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_delete_user{{ $user->id }}">
                                                <i class="ki-duotone ki-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                    {{-- MODAL VIEW USER --}}
                                    <div class="modal fade" id="kt_modal_view_user{{ $user->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered mw-800px">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="fw-bold">User Details</h2>
                                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                        data-bs-dismiss="modal">
                                                        <i class="ki-duotone ki-cross fs-1"><span
                                                                class="path1"></span><span class="path2"></span></i>
                                                    </div>
                                                </div>
                                                <div class="modal-body px-5 py-10">
                                                    <div class="card card-flush mb-8 shadow-sm">
                                                        <div class="card-body p-8">
                                                            {{-- User Header --}}
                                                            <div class="d-flex align-items-center mb-7 pb-5 border-bottom">
                                                                <div class="symbol symbol-60px me-5">
                                                                    <div
                                                                        class="symbol-label fs-2 fw-bold bg-light-primary text-primary">
                                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <span
                                                                        class="text-gray-800 fs-4 fw-bold">{{ $user->detail->name ?? '-' }}</span>
                                                                    <div class="text-muted fw-semibold fs-6">
                                                                        {{ $user->email }}</div>
                                                                </div>
                                                                <span
                                                                    class="badge badge-light-{{ $user->is_restricted ? 'danger' : 'success' }} fs-7 fw-bold">
                                                                    {{ $user->is_restricted ? 'Restricted' : 'Active' }}
                                                                </span>
                                                            </div>

                                                            {{-- Info Grid --}}
                                                            <div class="row g-6">
                                                                <div class="col-md-6">
                                                                    <label
                                                                        class="fs-7 fw-bold text-muted text-uppercase ls-1 mb-1">Full
                                                                        Name</label>
                                                                    <div class="fs-6 fw-semibold text-gray-800">
                                                                        {{ $user->detail->name ?? '-' }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label
                                                                        class="fs-7 fw-bold text-muted text-uppercase ls-1 mb-1">NIK</label>
                                                                    <div class="fs-6 fw-semibold text-gray-800">
                                                                        {{ $user->detail->nik ?? '-' }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label
                                                                        class="fs-7 fw-bold text-muted text-uppercase ls-1 mb-1">Email</label>
                                                                    <div class="fs-6 fw-semibold text-gray-800">
                                                                        {{ $user->email }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label
                                                                        class="fs-7 fw-bold text-muted text-uppercase ls-1 mb-1">Phone
                                                                        Number</label>
                                                                    <div class="fs-6 fw-semibold text-gray-800">
                                                                        {{ $user->detail->no_hp ?? '-' }}</div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label
                                                                        class="fs-7 fw-bold text-muted text-uppercase ls-1 mb-1">Address</label>
                                                                    <div class="fs-6 fw-semibold text-gray-800">
                                                                        {{ $user->detail->address ?? '-' }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label
                                                                        class="fs-7 fw-bold text-muted text-uppercase ls-1 mb-1">Birth
                                                                        Date</label>
                                                                    <div class="fs-6 fw-semibold text-gray-800">
                                                                        {{ $user->detail->birth_date ? \Carbon\Carbon::parse($user->detail->birth_date)->isoFormat('D MMMM Y') : '-' }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label
                                                                        class="fs-7 fw-bold text-muted text-uppercase ls-1 mb-1">Role</label>
                                                                    <div class="fs-6 fw-semibold">
                                                                        <span
                                                                            class="badge badge-light-primary">{{ ucfirst($user->role) }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label
                                                                        class="fs-7 fw-bold text-muted text-uppercase ls-1 mb-1">Penalty
                                                                        Points</label>
                                                                    <div class="fs-6 fw-semibold">
                                                                        <span
                                                                            class="badge badge-light-warning">{{ $user->penalty_points ?? 0 }}
                                                                            Points</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label
                                                                        class="fs-7 fw-bold text-muted text-uppercase ls-1 mb-1">Registered
                                                                        At</label>
                                                                    <div class="fs-6 fw-semibold text-gray-800">
                                                                        {{ $user->created_at->isoFormat('D MMMM Y') }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-center pt-5">
                                                        <button type="button" class="btn btn-light me-3"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- MODAL EDIT USER --}}
                                    <div class="modal fade" id="kt_modal_edit_user{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered mw-900px">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h2 class="fw-bold">Edit User</h2>
                                                    <div class="btn btn-icon btn-sm" data-bs-dismiss="modal">✕</div>
                                                </div>

                                                <div class="modal-body px-5 py-10">
                                                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="d-flex flex-column scroll-y me-n7 pe-7">

                                                            {{-- PERSONAL --}}
                                                            <div class="card mb-6">
                                                                <div class="card-body">

                                                                    <h5 class="mb-5">Personal Information</h5>

                                                                    <div class="row mb-4">
                                                                        <div class="col-md-6">
                                                                            <label>Full Name</label>
                                                                            <input type="text" name="name"
                                                                                class="form-control"
                                                                                value="{{ $user->detail->name ?? '' }}">
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <label>NIK</label>
                                                                            <input type="text" name="nik"
                                                                                class="form-control"
                                                                                value="{{ $user->detail->nik ?? '' }}"
                                                                                readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-4">
                                                                        <div class="col-md-6">
                                                                            <label>Email</label>
                                                                            <input type="email" name="email"
                                                                                class="form-control"
                                                                                value="{{ $user->email }}">
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <label>Phone</label>
                                                                            <input type="text" name="no_hp"
                                                                                class="form-control"
                                                                                value="{{ $user->detail->no_hp ?? '' }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-4">
                                                                        <label>Address</label>
                                                                        <textarea name="address" class="form-control">{{ $user->detail->address ?? '' }}</textarea>
                                                                    </div>

                                                                    <div>
                                                                        <label>Birth Date</label>
                                                                        <input type="date" name="birth_date"
                                                                            class="form-control"
                                                                            value="{{ $user->detail->birth_date ?? '' }}">
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            {{-- PASSWORD --}}
                                                            <div class="card mb-6">
                                                                <div class="card-body">

                                                                    <h5 class="mb-2">Reset Password</h5>
                                                                    <small class="text-muted">Kosongkan jika tidak ingin
                                                                        mengubah</small>

                                                                    <div class="row mt-4">
                                                                        <div class="col-md-6">
                                                                            <input type="password" name="password"
                                                                                class="form-control"
                                                                                placeholder="New Password">
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <input type="password" name="confirm_password"
                                                                                class="form-control"
                                                                                placeholder="Confirm Password">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            {{-- ROLE --}}
                                                            <div class="card">
                                                                <div class="card-body">

                                                                    <h5 class="mb-5">Role & Permissions</h5>

                                                                    <div class="mb-4">
                                                                        <label>Role</label>
                                                                        <select name="role" class="form-select">
                                                                            <option value="admin"
                                                                                {{ $user->role == 'admin' ? 'selected' : '' }}>
                                                                                Admin</option>
                                                                            <option value="employee"
                                                                                {{ $user->role == 'employee' ? 'selected' : '' }}>
                                                                                Employee</option>
                                                                            <option value="user"
                                                                                {{ $user->role == 'user' ? 'selected' : '' }}>
                                                                                User</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Penalty Points</label>
                                                                            <input type="number" name="penalty_points"
                                                                                class="form-control"
                                                                                value="{{ $user->penalty_points ?? 0 }}">
                                                                        </div>

                                                                        <div class="col-md-6 mt-4">
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="is_restricted"
                                                                                    {{ $user->is_restricted ? 'checked' : '' }}>
                                                                                <label class="form-check-label">
                                                                                    Restrict Account
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="text-center mt-6">
                                                            <button type="button" class="btn btn-light me-3"
                                                                data-bs-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                Save Changes
                                                            </button>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    {{-- MODAL DELETE USER --}}
                                    <div class="modal fade" id="kt_modal_delete_user{{ $user->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered mw-480px">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="fw-bold">Delete User</h2>
                                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                        data-bs-dismiss="modal">
                                                        <i class="ki-duotone ki-cross fs-1"><span
                                                                class="path1"></span><span class="path2"></span></i>
                                                    </div>
                                                </div>
                                                <div class="modal-body px-8 py-10 text-center">
                                                    {{-- Icon --}}
                                                    <div class="mb-6">
                                                        <i class="ki-duotone ki-trash fs-5x text-danger">
                                                            <span class="path1"></span><span class="path2"></span>
                                                            <span class="path3"></span><span class="path4"></span><span
                                                                class="path5"></span>
                                                        </i>
                                                    </div>
                                                    <h3 class="fw-bold text-gray-800 fs-2 mb-3">Hapus User Ini?</h3>
                                                    <p class="text-muted fs-6 mb-2">Anda akan menghapus user:</p>
                                                    <p class="fw-bold text-danger fs-5 mb-4" id="delete_user_name">
                                                        {{ $user->detail->name ?? '-' }}</p>
                                                    <p class="text-muted fs-6 mb-0">
                                                        Tindakan ini <strong class="text-danger">tidak dapat
                                                            dibatalkan</strong>
                                                        dan semua data terkait user ini akan dihapus secara permanen.
                                                    </p>

                                                    <form method="POST" action="{{ route('users.delete', $user->id) }}"
                                                        class="mt-8">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="button" class="btn btn-light me-3"
                                                            data-bs-dismiss="modal">
                                                            Batal
                                                        </button>

                                                        <button type="submit" class="btn btn-danger">
                                                            Ya, Hapus
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
    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h2 class="fw-bold">Add New User</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body px-5 py-10">
                    <!--begin::Form-->
                    <form id="kt_modal_add_user_form" class="form" method="POST"
                        action="{{ route('users.store') }}">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                            data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                            <!--begin::Card - Personal Information-->
                            <div class="card card-flush mb-8 shadow-sm">
                                <div class="card-body p-8">
                                    <h5 class="card-title text-gray-800 fw-bold mb-6">Personal Information</h5>

                                    <!--begin::Row - Name & NIK-->
                                    <div class="row g-6 mb-6">
                                        <!--begin::Col - Name-->
                                        <div class="col-md-6 fv-row">
                                            <label class="required fw-semibold fs-6 mb-3 text-gray-700">Full Name</label>
                                            <input type="text" name="name" class="form-control form-control-solid"
                                                placeholder="Enter full name" />
                                        </div>
                                        <!--end::Col-->

                                        <!--begin::Col - NIK-->
                                        <div class="col-md-6 fv-row">
                                            <label class="required fw-semibold fs-6 mb-3 text-gray-700">NIK (ID
                                                Number)</label>
                                            <input type="text" name="nik" class="form-control form-control-solid"
                                                placeholder="Enter NIK" maxlength="16" />
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->

                                    <!--begin::Row - Email & Phone-->
                                    <div class="row g-6 mb-6">
                                        <!--begin::Col - Email-->
                                        <div class="col-md-6 fv-row">
                                            <label class="required fw-semibold fs-6 mb-3 text-gray-700">Email
                                                Address</label>
                                            <input type="email" name="email" class="form-control form-control-solid"
                                                placeholder="example@email.com" />
                                        </div>
                                        <!--end::Col-->

                                        <!--begin::Col - Phone-->
                                        <div class="col-md-6 fv-row">
                                            <label class="fw-semibold fs-6 mb-3 text-gray-700">Phone Number</label>
                                            <input type="text" name="no_hp" class="form-control form-control-solid"
                                                placeholder="+62 812-xxxx-xxxx" />
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->

                                    <!--begin::Input group - Address-->
                                    <div class="fv-row mb-6">
                                        <label class="fw-semibold fs-6 mb-3 text-gray-700">Address</label>
                                        <textarea name="address" class="form-control form-control-solid" rows="3" placeholder="Enter full address"></textarea>
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Row - Birth Date-->
                                    <div class="row g-6">
                                        <div class="col-md-6 fv-row">
                                            <label class="fw-semibold fs-6 mb-3 text-gray-700">Birth Date</label>
                                            <input type="date" name="birth_date"
                                                class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                </div>
                            </div>
                            <!--end::Card-->

                            <!--begin::Card - Account Security-->
                            <div class="card card-flush mb-8 shadow-sm">
                                <div class="card-body p-8">
                                    <h5 class="card-title text-gray-800 fw-bold mb-6">Account Security</h5>

                                    <!--begin::Row - Password & Confirm Password-->
                                    <div class="row g-6">
                                        <!--begin::Col - Password-->
                                        <div class="col-md-6 fv-row">
                                            <label class="required fw-semibold fs-6 mb-3 text-gray-700">Password</label>
                                            <div class="position-relative mb-2">
                                                <input type="password" name="password"
                                                    class="form-control form-control-solid"
                                                    placeholder="Enter password" />
                                                <span
                                                    class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2">
                                                    <i class="ki-duotone ki-eye-slash fs-2"></i>
                                                    <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                                </span>
                                            </div>
                                            <div class="form-text">Minimum 8 characters with uppercase, lowercase and
                                                number.</div>
                                        </div>
                                        <!--end::Col-->

                                        <!--begin::Col - Confirm Password-->
                                        <div class="col-md-6 fv-row">
                                            <label class="required fw-semibold fs-6 mb-3 text-gray-700">Confirm
                                                Password</label>
                                            <input type="password" name="confirm_password"
                                                class="form-control form-control-solid" placeholder="Re-enter password" />
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                            </div>
                            <!--end::Card-->

                            <!--begin::Card - Role & Permissions-->
                            <div class="card card-flush shadow-sm">
                                <div class="card-body p-8">
                                    <h5 class="card-title text-gray-800 fw-bold mb-6">Role & Permissions</h5>

                                    <!--begin::Row - Role-->
                                    <div class="row g-6 mb-6">
                                        <div class="col-md-12 fv-row">
                                            <label class="required fw-semibold fs-6 mb-3 text-gray-700">Role</label>
                                            <select name="role" class="form-select form-select-solid"
                                                data-control="select2" data-placeholder="Select a role"
                                                data-dropdown-parent="#kt_modal_add_user">

                                                <option></option>
                                                <option value="admin">Admin</option>
                                                <option value="employee">Employee</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--end::Row-->

                                    <!--begin::Row - Penalty Points & Status-->
                                    <div class="row g-6">
                                        <!--begin::Col - Penalty Points-->
                                        <div class="col-md-6 fv-row">
                                            <label class="fw-semibold fs-6 mb-3 text-gray-700">Penalty Points</label>
                                            <input type="number" name="penalty_points"
                                                class="form-control form-control-solid" placeholder="0" value="0"
                                                min="0" max="100" />
                                            <div class="form-text mt-2">Range: 0 - 100 points</div>
                                        </div>
                                        <!--end::Col-->

                                        <!--begin::Col - Status-->
                                        <div class="col-md-6 fv-row">
                                            <label class="fw-semibold fs-6 mb-3 text-gray-700">Account Status</label>
                                            <div class="form-check form-switch form-check-custom form-check-solid mt-4">
                                                <input class="form-check-input" type="checkbox" name="is_restricted"
                                                    id="is_restricted" />
                                                <label class="form-check-label fw-semibold text-gray-600 ms-3"
                                                    for="is_restricted">
                                                    Restrict this account
                                                </label>
                                            </div>
                                            <div class="form-text mt-2">Restricted users have limited access.</div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                            </div>
                            <!--end::Card-->

                        </div>
                        <!--end::Scroll-->

                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
        </div>
    </div>
    <!--end::Modal - Add User-->
@endsection
