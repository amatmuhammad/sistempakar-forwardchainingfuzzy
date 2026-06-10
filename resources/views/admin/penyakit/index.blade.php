@extends('partials.app-layout')

@section('title', 'Manajemen Data Penyakit')

@section('content')

<style>
    /* Kontainer Utama Penting */
    .clean-card {
        background: #ffffff;
        border: 1px solid var(--border-color, #e2e8f0);
        border-radius: 16px;
        padding: 2rem;
    }

    .clean-header {
        margin-bottom: 1.75rem;
    }

    /* === TOOLBAR: SEMUA ELEMENT RATA KANAN === */
    .toolbar-wrapper {
        display: flex;
        justify-content: flex-end; /* RATA KANAN */
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .search-box {
        position: relative;
        width: 280px;
        flex-shrink: 0;
    }
    .search-box input {
        width: 100%;
        padding: 0.65rem 2.4rem 0.65rem 2.5rem;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background-color: rgba(248, 250, 252, 0.5);
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    .search-box input:focus {
        background-color: #ffffff;
        border-color: var(--primary-color, #10b981);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
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
        flex-shrink: 0;
    }
    .entries-box label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted, #64748b);
        white-space: nowrap;
    }
    .entries-box select {
        padding: 0.6rem 2rem 0.6rem 0.85rem;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background-color: rgba(248, 250, 252, 0.5);
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-dark, #0f172a);
        cursor: pointer;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: calc(100% - 0.75rem) center;
    }
    .entries-box select:focus {
        border-color: var(--primary-color, #10b981);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    /* Info Hasil Pencarian - juga rata kanan */
    .search-info {
        font-size: 0.8rem;
        color: var(--text-muted, #64748b);
        margin-bottom: 1rem;
        display: none;
        align-items: center;
        justify-content: flex-end; /* RATA KANAN */
        gap: 0.5rem;
    }
    .search-info.active {
        display: flex;
    }
    .search-info .badge-count {
        background-color: var(--primary-color, #10b981);
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

    /* === PAGINATION TRUNCATED === */
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
        color: var(--text-muted, #64748b);
        font-weight: 500;
        white-space: nowrap;
    }

    .pagination-wrapper .pagination {
        margin-bottom: 0;
        gap: 4px;
    }
    .pagination-wrapper .page-item .page-link {
        color: var(--text-dark, #0f172a);
        background-color: #ffffff;
        border: 1px solid var(--border-color, #e2e8f0);
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
        color: var(--text-dark, #0f172a);
    }
    .pagination-wrapper .page-item.active .page-link {
        background-color: var(--text-dark, #0f172a);
        border-color: var(--text-dark, #0f172a);
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

    /* Row highlight saat di-search */
    .table-clean tbody tr.search-hidden {
        display: none;
    }
    .table-clean tbody tr.search-match {
        background-color: rgba(16, 185, 129, 0.04);
    }

    /* Tombol Utama Minimalis */
    .btn-action-primary {
        background-color: var(--text-dark, #0f172a);
        color: #ffffff;
        padding: 0.65rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-action-primary:hover {
        background-color: #1e293b;
        color: #ffffff;
    }

    /* Tombol Aksi Icon */
    .btn-icon-detail {
        background: none;
        border: 1px solid var(--border-color, #e2e8f0);
        color: #64748b;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-icon-detail:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: var(--primary-color, #10b981);
    }

    .btn-icon-edit {
        background: none;
        border: 1px solid var(--border-color, #e2e8f0);
        color: #334155;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-icon-edit:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
        color: var(--text-dark, #0f172a);
    }

    .btn-icon-delete {
        background: none;
        border: 1px solid rgba(239, 68, 68, 0.15);
        color: #ef4444;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-icon-delete:hover {
        background-color: rgba(239, 68, 68, 0.05);
        border-color: #ef4444;
    }

    /* Tabel Geometris Bersih */
    .table-clean {
        width: 100%;
        margin-bottom: 0;
        color: var(--text-dark, #0f172a);
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-clean th {
        background-color: #f8fafc;
        font-size: 0.725rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted, #64748b);
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border-color, #e2e8f0);
    }
    .table-clean td {
        padding: 1.25rem;
        font-size: 0.875rem;
        border-bottom: 1px solid var(--border-color, #e2e8f0);
        vertical-align: top;
    }
    .table-clean tbody tr:last-child td {
        border-bottom: none;
    }
    .table-clean tbody tr:hover {
        background-color: #fafafa;
    }

    /* Badge Kode Monospace */
    .code-badge {
        background-color: #f1f5f9;
        color: #334155;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 600;
        letter-spacing: -0.01em;
    }

    /* Kontrol Modal */
    .modal-clean-content {
        border-radius: 16px;
        border: 1px solid var(--border-color, #e2e8f0);
        padding: 0.5rem;
    }
    .form-label-clean {
        font-size: 0.725rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        color: var(--text-muted, #64748b);
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
    .form-control-clean {
        padding: 0.75rem 1rem;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background-color: rgba(248, 250, 252, 0.5);
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .form-control-clean:focus {
        background-color: #ffffff;
        border-color: var(--primary-color, #10b981);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1) !important;
    }

    .info-block {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.25rem;
    }

    mark.search-highlight {
        background-color: rgba(16, 185, 129, 0.25);
        color: inherit;
        padding: 0.05em 0.15em;
        border-radius: 3px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .toolbar-wrapper {
            justify-content: stretch;
        }
        .search-box {
            width: 100%;
        }
        .entries-box {
            width: 100%;
        }
        .entries-box select {
            flex: 1;
        }
        .btn-action-primary {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container py-2">
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.03em;">Data Penyakit Sapi</h2>
        <p class="text-muted small m-0">Repositori master pengetahuan penyakit dan opsi penanganan klinis</p>
    </div>

    <div class="clean-card">
        {{-- Header Judul --}}
        <div class="clean-header">
            <h5 class="fw-bold text-dark mb-1" style="letter-spacing: -0.01em;">Daftar Aturan</h5>
            {{-- === TOOLBAR: SEMUA ELEMENT RATA KANAN === --}}
            <div class="toolbar-wrapper">
                {{-- Search Box --}}
                <div class="search-box">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="liveSearch" placeholder="Cari kode, nama, definisi..." autocomplete="off" />
                    <button type="button" class="clear-search" id="clearSearch" title="Bersihkan pencarian">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
    
                {{-- Show Entries --}}
                <div class="entries-box">
                    <label for="showEntries">Tampilkan</label>
                    <select id="showEntries">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <label>entri</label>
                </div>
    
                {{-- Tombol Tambah --}}
                <button type="button" class="btn-action-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPenyakit">
                    <i class="bi bi-plus-lg"></i> Tambah Penyakit
                </button>
            </div>
    
            {{-- Info hasil pencarian (juga rata kanan) --}}
            <div class="search-info" id="searchInfo">
                <span>Menampilkan <span class="badge-count" id="matchCount">0</span> hasil untuk: "<strong id="searchKeyword"></strong>"</span>
                <i class="bi bi-funnel-fill" style="color: var(--primary-color, #10b981);"></i>
            </div>
            
        </div>


        <div class="table-responsive">
            <table class="table-clean" id="tablePenyakit">
                <thead>
                    <tr>
                        <th style="width: 110px;">Kode</th>
                        <th style="width: 240px;">Nama Penyakit</th>
                        <th>Definisi Penyakit</th>
                        <th>Saran Penanganan</th>
                        <th style="width: 160px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($penyakits as $penyakit)
                        <tr class="data-row"
                            data-search="{{ strtolower($penyakit->kode_penyakit . ' ' . $penyakit->nama_penyakit . ' ' . ($penyakit->definisi ?? '') . ' ' . ($penyakit->saran_penanganan ?? '')) }}">
                            <td><span class="code-badge">{{ $penyakit->kode_penyakit }}</span></td>
                            <td><strong style="font-weight: 600; color: #1e293b;">{{ $penyakit->nama_penyakit }}</strong></td>
                            <td><span class="text-muted" style="line-height: 1.6;">{{ Str::limit($penyakit->definisi ?? '-', 65) }}</span></td>
                            <td><span class="text-muted" style="line-height: 1.6;">{{ Str::limit($penyakit->saran_penanganan ?? '-', 65) }}</span></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" 
                                            class="btn-icon-detail btn-detail" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalDetailPenyakit"
                                            data-kode="{{ $penyakit->kode_penyakit }}"
                                            data-nama="{{ $penyakit->nama_penyakit }}"
                                            data-definisi="{{ $penyakit->definisi }}"
                                            data-saran="{{ $penyakit->saran_penanganan }}"
                                            title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <button type="button" 
                                            class="btn-icon-edit btn-edit" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditPenyakit"
                                            data-id="{{ $penyakit->id }}"
                                            data-kode="{{ $penyakit->kode_penyakit }}"
                                            data-nama="{{ $penyakit->nama_penyakit }}"
                                            data-definisi="{{ $penyakit->definisi }}"
                                            data-saran="{{ $penyakit->saran_penanganan }}"
                                            title="Ubah Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    
                                    <form action="{{ route('penyakit.destroy', $penyakit->id) }}" method="POST" class="form-delete m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-icon-delete btn-trigger-delete" title="Hapus Data">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-folder-x d-block mb-2" style="font-size: 2rem; color: #cbd5e1;"></i>
                                Belum ada entitas penyakit yang terekam di dalam sistem.
                            </td>
                        </tr>
                    @endforelse

                    <tr class="no-result-row" id="noResultRow">
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-search d-block mb-2" style="font-size: 2rem; color: #cbd5e1;"></i>
                            Tidak ada data yang cocok dengan pencarian Anda.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- === PAGINATION WRAPPER === --}}
        <div class="pagination-wrapper" id="paginationWrapper">
            <div id="paginationContainer">
                {{ $penyakits->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalDetailPenyakit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-clean-content">
            <div class="modal-header border-0 pb-2">
                <div>
                    <h5 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Detail Informasi Penyakit</h5>
                    <p class="text-muted small m-0">Ringkasan berkas basis pengetahuan sistem pakar</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <span class="form-label-clean d-block">Kode Penyakit</span>
                        <div class="mt-1">
                            <span class="code-badge" id="detail_kode" style="font-size: 0.9rem; padding: 0.4rem 0.75rem;">-</span>
                        </div>
                    </div>
                    <div class="col-md-8 mt-3 mt-md-0">
                        <span class="form-label-clean d-block">Nama Penyakit</span>
                        <h5 class="fw-bold text-dark mt-1" id="detail_nama" style="letter-spacing: -0.01em;">-</h5>
                    </div>
                </div>
                <div class="mb-3">
                    <span class="form-label-clean d-block">Definisi Penyakit</span>
                    <div class="info-block mt-1">
                        <p class="text-secondary m-0" id="detail_definisi" style="line-height: 1.6; font-size: 0.9rem; text-align: justify;">-</p>
                    </div>
                </div>
                <div class="mb-2">
                    <span class="form-label-clean d-block">Saran Penanganan / Solusi Klinis</span>
                    <div class="info-block mt-1" style="border-left: 4px solid var(--text-dark, #0f172a);">
                        <p class="text-secondary m-0" id="detail_saran" style="line-height: 1.6; font-size: 0.9rem; text-align: justify;">-</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn-action-primary" data-bs-dismiss="modal">Tutup Detail</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahPenyakit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-clean-content">
            <div class="modal-header border-0 pb-2">
                <div>
                    <h5 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Tambah Entitas Penyakit</h5>
                    <p class="text-muted small m-0">Suntikkan parameter medis rekam klinis baru</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penyakit.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="create_kode" class="form-label-clean">Kode Penyakit</label>
                            <input type="text" class="form-control form-control-clean" id="create_kode" name="kode_penyakit" placeholder="P01" maxlength="5" required />
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="create_nama" class="form-label-clean">Nama Penyakit</label>
                            <input type="text" class="form-control form-control-clean" id="create_nama" name="nama_penyakit" placeholder="Masukkan nama penyakit..." maxlength="100" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="create_definisi" class="form-label-clean">Definisi Penyakit</label>
                        <textarea class="form-control form-control-clean" id="create_definisi" name="definisi" rows="4" placeholder="Uraikan detail definisi medis terkait..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="create_saran" class="form-label-clean">Saran Penanganan</label>
                        <textarea class="form-control form-control-clean" id="create_saran" name="saran_penanganan" rows="4" placeholder="Berikan rekomendasi tindakan pengobatan pertolongan pertama..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn-action-primary" style="background-color: transparent; border: 1px solid #cbd5e1; color: #475569;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-action-primary">Simpan Rekor</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditPenyakit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-clean-content">
            <div class="modal-header border-0 pb-2">
                <div>
                    <h5 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Perbarui Informasi Penyakit</h5>
                    <p class="text-muted small m-0">Sesuaikan kembali detail parameter rekam klinis</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="formEditPenyakit">
                @csrf
                @method('PUT')
                <div class="modal-body py-3">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_kode" class="form-label-clean">Kode Penyakit</label>
                            <input type="text" class="form-control form-control-clean" id="edit_kode" name="kode_penyakit" maxlength="5" required />
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="edit_nama" class="form-label-clean">Nama Penyakit</label>
                            <input type="text" class="form-control form-control-clean" id="edit_nama" name="nama_penyakit" maxlength="100" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_definisi" class="form-label-clean">Definisi Penyakit</label>
                        <textarea class="form-control form-control-clean" id="edit_definisi" name="definisi" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_saran" class="form-label-clean">Saran Penanganan</label>
                        <textarea class="form-control form-control-clean" id="edit_saran" name="saran_penanganan" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn-action-primary" style="background-color: transparent; border: 1px solid #cbd5e1; color: #475569;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-action-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // =============================================
        // GLOBAL SWEETALERT CATCHER
        // =============================================
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#0f172a'
            });
        @endif

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 1800
            });
        @endif

        // =============================================
        // 1. LIVE SEARCH
        // =============================================
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
                if (cellIndex === cells.length - 1) return;
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

        // =============================================
        // 2. SHOW ENTRIES
        // =============================================
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

        // =============================================
        // 3. PAGINATION TRUNCATED
        // =============================================
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

        // =============================================
        // JS BINDING 1: MODAL DETAIL
        // =============================================
        const detailButtons = document.querySelectorAll('.btn-detail');
        detailButtons.forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('detail_kode').innerText = this.getAttribute('data-kode');
                document.getElementById('detail_nama').innerText = this.getAttribute('data-nama');
                document.getElementById('detail_definisi').innerText = this.getAttribute('data-definisi') || '-';
                document.getElementById('detail_saran').innerText = this.getAttribute('data-saran') || '-';
            });
        });

        // =============================================
        // JS BINDING 2: MODAL EDIT
        // =============================================
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_kode').value = this.getAttribute('data-kode');
                document.getElementById('edit_nama').value = this.getAttribute('data-nama');
                document.getElementById('edit_definisi').value = this.getAttribute('data-definisi');
                document.getElementById('edit_saran').value = this.getAttribute('data-saran');
                document.getElementById('formEditPenyakit').setAttribute('action', `/admin/penyakit/${id}`);
            });
        });

        // =============================================
        // JS BINDING 3: KONFIRMASI DELETE
        // =============================================
        const deleteButtons = document.querySelectorAll('.btn-trigger-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('.form-delete');
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Data master penyakit ini akan dihapus permanen dari sistem!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    background: '#ffffff',
                    customClass: { popup: 'rounded-4' }
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    });
</script>

@endsection