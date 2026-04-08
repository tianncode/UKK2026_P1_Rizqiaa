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
                        <h3 class="fw-bold m-0">Transaction History</h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_add_transaction">
                            <i class="ki-duotone ki-plus fs-2"></i>
                            Add New
                        </button>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table id="kt_project_users_table" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-250px">Manager</th>
                                    <th class="min-w-125px">Date</th>
                                    <th class="min-w-125px">Amount</th>
                                    <th class="min-w-125px">Status</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <div class="symbol-label">
                                                    <img src="assets/media/avatars/300-6.jpg" alt="Emma Smith"
                                                        class="w-100" />
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">Emma
                                                    Smith</a>
                                                <span class="text-gray-500 fs-7">smith@kpmg.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-gray-800 fw-bold">May 05, 2026</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-800 fw-bold">$743.00</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-info">In Progress</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <div class="symbol-label">
                                                    <img src="assets/media/avatars/300-1.jpg" alt="John Doe"
                                                        class="w-100" />
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">John
                                                    Doe</a>
                                                <span class="text-gray-500 fs-7">john@company.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-gray-800 fw-bold">Apr 28, 2026</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-800 fw-bold">$1,240.00</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-success">Completed</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <div class="symbol-label">
                                                    <img src="assets/media/avatars/300-5.jpg" alt="Sarah Wilson"
                                                        class="w-100" />
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#"
                                                    class="text-gray-800 text-hover-primary mb-1 fw-bold">Sarah Wilson</a>
                                                <span class="text-gray-500 fs-7">sarah@enterprise.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-gray-800 fw-bold">Apr 15, 2026</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-800 fw-bold">$532.00</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-warning">Pending</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm">
                                            View Details
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

    <!--begin::Modal - Add Transaction-->
    <div class="modal fade" id="kt_modal_add_transaction" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_transaction_header">
                    <h2 class="fw-bold">Add New Transaction</h2>
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
                    <form id="kt_modal_add_transaction_form" class="form" action="#">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_transaction_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_transaction_header"
                            data-kt-scroll-wrappers="#kt_modal_add_transaction_scroll" data-kt-scroll-offset="300px">

                            <!--begin::Input group - Manager-->
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Manager Name</label>
                                <input type="text" name="manager_name"
                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="Enter manager name" />
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group - Email-->
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Email Address</label>
                                <input type="email" name="manager_email"
                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="example@email.com" />
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group - Avatar-->
                            <div class="fv-row mb-7">
                                <label class="fw-semibold fs-6 mb-2">Profile Picture</label>
                                <input type="file" name="manager_avatar" class="form-control form-control-solid"
                                    accept="image/*" />
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group - Date-->
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Transaction Date</label>
                                <input type="date" name="transaction_date" class="form-control form-control-solid" />
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group - Amount-->
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Amount</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="amount" class="form-control form-control-solid"
                                        placeholder="0.00" step="0.01" />
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group - Status-->
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Status</label>
                                <select name="status" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select a status" data-dropdown-parent="#kt_modal_add_transaction">
                                    <option></option>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group - Notes-->
                            <div class="fv-row mb-7">
                                <label class="fw-semibold fs-6 mb-2">Notes</label>
                                <textarea name="notes" class="form-control form-control-solid" rows="3"
                                    placeholder="Add transaction notes (optional)"></textarea>
                            </div>
                            <!--end::Input group-->

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
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
    <!--end::Modal - Add Transaction-->
@endsection

@push('scripts')
    <script>
        // Form validation and submission
        const form = document.querySelector('#kt_modal_add_transaction_form');
        const modal = document.querySelector('#kt_modal_add_transaction');

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
                        text: "Transaction has been successfully added!",
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
    </script>
@endpush
