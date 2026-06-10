@extends('partials.app-layout')

@section('title', 'Riwayat Diagnosa')

@section('content')
<style>
    /* Gunakan style yang sama dengan halaman Gejala */
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
        margin-bottom: 2.5rem;
    }
    .btn-action-primary {
        background-color: #0f172a;
        color: #ffffff;
        padding: 0.65rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-icon-edit {
        background: none;
        border: 1px solid #e2e8f0;
        color: #334155;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }
    .btn-icon-edit:hover {
        background-color: #f1f5f9;
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
        padding: 1.25rem;
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
    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: flex-end;
    }
    .pagination-wrapper .pagination {
        gap: 4px;
    }
    .pagination-wrapper .page-link {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0;
        color: #0f172a;
        padding: 0.5rem 0.85rem;
    }
    .pagination-wrapper .active .page-link {
        background-color: #0f172a;
        border-color: #0f172a;
        color: white;
    }
    .progress {
        height: 8px;
        border-radius: 10px;
        background-color: #e2e8f0;
    }
</style>

<div class="container py-2">
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Riwayat Diagnosa</h2>
        <p class="text-muted small m-0">Daftar konsultasi yang telah dilakukan</p>
    </div>

    <div class="clean-card">
        <div class="clean-header">
            <div>
                <h5 class="fw-bold text-dark mb-1">Daftar Konsultasi</h5>
                <p class="text-muted small m-0">Riwayat diagnosa penyakit sapi berdasarkan gejala</p>
            </div>
            <!-- Opsional tombol cetak semua atau filter -->
        </div>

        <div class="table-responsive">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 140px;">Tanggal</th>
                        <th>Pemilik</th>
                        <th>Ternak</th>
                        <th>Hasil Diagnosa</th>
                        <th style="width: 160px;">Keyakinan</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $index => $item)
                    <tr>
                        <td>{{ $riwayat->firstItem() + $index }}</td>
                        <td class="text-nowrap">{{ $item->tanggal_periksa->format('d/m/Y H:i') }}</td>
                        <td>{{ $item->nama_pemilik }}</td>
                        <td>{{ $item->nama_ternak }}</td>
                        <td>
                            @if($item->penyakit)
                                <span class="code-badge">{{ $item->penyakit->kode_penyakit }}</span>
                                <span class="ms-1">{{ $item->penyakit->nama_penyakit }}</span>
                            @else
                                <span class="text-warning">Tidak Terdeteksi</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar rounded-pill 
                                        {{ $item->nilai_keyakinan >= 70 ? 'bg-success' : ($item->nilai_keyakinan >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                        style="width: {{ $item->nilai_keyakinan }}%"></div>
                                </div>
                                <span class="small fw-semibold">{{ number_format($item->nilai_keyakinan, 1) }}%</span>
                            </div>
                         </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('diagnosa.detail', $item->id) }}" class="btn-icon-edit" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-inbox d-block mb-2 fs-1"></i>
                            Belum ada riwayat konsultasi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $riwayat->links() }}
        </div>
    </div>
</div>

{{-- Sertakan Bootstrap Icons jika belum --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection