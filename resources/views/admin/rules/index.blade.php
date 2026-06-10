@extends('partials.app-layout')

@section('title', 'Manajemen Basis Aturan')

@section('content')

{{-- Choice.js CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/styles/choices.min.css" />

<style>
    .clean-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .clean-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .btn-action-primary { background-color: #0f172a; color: #ffffff; padding: 0.65rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: 0.85rem; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; }
    .btn-action-primary:hover { background-color: #1e293b; color: #fff; }
    .table-clean thead th { background-color: #f8fafc !important; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #64748b; padding: 1rem; border-bottom: 1px solid #e2e8f0; }
    .table-clean tbody td { padding: 1rem; border-bottom: 1px solid #f1f5f9; }
    .code-badge { background-color: #f1f5f9; color: #334155; font-family: monospace; font-size: 0.85rem; padding: 0.25rem 0.5rem; border-radius: 6px; font-weight: 600; }
    .btn-icon { width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; border: 1px solid #e2e8f0; background: white; color: #64748b; transition: 0.2s; }
    .btn-icon:hover { background: #f8fafc; border-color: #cbd5e1; }

    /* ========================================= */
    /* CHOICE.JS CUSTOM STYLING                  */
    /* ========================================= */
    .choices { margin-bottom: 0 !important; width: 100% !important; }
    
    .choices__inner {
        min-height: 46px !important;
        background-color: #fff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.9rem !important;
        transition: all 0.2s ease !important;
    }
    
    /* Single select styling */
    .choices__list--single {
        padding: 4px 8px !important;
    }
    .choices__list--single .choices__item {
        color: #0f172a !important;
    }
    
    /* Multiple select (Gejala) - Tags */
    .choices__list--multiple .choices__item {
        background: linear-gradient(135deg, #47fda5 0%, #39af93 100%) !important;
        border: none !important;
        border-radius: 6px !important;
        padding: 4px 10px !important;
        font-size: 0.85rem !important;
        font-weight: 500 !important;
        margin: 2px 6px 2px 0 !important;
        box-shadow: 0 2px 4px rgba(57, 175, 147, 0.3) !important;
        color: #ffffff !important;
    }
    
    .choices__list--multiple .choices__item.is-highlighted {
        background: linear-gradient(135deg, #39af93 0%, #2d8a74 100%) !important;
        opacity: 0.9 !important;
    }
    
    .choices__list--multiple .choices__item .choices__button {
        border-left: 1px solid rgba(255, 255, 255, 0.956) !important;
        margin-left: 8px !important;
        padding: 0 6px !important;
        background-image: none !important;
        width: auto !important;
    }
    
    .choices__list--multiple .choices__item .choices__button::after {
        content: "✕";
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.75rem;
        font-weight: bold;
    }
    
    .choices__list--multiple .choices__item .choices__button:hover::after {
        color: #ffffff;
    }
    
    /* Dropdown */
    .choices__list--dropdown,
    .choices__list[aria-expanded] {
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15) !important;
        margin-top: 4px !important;
        z-index: 10000 !important;
        background: #fff !important;
    }
    
    .choices__list--dropdown .choices__item,
    .choices__list[aria-expanded] .choices__item {
        padding: 10px 14px !important;
        font-size: 0.9rem !important;
        color: #b1d2ff !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    
    .choices__list--dropdown .choices__item:last-child,
    .choices__list[aria-expanded] .choices__item:last-child {
        border-bottom: none !important;
    }
    
    .choices__list--dropdown .choices__item--selectable.is-highlighted,
    .choices__list[aria-expanded] .choices__item--selectable.is-highlighted {
        background-color: #f0fdf4 !important;
        color: #0f172a !important;
    }
    
    /* Focus state */
    .choices.is-focused .choices__inner,
    .choices.is-open .choices__inner {
        border-color: #39af93 !important;
        box-shadow: 0 0 0 4px rgba(57, 175, 147, 0.15) !important;
    }
    
    /* Input search */
    .choices__input {
        background-color: transparent !important;
        color: #0f172a !important;
        font-size: 0.9rem !important;
        margin-bottom: 0 !important;
    }
    
    .choices__input::placeholder {
        color: #94a3b8 !important;
    }
    
    .choices__placeholder {
        color: #94a3b8 !important;
        opacity: 1 !important;
    }
</style>

<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold text-dark">Basis Aturan (Rules)</h2>
        <p class="text-muted">Pengaturan relasi penyakit dan gejala dalam sistem pakar.</p>
    </div>

    <div class="clean-card">
        <div class="clean-header">
            <div>
                <h5 class="fw-bold text-dark mb-1">Daftar Rule Inferensi</h5>
                <p class="text-muted small mb-0">Basis pengetahuan sistem pakar</p>
            </div>
            <button type="button" class="btn-action-primary" data-bs-toggle="modal" data-bs-target="#modalRule">
                <i class="bi bi-plus-lg"></i> Tambah Rule
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-clean align-middle">
                <thead>
                    <tr>
                        <th style="width: 120px;">Kode Rule</th>
                        <th>Penyakit</th>
                        <th style="width: 120px;">Kondisi</th>
                        <th style="width: 130px;" class="text-center">Jumlah Gejala</th>
                        <th style="width: 140px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rules as $rule)
                    <tr>
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
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $rules->links() }}
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
        // 1. INITIALIZE CHOICES.JS - MODAL TAMBAH
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

        // Gejala (Multiple Select) - PERBAIKAN: Tanpa callbackOnCreateTemplates
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

        // ==========================================
        // 2. INITIALIZE CHOICES.JS - MODAL EDIT
        // ==========================================
        
        // Penyakit Edit (Single Select)
        const editPenyakitEl = document.getElementById('editPenyakitSelect');
        if (editPenyakitEl) {
            choicesEditPenyakit = new Choices(editPenyakitEl, {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false,
                position: 'auto'
            });
        }

        // Kondisi Fuzzy Edit (Single Select)
        const editKondisiEl = document.getElementById('edit_kondisi_fuzzy');
        if (editKondisiEl) {
            choicesEditKondisi = new Choices(editKondisiEl, {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });
        }

        // Gejala Edit (Multiple Select) - PERBAIKAN: Tanpa callbackOnCreateTemplates
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
        // 3. RENDER LIST GEJALA + BOBOT (Tambah)
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

            // Simpan bobot lama berdasarkan ID gejala
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
        // 4. RENDER LIST GEJALA + BOBOT (Edit)
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

            // Simpan bobot lama
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
        // 5. HAPUS GEJALA DARI LIST
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
        // 6. RESET FORM TAMBAH
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
        // 7. LOAD DATA KE FORM EDIT
        // ==========================================
        document.querySelectorAll('.btn-edit-rule').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const kode = this.getAttribute('data-kode');
                const penyakit = this.getAttribute('data-penyakit');
                const kondisi = this.getAttribute('data-kondisi');
                const gejala = JSON.parse(this.getAttribute('data-gejala'));

                // Set action URL
                document.getElementById('formEditRule').setAttribute('action', `/rules/${id}`);
                
                // Isi field dasar
                document.getElementById('edit_kode_rule').value = kode;
                
                // Set nilai dropdown
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
                    // Set nilai gejala terpilih
                    if (choicesEditGejala) {
                        choicesEditGejala.setChoiceByValue(gejalaIds);
                    }

                    // Render list dengan bobot (gunakan index sequential)
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
        // 8. VALIDASI SEBELUM SUBMIT
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
        // 9. DELETE CONFIRMATION
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
        // 10. FLASH MESSAGES
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