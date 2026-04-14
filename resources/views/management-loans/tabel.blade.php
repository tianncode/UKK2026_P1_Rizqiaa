@extends('master')

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="tools-page">

                {{-- Page Header --}}
                <div class="tools-page-header">
                    <div>
                        <div class="tools-page-title">Daftar Alat</div>
                        <div class="tools-page-subtitle">Pilih alat yang ingin dipinjam</div>
                    </div>
                </div>

                {{-- Alert success --}}
                @if (session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-4 py-2 px-3"
                        style="font-size:.8125rem;border-radius:8px;">
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                            <path d="M3 8l4 4 6-7" stroke="#0e8a4a" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Filter Bar --}}
                <div class="filter-bar">

                    <div class="filter-search">
                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
                            <circle cx="6.5" cy="6.5" r="4.5" stroke="currentColor" stroke-width="1.4" />
                            <path d="M10 10l3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" />
                        </svg>
                        <input type="text" id="searchInput" placeholder="Cari nama alat...">
                    </div>

                    <select class="filter-select" id="filterCategory">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <select class="filter-select" id="filterType">
                        <option value="">Semua Tipe</option>
                        <option value="single">Single</option>
                        <option value="bundle">Bundle</option>
                    </select>

                    <select class="filter-select" id="filterAvail">
                        <option value="">Semua Status</option>
                        <option value="available">Ada Unit Tersedia</option>
                        <option value="empty">Tidak Tersedia</option>
                    </select>

                </div>

                {{-- Table Card --}}
                <div class="table-card">

                    <div class="table-card-header">
                        <span class="table-card-title">Inventaris Alat</span>
                        <span class="table-count-badge" id="rowCount">{{ $tools->count() }} alat</span>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="tools-table" id="toolsTable">
                            <thead>
                                <tr>
                                    <th style="width:40px;">#</th>
                                    <th>Alat</th>
                                    <th>Kategori</th>
                                    <th>Tipe</th>
                                    <th>Ketersediaan</th>
                                    <th style="text-align:right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tools as $index => $tool)
                                    @php
                                        $totalUnits = $tool->units->count();
                                        $availableUnits = $tool->units->where('status', 'available')->count();
                                        $pct = $totalUnits > 0 ? round(($availableUnits / $totalUnits) * 100) : 0;
                                        $barClass = $pct === 0 ? 'empty' : ($pct <= 30 ? 'low' : '');
                                    @endphp
                                    <tr data-category="{{ $tool->category_id }}" data-type="{{ $tool->item_type }}"
                                        data-avail="{{ $availableUnits > 0 ? 'available' : 'empty' }}"
                                        data-name="{{ strtolower($tool->name) }}">
                                        <td style="color:var(--bs-gray-400);font-size:.75rem;">
                                            {{ $index + 1 }}
                                        </td>

                                        <td>
                                            <div class="tool-cell">
                                                <div class="tool-avatar">
                                                    @if (!empty($tool->photo_path) && file_exists(public_path($tool->photo_path)))
                                                        <img src="{{ asset($tool->photo_path) }}"
                                                            alt="{{ $tool->name }}">
                                                    @else
                                                        {{ strtoupper(substr($tool->name, 0, 2)) }}
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="tool-cell-name">{{ $tool->name }}</div>
                                                    <div class="tool-cell-code">
                                                        #TL-{{ str_pad($tool->id, 3, '0', STR_PAD_LEFT) }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>{{ $tool->category->name ?? '-' }}</td>

                                        <td>
                                            @if ($tool->item_type == 'single')
                                                <span class="badge-type badge-single">Single</span>
                                            @else
                                                <span class="badge-type badge-bundle">Bundle</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="unit-bar-wrap">
                                                <div class="unit-bar">
                                                    <div class="unit-bar-fill {{ $barClass }}"
                                                        style="width:{{ $pct }}%"></div>
                                                </div>
                                                <span class="unit-text">{{ $availableUnits }}/{{ $totalUnits }}</span>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="action-group" style="justify-content:flex-end;">

                                                {{-- Detail --}}
                                                {{-- <a href="{{ route('tools.show', $tool->id) }}" class="btn-action" title="Detail">
                                                <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
                                                    <circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1.4"/>
                                                    <path d="M8 7v4M8 5.5v.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                                                </svg>
                                            </a> --}}

                                                {{-- Tombol Pinjam --}}
                                                @if ($availableUnits > 0)
                                                    <a href="{{ route('loans.form', $tool->id) }}" class="btn-pinjam">
                                                        <svg width="12" height="12" viewBox="0 0 16 16"
                                                            fill="none">
                                                            <path d="M3 8h10M9 4l4 4-4 4" stroke="white" stroke-width="1.6"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        Pinjam
                                                    </a>
                                                @else
                                                    <span class="btn-pinjam disabled">Tidak Tersedia</span>
                                                @endif

                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none">
                                                    <rect x="3" y="3" width="18" height="18" rx="3"
                                                        stroke="currentColor" stroke-width="1.2" />
                                                    <path d="M8 12h8M8 8h5M8 16h3" stroke="currentColor"
                                                        stroke-width="1.2" stroke-linecap="round" />
                                                </svg>
                                                <div class="empty-state-title">Belum ada alat</div>
                                                <div class="empty-state-sub">Data alat akan muncul di sini</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer: pagination --}}
                    <div class="table-footer">
                        <span>Menampilkan <span id="visibleCount">{{ $tools->count() }}</span> dari {{ $tools->count() }}
                            alat</span>
                        <div>
                            {{ $tools->links('pagination::simple-bootstrap-5') }}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const filterCategory = document.getElementById('filterCategory');
        const filterType = document.getElementById('filterType');
        const filterAvail = document.getElementById('filterAvail');
        const rowCount = document.getElementById('rowCount');
        const visibleCount = document.getElementById('visibleCount');

        function applyFilters() {
            const search = searchInput.value.toLowerCase().trim();
            const category = filterCategory.value;
            const type = filterType.value;
            const avail = filterAvail.value;

            const rows = document.querySelectorAll('#toolsTable tbody tr[data-name]');
            let visible = 0;

            rows.forEach(row => {
                const matchName = row.dataset.name.includes(search);
                const matchCategory = !category || row.dataset.category === category;
                const matchType = !type || row.dataset.type === type;
                const matchAvail = !avail || row.dataset.avail === avail;

                const show = matchName && matchCategory && matchType && matchAvail;
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            visibleCount.textContent = visible;
            rowCount.textContent = visible + ' alat';
        }

        searchInput.addEventListener('input', applyFilters);
        filterCategory.addEventListener('change', applyFilters);
        filterType.addEventListener('change', applyFilters);
        filterAvail.addEventListener('change', applyFilters);
    </script>
@endsection
