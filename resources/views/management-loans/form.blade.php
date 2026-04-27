@extends('master')
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card">
                <div class="card-body p-lg-20">
                    <div class="d-flex flex-column flex-xl-row position-relative">

                        <!--begin::Content-->
                        <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                            <div class="mt-n1">
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

                                    <!--begin::Unit List-->
                                    @if ($tool->units?->count() > 0)
                                        <div class="card card-flush mb-8">
                                            <div class="card-header pt-6 pb-4">
                                                <div class="card-title">
                                                    <h4 class="fw-bold text-gray-800 mb-0">Daftar Unit</h4>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row g-4">
                                                    @foreach ($tool->units as $unit)
                                                        <div class="col-md-4 col-sm-6">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between rounded px-4 py-3 border border-dashed">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="symbol symbol-35px">
                                                                        <span
                                                                            class="symbol-label
                                                                            @if ($unit->status == 'available') bg-light-success
                                                                            @elseif ($unit->status == 'borrowed') bg-light-warning
                                                                            @elseif ($unit->status == 'returned') bg-light-primary
                                                                            @elseif ($unit->status == 'overdue') bg-light-danger
                                                                            @else bg-light-danger @endif">
                                                                            <i
                                                                                class="ki-duotone ki-wrench fs-3
                                                                                @if ($unit->status == 'available') text-success
                                                                                @elseif ($unit->status == 'borrowed') text-warning
                                                                                @elseif ($unit->status == 'returned') bg-light-primary
                                                                                @elseif ($unit->status == 'overdue') bg-light-danger
                                                                                @else text-danger @endif">
                                                                                <span class="path1"></span>
                                                                                <span class="path2"></span>
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span
                                                                            class="fw-semibold text-gray-800 fs-7 d-block">{{ $unit->code }}</span>
                                                                        <span
                                                                            class="text-muted fs-8">{{ $unit->condition ?? 'Baik' }}</span>
                                                                    </div>
                                                                </div>
                                                                @if ($unit->status == 'available')
                                                                    <span class="badge badge-light-success">Tersedia</span>
                                                                @elseif ($unit->status == 'borrowed')
                                                                    <span class="badge badge-light-warning">Dipinjam</span>
                                                                @elseif ($unit->status == 'returned')
                                                                    <span
                                                                        class="badge badge-light-primary">Dikembalikan</span>
                                                                @elseif ($unit->status == 'overdue')
                                                                    <span class="badge badge-light-danger">Terlambat</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-light-danger">{{ ucfirst($unit->status) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <!--end::Unit List-->

                                    <!--begin::Tombol Ajukan-->
                                    <div class="d-flex justify-content-center mb-8" id="wrapBtnAjukan">
                                        <button type="button" class="btn btn-lg btn-primary" id="btnAjukanPinjam">
                                            <i class="ki-duotone ki-calendar-add fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            Ajukan Pinjam Sekarang
                                        </button>
                                    </div>
                                    <!--end::Tombol Ajukan-->

                                    <!--begin::Form Peminjaman (inline)-->
                                    <div id="formPinjamSection"
                                        style="display: none; opacity: 0; transform: translateY(16px); transition: opacity 0.3s ease, transform 0.3s ease;">
                                        <div class="card card-flush mb-8">

                                            <!--begin::Card Header-->
                                            <div class="card-header pt-7 pb-5">
                                                <div class="card-title">
                                                    <i class="ki-duotone ki-calendar-add fs-2 text-primary me-3">
                                                        <span class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span>
                                                    </i>
                                                    <h4 class="fw-bold text-gray-800 mb-0">Form Pengajuan Peminjaman</h4>
                                                </div>
                                                <div class="card-toolbar">
                                                    <button type="button" class="btn btn-sm btn-light-danger"
                                                        id="btnBatalPinjam">
                                                        <i class="ki-duotone ki-cross fs-3"><span
                                                                class="path1"></span><span class="path2"></span></i>
                                                        Batal
                                                    </button>
                                                </div>
                                            </div>
                                            <!--end::Card Header-->

                                            <div class="card-body pt-0">

                                                <!--begin::Tool Info Bar-->
                                                <div class="d-flex align-items-center gap-4 p-5 mb-8 rounded"
                                                    style="background: var(--bs-gray-100);">
                                                    @if (!empty($tool->photo_path) && file_exists(public_path($tool->photo_path)))
                                                        <img src="{{ asset($tool->photo_path) }}"
                                                            alt="{{ $tool->name }}" class="rounded"
                                                            style="width: 48px; height: 48px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded bg-light-primary text-primary fw-bold fs-4 d-flex align-items-center justify-content-center flex-shrink-0"
                                                            style="width: 48px; height: 48px;">
                                                            {{ strtoupper(substr($tool->name, 0, 2)) }}
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold text-gray-800 fs-6">{{ $tool->name }}</div>
                                                        <div class="text-muted fs-7">ID:
                                                            #TL-{{ str_pad($tool->id, 3, '0', STR_PAD_LEFT) }}</div>
                                                    </div>
                                                </div>
                                                <!--end::Tool Info Bar-->

                                                <form action="{{ route('loans.store') }}" method="POST"
                                                    id="formPeminjaman">
                                                    @csrf
                                                    <input type="hidden" name="tool_id" value="{{ $tool->id }}">

                                                    {{-- ── STEP 1: Pilih Tanggal ── --}}
                                                    <div class="d-flex align-items-center mb-6">
                                                        <span class="fw-bold text-gray-600 fs-7 me-3 text-nowrap">LANGKAH 1
                                                            — PILIH TANGGAL</span>
                                                        <div class="flex-grow-1 border-bottom border-dashed"></div>
                                                    </div>

                                                    <div class="row g-6 mb-6">
                                                        <div class="col-md-4">
                                                            <label class="form-label required text-gray-600 fs-7">Tanggal
                                                                Pinjam</label>
                                                            <div class="position-relative">
                                                                <input type="text" id="inputBorrowDate"
                                                                    name="loan_date"
                                                                    class="form-control form-control-lg ps-12"
                                                                    placeholder="Pilih tanggal pinjam" autocomplete="off"
                                                                    required>
                                                                <span
                                                                    class="position-absolute top-50 translate-middle-y ms-4"
                                                                    style="left: 0; pointer-events: none;">
                                                                    <i class="ki-duotone ki-calendar fs-3 text-gray-500">
                                                                        <span class="path1"></span><span
                                                                            class="path2"></span>
                                                                    </i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label required text-gray-600 fs-7">Tanggal
                                                                Rencana Kembali</label>
                                                            <div class="position-relative">
                                                                <input type="text" id="inputReturnDate"
                                                                    name="due_date"
                                                                    class="form-control form-control-lg ps-12"
                                                                    placeholder="Pilih tanggal kembali" autocomplete="off"
                                                                    required>
                                                                <span
                                                                    class="position-absolute top-50 translate-middle-y ms-4"
                                                                    style="left: 0; pointer-events: none;">
                                                                    <i class="ki-duotone ki-calendar fs-3 text-gray-500">
                                                                        <span class="path1"></span><span
                                                                            class="path2"></span>
                                                                    </i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 d-flex align-items-end">
                                                            <button type="button" id="btnCekKetersediaan"
                                                                class="btn btn-light-primary btn-lg w-100" disabled>
                                                                <i class="ki-duotone ki-search-list fs-2">
                                                                    <span class="path1"></span><span
                                                                        class="path2"></span><span class="path3"></span>
                                                                </i>
                                                                Cek Ketersediaan
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!--begin::Availability Result-->
                                                    <div id="availabilityResult" class="mb-8" style="display: none;">
                                                        {{-- Diisi oleh JS --}}
                                                    </div>
                                                    <!--end::Availability Result-->

                                                    {{-- ── STEP 2: Detail Peminjaman (muncul setelah cek) ── --}}
                                                    <div id="formDetailSection"
                                                        style="display: none; opacity: 0; transform: translateY(12px); transition: opacity 0.3s ease, transform 0.3s ease;">

                                                        <div class="d-flex align-items-center mb-6">
                                                            <span
                                                                class="fw-bold text-gray-600 fs-7 me-3 text-nowrap">LANGKAH
                                                                2 — DATA PEMINJAM</span>
                                                            <div class="flex-grow-1 border-bottom border-dashed"></div>
                                                            <span class="ms-3 badge badge-light-info fs-8">Otomatis dari
                                                                akun</span>
                                                        </div>

                                                        <div class="row g-6 mb-8">
                                                            <div class="col-md-4">
                                                                <label class="form-label text-gray-600 fs-7">Nama
                                                                    Peminjam</label>
                                                                <input type="text" name="name"
                                                                    class="form-control form-control-lg bg-light"
                                                                    value="{{ auth()->user()->detail->name ?? '-' }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label text-gray-600 fs-7">Email</label>
                                                                <input type="email" name="email"
                                                                    class="form-control form-control-lg bg-light"
                                                                    value="{{ auth()->user()->email }}" readonly>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label text-gray-600 fs-7">No.
                                                                    Telepon</label>
                                                                <input type="tel" name="phone"
                                                                    class="form-control form-control-lg bg-light"
                                                                    value="{{ auth()->user()->detail->no_hp ?? '-' }}"
                                                                    readonly>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-center mb-6">
                                                            <span
                                                                class="fw-bold text-gray-600 fs-7 me-3 text-nowrap">LANGKAH
                                                                3 — DETAIL PEMINJAMAN</span>
                                                            <div class="flex-grow-1 border-bottom border-dashed"></div>
                                                        </div>

                                                        <div class="row g-6 mb-8">

                                                            {{-- Pilih Unit via Card --}}
                                                            <div class="col-12">
                                                                <label class="form-label required text-gray-600 fs-7">Pilih
                                                                    Unit</label>
                                                                <input type="hidden" name="unit_code"
                                                                    id="selectedUnitCode" required>

                                                                <div class="row g-3" id="unitCardList">
                                                                    {{-- Diisi JS setelah cek ketersediaan --}}
                                                                </div>

                                                                <div id="unitSelectedInfo" class="mt-3"
                                                                    style="display:none;">
                                                                    <span class="badge badge-light-primary fs-7">
                                                                        Unit <span id="unitSelectedLabel"></span> dipilih
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            {{-- Keperluan & Catatan --}}
                                                            <div class="col-md-6">
                                                                <label
                                                                    class="form-label required text-gray-600 fs-7">Keperluan</label>
                                                                <textarea name="purpose" class="form-control form-control-lg" rows="3"
                                                                    placeholder="Jelaskan keperluan peminjaman alat..." required></textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label text-gray-600 fs-7">Catatan
                                                                    Tambahan
                                                                    <span class="text-muted">(Opsional)</span>
                                                                </label>
                                                                <textarea name="notes" class="form-control form-control-lg" rows="3"
                                                                    placeholder="Catatan atau permintaan khusus..."></textarea>
                                                            </div>

                                                        </div>

                                                        <div class="d-flex justify-content-end gap-3 pt-6 border-top">
                                                            <button type="button" class="btn btn-light btn-lg"
                                                                id="btnBatalPinjam2">Batal</button>
                                                            <button type="submit" class="btn btn-primary btn-lg">
                                                                <i class="ki-duotone ki-check fs-2"><span
                                                                        class="path1"></span></i>
                                                                Ajukan Peminjaman
                                                            </button>
                                                        </div>

                                                    </div>
                                                    {{-- ── end STEP 2 ── --}}

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form Peminjaman-->

                                </div>
                            </div>
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
                                    $dikembalikan = $tool->units?->where('status', 'returned')->count() ?? 0;
                                    $terlambat = $tool->units?->where('status', 'overdue')->count() ?? 0;
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
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            let fpBorrow, fpReturn;

            fpBorrow = flatpickr('#inputBorrowDate', {
                locale: 'id',
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'j F Y',
                minDate: 'today',
                disableMobile: true,
                onChange: function(selectedDates) {
                    if (selectedDates[0]) {
                        const nextDay = new Date(selectedDates[0]);
                        nextDay.setDate(nextDay.getDate() + 1);
                        fpReturn.set('minDate', nextDay);
                        fpReturn.clear();
                    }
                    toggleCekBtn();
                    resetAvailability();
                }
            });

            fpReturn = flatpickr('#inputReturnDate', {
                locale: 'id',
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'j F Y',
                minDate: 'today',
                disableMobile: true,
                onChange: function() {
                    toggleCekBtn();
                    resetAvailability();
                }
            });

            function toggleCekBtn() {
                const b = document.getElementById('inputBorrowDate').value;
                const r = document.getElementById('inputReturnDate').value;
                document.getElementById('btnCekKetersediaan').disabled = !(b && r);
            }

            function resetAvailability() {
                document.getElementById('availabilityResult').style.display = 'none';
                hideFormDetail();
            }

            function hideFormDetail() {
                const el = document.getElementById('formDetailSection');
                el.style.opacity = '0';
                el.style.transform = 'translateY(12px)';
                setTimeout(() => el.style.display = 'none', 300);
            }

            function showFormDetail(units) {
                // ── Render unit cards ──
                const container = document.getElementById('unitCardList');
                container.innerHTML = '';
                document.getElementById('selectedUnitCode').value = '';
                document.getElementById('unitSelectedInfo').style.display = 'none';

                const colorMap = {
                    available: {
                        bg: 'bg-light-success',
                        icon: 'text-success',
                        badge: 'badge-light-success',
                        label: 'Tersedia'
                    },
                    borrowed: {
                        bg: 'bg-light-warning',
                        icon: 'text-warning',
                        badge: 'badge-light-warning',
                        label: 'Dipinjam'
                    },
                };

                units.forEach(unit => {
                    const isAvailable = unit.status === 'available';
                    const c = colorMap[unit.status] ?? {
                        bg: 'bg-light-danger',
                        icon: 'text-danger',
                        badge: 'badge-light-danger',
                        label: unit.status.charAt(0).toUpperCase() + unit.status.slice(1)
                    };

                    const col = document.createElement('div');
                    col.className = 'col-md-4 col-sm-6';
                    col.innerHTML = `
                <div class="unit-select-card d-flex align-items-center justify-content-between rounded px-4 py-3 border border-dashed ${!isAvailable ? 'opacity-50' : ''}"
                     data-code="${unit.code}"
                     style="${isAvailable ? 'cursor:pointer;' : 'pointer-events:none;'}">
                    <div class="d-flex align-items-center gap-3">
                        <div class="symbol symbol-35px">
                            <span class="symbol-label ${c.bg}">
                                <i class="ki-duotone ki-wrench fs-3 ${c.icon}">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </span>
                        </div>
                        <div>
                            <span class="fw-semibold text-gray-800 fs-7 d-block">${unit.code}</span>
                            <span class="text-muted fs-8">${unit.condition ?? 'Baik'}</span>
                        </div>
                    </div>
                    <span class="badge ${c.badge}">${c.label}</span>
                </div>`;

                    if (isAvailable) {
                        col.querySelector('.unit-select-card').addEventListener('click', function() {
                            document.querySelectorAll('.unit-select-card').forEach(el => {
                                el.classList.remove('border-primary', 'bg-light-primary');
                            });
                            this.classList.add('border-primary', 'bg-light-primary');
                            document.getElementById('selectedUnitCode').value = unit.code;
                            document.getElementById('unitSelectedLabel').textContent = unit.code;
                            document.getElementById('unitSelectedInfo').style.display = 'block';
                        });
                    }

                    container.appendChild(col);
                });

                // ── Tampilkan section ──
                const el = document.getElementById('formDetailSection');
                el.style.display = 'block';
                requestAnimationFrame(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                });
                el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
            // ── Cek Ketersediaan ──
            document.getElementById('btnCekKetersediaan').addEventListener('click', function() {
                const borrowDate = document.getElementById('inputBorrowDate').value;
                const returnDate = document.getElementById('inputReturnDate').value;
                const resultEl = document.getElementById('availabilityResult');
                const btn = this;

                btn.disabled = true;
                btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span> Mengecek...`;

                fetch(`{{ route('tools.check-availability', $tool) }}?borrow_date=${borrowDate}&return_date=${returnDate}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => {
                        if (!res.ok) {
                            return res.json()
                                .then(err => {
                                    throw new Error(err.message ?? `HTTP ${res.status}`);
                                })
                                .catch(() => {
                                    throw new Error(`HTTP ${res.status}`);
                                });
                        }
                        return res.json();
                    })
                    .then(data => {
                        resultEl.style.display = 'block';

                        if (data.available) {
                            resultEl.innerHTML = `
                <div class="notice d-flex bg-light-success rounded border-success border border-dashed p-5">
                    <i class="ki-duotone ki-check-circle fs-2tx text-success me-4">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                    <div>
                        <div class="fw-bold text-gray-800 fs-6">Unit Tersedia!</div>
                        <div class="text-gray-600 fs-7">${data.count} unit tersedia untuk tanggal yang dipilih. Lanjutkan isi form di bawah.</div>
                    </div>
                </div>`;
                            showFormDetail(data.units);
                        } else {
                            resultEl.innerHTML = `
                <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-5">
                    <i class="ki-duotone ki-information-5 fs-2tx text-danger me-4">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                    <div>
                        <div class="fw-bold text-gray-800 fs-6">Tidak Ada Unit Tersedia</div>
                        <div class="text-gray-600 fs-7">Semua unit sedang dipinjam pada rentang tanggal tersebut. Coba pilih tanggal lain.</div>
                    </div>
                </div>`;
                            hideFormDetail();
                        }
                    })
                    .catch(err => {
                        console.error('Fetch error:', err);
                        resultEl.style.display = 'block';
                        resultEl.innerHTML = `
            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-5">
                <i class="ki-duotone ki-warning-2 fs-2tx text-warning me-4">
                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                </i>
                <div>
                    <div class="fw-bold text-gray-800 fs-6">Gagal Mengecek</div>
                    <div class="text-gray-600 fs-7">${err.message ?? 'Terjadi kesalahan. Silakan coba lagi.'}</div>
                </div>
            </div>`;
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML =
                            `<i class="ki-duotone ki-search-list fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> Cek Ketersediaan`;
                        toggleCekBtn();
                    });
            });

            // ── Open / close form ──
            const wrapBtn = document.getElementById('wrapBtnAjukan');
            const formSection = document.getElementById('formPinjamSection');

            document.getElementById('btnAjukanPinjam').addEventListener('click', function() {
                wrapBtn.style.display = 'none';
                formSection.style.display = 'block';
                requestAnimationFrame(() => {
                    formSection.style.opacity = '1';
                    formSection.style.transform = 'translateY(0)';
                });
                formSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });

            function closeForm() {
                formSection.style.opacity = '0';
                formSection.style.transform = 'translateY(16px)';
                setTimeout(() => {
                    formSection.style.display = 'none';
                    wrapBtn.style.display = 'flex';
                    wrapBtn.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }, 300);
            }

            document.getElementById('btnBatalPinjam').addEventListener('click', closeForm);
            document.getElementById('btnBatalPinjam2').addEventListener('click', closeForm);
        });
    </script>
@endsection
