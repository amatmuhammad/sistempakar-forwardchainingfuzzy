<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Konsultasi;
use App\Models\KonsultasiDetail;
use App\Models\Penyakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiagnosaController extends Controller
{
    // Threshold α minimum untuk menampilkan hasil
    private const CF_MINIMUM = 0.1;
    private const MAX_KANDIDAT = 5;
    private const MU_THRESHOLD = 0.10;
    private const FALLBACK_PROPORTION = 0.20;

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

        // Proses diagnosa dengan forward chaining fuzzy
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
     * FORWARD CHAINING + MAXIMUM MEMBERSHIP (SESUAI CONTOH JURNAL)
     */
    private function forwardChainingDiagnosa(array $gejalaInput): array
    {
        $workingMemory = $gejalaInput;
        $agenda = array_keys($workingMemory);
        $processedFacts = [];
        $penyakitRulesFired = [];

        $maxIterations = 20;
        $iteration = 0;

        while (!empty($agenda) && $iteration < $maxIterations) {
            $iteration++;
            $currentFactId = array_shift($agenda);
            if (in_array($currentFactId, $processedFacts)) {
                continue;
            }
            $processedFacts[] = $currentFactId;

            $relatedRules = \App\Models\Rule::whereHas('ruleDetails', function($q) use ($currentFactId) {
                $q->where('gejala_id', $currentFactId);
            })->with(['ruleDetails.gejala', 'penyakit'])->get();

            foreach ($relatedRules as $rule) {
                $result = $this->evaluasiRuleFuzzy($rule, $workingMemory);
                if ($result !== null && $result['alpha'] > 0) {
                    $penyakitId = $rule->penyakit_id;
                    if (!isset($penyakitRulesFired[$penyakitId])) {
                        $penyakitRulesFired[$penyakitId] = [
                            'penyakit'     => $rule->penyakit,
                            'aturan_fired' => [],
                        ];
                    }

                    $alreadyFired = false;
                    foreach ($penyakitRulesFired[$penyakitId]['aturan_fired'] as $fired) {
                        if ($fired['rule']->id === $rule->id) {
                            $alreadyFired = true;
                            break;
                        }
                    }

                    if (!$alreadyFired) {
                        $penyakitRulesFired[$penyakitId]['aturan_fired'][] = [
                            'rule'   => $rule,
                            'alpha'  => $result['alpha'],
                            'output' => $result['output'],
                            'detail' => $result['detail'],
                        ];
                    }
                }
            }
        }

        // Fallback jika tidak ada aturan fired
        if (empty($penyakitRulesFired)) {
            $fallbackResults = $this->evaluasiFallbackFuzzy($gejalaInput);
            if (!empty($fallbackResults)) {
                $penyakitRulesFired = $fallbackResults;
            }
        }

        // ===== POST-PROCESSING: MAXIMUM MEMBERSHIP =====
        $hasilAkhir = [];

        foreach ($penyakitRulesFired as $penyakitId => $data) {
            if (empty($data['aturan_fired'])) continue;

            // Kumpulkan alpha maksimum per label
            $labelMax = [
                'Tidak Yakin'  => 0.0,
                'Yakin'        => 0.0,
                'Sangat Yakin' => 0.0,
            ];
            foreach ($data['aturan_fired'] as $fired) {
                $label = $fired['rule']->kondisi_fuzzy;
                $alpha = $fired['alpha'];
                if ($alpha > $labelMax[$label]) {
                    $labelMax[$label] = $alpha;
                }
            }

            // Cari label dengan alpha tertinggi
            $maxAlpha = max($labelMax);
            if ($maxAlpha < self::CF_MINIMUM) continue;

            $kategori = array_search($maxAlpha, $labelMax);

            // Detail aturan
            $detailRules = [];
            foreach ($data['aturan_fired'] as $fired) {
                $detailRules[] = [
                    'kode_rule'      => $fired['rule']->kode_rule,
                    'kondisi_fuzzy'  => $fired['rule']->kondisi_fuzzy,
                    'alpha_predikat' => round($fired['alpha'], 4),
                    'gejala_fired'   => $fired['detail'],
                ];
            }

            $hasilAkhir[$penyakitId] = [
                'kategori'      => $kategori,
                'max_alpha'     => $maxAlpha,
                'detail_rules'  => $detailRules,
            ];
        }

        // Urutkan berdasarkan maxAlpha tertinggi
        uasort($hasilAkhir, function($a, $b) {
            return $b['max_alpha'] <=> $a['max_alpha'];
        });

        // ===== FORMAT OUTPUT =====
        $hasil = [];
        $count = 0;
        foreach ($hasilAkhir as $penyakitId => $data) {
            if ($count >= self::MAX_KANDIDAT) break;
            $penyakit  = $penyakitRulesFired[$penyakitId]['penyakit'];
            $maxAlpha  = $data['max_alpha'];
            $kategori  = $data['kategori'];

            $hasil[] = [
                'penyakit_id'        => $penyakit->id,
                'kode_penyakit'      => $penyakit->kode_penyakit,
                'nama_penyakit'      => $penyakit->nama_penyakit,
                'definisi'           => $penyakit->definisi,
                'saran_penanganan'   => $penyakit->saran_penanganan,
                'skor'               => round($maxAlpha, 4),
                'keyakinan'          => round($maxAlpha * 100, 2),
                'kategori_keyakinan' => $kategori,
                'detail_calc'        => $data['detail_rules'],
            ];
            $count++;
        }

        return $hasil;
    }

    /**
     * Evaluasi satu rule (full matching dengan MIN)
     */
    private function evaluasiRuleFuzzy($rule, array $workingMemory): ?array
    {
        $alpha = 1.0;
        $gejalaFired = [];
        $allFilled = true;

        foreach ($rule->ruleDetails as $detail) {
            $gejalaId = (int) $detail->gejala_id;
            $bobot = (float) $detail->bobot;
            $crispValue = $workingMemory[$gejalaId] ?? 0.0;

            if ($crispValue <= 0) {
                $allFilled = false;
                break;
            }

            $mu = $this->fuzzifikasi($crispValue, $detail->gejala);
            if ($mu < self::MU_THRESHOLD) {
                $allFilled = false;
                break;
            }

            $alpha = min($alpha, $mu);
            $gejalaFired[] = [
                'kode_gejala' => $detail->gejala->kode_gejala,
                'nama_gejala' => $detail->gejala->nama_gejala,
                'nilai_crisp' => $crispValue,
                'mu'          => round($mu, 4),
                'bobot'       => $bobot,
            ];
        }

        if (!$allFilled || $alpha <= 0) {
            return null;
        }

        return [
            'alpha' => $alpha,
            'output' => [
                'a' => (float) $rule->output_a,
                'b' => (float) $rule->output_b,
                'c' => (float) $rule->output_c,
                'd' => (float) $rule->output_d,
            ],
            'detail'    => $gejalaFired,
            'new_facts' => null,
        ];
    }

    // ===== FUNGSI-FUNGSI PENDUKUNG =====
    private function fuzzifikasi(float $x, $gejala): float
    {
        if ($x <= 0.0) return 0.0;
        $a = (float) ($gejala->fuzzy_a ?? 0.0);
        $b = (float) ($gejala->fuzzy_b ?? 0.0);
        $c = (float) ($gejala->fuzzy_c ?? 0.0);
        $d = (float) ($gejala->fuzzy_d ?? 0.0);

        if ($a == 0 && $b == 0 && $c == 0 && $d == 0) {
            return min(max($x, 0.0), 1.0);
        }

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

    private function evaluasiFallbackFuzzy(array $gejalaInput): array
    {
        $penyakitList = Penyakit::with(['rules.ruleDetails.gejala'])->get();
        $fallbackResults = [];

        foreach ($penyakitList as $penyakit) {
            $bestAturanFired = [];
            $bestTotalAlpha = 0;

            foreach ($penyakit->rules as $rule) {
                $matchedCount = 0;
                $totalCount = count($rule->ruleDetails);
                $alpha = 1.0;
                $gejalaFired = [];

                foreach ($rule->ruleDetails as $detail) {
                    $gejalaId = (int) $detail->gejala_id;
                    $crispValue = $gejalaInput[$gejalaId] ?? 0.0;

                    if ($crispValue > 0) {
                        $mu = $this->fuzzifikasi($crispValue, $detail->gejala);
                        if ($mu >= self::MU_THRESHOLD) {
                            $matchedCount++;
                            $alpha = min($alpha, $mu);
                            $gejalaFired[] = [
                                'kode_gejala' => $detail->gejala->kode_gejala,
                                'nama_gejala' => $detail->gejala->nama_gejala,
                                'nilai_crisp' => $crispValue,
                                'mu'          => round($mu, 4),
                                'bobot'       => (float) $detail->bobot,
                            ];
                        }
                    }
                }

                $proporsi = $totalCount > 0 ? $matchedCount / $totalCount : 0;
                if ($proporsi >= self::FALLBACK_PROPORTION && $alpha > 0) {
                    $alphaPenalti = $alpha * 0.6;
                    if ($alphaPenalti > $bestTotalAlpha) {
                        $bestTotalAlpha = $alphaPenalti;
                        $bestAturanFired = [[
                            'rule'   => $rule,
                            'alpha'  => $alphaPenalti,
                            'output' => [
                                'a' => (float) $rule->output_a,
                                'b' => (float) $rule->output_b,
                                'c' => (float) $rule->output_c,
                                'd' => (float) $rule->output_d,
                            ],
                            'detail' => $gejalaFired,
                        ]];
                    }
                }
            }

            if (!empty($bestAturanFired)) {
                $fallbackResults[$penyakit->id] = [
                    'penyakit'     => $penyakit,
                    'aturan_fired' => $bestAturanFired,
                ];
            }
        }

        return $fallbackResults;
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

    // Method lain (riwayat, detail, reset) tetap seperti sebelumnya
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