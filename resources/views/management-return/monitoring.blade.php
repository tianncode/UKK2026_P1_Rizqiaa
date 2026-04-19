@extends('master')

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            {{-- ══ Header ══════════════════════════════════════════════════════ --}}
            <div class="d-flex align-items-center justify-content-between mb-7">
                <div>
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 my-0">
                        Monitoring Pengembalian
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">Manajemen</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Monitoring Pengembalian</li>
                    </ul>
                </div>
            </div>

            {{-- ══ Alert sukses / error ════════════════════════════════════════ --}}
            @if (session('success'))
                <div class="alert alert-dismissible bg-light-success d-flex align-items-center p-5 mb-7">
                    <i class="ki-duotone ki-check-circle fs-2hx text-success me-4">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                    <div class="d-flex flex-column">
                        <span class="text-gray-700">{{ session('success') }}</span>
                    </div>
                    <button type="button"
                        class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                        data-bs-dismiss="alert">
                        <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span
                                class="path2"></span></i>
                    </button>
                </div>
            @endif

            {{-- ══ Alert Keterlambatan ══════════════════════════════════════════ --}}
            @if ($overdueLoans->isNotEmpty())
                <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-5 mb-7">
                    <i class="ki-duotone ki-information-5 fs-2tx text-danger me-4 flex-shrink-0">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                    <div class="d-flex flex-column w-100">
                        <h4 class="mb-2 text-danger">{{ $overdueLoans->count() }} Pengembalian Terlambat!</h4>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($overdueLoans as $loan)
                                <span class="badge badge-light-danger fs-8 py-2 px-3">
                                    <i class="ki-duotone ki-time fs-7 text-danger me-1">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    {{ $loan->loan_code ?? '-' }} —
                                    {{ $loan->user->userDetail->name ?? 'N/A' }}
                                    ({{ \Carbon\Carbon::today()->diffInDays($loan->due_date) }} hari terlambat)
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- ══ Statistik Cards ═════════════════════════════════════════════ --}}
            <div class="row g-5 mb-7">
                <div class="col-6 col-md-3">
                    <div class="card bg-light-primary h-100">
                        <div class="card-body p-5">
                            <i class="ki-duotone ki-document fs-2x text-primary mb-3">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            <div class="text-primary fw-bold fs-2x mb-1">{{ $stats['total'] }}</div>
                            <div class="fw-semibold text-gray-500 fs-7">Total Pengembalian</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card bg-light-warning h-100">
                        <div class="card-body p-5">
                            <i class="ki-duotone ki-time fs-2x text-warning mb-3">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            <div class="text-warning fw-bold fs-2x mb-1">{{ $stats['pending'] }}</div>
                            <div class="fw-semibold text-gray-500 fs-7">Menunggu Verifikasi</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card bg-light-success h-100">
                        <div class="card-body p-5">
                            <i class="ki-duotone ki-check-circle fs-2x text-success mb-3">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            <div class="text-success fw-bold fs-2x mb-1">{{ $stats['verified'] }}</div>
                            <div class="fw-semibold text-gray-500 fs-7">Terverifikasi</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card bg-light-danger h-100">
                        <div class="card-body p-5">
                            <i class="ki-duotone ki-warning-2 fs-2x text-danger mb-3">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            <div class="text-danger fw-bold fs-2x mb-1">{{ $stats['late'] }}</div>
                            <div class="fw-semibold text-gray-500 fs-7">Terlambat</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══ Card Utama ═══════════════════════════════════════════════════ --}}
            <div class="card">

                {{-- ── Card Header + Filter ─────────────────────────────────── --}}
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            <form method="GET" action="{{ route('return.index') }}" id="searchForm">
                                <input type="text" name="search" class="form-control form-control-solid w-250px ps-13"
                                    placeholder="Cari nama / kode pinjam..." value="{{ request('search') }}"
                                    onchange="document.getElementById('searchForm').submit()">
                            </form>
                        </div>
                    </div>

                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end align-items-center gap-3">

                            {{-- Filter Status --}}
                            <form method="GET" action="{{ route('return.index') }}" id="filterForm">
                                @if (request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                @if (request('date_from'))
                                    <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                                @endif
                                @if (request('date_to'))
                                    <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                                @endif

                                <select name="status" class="form-select form-select-solid w-175px"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Status</option>
                                    @foreach (['pending', 'verified', 'late'] as $s)
                                        <option value="{{ $s }}" @selected(request('status') === $s)>
                                            {{ ucfirst($s) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>

                            {{-- Filter Tanggal --}}
                            <button type="button" class="btn btn-light-primary btn-sm" data-bs-toggle="collapse"
                                data-bs-target="#filterDate">
                                <i class="ki-duotone ki-filter fs-3">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                Filter Tanggal
                            </button>

                            @if (request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                                <a href="{{ route('return.index') }}" class="btn btn-light-danger btn-sm">
                                    <i class="ki-duotone ki-cross fs-3">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    Reset
                                </a>
                            @endif

                        </div>
                    </div>
                </div>

                {{-- ── Filter Tanggal Collapsible ────────────────────────────── --}}
                <div class="collapse {{ request()->hasAny(['date_from', 'date_to']) ? 'show' : '' }}" id="filterDate">
                    <div class="card-body pt-0 pb-5">
                        <form method="GET" action="{{ route('return.index') }}" class="d-flex align-items-end gap-3">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if (request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <div>
                                <label class="form-label fs-7 text-gray-600 mb-1">Dari Tanggal</label>
                                <input type="date" name="date_from" class="form-control form-control-solid w-175px"
                                    value="{{ request('date_from') }}">
                            </div>
                            <div>
                                <label class="form-label fs-7 text-gray-600 mb-1">Sampai Tanggal</label>
                                <input type="date" name="date_to" class="form-control form-control-solid w-175px"
                                    value="{{ request('date_to') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
                        </form>
                    </div>
                </div>

                {{-- ── Tabel ─────────────────────────────────────────────────── --}}
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">No</th>
                                    <th class="min-w-125px">Kode Pinjam</th>
                                    <th class="min-w-200px">Peminjam</th>
                                    <th class="min-w-175px">Alat / Unit</th>
                                    <th class="min-w-120px">Tgl Kembali</th>
                                    <th class="min-w-100px">Keterlambatan</th>
                                    <th class="min-w-120px">Kondisi Alat</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="min-w-100px text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse ($returns as $return)
                                    @php
                                        $isLate = $return->late_days > 0;
                                    @endphp
                                    <tr class="{{ $isLate ? 'bg-light-danger' : '' }}">

                                        {{-- No --}}
                                        <td class="text-gray-500">
                                            {{ $returns->firstItem() + $loop->index }}
                                        </td>

                                        {{-- Kode Pinjam --}}
                                        <td>
                                            <span class="text-gray-800 fw-bold text-hover-primary">
                                                {{ $return->loan->loan_code ?? '-' }}
                                            </span>
                                        </td>

                                        {{-- Peminjam --}}
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-35px me-3">
                                                    <span class="symbol-label bg-light-primary text-primary fw-bold fs-6">
                                                        {{ strtoupper(substr($return->loan->user->detail->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 fw-bold">
                                                        {{ $return->loan->user->detail->name ?? '-' }}
                                                    </span>
                                                    <span class="text-muted fs-7">
                                                        {{ $return->loan->user->email ?? '' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Alat / Unit --}}
                                        <td>
                                            <span class="text-gray-800 fw-bold d-block">
                                                {{ $return->loan->tool->name ?? '-' }}
                                            </span>
                                            <span class="text-muted fs-7">
                                                Unit: {{ $return->loan->unit_code ?? '-' }}
                                            </span>
                                        </td>

                                        {{-- Tgl Kembali --}}
                                        <td class="text-gray-600 fs-7">
                                            {{ \Carbon\Carbon::parse($return->return_date)->format('d M Y') }}
                                        </td>

                                        {{-- Keterlambatan --}}
                                        <td>
                                            @if ($isLate)
                                                <span class="badge badge-light-danger fs-8">
                                                    {{ $return->late_days }} hari
                                                </span>
                                            @else
                                                <span class="badge badge-light-success fs-8">Tepat Waktu</span>
                                            @endif
                                        </td>

                                        {{-- Kondisi Alat --}}
                                        <td>
                                            @php
                                                $condition = $return->unitConditions->first()?->conditions;

                                                $conditionBadge = match ($condition) {
                                                    'good' => ['badge-light-success', 'Baik'],
                                                    'broken' => ['badge-light-danger', 'Rusak'], // ✅ was: 'damaged'
                                                    'lost' => ['badge-light-dark', 'Hilang'],
                                                    'maintenance' => ['badge-light-warning', 'Perawatan'],
                                                    default => ['badge-light-secondary', 'Belum Dicek'],
                                                };
                                            @endphp
                                            <span class="badge {{ $conditionBadge[0] }} fs-8">
                                                {{ $conditionBadge[1] }}
                                            </span>
                                        </td>

                                        {{-- Status --}}
                                        <td>
                                            @php
                                                $statusBadge = match ($return->loan->status ?? '') {
                                                    'pending_return' => 'badge-light-warning',
                                                    'returned' => 'badge-light-success',
                                                    default => 'badge-light-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $statusBadge }} fs-8">
                                                {{ ucfirst(str_replace('_', ' ', $return->loan->status ?? '-')) }}
                                            </span>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">

                                                {{-- Verifikasi (hanya jika loan masih pending return) --}}
                                                @if (($return->loan->status ?? '') === 'pending_return')
                                                    <button type="button" class="btn btn-icon btn-light-success btn-sm"
                                                        title="Verifikasi Pengembalian" data-bs-toggle="modal"
                                                        data-bs-target="#verifyModal"
                                                        data-return-id="{{ $return->id }}"
                                                        data-loan-code="{{ $return->loan->loan_code ?? '-' }}">
                                                        <i class="ki-duotone ki-check fs-4 text-warble-success">
                                                            <span class="path1"></span>
                                                        </i>
                                                    </button>
                                                @endif

                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-10">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ki-duotone ki-document fs-3x text-gray-300 mb-3">
                                                    <span class="path1"></span><span class="path2"></span>
                                                </i>
                                                <span class="text-muted fs-6">Tidak ada data pengembalian.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($returns->hasPages())
                        <div class="d-flex justify-content-between align-items-center pt-5">
                            <div class="text-muted fs-7">
                                Menampilkan {{ $returns->firstItem() }}–{{ $returns->lastItem() }}
                                dari {{ $returns->total() }} data
                            </div>
                            {{ $returns->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>
            {{-- end card --}}

        </div>
    </div>

    {{-- ══ Modal Verifikasi Pengembalian ═══════════════════════════════════════ --}}
    <div class="modal fade" id="verifyModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-550px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Verifikasi Pengembalian</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <form id="verifyForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        {{-- Info kode pinjaman --}}
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-4 mb-5">
                            <i class="ki-duotone ki-information-5 fs-2tx text-primary me-4">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                            <div class="d-flex flex-column">
                                <h5 class="mb-1">Konfirmasi Verifikasi</h5>
                                <span class="text-gray-600 fs-7">
                                    Kode peminjaman: <strong id="verifyLoanCode"></strong>
                                </span>
                            </div>
                        </div>

                        {{-- Kondisi Alat --}}
                        <div class="fv-row mb-5">
                            <label class="fs-6 fw-semibold form-label mb-2 required">
                                Kondisi Alat Saat Dikembalikan
                            </label>
                            <select name="condition" id="conditionSelect" class="form-select form-select-solid">
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="good">Baik</option>
                                <option value="damaged">Rusak</option>
                                <option value="lost">Hilang</option>
                            </select>
                        </div>

                        {{-- Catatan --}}
                        <div class="fv-row mb-5">
                            <label class="fs-6 fw-semibold form-label mb-2">
                                Catatan
                                <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <textarea name="notes" class="form-control form-control-solid" rows="3"
                                placeholder="Tambahkan catatan jika ada kerusakan atau kehilangan..."></textarea>
                        </div>

                        {{-- Section Denda — muncul jika kondisi damaged/lost --}}
                        <div id="violationSection" class="d-none">
                            <div class="separator separator-dashed my-5"></div>

                            <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-4 mb-5">
                                <i class="ki-duotone ki-warning-2 fs-2tx text-danger me-4">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <div class="d-flex flex-column">
                                    <h5 class="mb-1 text-danger">Pelanggaran Terdeteksi</h5>
                                    <span class="text-gray-600 fs-7" id="violationDesc">
                                        Alat dikembalikan dalam kondisi bermasalah. Poin pelanggaran akan otomatis dicatat.
                                    </span>
                                </div>
                            </div>

                            {{-- Poin Pelanggaran --}}
                            <div class="fv-row mb-5">
                                <label class="fs-6 fw-semibold form-label mb-2 required">
                                    Poin Pelanggaran
                                </label>
                                <input type="number" name="violation_points" id="violationPoints"
                                    class="form-control form-control-solid" placeholder="Masukkan jumlah poin..."
                                    min="1" max="100">
                                <div class="form-text text-muted fs-8 mt-1" id="violationPointsHint"></div>
                            </div>

                            {{-- Deskripsi Pelanggaran --}}
                            <div class="fv-row">
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Deskripsi Pelanggaran
                                    <span class="text-muted fw-normal">(Opsional)</span>
                                </label>
                                <textarea name="violation_description" class="form-control form-control-solid" rows="2"
                                    placeholder="Contoh: Layar retak, baterai rusak..."></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ki-duotone ki-check-circle fs-3 me-1">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            Verifikasi Pengembalian
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Set action form + loan code saat modal dibuka
        document.getElementById('verifyModal').addEventListener('show.bs.modal', function(e) {
            const btn = e.relatedTarget;
            const returnId = btn.getAttribute('data-return-id');
            const loanCode = btn.getAttribute('data-loan-code');

            document.getElementById('verifyLoanCode').textContent = loanCode ?? '-';
            document.getElementById('verifyForm').setAttribute('action', `/management-return/${returnId}/verify`);

            // Reset form tiap buka modal
            document.getElementById('conditionSelect').value = '';
            document.getElementById('violationSection').classList.add('d-none');
            document.getElementById('violationPoints').value = '';
        });

        // Tampilkan section denda jika kondisi damaged/lost
        document.getElementById('conditionSelect').addEventListener('change', function() {
            const section = document.getElementById('violationSection');
            const pointsInput = document.getElementById('violationPoints');
            const hint = document.getElementById('violationPointsHint');
            const desc = document.getElementById('violationDesc');

            if (this.value === 'damaged') {
                section.classList.remove('d-none');
                pointsInput.value = 20;
                hint.textContent = 'Default 20 poin untuk kerusakan. Bisa diubah sesuai tingkat kerusakan.';
                desc.textContent = 'Alat dikembalikan dalam kondisi rusak. Poin pelanggaran akan dicatat.';
            } else if (this.value === 'lost') {
                section.classList.remove('d-none');
                pointsInput.value = 50;
                hint.textContent = 'Default 50 poin untuk kehilangan. Bisa diubah sesuai kebijakan.';
                desc.textContent = 'Alat hilang dan tidak dikembalikan. Poin pelanggaran akan dicatat.';
            } else {
                section.classList.add('d-none');
                pointsInput.value = '';
            }
        });
    </script>
@endsection
