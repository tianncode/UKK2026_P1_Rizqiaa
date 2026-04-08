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
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                <tr>
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" />
                                        </div>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <div class="symbol-label">
                                                <img src="assets/media/avatars/300-6.jpg" alt="Emma Smith" class="w-100" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-gray-800 text-hover-primary mb-1">Emma Smith</a>
                                            <span class="text-muted fs-7">ID: #USR-001</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-800 mb-1">emma.smith@kpmg.com</span>
                                            <span class="text-muted fs-7">+62 812-3456-7890</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light-primary fw-bold">Administrator</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress h-6px w-100px me-2">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 20%">
                                                </div>
                                            </div>
                                            <span class="text-muted fs-7">20/100</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light-success fw-bold">Active</div>
                                    </td>
                                    <td>
                                        <span class="text-gray-800">10 Nov 2024</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#"
                                            class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            Actions
                                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                        </a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                            data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">Edit</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3"
                                                    data-kt-users-table-filter="delete_row">Delete</a>
                                            </div>
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" />
                                        </div>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <div class="symbol-label">
                                                <img src="assets/media/avatars/300-1.jpg" alt="John Doe" class="w-100" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-gray-800 text-hover-primary mb-1">John Doe</a>
                                            <span class="text-muted fs-7">ID: #USR-002</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-800 mb-1">john.doe@company.com</span>
                                            <span class="text-muted fs-7">+62 813-9876-5432</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light-info fw-bold">Manager</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress h-6px w-100px me-2">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: 45%">
                                                </div>
                                            </div>
                                            <span class="text-muted fs-7">45/100</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light-success fw-bold">Active</div>
                                    </td>
                                    <td>
                                        <span class="text-gray-800">15 Oct 2024</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#"
                                            class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            Actions
                                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" />
                                        </div>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <div class="symbol-label">
                                                <img src="assets/media/avatars/300-5.jpg" alt="Sarah Wilson"
                                                    class="w-100" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-gray-800 text-hover-primary mb-1">Sarah
                                                Wilson</a>
                                            <span class="text-muted fs-7">ID: #USR-003</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-800 mb-1">sarah.w@enterprise.com</span>
                                            <span class="text-muted fs-7">+62 821-5555-4444</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light-warning fw-bold">User</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress h-6px w-100px me-2">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                    style="width: 75%">
                                                </div>
                                            </div>
                                            <span class="text-muted fs-7">75/100</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light-danger fw-bold">Restricted</div>
                                    </td>
                                    <td>
                                        <span class="text-gray-800">01 Sep 2024</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#"
                                            class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            Actions
                                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
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
                    <form id="kt_modal_add_user_form" class="form" action="#">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                            data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                            <!--begin::Notice-->
                            <div
                                class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                                <i class="ki-duotone ki-information fs-2tx text-primary me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-semibold">
                                        <h4 class="text-gray-900 fw-bold">User Information</h4>
                                        <div class="fs-6 text-gray-700">Please fill in all required fields marked with an
                                            asterisk (*) to create a new user account.</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Notice-->

                            <!--begin::Input group - Avatar-->
                            <div class="fv-row mb-7">
                                <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                    style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url(assets/media/avatars/300-6.jpg)"></div>
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="Change avatar">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                    </label>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        title="Cancel avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        title="Remove avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                </div>
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Row - Name & NIK-->
                            <div class="row g-9 mb-7">
                                <!--begin::Col - Name-->
                                <div class="col-md-6 fv-row">
                                    <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                                    <input type="text" name="name" class="form-control form-control-solid"
                                        placeholder="Enter full name" />
                                </div>
                                <!--end::Col-->

                                <!--begin::Col - NIK-->
                                <div class="col-md-6 fv-row">
                                    <label class="required fw-semibold fs-6 mb-2">NIK (ID Number)</label>
                                    <input type="text" name="nik" class="form-control form-control-solid"
                                        placeholder="Enter NIK" maxlength="16" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->

                            <!--begin::Row - Email & Phone-->
                            <div class="row g-9 mb-7">
                                <!--begin::Col - Email-->
                                <div class="col-md-6 fv-row">
                                    <label class="required fw-semibold fs-6 mb-2">Email Address</label>
                                    <input type="email" name="email" class="form-control form-control-solid"
                                        placeholder="example@email.com" />
                                </div>
                                <!--end::Col-->

                                <!--begin::Col - Phone-->
                                <div class="col-md-6 fv-row">
                                    <label class="fw-semibold fs-6 mb-2">Phone Number</label>
                                    <input type="text" name="no_hp" class="form-control form-control-solid"
                                        placeholder="+62 812-xxxx-xxxx" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->

                            <!--begin::Row - Password & Confirm Password-->
                            <div class="row g-9 mb-7">
                                <!--begin::Col - Password-->
                                <div class="col-md-6 fv-row">
                                    <label class="required fw-semibold fs-6 mb-2">Password</label>
                                    <div class="position-relative mb-3">
                                        <input type="password" name="password" class="form-control form-control-solid"
                                            placeholder="Enter password" />
                                        <span
                                            class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2">
                                            <i class="ki-duotone ki-eye-slash fs-2"></i>
                                            <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
                                    <div class="form-text">Minimum 8 characters with uppercase, lowercase and number.</div>
                                </div>
                                <!--end::Col-->

                                <!--begin::Col - Confirm Password-->
                                <div class="col-md-6 fv-row">
                                    <label class="required fw-semibold fs-6 mb-2">Confirm Password</label>
                                    <input type="password" name="confirm_password"
                                        class="form-control form-control-solid" placeholder="Re-enter password" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->

                            <!--begin::Input group - Address-->
                            <div class="fv-row mb-7">
                                <label class="fw-semibold fs-6 mb-2">Address</label>
                                <textarea name="address" class="form-control form-control-solid" rows="3" placeholder="Enter full address"></textarea>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Row - Birth Date & Role-->
                            <div class="row g-9 mb-7">
                                <!--begin::Col - Birth Date-->
                                <div class="col-md-6 fv-row">
                                    <label class="fw-semibold fs-6 mb-2">Birth Date</label>
                                    <input type="date" name="birth_date" class="form-control form-control-solid" />
                                </div>
                                <!--end::Col-->

                                <!--begin::Col - Role-->
                                <div class="col-md-6 fv-row">
                                    <label class="required fw-semibold fs-6 mb-2">Role</label>
                                    <select name="role" class="form-select form-select-solid" data-control="select2"
                                        data-placeholder="Select a role" data-dropdown-parent="#kt_modal_add_user">
                                        <option></option>
                                        <option value="administrator">Administrator</option>
                                        <option value="manager">Manager</option>
                                        <option value="user">User</option>
                                        <option value="guest">Guest</option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->

                            <!--begin::Row - Penalty Points & Status-->
                            <div class="row g-9 mb-7">
                                <!--begin::Col - Penalty Points-->
                                <div class="col-md-6 fv-row">
                                    <label class="fw-semibold fs-6 mb-2">Penalty Points</label>
                                    <input type="number" name="penalty_points" class="form-control form-control-solid"
                                        placeholder="0" value="0" min="0" max="100" />
                                    <div class="form-text">Range: 0 - 100 points</div>
                                </div>
                                <!--end::Col-->

                                <!--begin::Col - Status-->
                                <div class="col-md-6 fv-row">
                                    <label class="fw-semibold fs-6 mb-2">Account Status</label>
                                    <div class="form-check form-switch form-check-custom form-check-solid mt-3">
                                        <input class="form-check-input" type="checkbox" name="is_restricted"
                                            id="is_restricted" />
                                        <label class="form-check-label fw-semibold text-gray-400 ms-3"
                                            for="is_restricted">
                                            Restrict this account
                                        </label>
                                    </div>
                                    <div class="form-text">Restricted users have limited access.</div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->

                        </div>
                        <!--end::Scroll-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
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

@push('scripts')
    <script>
        // Form validation and submission
        const form = document.querySelector('#kt_modal_add_user_form');
        const modal = document.querySelector('#kt_modal_add_user');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitButton = form.querySelector('[type="submit"]');
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;

                // Simulate form submission
                setTimeout(function() {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    // Close modal
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    bsModal.hide();

                    // Reset form
                    form.reset();

                    // Show success message
                    Swal.fire({
                        text: "User has been successfully added!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }, 2000);
            });
        }

        // Password toggle visibility
        document.querySelectorAll('[name="password"]').forEach(input => {
            const toggleBtn = input.nextElementSibling;
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.querySelector('.ki-eye-slash').classList.toggle('d-none');
                    this.querySelector('.ki-eye').classList.toggle('d-none');
                });
            }
        });
    </script>
@endpush
