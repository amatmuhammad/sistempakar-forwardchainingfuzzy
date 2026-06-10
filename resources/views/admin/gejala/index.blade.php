@extends('partials.app-layout')

@section('title', 'Manajemen Data Gejala')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Kontainer Utama Penting */
    .clean-card {
        background: #ffffff;
        border: 1px solid var(--border-color, #e2e8f0);
        border-radius: 16px;
        padding: 2rem;
    }

    .clean-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    /* Tombol Utama Minimalis */
    .btn-action-primary {
        background-color: var(--text-dark, #0ee27c);
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
    }
    .btn-action-primary:hover {
        background-color: #21df73;
        color: #ffffff;
    }

    /* Tombol Aksi Icon Bersih */
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
        vertical-align: middle;
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

    /* Search Box Styling */
    .search-box {
        position: relative;
        width: 300px;
    }
    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.9rem;
        pointer-events: none;
    }
    .search-box input {
        padding-left: 38px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 0.85rem;
    }
    .search-box input:focus {
        border-color: #0f172a;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
    }

    /* Show entries dropdown */
    .show-entries {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .show-entries select {
        width: 70px;
        padding: 0.4rem 0.6rem;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.85rem;
        background-color: white;
        cursor: pointer;
    }
    
    /* Loading indicator */
    .table-responsive {
        position: relative;
        min-height: 400px;
    }
    
    .loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 20;
        display: none;
    }
    
    .loading-spinner.show {
        display: block;
    }
    
    .table-content {
        transition: opacity 0.3s ease;
    }
    
    .table-content.loading {
        opacity: 0.5;
        pointer-events: none;
    }
    
    /* Kustomisasi Paginasi Kontrol */
    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
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
        cursor: pointer;
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
        cursor: not-allowed;
    }
    
    /* Badge Nilai Parameter Fuzzy */
    .fuzzy-param-badge {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        font-family: ui-monospace, monospace;
        font-size: 0.8rem;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        color: #475569;
    }
    
    .data-info {
        font-size: 0.8rem;
        color: #64748b;
    }
    
    /* Search loading indicator */
    .search-box .search-loading {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        border: 2px solid #e2e8f0;
        border-top-color: #0f172a;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
        display: none;
    }
    
    @keyframes spin {
        to { transform: translateY(-50%) rotate(360deg); }
    }
    
    .search-box.loading .search-loading {
        display: block;
    }
    .search-box.loading i {
        opacity: 0.5;
    }
</style>

