{{-- resources/views/diagnosa/index.blade.php --}}
{{-- Tambahkan di bagian atas form atau di bagian hasil diagnosa --}}

@extends('partials.app-layout')

@section('title', 'Diagnosa Penyakit Sapi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-5 mt-5">Sistem Pakar Diagnosa Penyakit Sapi</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                        <li class="breadcrumb-item active">Diagnosa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

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

    <div class="row">
        <!-- FORM SECTION -->
        <div class="col-xl-6">
            <div class="card mb-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="ri-clipboard-line"></i> Form Diagnosa
                    </h5>
                    <div>
                        <a href="{{ route('diagnosa.reset') }}" class="btn btn-sm btn-warning" 
                           onclick="return confirm('Yakin ingin mereset semua data diagnosa?')">
                            <i class="ri-refresh-line"></i> Reset Session
                        </a>
                    </div>
                </div>
                <div class="card-body ">
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
                            <input type="text" id="searchGejala" class="form-control" placeholder="Ketik untuk mencari gejala...">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Pilih Gejala yang Dialami <span class="text-danger">*</span></label>
                            <div id="gejalaContainer" style="max-height: 500px; overflow-y: auto;">
                                @foreach($gejalaList as $index => $gejala)
                                <div class="border rounded p-2 mb-2 gejala-item" data-name="{{ strtolower($gejala->nama_gejala) }}">
                                    <div class="fw-bold">{{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}</div>
                                    <div class="row mt-2">
                                        <div class="col-8">
                                            <input type="range" class="form-range gejala-slider" 
                                                   data-id="{{ $gejala->id }}"
                                                   min="0" max="1" step="0.01" value="0">
                                        </div>
                                        <div class="col-4">
                                            <input type="number" class="form-control gejala-number" 
                                                   data-id="{{ $gejala->id }}"
                                                   step="0.01" min="0" max="1" value="0">
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <span class="badge bg-secondary gejala-status" data-id="{{ $gejala->id }}">
                                            Tidak Dipilih
                                        </span>
                                        <span class="badge bg-info">Bobot: {{ number_format($gejala->fuzzy_b, 2) }}</span>
                                    </div>
                                    <input type="hidden" name="gejala[{{ $index }}][id]" value="{{ $gejala->id }}">
                                    <input type="hidden" name="gejala[{{ $index }}][nilai]" class="gejala-value-{{ $gejala->id }}" value="0">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-search-line"></i> Diagnosa Sekarang
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="ri-refresh-line"></i> Reset Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        {{-- resources/views/diagnosa/index.blade.php --}}
        {{-- GANTI bagian hasil diagnosa dengan kode di bawah --}}

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="ri-heart-pulse-line"></i> Hasil Diagnosa
                    </h5>
                    @if(session('hasilDiagnosa') && count(session('hasilDiagnosa')) > 0)
                    <a href="{{ route('diagnosa.reset') }}" class="btn btn-sm btn-danger" 
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
                        <div class="alert alert-info mb-3">
                            <i class="ri-information-line"></i> 
                            Ditemukan <strong>{{ count($hasilDiagnosa) }}</strong> penyakit yang terdeteksi dari gejala yang dilaporkan.
                        </div>
                        
                        {{-- Looping untuk menampilkan SEMUA penyakit --}}
                        @foreach($hasilDiagnosa as $index => $hasil)
                            @php
                                $keyakinan = $hasil['keyakinan'] ?? 0;
                                $progressClass = $keyakinan >= 70 ? 'success' : ($keyakinan >= 50 ? 'warning' : 'danger');
                                $isPrimary = $index == 0;
                            @endphp
                            
                            <div class="card mb-3 border-{{ $isPrimary ? 'primary' : 'secondary' }} shadow-sm">
                                <div class="card-header bg-{{ $isPrimary ? 'primary' : 'light' }} text-{{ $isPrimary ? 'white' : 'dark' }}">
                                    <strong>
                                        @if($isPrimary)
                                            <i class="ri-star-fill"></i> DIAGNOSA UTAMA
                                        @else
                                            <i class="ri-stethoscope-line"></i> DIAGNOSA ALTERNATIF {{ $index }}
                                        @endif
                                        <span class="float-end badge bg-{{ $progressClass }}">
                                            {{ number_format($keyakinan, 1) }}%
                                        </span>
                                    </strong>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-{{ $isPrimary ? 'primary' : 'dark' }}">
                                        {{ $hasil['kode_penyakit'] ?? '-' }} - {{ $hasil['nama_penyakit'] ?? 'Tidak diketahui' }}
                                    </h5>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Tingkat Keyakinan</span>
                                            <span class="fw-bold">{{ number_format($keyakinan, 1) }}%</span>
                                        </div>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar progress-bar-striped bg-{{ $progressClass }}" 
                                                role="progressbar" 
                                                style="width: {{ $keyakinan }}%">
                                                {{ number_format($keyakinan, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <span class="badge bg-{{ $progressClass }} p-2">
                                            <i class="ri-shield-check-line"></i> 
                                            Kategori: {{ $hasil['kategori_keyakinan'] ?? 'Tidak diketahui' }}
                                        </span>
                                        @if(isset($hasil['gejala_yang_cocok']))
                                        <span class="badge bg-info p-2 ms-2">
                                            <i class="ri-checkbox-circle-line"></i> 
                                            {{ $hasil['gejala_yang_cocok'] }} Gejala Cocok
                                        </span>
                                        @endif
                                    </div>
                                    
                                    @if($isPrimary)
                                        @if(isset($hasil['definisi']) && $hasil['definisi'])
                                            <hr>
                                            <div class="alert alert-info mb-2">
                                                <strong>📖 Definisi:</strong><br>
                                                {{ $hasil['definisi'] }}
                                            </div>
                                        @endif
                                        
                                        @if(isset($hasil['saran_penanganan']) && $hasil['saran_penanganan'])
                                            <div class="alert alert-success mb-0">
                                                <strong>💡 Saran Penanganan:</strong><br>
                                                {{ $hasil['saran_penanganan'] }}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Gejala yang Dipilih -->
                        @if(session('selectedGejala'))
                            <div class="mt-4">
                                <h6 class="fw-bold"><i class="ri-list-check"></i> Gejala yang Dilaporkan:</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Kode</th>
                                                <th>Gejala</th>
                                                <th>Nilai</th>
                                                <th>Kategori</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(session('selectedGejala') as $gejala)
                                                @if(isset($gejala['nilai']) && floatval($gejala['nilai']) > 0)
                                                    @php
                                                        $gejalaData = $gejalaList->firstWhere('id', $gejala['id']);
                                                        $nilai = floatval($gejala['nilai']);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $gejalaData->kode_gejala ?? '-' }}</td>
                                                        <td>{{ $gejalaData->nama_gejala ?? '-' }}</td>
                                                        <td>{{ number_format($nilai * 100, 0) }}%</td>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        
                        
                        
                    @else
                        <div class="text-center py-5">
                            <i class="ri-stethoscope-line" style="font-size: 4rem; color: #adb5bd;"></i>
                            <h5 class="mt-3 text-muted">Belum Ada Hasil Diagnosa</h5>
                            <p class="text-muted">Silakan isi form diagnosa di samping untuk memulai analisis</p>
                            <hr>
                            <div class="text-start">
                                <small class="text-muted">
                                    <strong>Tips:</strong> Pilih minimal 3-5 gejala yang relevan dengan nilai keyakinan di atas 0.7
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
    
    // Function untuk update nilai
    function updateValue(gejalaId, value) {
        value = parseFloat(value) || 0;
        if (value < 0) value = 0;
        if (value > 1) value = 1;
        
        const slider = document.querySelector(`.gejala-slider[data-id="${gejalaId}"]`);
        if (slider) slider.value = value;
        
        const numberInput = document.querySelector(`.gejala-number[data-id="${gejalaId}"]`);
        if (numberInput) numberInput.value = value;
        
        const hiddenInput = document.querySelector(`.gejala-value-${gejalaId}`);
        if (hiddenInput) hiddenInput.value = value;
        
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
                statusBadge.className = 'badge bg-warning gejala-status';
            } else if (value > 0) {
                statusBadge.textContent = 'Kurang Yakin';
                statusBadge.className = 'badge bg-danger gejala-status';
            } else {
                statusBadge.textContent = 'Tidak Dipilih';
                statusBadge.className = 'badge bg-secondary gejala-status';
            }
        }
    }
    
    // Event listeners
    const sliders = document.querySelectorAll('.gejala-slider');
    sliders.forEach(function(slider) {
        slider.addEventListener('input', function() {
            const gejalaId = this.getAttribute('data-id');
            updateValue(gejalaId, this.value);
        });
    });
    
    const numberInputs = document.querySelectorAll('.gejala-number');
    numberInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            const gejalaId = this.getAttribute('data-id');
            updateValue(gejalaId, this.value);
        });
    });
});

function resetForm() {
    const sliders = document.querySelectorAll('.gejala-slider');
    sliders.forEach(function(slider) {
        const gejalaId = slider.getAttribute('data-id');
        const updateValue = function(id, val) {
            const s = document.querySelector(`.gejala-slider[data-id="${id}"]`);
            const n = document.querySelector(`.gejala-number[data-id="${id}"]`);
            const h = document.querySelector(`.gejala-value-${id}`);
            const b = document.querySelector(`.gejala-status[data-id="${id}"]`);
            if (s) s.value = val;
            if (n) n.value = val;
            if (h) h.value = val;
            if (b) {
                b.textContent = 'Tidak Dipilih';
                b.className = 'badge bg-secondary gejala-status';
            }
        };
        updateValue(gejalaId, 0);
    });
}
</script>
@endsection