  @extends('master')

  @section('content')
      <div id="kt_app_content" class="app-content flex-column-fluid">
          <div id="kt_app_content_container" class="app-container container-fluid">

              <div class="d-flex align-items-center justify-content-between mb-7">
                  <div>

                      <h1 class="page-heading text-gray-900 fw-bold fs-3 my-0">
                          Pengembalian Alat
                      </h1>

                      @if ($loans)
                          <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                              <li class="breadcrumb-item text-muted">Pengembalian</li>
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
                      Tidak ada alat yang sedang dipinjam.
                  </div>
              @endif

              @if ($loans)
                  @php
                      $statusBadge = match ($loans->status) {
                          'approved' => ['class' => 'badge-light-success', 'label' => 'Sedang Dipinjam'],
                          'returned' => ['class' => 'badge-light-info', 'label' => 'Sudah Dikembalikan'],
                          default => ['class' => 'badge-light', 'label' => ucfirst($loans->status)],
                      };
                  @endphp

                  <div class="row g-7">

                      <div class="col-xl-12">

                          {{-- STATUS --}}
                          <div class="card mb-7">
                              <div class="card-body p-7">

                                  <div class="d-flex align-items-center justify-content-between mb-6">

                                      <div>
                                          <h4 class="fw-bold text-gray-800 mb-1">
                                              {{ $loans->loan_code }}
                                          </h4>

                                          <span class="text-muted fs-7">
                                              Dipinjam {{ \Carbon\Carbon::parse($loans->loan_date)->diffForHumans() }}
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
                                              ['key' => 'approved', 'label' => 'Dipinjam'],
                                              ['key' => 'return', 'label' => 'Pengembalian'],
                                              ['key' => 'returned', 'label' => 'Selesai'],
                                          ];
                                      @endphp

                                      @foreach ($steps as $step)
                                          <div class="d-flex flex-column align-items-center">

                                              <div class="symbol symbol-40px mb-2">

                                                  <span
                                                      class="symbol-label
  {{ $loans->status == $step['key'] || $loans->status == 'returned' ? 'bg-light-primary' : 'bg-light' }}">

                                                      <i
                                                          class="ki-duotone ki-check fs-3
  {{ $loans->status == $step['key'] || $loans->status == 'returned' ? 'text-primary' : 'text-gray-400' }}"></i>

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

                                  </div>

                              </div>
                          </div>

                          @foreach ($loans as $loan)
                              @if (is_object($loan) && $loan->status == 'approved')
                                  <div class="card mb-7">
                                      <div class="card-header">
                                          <h4 class="card-title">Ajukan Pengembalian</h4>
                                      </div>

                                      <div class="card-body">

                                          <form action="{{ route('returns.store') }}" method="POST">
                                              @csrf

                                              <input type="hidden" name="loan_id" value="{{ $loan->id }}">

                                              <div class="mb-5">
                                                  <label class="form-label">Catatan</label>
                                                  <textarea name="notes" class="form-control"></textarea>
                                              </div>

                                              <button class="btn btn-primary">
                                                  Ajukan Pengembalian
                                              </button>

                                          </form>

                                      </div>
                                  </div>
                              @endif
                          @endforeach

                      </div>

                      <div class="col-xl-8">
                          {{-- FORM PENGEMBALIAN --}}
                          @if ($loans->status == 'approved')
                              <div class="card mb-7">
                                  <div class="card-body text-center p-10">

                                      <h4 class="mb-5">
                                          Ajukan Pengembalian Alat
                                      </h4>

                                      <form action="" method="POST">
                                          @csrf

                                          <input type="hidden" name="loan_id" value="{{ $loans->id }}">

                                          <div class="mb-5 text-start">
                                              <label class="form-label">Catatan</label>
                                              <textarea name="notes" class="form-control"></textarea>
                                          </div>

                                          <button class="btn btn-primary px-10">
                                              Ajukan Pengembalian
                                          </button>

                                      </form>

                                  </div>
                              </div>
                          @endif
                      </div>

                      {{-- SIDEBAR --}}
                      <div class="col-xl-4">

                          <div class="card sticky-top">
                              <div class="card-body">

                                  <h6 class="fw-bolder text-gray-600 fs-7 mb-20 text-uppercase">
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

                                      <div class="d-flex justify-content-between">
                                          <span>Tanggal Pinjam</span>
                                          <span>
                                              {{ \Carbon\Carbon::parse($loans->loan_date)->format('d M Y') }}
                                          </span>
                                      </div>

                                      <div class="d-flex justify-content-between">
                                          <span>Jatuh Tempo</span>
                                          <span class="text-warning">
                                              {{ \Carbon\Carbon::parse($loans->due_date)->format('d M Y') }}
                                          </span>
                                      </div>

                                      @if ($loans->status == 'returned')
                                          <div class="d-flex justify-content-between">
                                              <span>Tanggal Kembali</span>
                                              <span class="text-success">
                                                  {{ \Carbon\Carbon::parse($loans->return_date)->format('d M Y') }}
                                              </span>
                                          </div>
                                      @endif

                                  </div>

                              </div>
                          </div>

                      </div>

                  </div>
              @endif

          </div>
      </div>
  @endsection
