@extends('partials.app-layout')

@section('title', 'Manajemen Basis Aturan')

@section('content')

{{-- Choice.js CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/styles/choices.min.css" />

<style>
    .clean-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    
    /* === HEADER SECTION: JUDUL & TOOLBAR SEJAJAR === */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .header-title {
        flex: 1;
        min-width: 250px;
    }

    .header-title h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.25rem;
        letter-spacing: -0.02em;
    }

    .header-title p {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0;
    }

    /* === TOOLBAR === */
    .toolbar-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    .search-box {
        position: relative;
        width: 260px;
    }
    .search-box input {
        width: 100%;
        padding: 0.65rem 1rem 0.65rem 2.5rem;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background-color: rgba(248, 250, 252, 0.5);
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    .search-box input:focus {
        background-color: #ffffff;
        border-color: #39af93;
        box-shadow: 0 0 0 4px rgba(57, 175, 147, 0.15);
        outline: none;
    }
    .search-box .search-icon {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.9rem;
        pointer-events: none;
    }
    .search-box .clear-search {
        position: absolute;
        right: 0.6rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        display: none;
        font-size: 0.8rem;
        padding: 0.25rem;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        line-height: 1;
        transition: all 0.2s;
    }
    .search-box .clear-search:hover {
        color: #ef4444;
        background-color: rgba(239, 68, 68, 0.08);
    }

    .entries-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .entries-box label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #0f172a;
        white-space: nowrap;
    }
    .entries-box select {
        padding: 0.6rem 2rem 0.6rem 0.85rem;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background-color: rgba(248, 250, 252, 0.5);
        font-size: 0.85rem;
        font-weight: 600;
        color: #0f172a;
        cursor: pointer;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: calc(100% - 0.75rem) center;
    }
    .entries-box select:focus {
        border-color: #39af93;
        box-shadow: 0 0 0 4px rgba(57, 175, 147, 0.15);
        outline: none;
    }

    .btn-action-primary { background-color: #0f172a; color: #ffffff; padding: 0.65rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: 0.85rem; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; white-space: nowrap; }
    .btn-action-primary:hover { background-color: #1e293b; color: #fff; }
    
    .table-clean thead th { background-color: #f8fafc !important; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #64748b; padding: 1rem; border-bottom: 1px solid #e2e8f0; }
    .table-clean tbody td { padding: 1rem; border-bottom: 1px solid #f1f5f9; }
    .code-badge { background-color: #f1f5f9; color: #334155; font-family: monospace; font-size: 0.85rem; padding: 0.25rem 0.5rem; border-radius: 6px; font-weight: 600; }
    .btn-icon { width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; border: 1px solid #e2e8f0; background: white; color: #64748b; transition: 0.2s; }
    .btn-icon:hover { background: #f8fafc; border-color: #cbd5e1; }

    /* Info Hasil Pencarian */
    .search-info {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 1rem;
        display: none;
        align-items: center;
        gap: 0.5rem;
    }
    .search-info.active {
        display: flex;
    }
    .search-info .badge-count {
        background-color: #39af93;
        color: #fff;
        padding: 0.15rem 0.5rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* No result state */
    .no-result-row {
        display: none;
    }
    .no-result-row.active {
        display: table-row;
    }

    /* Row highlight saat di-search */
    .table-clean tbody tr.search-hidden {
        display: none;
    }
    .table-clean tbody tr.search-match {
        background-color: rgba(57, 175, 147, 0.04);
    }

    mark.search-highlight {
        background-color: rgba(57, 175, 147, 0.25);
        color: inherit;
        padding: 0.05em 0.15em;
        border-radius: 3px;
    }

    /* === PAGINATION === */
    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .pagination-info {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
        white-space: nowrap;
    }

    .pagination-wrapper .pagination {
        margin-bottom: 0;
        gap: 4px;
    }
    .pagination-wrapper .page-item .page-link {
        color: #0f172a;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 0.85rem;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 8px !important;
        transition: all 0.2s;
        min-width: 38px;
        text-align: center;
    }
    .pagination-wrapper .page-item .page-link:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
    }
    .pagination-wrapper .page-item.active .page-link {
        background-color: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }
    .pagination-wrapper .page-item.disabled .page-link {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #94a3b8;
    }
    .pagination-wrapper .page-item.page-ellipsis .page-link {
        background: transparent;
        border-color: transparent;
        color: #94a3b8;
        cursor: default;
        pointer-events: none;
        padding: 0.5rem 0.4rem;
    }

    /* ========================================= */
    /* CHOICE.JS CUSTOM STYLING                  */
    /* ========================================= */
    .choices { margin-bottom: 0 !important; width: 100% !important; }
    
    .choices__inner {
        min-height: 36px !important;
        background-color: #ffffff !important;
        border: 1px solid #d7dee8 !important;
        border-radius: 6px !important;
        padding: 3px 8px !important;
        font-size: 0.84rem !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease !important;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04) !important;
    }

    .choices[data-type*="select-multiple"] .choices__inner {
        max-height: 48px !important;
        overflow-y: auto !important;
    }

    .choices[data-type*="select-one"]::after {
        border-color: #64748b transparent transparent !important;
        right: 14px !important;
        margin-top: -2px !important;
    }

    .choices[data-type*="select-one"].is-open::after {
        border-color: transparent transparent #64748b !important;
        margin-top: -7px !important;
    }
    
    .choices__list--single {
        padding: 1px 24px 1px 2px !important;
    }
    .choices__list--single .choices__item {
        color: #0f172a !important;
        font-weight: 500 !important;
    }
    
    .choices__list--multiple {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        gap: 2px 4px !important;
    }

    .choices__list--multiple .choices__item {
        background: #f1f5f4 !important;
        border: 1px solid #b9d8cf !important;
        border-radius: 4px !important;
        padding: 1px 6px !important;
        font-size: 0.74rem !important;
        font-weight: 600 !important;
        margin: 0 !important;
        box-shadow: none !important;
        color: #0f5f50 !important;
        line-height: 1.25 !important;
        max-width: 100% !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        vertical-align: middle !important;
    }
    
    .choices__list--multiple .choices__item.is-highlighted {
        background: #e2f3ee !important;
        border-color: #39af93 !important;
        opacity: 1 !important;
    }
    
    .choices__list--multiple .choices__item .choices__button {
        border-left: 1px solid #b9d8cf !important;
        margin-left: 4px !important;
        padding: 0 0 0 4px !important;
        background-image: none !important;
        width: 14px !important;
        min-width: 14px !important;
        height: 14px !important;
        opacity: 1 !important;
        text-indent: 0 !important;
        overflow: visible !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: transparent !important;
        position: relative !important;
    }
    
    .choices__list--multiple .choices__item .choices__button::after {
        content: "\00d7";
        color: #0f5f50;
        font-size: 0.82rem;
        line-height: 1;
        font-weight: bold;
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .choices__list--multiple .choices__item .choices__button:hover::after {
        color: #ef4444;
    }
    
    .choices__list--dropdown,
    .choices__list[aria-expanded] {
        border: 1px solid #d7dee8 !important;
        border-radius: 6px !important;
        box-shadow: 0 12px 24px -16px rgba(15, 23, 42, 0.35), 0 4px 10px rgba(15, 23, 42, 0.08) !important;
        margin-top: 4px !important;
        z-index: 10000 !important;
        background: #fff !important;
        overflow: hidden !important;
    }

    .choices__list--dropdown .choices__list,
    .choices__list[aria-expanded] .choices__list {
        max-height: 180px !important;
    }
    
    .choices__list--dropdown .choices__item,
    .choices__list[aria-expanded] .choices__item {
        padding: 6px 10px !important;
        font-size: 0.82rem !important;
        color: #0f172a !important;
        border-bottom: 1px solid #f1f5f9 !important;
        line-height: 1.25 !important;
    }
    
    .choices__list--dropdown .choices__item:last-child,
    .choices__list[aria-expanded] .choices__item:last-child {
        border-bottom: none !important;
    }
    
    .choices__list--dropdown .choices__item--selectable.is-highlighted,
    .choices__list[aria-expanded] .choices__item--selectable.is-highlighted {
        background-color: #f8fafc !important;
        color: #0f172a !important;
    }
    
    .choices.is-focused .choices__inner,
    .choices.is-open .choices__inner {
        border-color: #39af93 !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(57, 175, 147, 0.14), 0 1px 2px rgba(15, 23, 42, 0.05) !important;
    }
    
    .choices__input {
        background-color: transparent !important;
        color: #0f172a !important;
        font-size: 0.82rem !important;
        margin-bottom: 0 !important;
        padding: 1px 0 !important;
    }

    .choices[data-type*="select-multiple"] .choices__input {
        flex: 1 0 180px !important;
        min-width: 180px !important;
        min-height: 26px !important;
        padding: 4px 2px !important;
    }

    #selectedGejalaList,
    #editSelectedGejalaList {
        padding: 0.5rem !important;
        max-height: 160px;
        overflow-y: auto;
    }

    #selectedGejalaList .gejala-item,
    #editSelectedGejalaList .gejala-item {
        margin-bottom: 0.15rem !important;
        row-gap: 0.25rem;
    }

    #selectedGejalaList .code-badge,
    #editSelectedGejalaList .code-badge {
        font-size: 0.72rem;
        padding: 0.1rem 0.35rem;
        border-radius: 4px;
    }

    #selectedGejalaList .form-control-sm,
    #editSelectedGejalaList .form-control-sm {
        min-height: 28px;
        padding-top: 0.15rem;
        padding-bottom: 0.15rem;
        font-size: 0.78rem;
    }

    #selectedGejalaList .btn-sm,
    #editSelectedGejalaList .btn-sm {
        --bs-btn-padding-y: 0.15rem;
        --bs-btn-padding-x: 0.4rem;
        --bs-btn-font-size: 0.78rem;
    }

    #selectedGejalaList .gejala-item:last-child,
    #editSelectedGejalaList .gejala-item:last-child {
        margin-bottom: 0 !important;
    }
    
    .choices__input::placeholder {
        color: #94a3b8 !important;
    }
    
    .choices__placeholder {
        color: #94a3b8 !important;
        opacity: 1 !important;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .header-section {
            flex-direction: column;
            align-items: stretch;
        }
        .header-title {
            min-width: 100%;
            margin-bottom: 1rem;
        }
        .toolbar-wrapper {
            justify-content: flex-end;
            flex-wrap: wrap;
        }
        .search-box {
            width: 100%;
            max-width: 300px;
        }
    }

    @media (max-width: 576px) {
        .toolbar-wrapper {
            flex-direction: column;
            align-items: stretch;
        }
        .search-box,
        .entries-box,
        .btn-action-primary {
            width: 100%;
            justify-content: center;
        }
        .entries-box {
            justify-content: center;
        }
    }
</style>

<div class="container py-4">
    <div class="clean-card">
        {{-- === HEADER: JUDUL & TOOLBAR SEJAJAR === --}}
        <div class="header-section">
            {{-- Judul di kiri --}}
            <div class="header-title">
                <h2>Basis Aturan (Rules)</h2>
                <p>Pengaturan relasi penyakit dan gejala dalam sistem pakar</p>
            </div>

            {{-- Toolbar di kanan --}}
            <div class="toolbar-wrapper">
                {{-- Search Box --}}
                <div class="search-box">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="liveSearch" placeholder="Cari kode rule, penyakit..." autocomplete="off" />
                    <button type="button" class="clear-search" id="clearSearch" title="Bersihkan pencarian">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                {{-- Show Entries --}}
                <div class="entries-box">
                    <label>Show</label>
                    <select id="showEntries">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                {{-- Tombol Tambah --}}
                <button type="button" class="btn-action-primary" data-bs-toggle="modal" data-bs-target="#modalRule">
                    <i class="bi bi-plus-lg"></i> Tambah Rule
                </button>
            </div>
        </div>

        {{-- Info hasil pencarian --}}
        <div class="search-info" id="searchInfo">
            <i class="bi bi-funnel-fill" style="color: #39af93;"></i>
            <span>Menampilkan <span class="badge-count" id="matchCount">0</span> hasil untuk: "<strong id="searchKeyword"></strong>"</span>
        </div>

        <div class="table-responsive">
            <table class="table table-clean align-middle" id="tableRules">
                <thead>
                    <tr>
                        <th style="width: 120px;">Kode Rule</th>
                        <th>Penyakit</th>
                        <th style="width: 120px;">Kondisi</th>
                        <th style="width: 130px;" class="text-center">Jumlah Gejala</th>
                        <th style="width: 140px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($rules as $rule)
                    <tr class="data-row"
                        data-search="{{ strtolower($rule->kode_rule . ' ' . ($rule->penyakit->nama_penyakit ?? '') . ' ' . $rule->kondisi_fuzzy) }}">
                        <td><span class="code-badge">{{ $rule->kode_rule }}</span></td>
                        <td class="fw-semibold">{{ $rule->penyakit->nama_penyakit ?? '-' }}</td>
                        <td>
                            @php
                                $color = match($rule->kondisi_fuzzy){
                                    'Tinggi' => 'bg-danger-subtle text-danger',
                                    'Sedang' => 'bg-warning-subtle text-warning',
                                    default => 'bg-success-subtle text-success'
                                };
                            @endphp
                            <span class="badge {{ $color }}">{{ $rule->kondisi_fuzzy }}</span>
                        </td>
                        <td class="text-center"><span class="text-muted">{{ $rule->ruleDetails->count() }} Gejala</span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#detailRule{{ $rule->id }}" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </button>
                                
                                <button type="button" 
                                        class="btn-icon btn-edit-rule" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEditRule"
                                        data-id="{{ $rule->id }}"
                                        data-kode="{{ $rule->kode_rule }}"
                                        data-penyakit="{{ $rule->penyakit_id }}"
                                        data-kondisi="{{ $rule->kondisi_fuzzy }}"
                                        data-gejala='@json($rule->ruleDetails->map(fn($d) => ["id" => $d->gejala_id, "bobot" => $d->bobot]))'
                                        title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                
                                <form action="{{ route('rules.destroy', $rule->id) }}" method="POST" class="m-0 delete-form">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" style="color: #ef4444;" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox d-block mb-2" style="font-size: 2rem; color: #cbd5e1;"></i>
                            Belum ada data rule.
                        </td>
                    </tr>
                    @endforelse

                    {{-- No Result Row --}}
                    <tr class="no-result-row" id="noResultRow">
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-search d-block mb-2" style="font-size: 2rem; color: #cbd5e1;"></i>
                            Tidak ada data yang cocok dengan pencarian Anda.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper" id="paginationWrapper">
            <span class="pagination-info" id="paginationInfo"></span>
            <div id="paginationContainer">
                {{ $rules->links() }}
            </div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL TAMBAH RULE --}}
{{-- ========================================== --}}
<div class="modal fade" id="modalRule" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 px-4 pt-4">
                <div>
                    <h5 class="modal-title fw-bold">Tambah Rule Baru</h5>
                    <p class="text-muted small mb-0">Definisikan aturan inferensi baru</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('rules.store') }}" method="POST" id="formRule">
                @csrf
                <div class="modal-body px-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kode Rule <span class="text-danger">*</span></label>
                            <input type="text" name="kode_rule" class="form-control" placeholder="Contoh: R001" required maxlength="10">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kondisi Fuzzy <span class="text-danger">*</span></label>
                            <select id="kondisi_fuzzy" name="kondisi_fuzzy" required>
                                <option value="" disabled selected>Pilih Kondisi</option>
                                <option value="Rendah">Rendah</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Tinggi">Tinggi</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Penyakit <span class="text-danger">*</span></label>
                        <select id="penyakitSelect" name="penyakit_id" required>
                            <option value="" disabled selected>-- Pilih Penyakit --</option>
                            @foreach($penyakits as $p) 
                                <option value="{{ $p->id }}">{{ $p->nama_penyakit }}</option> 
                            @endforeach
                        </select>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Gejala <span class="text-danger">*</span></label>
                        <p class="text-muted small mb-2">Pilih satu atau lebih gejala, lalu atur bobot masing-masing.</p>
                        <select id="gejalaSelect" multiple required>
                            @foreach($gejalas as $g)
                                <option value="{{ $g->id }}" data-custom-properties='{"kode":"{{ $g->kode_gejala }}","nama":"{{ $g->nama_gejala }}"}'>
                                    {{ $g->kode_gejala }} - {{ $g->nama_gejala }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="selectedGejalaWrapper" class="d-none">
                        <label class="form-label fw-semibold mt-2">
                            <i class="bi bi-list-check text-primary"></i> Gejala Terpilih & Bobot
                            <span class="badge bg-primary rounded-pill" id="countBadge">0</span>
                        </label>
                        <div id="selectedGejalaList" class="border rounded p-3 bg-light"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL EDIT RULE --}}
{{-- ========================================== --}}
<div class="modal fade" id="modalEditRule" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 px-4 pt-4">
                <div>
                    <h5 class="modal-title fw-bold">Edit Rule</h5>
                    <p class="text-muted small mb-0">Perbarui aturan inferensi</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="formEditRule">
                @csrf
                @method('PUT')
                <div class="modal-body px-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kode Rule <span class="text-danger">*</span></label>
                            <input type="text" name="kode_rule" id="edit_kode_rule" class="form-control" required maxlength="10">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kondisi Fuzzy <span class="text-danger">*</span></label>
                            <select id="edit_kondisi_fuzzy" name="kondisi_fuzzy" required>
                                <option value="" disabled>Pilih Kondisi</option>
                                <option value="Rendah">Rendah</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Tinggi">Tinggi</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Penyakit <span class="text-danger">*</span></label>
                        <select id="editPenyakitSelect" name="penyakit_id" required>
                            <option value="" disabled>-- Pilih Penyakit --</option>
                            @foreach($penyakits as $p) 
                                <option value="{{ $p->id }}">{{ $p->nama_penyakit }}</option> 
                            @endforeach
                        </select>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Gejala <span class="text-danger">*</span></label>
                        <select id="editGejalaSelect" multiple required>
                            @foreach($gejalas as $g)
                                <option value="{{ $g->id }}" data-custom-properties='{"kode":"{{ $g->kode_gejala }}","nama":"{{ $g->nama_gejala }}"}'>
                                    {{ $g->kode_gejala }} - {{ $g->nama_gejala }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="editSelectedGejalaWrapper" class="d-none">
                        <label class="form-label fw-semibold mt-2">
                            <i class="bi bi-list-check text-primary"></i> Gejala Terpilih & Bobot
                            <span class="badge bg-primary rounded-pill" id="editCountBadge">0</span>
                        </label>
                        <div id="editSelectedGejalaList" class="border rounded p-3 bg-light"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL DETAIL --}}
{{-- ========================================== --}}
@foreach($rules as $rule)
<div class="modal fade" id="detailRule{{ $rule->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 px-4 pt-4">
                <div>
                    <h5 class="modal-title fw-bold">Detail Aturan: {{ $rule->kode_rule }}</h5>
                    <p class="text-muted small mb-0">{{ $rule->penyakit->nama_penyakit ?? '-' }} • Kondisi: {{ $rule->kondisi_fuzzy }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 120px;">Kode Gejala</th>
                                <th>Nama Gejala</th>
                                <th style="width: 100px;" class="text-center">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rule->ruleDetails as $detail)
                            <tr>
                                <td><span class="code-badge">{{ $detail->gejala->kode_gejala }}</span></td>
                                <td>{{ $detail->gejala->nama_gejala }}</td>
                                <td class="text-center"><span class="badge bg-dark">{{ number_format($detail->bobot, 1) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Helper escape HTML
    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    let choicesPenyakit = null;
    let choicesKondisi = null;
    let choicesGejala = null;
    let choicesEditPenyakit = null;
    let choicesEditKondisi = null;
    let choicesEditGejala = null;

    document.addEventListener('DOMContentLoaded', function() {
        
        // ==========================================
        // LIVE SEARCH
        // ==========================================
        const searchInput = document.getElementById('liveSearch');
        const clearBtn = document.getElementById('clearSearch');
        const dataRows = document.querySelectorAll('.data-row');
        const noResultRow = document.getElementById('noResultRow');
        const searchInfo = document.getElementById('searchInfo');
        const matchCount = document.getElementById('matchCount');
        const searchKeyword = document.getElementById('searchKeyword');

        const originalContents = [];
        dataRows.forEach((row, rowIndex) => {
            originalContents[rowIndex] = [];
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, cellIndex) => {
                originalContents[rowIndex][cellIndex] = cell.innerHTML;
            });
        });

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            clearBtn.style.display = query.length > 0 ? 'block' : 'none';

            let visibleCount = 0;

            dataRows.forEach((row, rowIndex) => {
                const searchData = row.getAttribute('data-search');
                const isMatch = query === '' || searchData.includes(query);

                if (isMatch) {
                    row.classList.remove('search-hidden');
                    row.classList.add('search-match');
                    visibleCount++;
                    if (query.length > 0) {
                        highlightRow(row, rowIndex, query);
                    } else {
                        restoreRow(row, rowIndex);
                    }
                } else {
                    row.classList.add('search-hidden');
                    row.classList.remove('search-match');
                    restoreRow(row, rowIndex);
                }
            });

            if (query.length > 0) {
                searchInfo.classList.add('active');
                matchCount.textContent = visibleCount;
                searchKeyword.textContent = this.value.trim();
            } else {
                searchInfo.classList.remove('active');
                dataRows.forEach((row, rowIndex) => {
                    row.classList.remove('search-hidden', 'search-match');
                    restoreRow(row, rowIndex);
                });
            }

            if (visibleCount === 0 && query.length > 0) {
                noResultRow.classList.add('active');
            } else {
                noResultRow.classList.remove('active');
            }

            updatePaginationInfo();
        });

        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
            searchInput.focus();
        });

        function highlightRow(row, rowIndex, query) {
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, cellIndex) => {
                if (cellIndex === cells.length - 1) return; // Skip kolom aksi
                const original = originalContents[rowIndex][cellIndex];
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = original;
                const textContent = tempDiv.textContent || tempDiv.innerText;
                if (textContent.toLowerCase().includes(query)) {
                    cell.innerHTML = highlightText(original, query);
                } else {
                    cell.innerHTML = original;
                }
            });
        }

        function highlightText(html, query) {
            const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
            return html.replace(/>([^<]+)</g, function(match, textContent) {
                return '>' + textContent.replace(regex, '<mark class="search-highlight">$1</mark>') + '<';
            });
        }

        function escapeRegex(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function restoreRow(row, rowIndex) {
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, cellIndex) => {
                cell.innerHTML = originalContents[rowIndex][cellIndex];
            });
        }

        // ==========================================
        // SHOW ENTRIES
        // ==========================================
        const showEntries = document.getElementById('showEntries');
        const urlParams = new URLSearchParams(window.location.search);
        const currentPerPage = urlParams.get('per_page') || 10;
        showEntries.value = currentPerPage;

        showEntries.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', this.value);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        });

        // ==========================================
        // PAGINATION TRUNCATED
        // ==========================================
        function buildTruncatedPagination() {
            const paginationContainer = document.getElementById('paginationContainer');
            const paginationNav = paginationContainer.querySelector('nav');
            if (!paginationNav) return;

            const paginationUl = paginationNav.querySelector('ul.pagination') || paginationNav.querySelector('ul');
            if (!paginationUl) return;

            const allItems = Array.from(paginationUl.querySelectorAll('.page-item'));
            if (allItems.length <= 7) return;

            let pageItems = [];

            allItems.forEach(item => {
                const link = item.querySelector('.page-link');
                if (!link) return;
                const ariaLabel = item.getAttribute('aria-label') || '';
                if (ariaLabel.toLowerCase().includes('previous') || 
                    ariaLabel.toLowerCase().includes('next') || 
                    item.classList.contains('page-item-prev') || 
                    item.classList.contains('page-item-next') ||
                    link.querySelector('.bi-chevron-left') ||
                    link.querySelector('.bi-chevron-right')) {
                    return;
                }
                const pageNum = parseInt(link.textContent.trim());
                if (!isNaN(pageNum)) {
                    pageItems.push({ element: item, page: pageNum });
                }
            });

            if (pageItems.length === 0) return;

            const activeItem = paginationUl.querySelector('.page-item.active');
            let currentPage = 1;
            if (activeItem) {
                const activeLink = activeItem.querySelector('.page-link');
                currentPage = parseInt(activeLink.textContent.trim()) || 1;
            }

            const totalPages = pageItems[pageItems.length - 1].page;
            const firstPage = pageItems[0].page;

            const visiblePages = new Set();
            visiblePages.add(firstPage);
            visiblePages.add(totalPages);
            for (let i = Math.max(firstPage, currentPage - 1); i <= Math.min(totalPages, currentPage + 1); i++) {
                visiblePages.add(i);
            }
            if (totalPages >= 2) visiblePages.add(2);
            if (totalPages >= 2) visiblePages.add(totalPages - 1);

            pageItems.forEach(({ element, page }) => {
                if (visiblePages.has(page)) {
                    element.style.display = '';
                    element.classList.remove('page-ellipsis');
                } else {
                    element.style.display = 'none';
                }
            });

            paginationUl.querySelectorAll('.page-ellipsis').forEach(el => el.remove());
            const sortedVisible = Array.from(visiblePages).sort((a, b) => a - b);

            for (let i = 0; i < sortedVisible.length - 1; i++) {
                const current = sortedVisible[i];
                const next = sortedVisible[i + 1];
                if (next - current > 1) {
                    const targetItem = pageItems.find(p => p.page === next);
                    if (targetItem) {
                        const ellipsis = document.createElement('li');
                        ellipsis.className = 'page-item page-ellipsis';
                        ellipsis.innerHTML = '<span class="page-link">…</span>';
                        ellipsis.style.display = '';
                        paginationUl.insertBefore(ellipsis, targetItem.element);
                    }
                }
            }
        }

        function updatePaginationInfo() {
            const infoEl = document.getElementById('paginationInfo');
            const totalRows = dataRows.length;
            const visibleRows = document.querySelectorAll('.data-row:not(.search-hidden)').length;

            if (searchInput.value.trim().length > 0) {
                infoEl.textContent = `Ditemukan ${visibleRows} dari ${totalRows} data`;
                return;
            }

            const paginationNav = document.querySelector('#paginationContainer nav');
            if (paginationNav) {
                const showingText = paginationNav.querySelector('.text-muted, small');
                if (showingText) {
                    infoEl.textContent = showingText.textContent.trim();
                } else {
                    infoEl.textContent = `${visibleRows} data`;
                }
            } else {
                infoEl.textContent = `${visibleRows} data`;
            }
        }

        buildTruncatedPagination();
        updatePaginationInfo();

        // ==========================================
        // CHOICES.JS INITIALIZATION
        // ==========================================
        
        // Penyakit (Single Select)
        const penyakitEl = document.getElementById('penyakitSelect');
        if (penyakitEl) {
            choicesPenyakit = new Choices(penyakitEl, {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false,
                position: 'auto'
            });
        }

        // Kondisi Fuzzy (Single Select)
        const kondisiEl = document.getElementById('kondisi_fuzzy');
        if (kondisiEl) {
            choicesKondisi = new Choices(kondisiEl, {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });
        }

        // Gejala (Multiple Select)
        const gejalaEl = document.getElementById('gejalaSelect');
        if (gejalaEl) {
            choicesGejala = new Choices(gejalaEl, {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Ketik untuk mencari gejala...',
                searchEnabled: true,
                noResultsText: 'Gejala tidak ditemukan',
                noChoicesText: 'Tidak ada pilihan gejala',
                itemSelectText: '',
                shouldSort: false,
                position: 'auto'
            });

            gejalaEl.addEventListener('change', renderSelectedGejala);
        }

        // Edit Penyakit (Single Select)
        const editPenyakitEl = document.getElementById('editPenyakitSelect');
        if (editPenyakitEl) {
            choicesEditPenyakit = new Choices(editPenyakitEl, {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false,
                position: 'auto'
            });
        }

        // Edit Kondisi Fuzzy (Single Select)
        const editKondisiEl = document.getElementById('edit_kondisi_fuzzy');
        if (editKondisiEl) {
            choicesEditKondisi = new Choices(editKondisiEl, {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });
        }

        // Edit Gejala (Multiple Select)
        const editGejalaEl = document.getElementById('editGejalaSelect');
        if (editGejalaEl) {
            choicesEditGejala = new Choices(editGejalaEl, {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Ketik untuk mencari gejala...',
                searchEnabled: true,
                noResultsText: 'Gejala tidak ditemukan',
                noChoicesText: 'Tidak ada pilihan gejala',
                itemSelectText: '',
                shouldSort: false,
                position: 'auto'
            });

            editGejalaEl.addEventListener('change', renderEditSelectedGejala);
        }

        // ==========================================
        // RENDER LIST GEJALA + BOBOT (Tambah)
        // ==========================================
        function renderSelectedGejala() {
            if (!choicesGejala) return;
            
            const selectedValues = choicesGejala.getValue(true);
            const wrapper = document.getElementById('selectedGejalaWrapper');
            const list = document.getElementById('selectedGejalaList');
            const badge = document.getElementById('countBadge');

            if (!badge || !wrapper || !list) return;

            badge.textContent = selectedValues.length;

            if (selectedValues.length === 0) {
                wrapper.classList.add('d-none');
                list.innerHTML = '';
                return;
            }

            wrapper.classList.remove('d-none');

            const oldBobot = {};
            list.querySelectorAll('.gejala-item').forEach(item => {
                const id = item.getAttribute('data-id');
                const input = item.querySelector('input[name$="[bobot]"]');
                if (input && id) oldBobot[id] = input.value;
            });

            let html = '';
            selectedValues.forEach((id, index) => {
                const option = document.querySelector('#gejalaSelect option[value="' + id + '"]');
                if (option) {
                    let props = {};
                    try { 
                        if (option.dataset.customProperties) {
                            props = JSON.parse(option.dataset.customProperties); 
                        }
                    } catch(e) {}
                    
                    const kode = props.kode || '';
                    const nama = props.nama || option.text.split(' - ').slice(1).join(' - ') || option.text;
                    const val = oldBobot[id] || '';
                    
                    html += `
                        <div class="row mb-2 align-items-center gejala-item" data-id="${id}">
                            <div class="col-md-7">
                                <input type="hidden" name="gejala[${index}][id]" value="${id}">
                                <span class="code-badge me-2">${escapeHtml(kode)}</span>
                                <span>${escapeHtml(nama)}</span>
                            </div>
                            <div class="col-md-4">
                                <input type="number" step="0.1" min="0" max="1" 
                                    name="gejala[${index}][bobot]" class="form-control form-control-sm" 
                                    placeholder="0.0 - 1.0" value="${val}" required>
                            </div>
                            <div class="col-md-1 text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-gejala" title="Hapus">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                    `;
                }
            });
            list.innerHTML = html;
        }

        // ==========================================
        // RENDER LIST GEJALA + BOBOT (Edit)
        // ==========================================
        function renderEditSelectedGejala() {
            if (!choicesEditGejala) return;
            
            const selectedValues = choicesEditGejala.getValue(true);
            const wrapper = document.getElementById('editSelectedGejalaWrapper');
            const list = document.getElementById('editSelectedGejalaList');
            const badge = document.getElementById('editCountBadge');

            if (!badge || !wrapper || !list) return;

            badge.textContent = selectedValues.length;

            if (selectedValues.length === 0) {
                wrapper.classList.add('d-none');
                list.innerHTML = '';
                return;
            }

            wrapper.classList.remove('d-none');

            const oldBobot = {};
            list.querySelectorAll('.gejala-item').forEach(item => {
                const id = item.getAttribute('data-id');
                const input = item.querySelector('input[name$="[bobot]"]');
                if (input && id) oldBobot[id] = input.value;
            });

            let html = '';
            selectedValues.forEach((id, index) => {
                const option = document.querySelector('#editGejalaSelect option[value="' + id + '"]');
                if (option) {
                    let props = {};
                    try { 
                        if (option.dataset.customProperties) {
                            props = JSON.parse(option.dataset.customProperties); 
                        }
                    } catch(e) {}
                    
                    const kode = props.kode || '';
                    const nama = props.nama || option.text.split(' - ').slice(1).join(' - ') || option.text;
                    const val = oldBobot[id] || '';
                    
                    html += `
                        <div class="row mb-2 align-items-center gejala-item" data-id="${id}">
                            <div class="col-md-7">
                                <input type="hidden" name="gejala[${index}][id]" value="${id}">
                                <span class="code-badge me-2">${escapeHtml(kode)}</span>
                                <span>${escapeHtml(nama)}</span>
                            </div>
                            <div class="col-md-4">
                                <input type="number" step="0.1" min="0" max="1" 
                                    name="gejala[${index}][bobot]" class="form-control form-control-sm" 
                                    placeholder="0.0 - 1.0" value="${val}" required>
                            </div>
                            <div class="col-md-1 text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-edit-gejala" title="Hapus">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                    `;
                }
            });
            list.innerHTML = html;
        }

        // ==========================================
        // HAPUS GEJALA DARI LIST
        // ==========================================
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-remove-gejala')) {
                const item = e.target.closest('.gejala-item');
                const id = item.getAttribute('data-id');
                if (choicesGejala) {
                    choicesGejala.removeActiveItemsByValue(id);
                }
            }
            
            if (e.target.closest('.btn-remove-edit-gejala')) {
                const item = e.target.closest('.gejala-item');
                const id = item.getAttribute('data-id');
                if (choicesEditGejala) {
                    choicesEditGejala.removeActiveItemsByValue(id);
                }
            }
        });

        // ==========================================
        // RESET FORM TAMBAH
        // ==========================================
        const modalRule = document.getElementById('modalRule');
        if (modalRule) {
            modalRule.addEventListener('hidden.bs.modal', function () {
                const form = document.getElementById('formRule');
                if (form) form.reset();
                
                if (choicesPenyakit) choicesPenyakit.removeActiveItems();
                if (choicesKondisi) choicesKondisi.removeActiveItems();
                if (choicesGejala) choicesGejala.removeActiveItems();
                
                const wrapper = document.getElementById('selectedGejalaWrapper');
                const list = document.getElementById('selectedGejalaList');
                if (wrapper) wrapper.classList.add('d-none');
                if (list) list.innerHTML = '';
            });
        }

        // ==========================================
        // LOAD DATA KE FORM EDIT
        // ==========================================
        document.querySelectorAll('.btn-edit-rule').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const kode = this.getAttribute('data-kode');
                const penyakit = this.getAttribute('data-penyakit');
                const kondisi = this.getAttribute('data-kondisi');
                const gejala = JSON.parse(this.getAttribute('data-gejala'));

                document.getElementById('formEditRule').setAttribute('action', `/rules/${id}`);
                document.getElementById('edit_kode_rule').value = kode;
                
                if (choicesEditPenyakit) {
                    choicesEditPenyakit.removeActiveItems();
                    choicesEditPenyakit.setChoiceByValue(penyakit);
                }
                
                if (choicesEditKondisi) {
                    choicesEditKondisi.removeActiveItems();
                    choicesEditKondisi.setChoiceByValue(kondisi);
                }
                
                if (choicesEditGejala) {
                    choicesEditGejala.removeActiveItems();
                }
                
                const editWrapper = document.getElementById('editSelectedGejalaWrapper');
                const editList = document.getElementById('editSelectedGejalaList');
                if (editWrapper) editWrapper.classList.add('d-none');
                if (editList) editList.innerHTML = '';

                const gejalaIds = gejala.map(g => g.id.toString());
                
                setTimeout(() => {
                    if (choicesEditGejala) {
                        choicesEditGejala.setChoiceByValue(gejalaIds);
                    }

                    let html = '';
                    gejala.forEach((g, index) => {
                        const option = document.querySelector('#editGejalaSelect option[value="' + g.id + '"]');
                        if (option) {
                            let props = {};
                            try { 
                                if (option.dataset.customProperties) {
                                    props = JSON.parse(option.dataset.customProperties); 
                                }
                            } catch(e) {}
                            
                            const kodeGejala = props.kode || '';
                            const namaGejala = props.nama || option.text.split(' - ').slice(1).join(' - ') || option.text;
                            
                            html += `
                                <div class="row mb-2 align-items-center gejala-item" data-id="${g.id}">
                                    <div class="col-md-7">
                                        <input type="hidden" name="gejala[${index}][id]" value="${g.id}">
                                        <span class="code-badge me-2">${escapeHtml(kodeGejala)}</span>
                                        <span>${escapeHtml(namaGejala)}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" step="0.1" min="0" max="1" 
                                            name="gejala[${index}][bobot]" class="form-control form-control-sm" 
                                            placeholder="0.0 - 1.0" value="${g.bobot}" required>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-edit-gejala" title="Hapus">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                            `;
                        }
                    });
                    
                    if (editList) editList.innerHTML = html;
                    if (editWrapper) editWrapper.classList.remove('d-none');
                    
                    const editBadge = document.getElementById('editCountBadge');
                    if (editBadge) editBadge.textContent = gejala.length;
                }, 150);
            });
        });

        // ==========================================
        // VALIDASI SEBELUM SUBMIT
        // ==========================================
        ['formRule', 'formEditRule'].forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', function(e) {
                    const isEdit = formId === 'formEditRule';
                    const choices = isEdit ? choicesEditGejala : choicesGejala;
                    const listId = isEdit ? 'editSelectedGejalaList' : 'selectedGejalaList';
                    const list = document.getElementById(listId);

                    if (!choices || !list) return;

                    const selectedValues = choices.getValue(true);

                    if (selectedValues.length === 0) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Pilih minimal 1 gejala!'
                        });
                        return false;
                    }

                    let bobotValid = true;
                    list.querySelectorAll('input[type="number"]').forEach(input => {
                        const val = parseFloat(input.value);
                        if (isNaN(val) || val < 0 || val > 1) {
                            bobotValid = false;
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!bobotValid) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Pastikan semua bobot antara 0.0 - 1.0'
                        });
                        return false;
                    }
                });
            }
        });

        // ==========================================
        // DELETE CONFIRMATION
        // ==========================================
        document.body.addEventListener('submit', function(e) {
            const form = e.target;
            
            if (form && form.classList.contains('delete-form')) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Tindakan ini tidak dapat dibatalkan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    zIndex: 99999
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); },
                            zIndex: 99999
                        });
                        form.submit();
                    }
                });
            }
        });

        // ==========================================
        // FLASH MESSAGES
        // ==========================================
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        @if(session('error') || $errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') ?? 'Terjadi kesalahan input.' }}"
            });
        @endif
    });
</script>

@endsection