<div class="container py-2">
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.03em;">Data Gejala Klinis</h2>
        <p class="text-muted small m-0">Kelola indikator gejala fisik dan perubahan perilaku pada sapi</p>
    </div>

    <div class="clean-card">
        <div class="clean-header">
            <div>
                <h5 class="fw-bold text-dark mb-1" style="letter-spacing: -0.01em;">Daftar Kriteria Gejala</h5>
                <p class="text-muted small m-0">Gunakan tabel interaktif untuk menambah atau memodifikasi indikator medis</p>
            </div>
            <div class="d-flex gap-3 align-items-center flex-wrap">
                <!-- Search Box Live dengan Debounce -->
                <div class="search-box" id="searchBox">
                    {{-- <i class="bi bi-search"></i> --}}
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari kode atau gejala..." autocomplete="off" value="{{ request('search') }}">
                    <div class="search-loading"></div>
                </div>
                
                <!-- Show Entries -->
                <div class="show-entries">
                    <span class="text-muted small">Show</span>
                    <select id="perPageSelect" class="form-select">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="text-muted small"></span>
                </div>
                
                <!-- Tombol Tambah -->
                <button type="button" class="btn-action-primary" data-bs-toggle="modal" data-bs-target="#modalTambahGejala">
                    <i class="bi bi-plus-lg"></i> Tambah Gejala
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border text-dark" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="table-content" id="tableContent">
                <table class="table-clean">
                    <thead>
                        <tr>
                            <th style="width: 110px;">Kode Gejala</th>
                            <th>Deskripsi Indikator Gejala</th>
                            <th style="width: 280px; text-align: center;">Parameter Fuzzy (a, b, c, d)</th>
                            <th style="width: 120px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($gejalas as $gejala)
                            <tr class="gejala-row" data-id="{{ $gejala->id }}">
                                <td><span class="code-badge">{{ $gejala->kode_gejala }}</span></td>
                                <td><span class="text-dark" style="font-weight: 500; line-height: 1.6;">{{ $gejala->nama_gejala }}</span></td>
                                <td class="text-center">
                                    <span class="fuzzy-param-badge">a: <strong>{{ $gejala->fuzzy_a ?? 0 }}</strong></span>
                                    <span class="fuzzy-param-badge">b: <strong>{{ $gejala->fuzzy_b ?? 0 }}</strong></span>
                                    <span class="fuzzy-param-badge">c: <strong>{{ $gejala->fuzzy_c ?? 0 }}</strong></span>
                                    <span class="fuzzy-param-badge">d: <strong>{{ $gejala->fuzzy_d ?? 0 }}</strong></span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" 
                                                class="btn-icon-edit btn-edit-gejala" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditGejala"
                                                data-id="{{ $gejala->id }}"
                                                data-kode="{{ $gejala->kode_gejala }}"
                                                data-nama="{{ $gejala->nama_gejala }}"
                                                data-a="{{ $gejala->fuzzy_a }}"
                                                data-b="{{ $gejala->fuzzy_b }}"
                                                data-c="{{ $gejala->fuzzy_c }}"
                                                data-d="{{ $gejala->fuzzy_d }}"
                                                title="Ubah Gejala">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        
                                        <form action="{{ route('gejala.destroy', $gejala->id) }}" method="POST" class="m-0 delete-form">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon-delete" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="bi bi-exclamation-triangle d-block mb-2" style="font-size: 2rem; color: #cbd5e1;"></i>
                                    Belum ada indikator gejala fuzzy yang terekam di dalam database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-wrapper" id="paginationWrapper">
            <div class="data-info" id="dataInfo">
                Menampilkan <span id="dataFrom">{{ $gejalas->firstItem() ?? 0 }}</span> - <span id="dataTo">{{ $gejalas->lastItem() ?? 0 }}</span> 
                dari <span id="dataTotal">{{ $gejalas->total() }}</span> data
            </div>
            <div id="paginationLinks">
                {{ $gejalas->appends(['search' => request('search'), 'per_page' => request('per_page')])->links() }}
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH GEJALA --}}
<div class="modal fade" id="modalTambahGejala" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-clean-content">
            <div class="modal-header border-0 pb-2">
                <div>
                    <h5 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Tambah Kriteria Gejala</h5>
                    <p class="text-muted small m-0">Definisikan kode parameter indikator baru</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('gejala.store') }}" method="POST" id="formTambahGejala">
                @csrf
                <div class="modal-body py-3">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="create_kode" class="form-label-clean">Kode Gejala</label>
                            <input type="text" class="form-control form-control-clean" id="create_kode" name="kode_gejala" placeholder="Contoh: G01" maxlength="5" required />
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="create_nama" class="form-label-clean">Deskripsi Gejala</label>
                            <textarea class="form-control form-control-clean" id="create_nama" name="nama_gejala" rows="2" placeholder="Uraikan indikator fisik (misal: Air liur keluar berlebihan)..." required></textarea>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="mb-3">
                        <label class="form-label-clean">Parameter Fuzzy (Opsional)</label>
                        <p class="text-muted small mb-3">Atur rentang nilai fuzzy untuk gejala ini. Kosongkan jika tidak digunakan.</p>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="create_a" class="form-label small text-muted">Nilai a (min)</label>
                                <input type="number" step="0.01" class="form-control form-control-clean" id="create_a" name="fuzzy_a" placeholder="0.0" />
                            </div>
                            <div class="col-md-3">
                                <label for="create_b" class="form-label small text-muted">Nilai b</label>
                                <input type="number" step="0.01" class="form-control form-control-clean" id="create_b" name="fuzzy_b" placeholder="0.0" />
                            </div>
                            <div class="col-md-3">
                                <label for="create_c" class="form-label small text-muted">Nilai c</label>
                                <input type="number" step="0.01" class="form-control form-control-clean" id="create_c" name="fuzzy_c" placeholder="0.0" />
                            </div>
                            <div class="col-md-3">
                                <label for="create_d" class="form-label small text-muted">Nilai d (max)</label>
                                <input type="number" step="0.01" class="form-control form-control-clean" id="create_d" name="fuzzy_d" placeholder="0.0" />
                            </div>
                        </div>
                        <div class="form-text mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>Segitiga:</strong> isi a, b, c (d=0). <strong>Trapesium:</strong> isi a, b, c, d lengkap.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn-action-primary" style="background-color: transparent; border: 1px solid #cbd5e1; color: #475569;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-action-primary">Simpan Gejala</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT GEJALA --}}
<div class="modal fade" id="modalEditGejala" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-clean-content">
            <div class="modal-header border-0 pb-2">
                <div>
                    <h5 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Perbarui Informasi Gejala</h5>
                    <p class="text-muted small m-0">Sesuaikan deskripsi indikator klinis</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="formEditGejala">
                @csrf
                @method('PUT')
                <div class="modal-body py-3">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_kode" class="form-label-clean">Kode Gejala</label>
                            <input type="text" class="form-control form-control-clean" id="edit_kode" name="kode_gejala" maxlength="5" required />
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="edit_nama" class="form-label-clean">Deskripsi Gejala</label>
                            <textarea class="form-control form-control-clean" id="edit_nama" name="nama_gejala" rows="2" required></textarea>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="mb-3">
                        <label class="form-label-clean">Parameter Fuzzy</label>
                        <p class="text-muted small mb-3">Atur rentang nilai fuzzy untuk gejala ini.</p>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="edit_a" class="form-label small text-muted">Nilai a (min)</label>
                                <input type="number" step="0.01" class="form-control form-control-clean" id="edit_a" name="fuzzy_a" placeholder="0.0" />
                            </div>
                            <div class="col-md-3">
                                <label for="edit_b" class="form-label small text-muted">Nilai b</label>
                                <input type="number" step="0.01" class="form-control form-control-clean" id="edit_b" name="fuzzy_b" placeholder="0.0" />
                            </div>
                            <div class="col-md-3">
                                <label for="edit_c" class="form-label small text-muted">Nilai c</label>
                                <input type="number" step="0.01" class="form-control form-control-clean" id="edit_c" name="fuzzy_c" placeholder="0.0" />
                            </div>
                            <div class="col-md-3">
                                <label for="edit_d" class="form-label small text-muted">Nilai d (max)</label>
                                <input type="number" step="0.01" class="form-control form-control-clean" id="edit_d" name="fuzzy_d" placeholder="0.0" />
                            </div>
                        </div>
                        <div class="form-text mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>Segitiga:</strong> isi a, b, c (d=0). <strong>Trapesium:</strong> isi a, b, c, d lengkap.
                        </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    let searchTimeout;
    let currentUrl = "{{ route('gejala') }}";
    
    // SweetAlert untuk error dan success
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            html: '{!! implode("<br>", $errors->all()) !!}',
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
        }).then(() => {
            location.reload();
        });
    @endif

    // Fungsi untuk render tabel dari HTML response
    function renderTable(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newBody = doc.querySelector('tbody');
        
        if (newBody) {
            $('#tableBody').html(newBody.innerHTML);
        } else {
            // Jika tidak ada tbody dalam response, coba cari table
            const table = doc.querySelector('table');
            if (table) {
                const tbody = table.querySelector('tbody');
                if (tbody) {
                    $('#tableBody').html(tbody.innerHTML);
                }
            }
        }
    }
    
    // Fungsi untuk load data via AJAX
    function loadData(page = 1) {
        const search = $('#searchInput').val();
        const perPage = $('#perPageSelect').val();
        
        // Tampilkan loading
        $('#loadingSpinner').addClass('show');
        $('#tableContent').addClass('loading');
        
        $.ajax({
            url: currentUrl,
            type: 'GET',
            data: {
                search: search,
                per_page: perPage,
                page: page,
                ajax: true
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                // Update table body
                if (response.data) {
                    $('#tableBody').html(response.data);
                }
                
                // Update pagination
                if (response.pagination) {
                    $('#paginationLinks').html(response.pagination);
                }
                
                // Update data info
                $('#dataFrom').text(response.from || 0);
                $('#dataTo').text(response.to || 0);
                $('#dataTotal').text(response.total || 0);
                
                // Update URL tanpa reload
                const newUrl = `${currentUrl}?search=${encodeURIComponent(search)}&per_page=${perPage}&page=${page}`;
                window.history.pushState({}, '', newUrl);
            },
            error: function(xhr) {
                console.error('Error loading data:', xhr);
                let errorMsg = 'Gagal memuat data. Silakan refresh halaman.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                $('#tableBody').html(`
                    <tr>
                        <td colspan="4" class="text-center text-danger py-5">
                            <i class="bi bi-exclamation-triangle d-block mb-2" style="font-size: 2rem;"></i>
                            ${errorMsg}
                        </td>
                    </tr>
                `);
            },
            complete: function() {
                $('#loadingSpinner').removeClass('show');
                $('#tableContent').removeClass('loading');
                $('#searchBox').removeClass('loading');
                reBindEvents();
            }
        });
    }
    
    // Re-bind event setelah load data
    function reBindEvents() {
        // Bind edit buttons
        $('.btn-edit-gejala').off('click').on('click', function() {
            const id = $(this).data('id');
            const kode = $(this).data('kode');
            const nama = $(this).data('nama');
            const a = $(this).data('a');
            const b = $(this).data('b');
            const c = $(this).data('c');
            const d = $(this).data('d');

            $('#edit_kode').val(kode);
            $('#edit_nama').val(nama);
            $('#edit_a').val(a || '');
            $('#edit_b').val(b || '');
            $('#edit_c').val(c || '');
            $('#edit_d').val(d || '');

            $('#formEditGejala').attr('action', `/admin/gejala/${id}`);
        });
        
        // Bind delete forms
        $('.delete-form').off('submit').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Menghapus gejala ini berisiko mengganggu relasi basis aturan (rule) inferensi yang ada!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: 'Data gejala berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                loadData();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                confirmButtonColor: '#0f172a'
                            });
                        }
                    });
                }
            });
        });
    }
    
    // Event handler untuk search dengan debounce
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimeout);
        $('#searchBox').addClass('loading');
        
        searchTimeout = setTimeout(() => {
            loadData(1);
        }, 500);
    });
    
    // Event handler untuk change per page
    $('#perPageSelect').on('change', function() {
        loadData(1);
    });
    
    // Event handler untuk pagination links (delegation)
    $(document).on('click', '#paginationLinks .page-link', function(e) {
        e.preventDefault();
        
        const url = $(this).attr('href');
        if (url && !$(this).parent().hasClass('disabled')) {
            const pageMatch = url.match(/[?&]page=(\d+)/);
            if (pageMatch) {
                loadData(pageMatch[1]);
            }
        }
    });
    
    // Handle modal tambah
    $('#formTambahGejala').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#modalTambahGejala').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data gejala berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    loadData(1);
                    $('#formTambahGejala')[0].reset();
                });
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: errorMessage,
                    confirmButtonColor: '#0f172a'
                });
            }
        });
    });
    
    // Handle modal edit
    $('#formEditGejala').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#modalEditGejala').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data gejala berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    loadData();
                });
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat memperbarui data.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: errorMessage,
                    confirmButtonColor: '#0f172a'
                });
            }
        });
    });
    
    // Initial bind events
    reBindEvents();
});
</script>

@endsection