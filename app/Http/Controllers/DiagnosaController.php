<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Konsultasi;
use App\Models\KonsultasiDetail;
use App\Models\Penyakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ╔══════════════════════════════════════════════════════════════════════════╗
 * ║    SISTEM PAKAR DIAGNOSA PENYAKIT SAPI — FORWARD CHAINING + FUZZY CF     ║
 * ║    PERBAIKAN:                                                             ║
 * ║    1. Forward Chaining dengan Agenda Cycle (siap untuk rantai aturan)     ║
 * ║    2. Threshold µ minimal (0.1) untuk mengurangi noise                    ║
 * ║    3. Fallback hanya jika tidak ada aturan terpenuhi                      ║
 * ║    4. Proteksi division by zero                                           ║
 * ║    5. Akurasi ditingkatkan dengan penalti proporsional                    ║
 * ╚══════════════════════════════════════════════════════════════════════════╝
 */
class DiagnosaController extends Controller
{
    private const CF_MINIMUM = 0.10;         // Ambang batas keyakinan minimum
    private const MAX_KANDIDAT = 5;          // Maksimal kandidat penyakit
    private const MU_THRESHOLD = 0.10;       // Gejala dengan μ < threshold diabaikan
    private const FALLBACK_PROPORTION = 0.30; // Minimal 30% bobot rule harus terpenuhi untuk fallback

    public function index()
    {
        $gejalaList     = Gejala::orderBy('kode_gejala')->get();
        $hasilDiagnosa  = session('hasilDiagnosa');
        $selectedGejala = session('selectedGejala', []);

        return view('diagnosa.index', compact('gejalaList', 'hasilDiagnosa', 'selectedGejala'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'nama_pemilik'    => 'required|string|max:100',
            'nama_ternak'     => 'required|string|max:50',
            'gejala'          => 'required|array|min:1',
            'gejala.*.nilai'  => 'required|numeric|min:0|max:1',
        ]);

        // Filter gejala dengan nilai > 0
        $activeGejala = [];
        foreach ($request->input('gejala') as $item) {
            $id    = (int) ($item['id'] ?? 0);
            $nilai = (float) ($item['nilai'] ?? 0.0);
            if ($id > 0 && $nilai > self::MU_THRESHOLD) {
                $activeGejala[$id] = $nilai;
            }
        }

        if (empty($activeGejala)) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu gejala dengan nilai keyakinan > ' . self::MU_THRESHOLD . '.');
        }

        // Proses diagnosa dengan forward chaining
        $hasilDiagnosa = $this->forwardChainingDiagnosa($activeGejala);

        // Simpan ke database
        $this->simpanKonsultasi($request, $hasilDiagnosa, $activeGejala);

        if (empty($hasilDiagnosa)) {
            return redirect()->route('diagnosa.index')->with([
                'selectedGejala' => $request->input('gejala'),
                'error'          => 'Tidak ada penyakit yang terdeteksi. Gejala yang dipilih mungkin terlalu umum atau tidak cukup spesifik.',
            ]);
        }

