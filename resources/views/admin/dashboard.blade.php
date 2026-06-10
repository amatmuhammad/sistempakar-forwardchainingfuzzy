@extends('partials.app-layout')

@section('title', 'Dashboard Overview')

@section('content')
<style>
    /* Global dashboard spacing */
    .dashboard-container {
        padding: 1.75rem 1.5rem;
    }

    /* Modern Premium Stat Cards */
    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 1.5rem;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        border-color: rgba(16, 185, 129, 0.3);
        box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.01);
    }

    .stat-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon-red {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(248, 113, 113, 0.08) 100%);
        color: #ef4444;
    }

    .stat-icon-cyan {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.08) 0%, rgba(34, 211, 238, 0.08) 100%);
        color: #0891b2;
    }

    .stat-icon-purple {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.08) 0%, rgba(167, 139, 250, 0.08) 100%);
        color: #7c3aed;
    }

    .stat-icon-emerald {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(52, 211, 153, 0.08) 100%);
        color: #059669;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }

    .stat-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #64748b;
    }

    .stat-value {
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    /* Dashboard Panels */
    .dashboard-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    }

    .panel-header {
        margin-bottom: 1.5rem;
    }

    .panel-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin-bottom: 0.25rem;
    }

    .panel-subtitle {
        font-size: 0.82rem;
        color: #64748b;
        margin: 0;
    }

    /* Table custom designs */
    .custom-table {
        margin: 0;
    }
    
    .custom-table th {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        border-bottom: 2px solid #f1f5f9;
        padding: 1rem 0.75rem;
    }

    .custom-table td {
        font-size: 0.88rem;
        color: #334155;
        padding: 1.1rem 0.75rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    /* Soft Translucent Custom Badges */
    .custom-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.75rem;
        border-radius: 100px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .badge-success {
        background: rgba(16, 185, 129, 0.08);
        border: 1px solid rgba(16, 185, 129, 0.15);
        color: #059669;
    }

    .badge-warning {
        background: rgba(245, 158, 11, 0.08);
        border: 1px solid rgba(245, 158, 11, 0.15);
        color: #d97706;
    }

    .text-semibold {
        font-weight: 600;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1.5rem;
        text-align: center;
        color: #94a3b8;
        gap: 0.75rem;
    }

    .empty-state svg {
        opacity: 0.5;
        color: #94a3b8;
    }
</style>

<div class="container dashboard-container">
    <!-- Page Header Title -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.03em;">Dashboard Overview</h2>
        <p class="text-muted small mb-0">Ringkasan statistik real-time dan tren diagnosis hewan ternak sapi</p>
    </div>

    <!-- Metrik Grid -->
    <div class="row g-4 mb-5">
        <!-- Card 1: Penyakit -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Jenis Penyakit</span>
                    <span class="stat-value">{{ $totalPenyakit }}</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Gejala -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-cyan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><path d="M12 11v6M9 14h6"></path></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Total Gejala</span>
                    <span class="stat-value">{{ $totalGejala }}</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Rules -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-purple">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="3" x2="6" y2="15"></line><circle cx="18" cy="6" r="3"></circle><circle cx="6" cy="18" r="3"></circle><path d="M18 9a9 9 0 0 1-9 9"></path></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Aturan Inferensi</span>
                    <span class="stat-value">{{ $totalRules }}</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Diagnosa -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-emerald">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Total Diagnosa</span>
                    <span class="stat-value">{{ $totalKonsultasi }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Tren Diagnosa 7 Hari -->
    <div class="dashboard-panel mb-5">
        <div class="panel-header">
            <h5 class="panel-title">Tren Aktivitas Diagnosa</h5>
            <p class="panel-subtitle">Jumlah kasus konsultasi yang tercatat dalam 7 hari terakhir</p>
        </div>
        
        <div style="position: relative; height: 320px; width: 100%;">
            <canvas id="analyticsChart"></canvas>
        </div>
    </div>

    <!-- Riwayat Aktivitas Diagnosa Terbaru -->
    <div class="dashboard-panel">
        <div class="panel-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="panel-title">Riwayat Diagnosa Terbaru</h5>
                <p class="panel-subtitle">5 rekaman konsultasi sapi terbaru di dalam database</p>
            </div>
            @if(Route::has('diagnosa.riwayat'))
                <a href="{{ route('diagnosa.riwayat') }}" class="btn btn-sm btn-outline-success" style="border-radius: 10px; font-weight: 600;">Lihat Semua</a>
            @endif
        </div>

        @if($recentKonsultasi->isEmpty())
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <div>
                    <h6 class="fw-bold mb-1" style="color: #0f172a;">Belum Ada Data Diagnosa</h6>
                    <p class="small m-0 text-muted">Aktivitas diagnosis/konsultasi peternak belum tercatat di database.</p>
                </div>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table">
                    <thead>
                        <tr>
                            <th>Pemilik</th>
                            <th>Nama Sapi</th>
                            <th>Penyakit Terdeteksi</th>
                            <th>Nilai Keyakinan</th>
                            <th>Tanggal Periksa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentKonsultasi as $item)
                            <tr>
                                <td class="text-semibold">{{ $item->nama_pemilik }}</td>
                                <td>{{ $item->nama_ternak }}</td>
                                <td>
                                    @if($item->penyakit)
                                        <span class="text-danger text-semibold">{{ $item->penyakit->nama_penyakit }}</span>
                                    @else
                                        <span class="text-success text-semibold">Sehat / Tidak Terdeteksi</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->penyakit)
                                        <div class="custom-badge badge-warning">
                                            <span>{{ number_format($item->nilai_keyakinan * 1, 2) }}% Keyakinan</span>
                                        </div>
                                    @else
                                        <div class="custom-badge badge-success">
                                            <span>100% Sehat</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $item->tanggal_periksa ? $item->tanggal_periksa->format('d M Y, H:i') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        
        // Efek gradasi warna halus di bawah garis kurva
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.22)'); 
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0.00)'); 

        // Mengambil data dinamis riil dari Controller
        const labelsData = {!! json_encode($chartLabels) !!};
        const lineData = {!! json_encode($chartValues) !!}; 

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Kasus Terdiagnosa',
                    data: lineData,
                    borderColor: '#10b981', 
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2.5,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.38, 
                    fill: true,
                    backgroundColor: gradient
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a', 
                        titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: '600' },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#64748b' }
                    },
                    y: {
                        grid: { color: '#f1f5f9' },
                        ticks: { 
                            font: { family: 'Plus Jakarta Sans', size: 11 }, 
                            color: '#64748b',
                            stepSize: 1,
                            beginAtZero: true
                        },
                        border: { dash: [5, 5] }
                    }
                }
            }
        });
    });

        @if(session('success'))
            showCustomToast(ICON_SUCCESS, 'Berhasil', '{{ session('success') }}', 3500, '#10b981');
        @endif

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        @endif

</script>
@endsection