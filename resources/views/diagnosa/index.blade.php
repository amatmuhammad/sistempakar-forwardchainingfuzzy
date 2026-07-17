{{-- resources/views/diagnosa/index.blade.php --}}
@extends('partials.app-layout')

@section('title', 'Diagnosa Penyakit Sapi')

@section('content')
<style>
    .diagnosa-page .page-title-box {
        background: linear-gradient(135deg, #f8fbff 0%, #eef8f5 100%);
        border: 1px solid #e3f0eb;
        border-radius: 18px;
        padding: 1rem 1.2rem;
        margin-bottom: 1rem;
    }

    .diagnosa-page .page-title-box h4 {
        margin: 0.25rem 0;
        font-size: 1.25rem;
    }

    .diagnosa-page .diagnosa-card {
        border: 0;
        border-radius: 20px;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .diagnosa-page .diagnosa-card .card-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        border-bottom: 1px solid #e9f1ee;
        padding: 1rem 1.25rem;
    }

    .diagnosa-page .diagnosa-card .card-body {
        padding: 1rem 1rem 1.1rem;
    }

    .diagnosa-page .search-box-wrap {
        position: relative;
    }

    .diagnosa-page .search-box-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #7c8aa0;
    }

    .diagnosa-page .search-box-wrap input {
        padding-left: 2.5rem;
        border-radius: 12px;
    }

    .diagnosa-page .gejala-item {
        border: 1px solid #e5ece8;
        border-radius: 14px;
        padding: 0.75rem 0.8rem;
        background: linear-gradient(180deg, #ffffff 0%, #f8fcfb 100%);
        transition: all 0.2s ease;
        margin-bottom: 0.6rem;
    }

    .diagnosa-page .gejala-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 7px 16px rgba(15, 23, 42, 0.05);
    }

    .diagnosa-page .gejala-title {
        font-size: 0.95rem;
        line-height: 1.35;
    }

    .diagnosa-page .gejala-controls {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        flex-wrap: wrap;
        margin-top: 0.45rem;
    }

    .diagnosa-page .gejala-slider {
        flex: 1 1 220px;
        min-width: 140px;
        accent-color: #39af93;
    }

    .diagnosa-page .gejala-number {
        width: 78px;
        min-width: 78px;
    }

    .diagnosa-page .gejala-status {
        min-width: 100px;
        text-align: center;
        padding: 0.35rem 0.5rem;
    }

    .diagnosa-page #gejalaContainer {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 4px;
    }

    .diagnosa-page .result-card {
        border-radius: 18px;
        border: 1px solid #e7edf3;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.05);
    }

    .diagnosa-page .result-card .card-header {
        padding: 0.9rem 1rem;
    }

    .diagnosa-page .result-card .card-body {
        padding: 1rem 1rem 1.15rem;
    }

    .diagnosa-page .empty-state {
        background: linear-gradient(135deg, #f8fbff 0%, #f7fcfa 100%);
        border: 1px dashed #c9d8d4;
        border-radius: 18px;
        padding: 2rem 1.2rem;
    }

    .diagnosa-page .summary-box {
        background: #f8fbff;
        border: 1px solid #e3eef4;
        border-radius: 14px;
        padding: 0.85rem 0.95rem;
    }
</style>

<div class="container-fluid diagnosa-page">
    

    <!-- Alert Session -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="ri-information-line"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mt-5">
        <!-- FORM SECTION -->
        <div class="col-xl-6">
            <div class="card diagnosa-card mb-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">
                            <i class="ri-clipboard-line me-2"></i> Form Diagnosa
                        </h5>
                        <p class="text-muted small mb-0">Pilih gejala yang dialami ternak untuk memulai analisis.</p>
                    </div>
                    <div>
                        <a href="{{ route('diagnosa.reset') }}" class="btn btn-sm btn-outline-warning" 
                           onclick="return confirm('Yakin ingin mereset semua data diagnosa?')">
                            <i class="ri-refresh-line"></i> Reset Session
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('diagnosa.proses') }}" id="diagnosaForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_pemilik" 
                                       value="{{ old('nama_pemilik', session('nama_pemilik')) }}" 
                                       placeholder="Masukkan nama pemilik" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Ternak <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_ternak" 
                                       value="{{ old('nama_ternak', session('nama_ternak')) }}" 
                                       placeholder="Masukkan nama ternak" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Cari Gejala</label>
                            <div class="search-box-wrap">
                                <i class="ri-search-line"></i>
                                <input type="text" id="searchGejala" class="form-control" placeholder="Ketik untuk mencari gejala...">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                Pilih Gejala yang Dialami <span class="text-danger">*</span>
                            </label>
                            <div class="summary-box mb-2">
                                <small class="text-muted">
                                    <i class="ri-information-line"></i> 
                                    Geser slider atau isi angka. Nilai 0 = tidak ada gejala, 1 = sangat yakin.
                                </small>
                            </div>
                            <div id="gejalaContainer">
                                @foreach($gejalaList as $index => $gejala)
                                <div class="gejala-item mb-2" data-name="{{ strtolower($gejala->nama_gejala) }}">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div class="fw-semibold text-dark gejala-title">
                                            <span class="badge bg-dark-subtle text-dark me-2">{{ $gejala->kode_gejala }}</span>
                                            {{ $gejala->nama_gejala }}
                                        </div>
                                        <small class="text-muted text-nowrap">
                                            @if($gejala->fuzzy_a == 0 && $gejala->fuzzy_b == 0 && $gejala->fuzzy_c == 0 && $gejala->fuzzy_d == 0)
                                                <span class="badge bg-info-subtle text-info">Default</span>
                                            @else
                                                <span class="badge bg-info-subtle text-info">Fuzzy</span>
                                            @endif
                                        </small>
                                    </div>
                                    <div class="gejala-controls">
                                        <input type="range" class="form-range gejala-slider" 
                                               data-id="{{ $gejala->id }}"
                                               min="0" max="1" step="0.01" value="0">
                                        <input type="number" class="form-control form-control-sm gejala-number" 
                                               data-id="{{ $gejala->id }}"
                                               step="0.01" min="0" max="1" value="0"
                                               placeholder="0.00">
                                        <span class="badge gejala-status" data-id="{{ $gejala->id }}" style="font-size: 0.7rem;">
                                            Tidak Dipilih
                                        </span>
                                    </div>
                                    <input type="hidden" name="gejala[{{ $index }}][id]" value="{{ $gejala->id }}">
                                    <input type="hidden" name="gejala[{{ $index }}][nilai]" class="gejala-value-{{ $gejala->id }}" value="0">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                <i class="ri-search-line me-2"></i> Diagnosa Sekarang
                            </button>
                            <button type="button" class="btn btn-outline-secondary rounded-pill" onclick="resetForm()">
                                <i class="ri-refresh-line me-2"></i> Reset Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- HASIL DIAGNOSA SECTION -->
        <div class="col-xl-6">
            <div class="card diagnosa-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">
                            <i class="ri-heart-pulse-line me-2"></i> Hasil Diagnosa Fuzzy
                        </h5>
                        <p class="text-muted small mb-0">Ringkasan hasil inferensi dan rekomendasi penyakit.</p>
                    </div>
                    @if(session('hasilDiagnosa') && count(session('hasilDiagnosa')) > 0)
                    <a href="{{ route('diagnosa.reset') }}" class="btn btn-sm btn-outline-danger" 
                       onclick="return confirm('Yakin ingin mereset hasil diagnosa?')">
                        <i class="ri-delete-bin-line"></i> Hapus Hasil
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    @php
                        $hasilDiagnosa = session('hasilDiagnosa');
                    @endphp
                    
                    @if($hasilDiagnosa && is_array($hasilDiagnosa) && count($hasilDiagnosa) > 0)
                        <div class="summary-box mb-3">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="ri-information-line text-primary"></i>
                                <strong>Ringkasan Hasil</strong>
                            </div>
                            <div class="small text-muted">
                                Ditemukan <strong>{{ count($hasilDiagnosa) }}</strong> kandidat penyakit dari 
                                <strong>{{ count(array_filter(session('selectedGejala') ?? [], function($g) { return ($g['nilai'] ?? 0) > 0; })) }}</strong> gejala yang dilaporkan.
                            </div>
                        </div>
                        
                        {{-- Looping untuk menampilkan SEMUA penyakit --}}
                        @foreach($hasilDiagnosa as $index => $hasil)
                            @php
                                $keyakinan = $hasil['keyakinan'] ?? 0;
                                $kategori = $hasil['kategori_keyakinan'] ?? 'Tidak Diketahui';
                                $isPrimary = $index == 0;
                                
                                // Tentukan warna berdasarkan kategori
                                if ($kategori == 'Sangat Yakin') {
                                    $cardClass = 'success';
                                    $badgeClass = 'success';
                                } elseif ($kategori == 'Yakin') {
                                    $cardClass = 'primary';
                                    $badgeClass = 'primary';
                                } else {
                                    $cardClass = 'warning';
                                    $badgeClass = 'warning';
                                }
                            @endphp
                            
                            <div class="card result-card mb-3 border-{{ $isPrimary ? $cardClass : 'secondary' }}">
                                <div class="card-header bg-{{ $isPrimary ? $cardClass : 'light' }} text-{{ $isPrimary ? 'white' : 'dark' }} d-flex justify-content-between align-items-center">
                                    <strong>
                                        @if($isPrimary)
                                            <i class="ri-star-fill"></i> DIAGNOSA UTAMA
                                        @else
                                            <i class="ri-stethoscope-line"></i> DIAGNOSA ALTERNATIF {{ $index }}
                                        @endif
                                    </strong>
                                    <span class="badge bg-{{ $badgeClass }} float-end">
                                        {{ number_format($keyakinan, 1) }}%
                                    </span>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-{{ $isPrimary ? $cardClass : 'dark' }}">
                                        {{ $hasil['kode_penyakit'] ?? '-' }} - {{ $hasil['nama_penyakit'] ?? 'Tidak diketahui' }}
                                    </h5>
                                    
                                    {{-- Progress Bar Keyakinan --}}
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>Tingkat Keyakinan (Metode Maximum Membership)</small>
                                            <small class="fw-bold">{{ number_format($keyakinan, 1) }}%</small>
                                        </div>
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $badgeClass }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $keyakinan }}%">
                                                {{ number_format($keyakinan, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Kategori & Skor --}}
                                    <div class="mb-3">
                                        <span class="badge bg-{{ $badgeClass }} p-2">
                                            <i class="ri-shield-check-line"></i> 
                                            Kategori: <strong>{{ $kategori }}</strong>
                                        </span>
                                        <span class="badge bg-info p-2 ms-2">
                                            <i class="ri-bar-chart-line"></i> 
                                            Skor Fuzzy: {{ number_format($keyakinan, 2) }}
                                        </span>
                                    </div>
                                    
                                    {{-- Detail Perhitungan (Jika Ada) --}}
                                    @if(isset($hasil['detail_calc']) && is_array($hasil['detail_calc']) && count($hasil['detail_calc']) > 0)
                                        <div class="mb-3">
                                            <button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="collapse" 
                                                    data-bs-target="#detailCalc{{ $index }}" aria-expanded="false">
                                                <i class="ri-code-line"></i> Lihat Detail Perhitungan Fuzzy
                                            </button>
                                            <div class="collapse mt-2" id="detailCalc{{ $index }}">
                                                <div class="card card-body bg-light">
                                                    <small class="text-muted">Aturan yang Fired:</small>
                                                    @foreach($hasil['detail_calc'] as $detail)
                                                        <div class="border rounded p-2 mb-1">
                                                            <strong>{{ $detail['kode_rule'] ?? '-' }}</strong>
                                                            <span class="badge bg-{{ ($detail['kondisi_fuzzy'] ?? '') == 'Sangat Yakin' ? 'success' : (($detail['kondisi_fuzzy'] ?? '') == 'Yakin' ? 'primary' : 'warning') }}">
                                                                {{ $detail['kondisi_fuzzy'] ?? '-' }}
                                                            </span>
                                                            <br>
                                                            <small>α-predikat: <strong>{{ number_format($detail['alpha_predikat'] ?? 0, 4) }}</strong></small>
                                                            @if(isset($detail['gejala_fired']))
                                                                <ul class="mb-0 small">
                                                                    @foreach($detail['gejala_fired'] as $gf)
                                                                        <li>
                                                                            {{ $gf['kode_gejala'] ?? '-' }}: μ = {{ number_format($gf['mu'] ?? 0, 4) }}
                                                                            (crisp: {{ number_format($gf['nilai_crisp'] ?? 0, 2) }}, bobot: {{ $gf['bobot'] ?? 0 }})
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    {{-- Definisi & Saran (hanya untuk diagnosa utama) --}}
                                    @if($isPrimary)
                                        @if(isset($hasil['definisi']) && $hasil['definisi'])
                                            <hr>
                                            <div class="alert alert-info mb-2">
                                                <strong><i class="ri-book-open-line"></i> Definisi:</strong><br>
                                                {{ $hasil['definisi'] }}
                                            </div>
                                        @endif
                                        
                                        @if(isset($hasil['saran_penanganan']) && $hasil['saran_penanganan'])
                                            <div class="alert alert-success mb-0">
                                                <strong><i class="ri-lightbulb-line"></i> Saran Penanganan:</strong><br>
                                                {!! nl2br(e($hasil['saran_penanganan'])) !!}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Ringkasan Gejala yang Dipilih -->
                        @if(session('selectedGejala'))
                            <div class="mt-4">
                                <h6 class="fw-bold">
                                    <i class="ri-list-check"></i> Ringkasan Gejala yang Dilaporkan:
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Kode</th>
                                                <th>Gejala</th>
                                                <th>Nilai Crisp</th>
                                                <th>Kategori Input</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $gejalaDipilih = 0;
                                            @endphp
                                            @foreach(session('selectedGejala') as $gejala)
                                                @if(isset($gejala['nilai']) && floatval($gejala['nilai']) > 0)
                                                    @php
                                                        $gejalaData = $gejalaList->firstWhere('id', $gejala['id']);
                                                        $nilai = floatval($gejala['nilai']);
                                                        $gejalaDipilih++;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $gejalaData->kode_gejala ?? '-' }}</td>
                                                        <td>{{ $gejalaData->nama_gejala ?? '-' }}</td>
                                                        <td>{{ number_format($nilai, 2) }}</td>
                                                        <td>
                                                            @if($nilai >= 0.9)
                                                                <span class="badge bg-success">Sangat Yakin</span>
                                                            @elseif($nilai >= 0.7)
                                                                <span class="badge bg-primary">Yakin</span>
                                                            @elseif($nilai >= 0.5)
                                                                <span class="badge bg-warning text-dark">Cukup Yakin</span>
                                                            @else
                                                                <span class="badge bg-danger">Kurang Yakin</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            @if($gejalaDipilih == 0)
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Tidak ada gejala yang dipilih</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        
                    @else
                        <div class="empty-state text-center">
                            <i class="ri-stethoscope-line" style="font-size: 4rem; color: #39af93;"></i>
                            <h5 class="mt-3 text-dark">Belum Ada Hasil Diagnosa</h5>
                            <p class="text-muted mb-3">Silakan isi form diagnosa di samping untuk memulai analisis.</p>
                            <div class="text-start mx-auto" style="max-width: 560px;">
                                <small class="text-muted">
                                    <strong><i class="ri-information-line"></i> Tentang Sistem:</strong><br>
                                    Sistem ini menggunakan <strong>Fuzzy Inference System</strong> dengan metode:
                                    <ul class="mb-2 mt-2">
                                        <li><strong>Forward Chaining</strong> - Penalaran dari fakta ke kesimpulan</li>
                                        <li><strong>Operator AND (MIN)</strong> - Untuk menghitung α-predikat</li>
                                        <li><strong>Agregasi MAX</strong> - Menggabungkan alpha-predikat setiap kategori</li>
                                        <li><strong>Maximum Membership</strong> - Memilih kategori dengan derajat keanggotaan tertinggi</li>
                                    </ul>
                                    <strong>Tips:</strong> Pilih minimal 3-5 gejala yang relevan dengan nilai keyakinan di atas 0.7 untuk hasil optimal.
                                </small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search gejala
    const searchInput = document.getElementById('searchGejala');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const items = document.querySelectorAll('.gejala-item');
            items.forEach(function(item) {
                const name = item.getAttribute('data-name');
                if (name && name.includes(searchText)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
    
    // Function untuk update nilai (slider, number input, hidden input, status badge)
    function updateValue(gejalaId, value) {
        value = parseFloat(value) || 0;
        if (value < 0) value = 0;
        if (value > 1) value = 1;
        
        // Update slider
        const slider = document.querySelector(`.gejala-slider[data-id="${gejalaId}"]`);
        if (slider) slider.value = value;
        
        // Update number input
        const numberInput = document.querySelector(`.gejala-number[data-id="${gejalaId}"]`);
        if (numberInput) numberInput.value = value;
        
        // Update hidden input (yang dikirim ke server)
        const hiddenInput = document.querySelector(`.gejala-value-${gejalaId}`);
        if (hiddenInput) hiddenInput.value = value;
        
        // Update status badge
        const statusBadge = document.querySelector(`.gejala-status[data-id="${gejalaId}"]`);
        if (statusBadge) {
            if (value >= 0.9) {
                statusBadge.textContent = 'Sangat Yakin';
                statusBadge.className = 'badge bg-success gejala-status';
            } else if (value >= 0.7) {
                statusBadge.textContent = 'Yakin';
                statusBadge.className = 'badge bg-primary gejala-status';
            } else if (value >= 0.5) {
                statusBadge.textContent = 'Cukup Yakin';
                statusBadge.className = 'badge bg-warning text-dark gejala-status';
            } else if (value > 0) {
                statusBadge.textContent = 'Kurang Yakin';
                statusBadge.className = 'badge bg-danger gejala-status';
            } else {
                statusBadge.textContent = 'Tidak Dipilih';
                statusBadge.className = 'badge bg-secondary gejala-status';
            }
        }
    }
    
    // Event listener untuk slider
    const sliders = document.querySelectorAll('.gejala-slider');
    sliders.forEach(function(slider) {
        slider.addEventListener('input', function() {
            const gejalaId = this.getAttribute('data-id');
            updateValue(gejalaId, this.value);
        });
    });
    
    // Event listener untuk number input
    const numberInputs = document.querySelectorAll('.gejala-number');
    numberInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            const gejalaId = this.getAttribute('data-id');
            updateValue(gejalaId, this.value);
        });
        
        // Juga update saat blur (ketika user selesai mengetik)
        input.addEventListener('blur', function() {
            const gejalaId = this.getAttribute('data-id');
            let value = parseFloat(this.value) || 0;
            if (value < 0) value = 0;
            if (value > 1) value = 1;
            this.value = value;
            updateValue(gejalaId, value);
        });
    });
});

function resetForm() {
    const sliders = document.querySelectorAll('.gejala-slider');
    sliders.forEach(function(slider) {
        const gejalaId = slider.getAttribute('data-id');
        
        // Reset slider
        slider.value = 0;
        
        // Reset number input
        const numberInput = document.querySelector(`.gejala-number[data-id="${gejalaId}"]`);
        if (numberInput) numberInput.value = 0;
        
        // Reset hidden input
        const hiddenInput = document.querySelector(`.gejala-value-${gejalaId}`);
        if (hiddenInput) hiddenInput.value = 0;
        
        // Reset status badge
        const statusBadge = document.querySelector(`.gejala-status[data-id="${gejalaId}"]`);
        if (statusBadge) {
            statusBadge.textContent = 'Tidak Dipilih';
            statusBadge.className = 'badge bg-secondary gejala-status';
        }
    });
    
    // Reset search
    const searchInput = document.getElementById('searchGejala');
    if (searchInput) searchInput.value = '';
    
    // Tampilkan semua item
    const items = document.querySelectorAll('.gejala-item');
    items.forEach(function(item) {
        item.style.display = 'block';
    });
}
</script>
@endsection