        return redirect()->route('diagnosa.index')->with([
            'hasilDiagnosa'  => $hasilDiagnosa,
            'selectedGejala' => $request->input('gejala'),
            'nama_pemilik'   => $request->nama_pemilik,
            'nama_ternak'    => $request->nama_ternak,
            'success'        => 'Analisis selesai. Ditemukan ' . count($hasilDiagnosa) . ' kandidat penyakit.',
        ]);
    }

    /**
     * FORWARD CHAINING DENGAN AGENDA CYCLE
     * Fakta awal (gejala) → evaluasi semua aturan → kumpulkan CF per penyakit
     * (Jika ada aturan yang menghasilkan fakta baru, bisa ditambahkan ke agenda, 
     * namun untuk kasus ini langsung ke penyakit)
     */
    private function forwardChainingDiagnosa(array $gejalaInput): array
    {
        // Agenda: daftar fakta yang diketahui (gejala dengan μ)
        $workingMemory = $gejalaInput; // [gejala_id => μ]
        
        // Hasil sementara untuk setiap penyakit
        $penyakitCF = []; // [penyakit_id => cf_combined]
        $detailPerPenyakit = [];

        // Ambil semua aturan yang terdefinisi
        $penyakitList = Penyakit::with(['rules.ruleDetails.gejala'])->get();

        // Untuk setiap penyakit, evaluasi semua aturannya
        foreach ($penyakitList as $penyakit) {
            $cfRuleList = [];
            $detailRules = [];

            foreach ($penyakit->rules as $rule) {
                $cfRule = $this->evaluasiRule($rule, $workingMemory);
                if ($cfRule !== null) {
                    $cfRuleList[] = $cfRule;
                    $detailRules[] = [
                        'kode_rule' => $rule->kode_rule,
                        'cf_rule'   => round($cfRule, 4),
                    ];
                }
            }

            if (empty($cfRuleList)) {
                // Tidak ada aturan yang terpenuhi sama sekali → coba fallback
                $fallbackResult = $this->evaluasiFallback($penyakit, $workingMemory);
                if ($fallbackResult !== null) {
                    $cfRuleList = [$fallbackResult['cf']];
                    $detailRules = $fallbackResult['detail'];
                }
            }

            if (!empty($cfRuleList)) {
                // Kombinasi CF menggunakan rumus MYCIN (akumulasi bukti)
                $cfCombined = $this->kombinasiCF($cfRuleList);
                if ($cfCombined >= self::CF_MINIMUM) {
                    $penyakitCF[$penyakit->id] = $cfCombined;
                    $detailPerPenyakit[$penyakit->id] = $detailRules;
                }
            }
        }

        // Urutkan berdasarkan CF tertinggi
        arsort($penyakitCF);

        // Format hasil
        $hasil = [];
        $count = 0;
        foreach ($penyakitCF as $penyakitId => $cf) {
            if ($count >= self::MAX_KANDIDAT) break;
            $penyakit = $penyakitList->firstWhere('id', $penyakitId);
            if ($penyakit) {
                $hasil[] = [
                    'penyakit_id'        => $penyakit->id,
                    'kode_penyakit'      => $penyakit->kode_penyakit,
                    'nama_penyakit'      => $penyakit->nama_penyakit,
                    'definisi'           => $penyakit->definisi,
                    'saran_penanganan'   => $penyakit->saran_penanganan,
                    'skor'               => $cf,
                    'keyakinan'          => round($cf * 100, 2),
                    'kategori_keyakinan' => $this->kategoriKeyakinan($cf * 100),
                    'detail_calc'        => $detailPerPenyakit[$penyakitId] ?? [],
                ];
            }
            $count++;
        }

        return $hasil;
    }

    /**
     * Evaluasi satu rule: hitung CF rule berdasarkan gejala yang terpenuhi.
     * 
     * @return float|null CF rule (0..1) atau null jika tidak ada gejala yang terpenuhi.
     */
    private function evaluasiRule($rule, array $workingMemory): ?float
    {
        $sumMuBobot = 0.0;
        $totalBobot = 0.0;
        $gejalaTerpenuhi = false;

        foreach ($rule->ruleDetails as $detail) {
            $gejalaId = (int) $detail->gejala_id;
            $bobot = (float) $detail->bobot;
            $totalBobot += $bobot;

            $crispValue = $workingMemory[$gejalaId] ?? 0.0;
            if ($crispValue > 0) {
                $gejalaTerpenuhi = true;
                $mu = $this->fuzzifikasi($crispValue, $detail->gejala);
                // Threshold: jika μ < MU_THRESHOLD, anggap tidak berkontribusi
                if ($mu >= self::MU_THRESHOLD) {
                    $sumMuBobot += $mu * $bobot;
                }
            }
        }

        if (!$gejalaTerpenuhi || $totalBobot == 0) {
            return null;
        }

        // CF rule = (total kontribusi berbobot) / (total bobot rule)
        // Ini memberikan penalti proporsional untuk gejala yang tidak terisi
        $cfRule = $sumMuBobot / $totalBobot;
        
        // Pastikan dalam rentang 0-1
        return min(max($cfRule, 0.0), 1.0);
    }

    /**
     * Fallback untuk kasus tidak ada aturan yang terpenuhi.
     * Hanya diaktifkan jika proporsi bobot gejala yang cocok >= FALLBACK_PROPORTION.
     */
    private function evaluasiFallback($penyakit, array $workingMemory): ?array
    {
        $bestCf = 0.0;
        $bestDetail = [];

        foreach ($penyakit->rules as $rule) {
            $matchedBobot = 0.0;
            $totalBobot = 0.0;
            $sumMuBobot = 0.0;
            $ruleDetail = [];

            foreach ($rule->ruleDetails as $detail) {
                $gejalaId = (int) $detail->gejala_id;
                $bobot = (float) $detail->bobot;
                $totalBobot += $bobot;

                $crispValue = $workingMemory[$gejalaId] ?? 0.0;
                if ($crispValue > 0) {
                    $mu = $this->fuzzifikasi($crispValue, $detail->gejala);
                    if ($mu >= self::MU_THRESHOLD) {
                        $matchedBobot += $bobot;
                        $sumMuBobot += $mu * $bobot;
                        $ruleDetail[] = [
                            'gejala_id'   => $gejalaId,
                            'nama_gejala' => $detail->gejala->nama_gejala,
                            'mu'          => round($mu, 4),
                            'bobot'       => $bobot,
                        ];
                    }
                }
            }

            if ($totalBobot > 0) {
                $proporsi = $matchedBobot / $totalBobot;
                if ($proporsi >= self::FALLBACK_PROPORTION) {
                    // CF fallback lebih rendah dari CF normal (diberi faktor 0.6 karena hanya parsial)
                    $cf = ($sumMuBobot / $totalBobot) * 0.6;
                    if ($cf > $bestCf) {
                        $bestCf = $cf;
                        $bestDetail = [[
                            'kode_rule' => $rule->kode_rule . '_FALLBACK',
                            'cf_rule'   => round($cf, 4),
                            'gejala'    => $ruleDetail,
                        ]];
                    }
                }
            }
        }

        if ($bestCf >= self::CF_MINIMUM) {
            return ['cf' => $bestCf, 'detail' => $bestDetail];
        }
        return null;
    }

    /**
     * Kombinasi beberapa CF menggunakan rumus MYCIN:
     * CF_combined = CF1 + CF2 * (1 - CF1)
     */
    private function kombinasiCF(array $cfList): float
    {
        $result = 0.0;
        foreach ($cfList as $cf) {
            $result = $result + $cf * (1 - $result);
        }
        return min(max($result, 0.0), 1.0);
    }

    /**
     * Fuzzifikasi nilai crisp (0-1) ke derajat keanggotaan berdasarkan parameter fuzzy.
     * Mendukung bentuk trapesium dan segitiga.
     */
    private function fuzzifikasi(float $x, $gejala): float
    {
        // Jika x di bawah threshold, langsung 0 (di luar kurva)
        if ($x <= 0.0) return 0.0;

        $a = (float) ($gejala->fuzzy_a ?? 0.0);
        $b = (float) ($gejala->fuzzy_b ?? 0.0);
        $c = (float) ($gejala->fuzzy_c ?? 0.0);
        $d = (float) ($gejala->fuzzy_d ?? 0.0);

        // Proteksi: jika nilai a,b,c,d tidak valid (misal semua 0), gunakan fungsi linear sederhana
        if ($a == 0 && $b == 0 && $c == 0 && $d == 0) {
            // default: keanggotaan linear naik dari 0 di x=0 ke 1 di x=1
            return min(max($x, 0.0), 1.0);
        }

        // Kasus trapesium (d > c)
        if ($d > $c) {
            if ($x <= $a || $x >= $d) return 0.0;
            if ($x >= $b && $x <= $c) return 1.0;
            if ($x > $a && $x < $b) {
                $range = $b - $a;
                return $range > 0 ? ($x - $a) / $range : 1.0;
            }
            if ($x > $c && $x < $d) {
                $range = $d - $c;
                return $range > 0 ? ($d - $x) / $range : 1.0;
            }
            return 0.0;
        }

        // Kasus segitiga
        return $this->fuzzifikasiSegitiga($x, $a, $b, $c);
    }

    private function fuzzifikasiSegitiga(float $x, float $a, float $b, float $c): float
    {
        if ($x <= $a || $x >= $c) return 0.0;
        if ($x == $b) return 1.0;

        if ($x > $a && $x < $b) {
            $range = $b - $a;
            return $range > 0 ? ($x - $a) / $range : 1.0;
        }
        if ($x > $b && $x < $c) {
            $range = $c - $b;
            return $range > 0 ? ($c - $x) / $range : 1.0;
        }
        return 0.0;
    }

    private function kategoriKeyakinan(float $nilai): string
    {
        if ($nilai >= 90) return 'Sangat Yakin';
        if ($nilai >= 70) return 'Yakin';
        if ($nilai >= 50) return 'Cukup Yakin';
        if ($nilai >= 30) return 'Kurang Yakin';
        return 'Tidak Yakin';
    }

    private function simpanKonsultasi(Request $request, array $hasilDiagnosa, array $activeGejala): void
    {
        DB::beginTransaction();
        try {
            $konsultasi = Konsultasi::create([
                'nama_pemilik'    => $request->nama_pemilik,
                'nama_ternak'     => $request->nama_ternak,
                'tanggal_periksa' => now(),
                'penyakit_id'     => !empty($hasilDiagnosa) ? $hasilDiagnosa[0]['penyakit_id'] : null,
                'nilai_keyakinan' => !empty($hasilDiagnosa) ? $hasilDiagnosa[0]['keyakinan'] : 0.0,
            ]);

            foreach ($activeGejala as $gejalaId => $nilai) {
                KonsultasiDetail::create([
                    'konsultasi_id' => $konsultasi->id,
                    'gejala_id'     => $gejalaId,
                    'nilai_crisp'   => $nilai,
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('DiagnosaController@simpanKonsultasi gagal: ' . $e->getMessage());
        }
    }

    public function riwayat()
    {
        $riwayat = Konsultasi::with(['penyakit', 'konsultasiDetails.gejala'])
            ->orderBy('tanggal_periksa', 'desc')
            ->paginate(10);
        return view('diagnosa.riwayat', compact('riwayat'));
    }

    public function detail($id)
    {
        $konsultasi = Konsultasi::with(['penyakit', 'konsultasiDetails.gejala'])
            ->findOrFail($id);
        return view('diagnosa.detail', compact('konsultasi'));
    }

    public function reset()
    {
        session()->forget(['hasilDiagnosa', 'selectedGejala', 'nama_pemilik', 'nama_ternak']);
        return redirect()->route('diagnosa.index')->with('success', 'Session direset.');
    }
}