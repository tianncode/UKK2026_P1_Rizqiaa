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
                    <span class="count-badge" id="rowCount">{{ $tools->count() }} alat</span>
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

                {{-- Warning Banner --}}
                @if (!$canBorrow)
                    <div
                        style="display:flex;align-items:center;gap:10px;background:#fff3cd;border:1px solid #ffc107;border-left:4px solid #e53e3e;color:#7b341e;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:0.875rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                            style="flex-shrink:0;color:#e53e3e;">
                            <path
                                d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Akun Anda memiliki <strong style="margin:0 3px;">{{ $totalPoints }} poin pelanggaran</strong>.
                        Peminjaman alat dinonaktifkan hingga poin di bawah 500.
                    </div>
                @endif

                {{-- Cards Grid --}}
                <div class="cards-grid" id="cardsGrid">
                    @forelse ($tools as $tool)
                        @php
                            $totalUnits = $tool->units->count();
                            $availableUnits = $tool->units->where('status', 'available')->count();
                            $pct = $totalUnits > 0 ? round(($availableUnits / $totalUnits) * 100) : 0;
                            $barClass = $pct === 0 ? 'empty' : ($pct <= 30 ? 'low' : '');
                        @endphp

                        <div class="tool-card" data-category="{{ $tool->category_id }}" data-type="{{ $tool->item_type }}"
                            data-avail="{{ $availableUnits > 0 ? 'available' : 'empty' }}"
                            data-name="{{ strtolower($tool->name) }}">

                            {{-- Avatar + Name --}}
                            <div class="card-top">
                                <div class="avatar">
                                    @if (!empty($tool->photo_path) && file_exists(public_path($tool->photo_path)))
                                        <img src="{{ asset($tool->photo_path) }}" alt="{{ $tool->name }}">
                                    @else
                                        {{ strtoupper(substr($tool->name, 0, 2)) }}
                                    @endif
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">{{ $tool->name }}</div>
                                    <div class="tool-code">#TL-{{ str_pad($tool->id, 3, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>

                            {{-- Badges --}}
                            <div class="card-meta">
                                <span class="badge {{ $tool->item_type == 'single' ? 'badge-single' : 'badge-bundle' }}">
                                    {{ ucfirst($tool->item_type) }}
                                </span>
                                <span class="badge badge-cat">{{ $tool->category->name ?? '-' }}</span>
                            </div>

                            {{-- Unit bar --}}
                            <div class="unit-section">
                                <div class="unit-row">
                                    <span class="unit-label">Ketersediaan</span>
                                    <span class="unit-count">{{ $availableUnits }}/{{ $totalUnits }} unit</span>
                                </div>
                                <div class="unit-bar">
                                    <div class="unit-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
                                </div>
                            </div>

                            {{-- Action --}}
                            <div class="card-action">
                                @if (!$canBorrow)
                                    <span class="btn-pinjam disabled"
                                        title="Poin pelanggaran melebihi batas ({{ $totalPoints }}/500)">
                                        Diblokir
                                    </span>
                                @elseif ($availableUnits > 0)
                                    <a href="{{ route('loans.form', $tool->id) }}" class="btn-pinjam">
                                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
                                            <path d="M3 8h10M9 4l4 4-4 4" stroke="white" stroke-width="1.6"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Pinjam
                                    </a>
                                @else
                                    <span class="btn-pinjam disabled">Tidak Tersedia</span>
                                @endif
                            </div>

                        </div>
                    @empty
                        <div class="empty-state">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="3" width="18" height="18" rx="3" stroke="currentColor"
                                    stroke-width="1.2" />
                                <path d="M8 12h8M8 8h5M8 16h3" stroke="currentColor" stroke-width="1.2"
                                    stroke-linecap="round" />
                            </svg>
                            <div class="empty-state-title">Belum ada alat</div>
                            <div class="empty-state-sub">Data alat akan muncul di sini</div>
                        </div>
                    @endforelse
                </div>

                {{-- Footer --}}
                <div class="cards-footer">
                    <span>Menampilkan <span id="visibleCount">{{ $tools->count() }}</span> dari {{ $tools->count() }}
                        alat</span>
                    <div>
                        {{ $tools->links('pagination::simple-bootstrap-5') }}
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
        const visibleCount = document.getElementById('visibleCount');
        const rowCount = document.getElementById('rowCount');

        function applyFilters() {
            const search = searchInput.value.toLowerCase().trim();
            const category = filterCategory.value;
            const type = filterType.value;
            const avail = filterAvail.value;

            // Selector diubah ke .tool-card di dalam #cardsGrid
            const cards = document.querySelectorAll('#cardsGrid .tool-card');
            let visible = 0;

            cards.forEach(card => {
                const matchName = card.dataset.name.includes(search);
                const matchCategory = !category || card.dataset.category === category;
                const matchType = !type || card.dataset.type === type;
                const matchAvail = !avail || card.dataset.avail === avail;

                const show = matchName && matchCategory && matchType && matchAvail;
                card.style.display = show ? '' : 'none';
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
