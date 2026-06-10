{{-- resources/views/diagnosa/detail.blade.php --}}
@extends('partials.app-layout')

@section('title', 'Detail Diagnosa')

@section('content')
<style>
    /* Gaya konsisten dengan halaman Gejala & Riwayat */
    .clean-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 2rem;
    }
    .clean-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .table-clean {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-clean th {
        background-color: #f8fafc;
        font-size: 0.725rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-clean td {
        padding: 1rem 1.25rem;
        font-size: 0.875rem;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    .table-clean tbody tr:hover {
        background-color: #fafafa;
    }
    .code-badge {
        background-color: #f1f5f9;
        color: #334155;
        font-family: monospace;
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 600;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .info-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.25rem;
        border: 1px solid #e2e8f0;
    }
    .info-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0.25rem;
        display: block;
    }
    .info-value {
        font-weight: 600;
        color: #0f172a;
        font-size: 1rem;
    }
    .progress {
        height: 8px;
        border-radius: 10px;
        background-color: #e2e8f0;
    }
    .progress-bar {
        border-radius: 10px;
        background: linear-gradient(90deg, #0f172a, #39af93);
    }
    .badge-confidence {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .badge-sangat-yakin { background-color: #198754; color: white; }
    .badge-yakin { background-color: #0d6efd; color: white; }
    .badge-cukup-yakin { background-color: #ffc107; color: #000; }
    .badge-kurang-yakin { background-color: #dc3545; color: white; }
    .btn-icon {
        background: none;
        border: 1px solid #e2e8f0;
        color: #334155;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-icon:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
    }
    .alert-clean {
        border-radius: 12px;
        border-left: 4px solid;
        background-color: #f8fafc;
        padding: 1rem;
    }
    .alert-info-clean {
        border-left-color: #0d6efd;
    }
    .alert-success-clean {
        border-left-color: #198754;
    }
</style>

<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Detail Diagnosa</h2>
        <p class="text-muted small m-0">Informasi lengkap hasil konsultasi</p>
    </div>

    <div class="clean-card">
        <div class="clean-header">
            <div>
                <h5 class="fw-bold text-dark mb-1">Hasil Konsultasi</h5>
                <p class="text-muted small m-0">{{ $konsultasi->tanggal_periksa->translatedFormat('d F Y, H:i') }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('diagnosa.riwayat') }}" class="btn-icon" title="Kembali">
                    <i class="bi bi-arrow-left"></i>
                </a>

            </div>
        </div>

        <!-- Informasi Konsultasi dalam grid dua kolom -->
        <div class="info-grid">
            <div class="info-card">
                <span class="info-label"><i class="bi bi-person"></i> Pemilik Ternak</span>
                <div class="info-value">{{ $konsultasi->nama_pemilik }}</div>
                <span class="info-label mt-2"><i class="bi bi-emoji-smile"></i> Nama Ternak</span>
                <div class="info-value">{{ $konsultasi->nama_ternak }}</div>
            </div>
            <div class="info-card">
                <span class="info-label"><i class="bi bi-clipboard-heart"></i> Hasil Diagnosa</span>
                <div class="info-value">
                    @if($konsultasi->penyakit)
                        <span class="code-badge">{{ $konsultasi->penyakit->kode_penyakit }}</span>
                        {{ $konsultasi->penyakit->nama_penyakit }}
                    @else
                        <span class="badge bg-warning">Tidak Terdeteksi</span>
                    @endif
                </div>
                <span class="info-label mt-2"><i class="bi bi-bar-chart-steps"></i> Tingkat Keyakinan</span>
                <div class="d-flex align-items-center gap-3 mt-1">
                    <div class="progress flex-grow-1">
                        <div class="progress-bar" style="width: {{ $konsultasi->nilai_keyakinan }}%"></div>
                    </div>
                    <span class="fw-semibold">{{ number_format($konsultasi->nilai_keyakinan, 1) }}%</span>
                </div>
            </div>
        </div>

        <!-- Tabel Gejala yang Dilaporkan -->
        <h6 class="fw-bold mb-3"><i class="bi bi-list-check me-2"></i>Gejala yang Dilaporkan</h6>
        <div class="table-responsive">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th style="width: 100px;">Kode</th>
                        <th>Gejala</th>
                        <th style="width: 140px;">Nilai Keyakinan</th>
                        <th style="width: 140px;">Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konsultasi->konsultasiDetails as $detail)
                    <tr>
                        <td><span class="code-badge">{{ $detail->gejala->kode_gejala }}</span></td>
                        <td>{{ $detail->gejala->nama_gejala }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: {{ $detail->nilai_crisp * 100 }}%"></div>
                                </div>
                                <span class="small">{{ round($detail->nilai_crisp * 100) }}%</span>
                            </div>
                        </td>
                        <td>
                            @php $nilai = $detail->nilai_crisp; @endphp
                            @if($nilai >= 0.9)
                                <span class="badge-confidence badge-sangat-yakin">Sangat Yakin</span>
                            @elseif($nilai >= 0.7)
                                <span class="badge-confidence badge-yakin">Yakin</span>
                            @elseif($nilai >= 0.5)
                                <span class="badge-confidence badge-cukup-yakin">Cukup Yakin</span>
                            @else
                                <span class="badge-confidence badge-kurang-yakin">Kurang Yakin</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Tidak ada gejala yang dilaporkan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Informasi Penyakit jika ada -->
        @if($konsultasi->penyakit)
            <div class="row mt-4 g-3">
                @if($konsultasi->penyakit->definisi)
                <div class="col-12">
                    <div class="alert-clean alert-info-clean">
                        <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                        <strong>Definisi Penyakit</strong><br>
                        {{ $konsultasi->penyakit->definisi }}
                    </div>
                </div>
                @endif
                @if($konsultasi->penyakit->saran_penanganan)
                <div class="col-12">
                    <div class="alert-clean alert-success-clean">
                        <i class="bi bi-lightbulb-fill me-2 text-success"></i>
                        <strong>Saran Penanganan</strong><br>
                        {{ $konsultasi->penyakit->saran_penanganan }}
                    </div>
                </div>
                @endif
            </div>
        @endif

        <!-- Tombol navigasi bawah (opsional) -->
        {{-- <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('diagnosa.riwayat') }}" class="btn-icon" style="width: auto; padding: 0 1rem;">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            
        </div> --}}
    </div>
</div>

{{-- Pastikan Bootstrap Icons sudah terpasang --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection