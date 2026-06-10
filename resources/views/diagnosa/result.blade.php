@extends('partials.app-layout')

@section('title', 'Hasil Diagnosa - ' . ($konsultasi->penyakit->nama_penyakit ?? 'Tidak Terdeteksi'))

@section('content')

{{-- ─────────────────────────────────────────────────────────────────────────
     HALAMAN HASIL DIAGNOSA
     Ditampilkan setelah redirect dari DiagnosaController@prosesDiagnosa (PRG).
     Route: diagnosa.result  →  showResult(Konsultasi $konsultasi)
     ───────────────────────────────────────────────────────────────────────── --}}

<div class="result-wrap">

    {{-- ── Navigasi balik ─────────────────────────────────────────────────── --}}
    <div class="result-nav">
        <a href="{{ route('diagnosa.index') }}" class="result-back">
            <i class="bi bi-arrow-left"></i>
            Diagnosa Baru
        </a>
        <a href="{{ route('diagnosa.riwayat') }}" class="result-back">
            <i class="bi bi-clock-history"></i>
            Riwayat
        </a>
    </div>

    {{-- ── Hero: identitas konsultasi ───────────────────────────────────── --}}
    <div class="result-hero {{ $konsultasi->penyakit ? 'result-hero--found' : 'result-hero--notfound' }}">
        <div class="result-hero__meta">
            <span class="result-hero__id">#{{ str_pad($konsultasi->id, 5, '0', STR_PAD_LEFT) }}</span>
            <span class="result-hero__date">{{ $konsultasi->created_at->format('d M Y, H:i') }} WIB</span>
        </div>
        <div class="result-hero__owner">
            <i class="bi bi-person-fill"></i> {{ $konsultasi->nama_pemilik }}
            <span class="result-hero__divider">·</span>
            <i class="bi bi-tag-fill"></i> {{ $konsultasi->nama_ternak }}
        </div>

        @if($konsultasi->penyakit)

            {{-- ── Penyakit terdeteksi ──────────────────────────────────── --}}
            <div class="result-diagnosis">
                <div class="result-diagnosis__score-wrap">
                    <svg viewBox="0 0 120 120" class="result-dial">
                        <circle cx="60" cy="60" r="50" fill="none" stroke="rgba(255,255,255,.15)" stroke-width="10"/>
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#fff" stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="{{ round($konsultasi->nilai_keyakinan / 100 * 314.16, 2) }} 314.16"
                                transform="rotate(-90 60 60)"/>
                        <text x="60" y="55" text-anchor="middle" font-size="22" font-weight="800" fill="#fff">{{ $konsultasi->nilai_keyakinan }}%</text>
                        <text x="60" y="74" text-anchor="middle" font-size="9" fill="rgba(255,255,255,.7)" font-weight="600" letter-spacing="1">KEYAKINAN</text>
                    </svg>
                </div>
                <div class="result-diagnosis__info">
                    <div class="result-diagnosis__badge">Penyakit Terdeteksi</div>
                    <h1 class="result-diagnosis__name">{{ $konsultasi->penyakit->nama_penyakit }}</h1>
                    @if($konsultasi->penyakit->kode_penyakit ?? null)
                        <span class="result-diagnosis__code">{{ $konsultasi->penyakit->kode_penyakit }}</span>
                    @endif
                    <p class="result-diagnosis__definisi">{{ $konsultasi->penyakit->definisi }}</p>
                </div>
            </div>

        @else

            {{-- ── Tidak terdeteksi ────────────────────────────────────── --}}
            <div class="result-notfound">
                <div class="result-notfound__icon">⚠️</div>
                <div>
                    <h2 class="result-notfound__title">Penyakit Tidak Terdeteksi</h2>
                    <p class="result-notfound__desc">
                        Berdasarkan nilai gejala yang diinput, sistem tidak menemukan kecocokan yang signifikan
                        dengan basis aturan yang ada. Nilai keyakinan: <strong>{{ $konsultasi->nilai_keyakinan }}%</strong>.
                    </p>
                    <p class="result-notfound__desc" style="opacity:.7;font-size:.82rem;margin:0">
                        Disarankan untuk melakukan konsultasi langsung dengan dokter hewan.
                    </p>
                </div>
            </div>

        @endif
    </div>

    {{-- ── Body: saran + inferensi ─────────────────────────────────────── --}}
    <div class="result-body">

        {{-- ── Kolom Kiri ─────────────────────────────────────────────── --}}
        <div class="result-col">

            @if($konsultasi->penyakit && $konsultasi->penyakit->saran_penanganan)
            <div class="result-card">
                <h3 class="result-card__title">
                    <i class="bi bi-heart-pulse-fill text-success"></i>
                    Rekomendasi Penanganan
                </h3>
                <div class="result-saran">
                    {{ $konsultasi->penyakit->saran_penanganan }}
                </div>
            </div>
            @endif

            {{-- Ringkasan skor fuzzy per gejala --}}
            <div class="result-card">
                <h3 class="result-card__title">
                    <i class="bi bi-bar-chart-fill text-primary"></i>
                    Nilai Input Gejala
                </h3>
                <div class="result-table-wrap">
                    <table class="result-table">
                        <thead>
                            <tr>
                                <th>Gejala</th>
                                <th class="text-center">Nilai Crisp</th>
                                <th>Intensitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($konsultasi->details->sortByDesc('nilai_crisp') as $d)
                            <tr class="{{ $d->nilai_crisp > 0 ? 'result-table__row--active' : '' }}">
                                <td>
                                    <span class="result-table__kode">{{ $d->gejala->kode_gejala ?? '—' }}</span>
                                    {{ $d->gejala->nama_gejala ?? 'Gejala tidak ditemukan' }}
                                </td>
                                <td class="text-center">
                                    <span class="result-badge {{ $d->nilai_crisp == 0 ? 'result-badge--zero' : ($d->nilai_crisp <= 30 ? 'result-badge--low' : ($d->nilai_crisp <= 70 ? 'result-badge--mid' : 'result-badge--high')) }}">
                                        {{ number_format($d->nilai_crisp, 1) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="result-mini-bar">
                                        <div class="result-mini-bar__fill {{ $d->nilai_crisp == 0 ? '' : ($d->nilai_crisp <= 30 ? 'low' : ($d->nilai_crisp <= 70 ? 'mid' : 'high')) }}"
                                             style="width: {{ min($d->nilai_crisp, 100) }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    Tidak ada data detail gejala.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- ── Kolom Kanan: Transparansi Inferensi ──────────────────────── --}}
        <div class="result-col">

            <div class="result-card">
                <h3 class="result-card__title">
                    <i class="bi bi-cpu-fill text-warning"></i>
                    Transparansi Inferensi Fuzzy
                </h3>
                <div class="result-inference">

                    {{-- Langkah 1 --}}
                    <div class="result-inference__step">
                        <div class="result-inference__step-head">
                            <span class="result-inference__step-num">1</span>
                            <span class="result-inference__step-title">Fuzzifikasi</span>
                        </div>
                        <p class="result-inference__step-desc">
                            Setiap nilai crisp dikonversi ke derajat keanggotaan μ ∈ [0,1]
                            menggunakan fungsi segitiga atau trapesium sesuai parameter
                            (a, b, c) atau (a, b, c, d) masing-masing gejala.
                        </p>
                    </div>

                    {{-- Langkah 2 --}}
                    <div class="result-inference__step">
                        <div class="result-inference__step-head">
                            <span class="result-inference__step-num">2</span>
                            <span class="result-inference__step-title">Evaluasi Rule (AND → MIN)</span>
                        </div>
                        <p class="result-inference__step-desc">
                            Forward chaining mencocokkan gejala ke setiap rule dalam basis aturan.
                            Kekuatan rule dihitung sebagai:
                        </p>
                        <div class="result-formula">
                            α<sub>rule</sub> = MIN(μ<sub>g1</sub>, μ<sub>g2</sub>, ..., μ<sub>gn</sub>)
                        </div>
                    </div>

                    {{-- Langkah 3 --}}
                    <div class="result-inference__step">
                        <div class="result-inference__step-head">
                            <span class="result-inference__step-num">3</span>
                            <span class="result-inference__step-title">Agregasi (MAX)</span>
                        </div>
                        <p class="result-inference__step-desc">
                            Skor tiap penyakit dihitung dari nilai MAX semua rule yang mengarah ke penyakit tersebut:
                        </p>
                        <div class="result-formula">
                            Skor<sub>penyakit</sub> = MAX(α<sub>rule1</sub>, α<sub>rule2</sub>, ...)
                        </div>
                    </div>

                    {{-- Langkah 4 --}}
                    <div class="result-inference__step">
                        <div class="result-inference__step-head">
                            <span class="result-inference__step-num">4</span>
                            <span class="result-inference__step-title">Keputusan</span>
                        </div>
                        <p class="result-inference__step-desc">
                            Penyakit dengan skor tertinggi dipilih sebagai hasil diagnosa.
                            Nilai keyakinan = skor × 100%.
                        </p>
                        <div class="result-inference__result-box {{ $konsultasi->penyakit ? '' : 'result-inference__result-box--empty' }}">
                            @if($konsultasi->penyakit)
                                <div class="result-inference__result-label">Hasil:</div>
                                <div class="result-inference__result-value">{{ $konsultasi->penyakit->nama_penyakit }}</div>
                                <div class="result-inference__result-score">{{ $konsultasi->nilai_keyakinan }}% keyakinan</div>
                            @else
                                <div class="result-inference__result-value" style="color:#9ca3af">Tidak ada penyakit dengan skor &gt; 0</div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            {{-- Tombol aksi --}}
            <div class="result-actions">
                <a href="{{ route('diagnosa.index') }}" class="result-action-btn result-action-btn--primary">
                    <i class="bi bi-plus-circle"></i>
                    Diagnosa Baru
                </a>
                <button onclick="window.print()" class="result-action-btn result-action-btn--ghost">
                    <i class="bi bi-printer"></i>
                    Cetak
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════════════
     STYLES
     ═══════════════════════════════════════════════════════════════════════════ --}}
<style>
*, *::before, *::after { box-sizing: border-box; }

.result-wrap {
    max-width: 1280px;
    margin: 0 auto;
    padding: 2rem 1.5rem 4rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
}

/* ── Nav ────────────────────────────────────────────────────────────────────── */
.result-nav { display: flex; gap: .75rem; margin-bottom: 1.5rem; }
.result-back {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .82rem;
    font-weight: 600;
    color: #374151;
    text-decoration: none;
    background: #f3f4f6;
    padding: .45rem .9rem;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    transition: background .15s;
}
.result-back:hover { background: #e5e7eb; color: #111; }

/* ── Hero ────────────────────────────────────────────────────────────────────── */
.result-hero {
    border-radius: 20px;
    padding: 2rem 2.5rem;
    margin-bottom: 1.75rem;
    color: #fff;
}
.result-hero--found    { background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 60%, #43a047 100%); }
.result-hero--notfound { background: linear-gradient(135deg, #78350f 0%, #92400e 60%, #b45309 100%); }

.result-hero__meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: .5rem;
    font-size: .75rem;
    opacity: .7;
}
.result-hero__id { font-weight: 700; font-family: monospace; }
.result-hero__owner {
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: .9rem;
    opacity: .85;
    margin-bottom: 1.5rem;
}
.result-hero__divider { opacity: .4; }

/* ── Diagnosis area ─────────────────────────────────────────────────────────── */
.result-diagnosis {
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}
.result-dial { width: 120px; height: 120px; flex-shrink: 0; }
.result-diagnosis__badge {
    display: inline-block;
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    background: rgba(255,255,255,.2);
    padding: .25rem .7rem;
    border-radius: 20px;
    margin-bottom: .5rem;
}
.result-diagnosis__name {
    font-size: clamp(1.4rem, 2.5vw, 2rem);
    font-weight: 800;
    margin: 0 0 .35rem;
    line-height: 1.15;
}
.result-diagnosis__code {
    font-size: .75rem;
    font-family: monospace;
    background: rgba(255,255,255,.2);
    padding: .2rem .6rem;
    border-radius: 6px;
    margin-bottom: .6rem;
    display: inline-block;
}
.result-diagnosis__definisi {
    font-size: .85rem;
    opacity: .8;
    line-height: 1.6;
    margin: .5rem 0 0;
    max-width: 600px;
}

/* ── Not found ──────────────────────────────────────────────────────────────── */
.result-notfound { display: flex; align-items: flex-start; gap: 1.5rem; }
.result-notfound__icon { font-size: 2.5rem; flex-shrink: 0; line-height: 1; }
.result-notfound__title { font-size: 1.5rem; font-weight: 700; margin: 0 0 .5rem; }
.result-notfound__desc  { font-size: .88rem; opacity: .8; margin: 0 0 .5rem; line-height: 1.6; }

/* ── Body grid ──────────────────────────────────────────────────────────────── */
.result-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    align-items: start;
}
@media (max-width: 900px) { .result-body { grid-template-columns: 1fr; } }
.result-col { display: flex; flex-direction: column; gap: 1.25rem; }

/* ── Cards ──────────────────────────────────────────────────────────────────── */
.result-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 1.5rem;
}
.result-card__title {
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: .78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .1em;
    color: #374151;
    margin: 0 0 1.25rem;
    padding-bottom: .75rem;
    border-bottom: 1px solid #f3f4f6;
}

/* ── Saran ──────────────────────────────────────────────────────────────────── */
.result-saran {
    font-size: .88rem;
    color: #374151;
    line-height: 1.75;
    white-space: pre-line;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 1rem 1.25rem;
}

/* ── Table ──────────────────────────────────────────────────────────────────── */
.result-table-wrap { overflow-x: auto; }
.result-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .82rem;
}
.result-table th {
    text-align: left;
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #9ca3af;
    padding: .4rem .75rem .6rem;
    border-bottom: 1px solid #e5e7eb;
}
.result-table td {
    padding: .55rem .75rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}
.result-table__row--active td { color: #111; }
.result-table tr:last-child td { border-bottom: none; }
.result-table__kode {
    font-size: .65rem;
    font-weight: 700;
    font-family: monospace;
    background: #f3f4f6;
    color: #6b7280;
    padding: .15rem .4rem;
    border-radius: 5px;
    margin-right: .4rem;
}

/* ── Badges ─────────────────────────────────────────────────────────────────── */
.result-badge {
    display: inline-block;
    font-size: .75rem;
    font-weight: 700;
    padding: .2rem .55rem;
    border-radius: 6px;
    font-variant-numeric: tabular-nums;
}
.result-badge--zero { background: #f3f4f6; color: #9ca3af; }
.result-badge--low  { background: #fef9c3; color: #92400e; }
.result-badge--mid  { background: #ffedd5; color: #c2410c; }
.result-badge--high { background: #fee2e2; color: #991b1b; }

/* ── Mini bar ────────────────────────────────────────────────────────────────── */
.result-mini-bar {
    height: 5px;
    background: #f3f4f6;
    border-radius: 99px;
    overflow: hidden;
    min-width: 60px;
}
.result-mini-bar__fill {
    height: 100%;
    border-radius: 99px;
    background: #d1d5db;
    transition: width .3s;
}
.result-mini-bar__fill.low  { background: #facc15; }
.result-mini-bar__fill.mid  { background: #f97316; }
.result-mini-bar__fill.high { background: #ef4444; }

/* ── Inference steps ─────────────────────────────────────────────────────────── */
.result-inference { display: flex; flex-direction: column; gap: 1.1rem; }
.result-inference__step {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1rem 1.1rem;
    border-left: 3px solid #e5e7eb;
}
.result-inference__step-head {
    display: flex;
    align-items: center;
    gap: .6rem;
    margin-bottom: .5rem;
}
.result-inference__step-num {
    width: 22px;
    height: 22px;
    border-radius: 6px;
    background: #374151;
    color: #fff;
    font-size: .7rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.result-inference__step-title { font-size: .82rem; font-weight: 700; color: #111; }
.result-inference__step-desc  { font-size: .78rem; color: #6b7280; margin: 0; line-height: 1.5; }
.result-formula {
    margin-top: .5rem;
    background: #1e293b;
    color: #7dd3fc;
    font-family: 'Courier New', monospace;
    font-size: .78rem;
    padding: .5rem .9rem;
    border-radius: 8px;
}
.result-inference__result-box {
    margin-top: .75rem;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: .75rem 1rem;
}
.result-inference__result-box--empty {
    background: #fef9c3;
    border-color: #fde047;
}
.result-inference__result-label { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #6b7280; margin-bottom: .2rem; }
.result-inference__result-value { font-size: 1rem; font-weight: 700; color: #111; }
.result-inference__result-score { font-size: .75rem; color: #2e7d32; font-weight: 600; margin-top: .2rem; }

/* ── Actions ─────────────────────────────────────────────────────────────────── */
.result-actions { display: flex; gap: .75rem; flex-wrap: wrap; }
.result-action-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .7rem 1.25rem;
    border-radius: 10px;
    font-size: .85rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: all .18s;
}
.result-action-btn--primary { background: #1b5e20; color: #fff; }
.result-action-btn--primary:hover { background: #2e7d32; color: #fff; transform: translateY(-1px); }
.result-action-btn--ghost { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
.result-action-btn--ghost:hover { background: #e5e7eb; }

/* ── Print ──────────────────────────────────────────────────────────────────── */
@media print {
    .result-nav, .result-actions { display: none; }
    .result-hero { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
}
</style>

@endsection