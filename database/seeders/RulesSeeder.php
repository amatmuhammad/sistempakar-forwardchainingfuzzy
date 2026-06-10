<?php
// database/seeders/RulesSeeder.php

namespace Database\Seeders;

use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\Rule;
use App\Models\RuleDetail;
use Illuminate\Database\Seeder;

class RulesSeeder extends Seeder
{
    public function run()
    {
        // ==================== PENYAKIT 1: SEPTICEMIA EPIZOOTICA ====================
        $penyakit1 = Penyakit::where('kode_penyakit', 'P001')->first();
        if ($penyakit1) {
            $rule1 = Rule::create([
                'kode_rule' => 'R001',
                'penyakit_id' => $penyakit1->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G001' => 0.8, // Membengkaknya kulit kepala
                'G002' => 0.7, // Membengkaknya leher, anus, vulva
                'G003' => 0.7, // Selaput lendir usus dan perut masam
                'G004' => 0.8, // Mati dalam 12-36 jam
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule1->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 2: ANTHRAKS ====================
        $penyakit2 = Penyakit::where('kode_penyakit', 'P002')->first();
        if ($penyakit2) {
            $rule2 = Rule::create([
                'kode_rule' => 'R002',
                'penyakit_id' => $penyakit2->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G005' => 0.7, // Radang limpa dan diare
                'G006' => 1.0, // Darah tidak membeku
                'G007' => 0.9, // Pendarahan hitam
                'G008' => 0.5, // Nafas tidak teratur
                'G009' => 0.6, // Bengkak bawah perut
                'G010' => 0.9, // Mati mendadak
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule2->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 3: PARATUBERCULOSIS ====================
        $penyakit3 = Penyakit::where('kode_penyakit', 'P003')->first();
        if ($penyakit3) {
            $rule3 = Rule::create([
                'kode_rule' => 'R003',
                'penyakit_id' => $penyakit3->id,
                'kondisi_fuzzy' => 'Sedang'
            ]);
            
            $gejalaMap = [
                'G011' => 0.8, // Penurunan berat badan
                'G012' => 0.8, // Edema bawah rahang
                'G013' => 0.7, // Mencret tidak berbau
                'G014' => 0.6, // Penurunan produksi susu
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule3->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 4: KELURON ====================
        $penyakit4 = Penyakit::where('kode_penyakit', 'P004')->first();
        if ($penyakit4) {
            $rule4 = Rule::create([
                'kode_rule' => 'R004',
                'penyakit_id' => $penyakit4->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G015' => 1.0, // Keguguran bulan 5-8
                'G016' => 0.8, // Cairan vaginal infeksius
                'G017' => 0.7, // Epididymitis dan orchitis
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule4->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 5: TUBERCULOSIS ====================
        $penyakit5 = Penyakit::where('kode_penyakit', 'P005')->first();
        if ($penyakit5) {
            $rule5 = Rule::create([
                'kode_rule' => 'R005',
                'penyakit_id' => $penyakit5->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G018' => 0.8, // Pembengkakan kelenjar getah bening
                'G019' => 0.8, // BB turun perlahan
                'G020' => 0.6, // Hidung mengeluarkan cairan
                'G021' => 0.9, // Napas berat dan batuk berdarah
                'G022' => 0.9, // Batuk kronis
                'G023' => 0.8, // Sesak nafas
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule5->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 6: BOTULISMUS ====================
        $penyakit6 = Penyakit::where('kode_penyakit', 'P006')->first();
        if ($penyakit6) {
            $rule6 = Rule::create([
                'kode_rule' => 'R006',
                'penyakit_id' => $penyakit6->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G024' => 0.9, // Kelumpuhan total
                'G025' => 0.9, // Kesulitan menelan, ngiler, mata terbelalak
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule6->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 7: MASTITIS ====================
        $penyakit7 = Penyakit::where('kode_penyakit', 'P007')->first();
        if ($penyakit7) {
            $rule7 = Rule::create([
                'kode_rule' => 'R007',
                'penyakit_id' => $penyakit7->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G026' => 0.8, // Kelenjar susu bengkak dan keras
                'G027' => 0.7, // Kelenjar susu merah, panas, sakit
                'G028' => 0.8, // Air susu encer bercampur nanah
                'G029' => 0.5, // Tidak nyaman saat berjalan
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule7->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 8: TETANUS ====================
        $penyakit8 = Penyakit::where('kode_penyakit', 'P008')->first();
        if ($penyakit8) {
            $rule8 = Rule::create([
                'kode_rule' => 'R008',
                'penyakit_id' => $penyakit8->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G030' => 0.8, // Kaku kelopak mata
                'G031' => 0.8, // Kaku telinga
                'G032' => 0.9, // Kaku tulang punggung
                'G033' => 0.9, // Kaku mulut
                'G034' => 0.9, // Kaku kaki
                'G035' => 0.8, // Ekor kaku
                'G036' => 0.8, // Sulit mengunyah
                'G037' => 0.8, // Sensitif suara/cahaya
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule8->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 9: ERYSIPELAS ====================
        $penyakit9 = Penyakit::where('kode_penyakit', 'P009')->first();
        if ($penyakit9) {
            $rule9 = Rule::create([
                'kode_rule' => 'R009',
                'penyakit_id' => $penyakit9->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G038' => 0.7, // Radang sendi
                'G039' => 0.7, // Pincang/kaku
                'G040' => 0.6, // Gangguan jantung
                'G041' => 1.0, // Lesi diamond skin
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule9->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 10: LEPTOSPIROSIS ====================
        $penyakit10 = Penyakit::where('kode_penyakit', 'P010')->first();
        if ($penyakit10) {
            $rule10 = Rule::create([
                'kode_rule' => 'R010',
                'penyakit_id' => $penyakit10->id,
                'kondisi_fuzzy' => 'Sedang'
            ]);
            
            $gejalaMap = [
                'G042' => 0.5, // Anemia
                'G043' => 0.3, // Tremor otot
                'G044' => 0.8, // Urin merah/coklat
                'G045' => 0.7, // Ginjal belang
                'G046' => 0.7, // Ikterus
                'G047' => 0.1, // Lahir anak lemah
                'G048' => 0.6, // Infertilitas
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule10->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 11: LISTERIOSIS ====================
        $penyakit11 = Penyakit::where('kode_penyakit', 'P011')->first();
        if ($penyakit11) {
            $rule11 = Rule::create([
                'kode_rule' => 'R011',
                'penyakit_id' => $penyakit11->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G049' => 0.8, // Demam tinggi
                'G050' => 0.7, // Keguguran
                'G051' => 0.7, // Depresi
                'G052' => 0.8, // Mata juling/buta
                'G053' => 0.8, // Berbaring terus
                'G054' => 0.9, // Sempoyongan
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule11->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 12: RABIES ====================
        $penyakit12 = Penyakit::where('kode_penyakit', 'P012')->first();
        if ($penyakit12) {
            $rule12 = Rule::create([
                'kode_rule' => 'R012',
                'penyakit_id' => $penyakit12->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G055' => 0.8, // Sulit minum
                'G056' => 0.9, // Ganas/agresif
                'G057' => 0.9, // Suka mengigit
                'G058' => 0.7, // Bersembunyi di gelap
                'G059' => 0.7, // Makan benda bukan makanan
                'G060' => 0.9, // Gangguan saraf
                'G061' => 1.0, // Air liur berlebihan
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule12->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 13: PMK ====================
        $penyakit13 = Penyakit::where('kode_penyakit', 'P013')->first();
        if ($penyakit13) {
            $rule13 = Rule::create([
                'kode_rule' => 'R013',
                'penyakit_id' => $penyakit13->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G062' => 0.9, // Luka lepuh
                'G063' => 0.7, // Menggeretak gigi
                'G064' => 0.7, // Menjulurkan lidah
                'G065' => 0.8, // Selaput lendir di mulut
                'G066' => 0.8, // Bibir dan gusi merah
                'G067' => 0.9, // Ludah seperti benang
                'G068' => 0.7, // Pergelangan bengkak
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule13->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 14: SURRA ====================
        $penyakit14 = Penyakit::where('kode_penyakit', 'P014')->first();
        if ($penyakit14) {
            $rule14 = Rule::create([
                'kode_rule' => 'R014',
                'penyakit_id' => $penyakit14->id,
                'kondisi_fuzzy' => 'Sedang'
            ]);
            
            $gejalaMap = [
                'G069' => 0.8, // Gerakan tidak beraturan
                'G070' => 0.7, // Selaput lendir pucat
                'G071' => 0.5, // Demam berulang
                'G072' => 0.7, // Edema
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule14->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 15: KUKU BUSUK ====================
        $penyakit15 = Penyakit::where('kode_penyakit', 'P015')->first();
        if ($penyakit15) {
            $rule15 = Rule::create([
                'kode_rule' => 'R015',
                'penyakit_id' => $penyakit15->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G073' => 0.7, // Celah kuku bengkak
                'G074' => 0.8, // Cairan kuning berbau
                'G075' => 0.7, // Mengelupasnya selaput
                'G076' => 0.8, // Pincang
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule15->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 16: KEMBUNG PERUT ====================
        $penyakit16 = Penyakit::where('kode_penyakit', 'P016')->first();
        if ($penyakit16) {
            $rule16 = Rule::create([
                'kode_rule' => 'R016',
                'penyakit_id' => $penyakit16->id,
                'kondisi_fuzzy' => 'Sedang'
            ]);
            
            $gejalaMap = [
                'G077' => 0.8, // Perut membesar
                'G078' => 0.3, // Napas cepat
                'G079' => 0.7, // Gelisah
                'G080' => 0.7, // Gerakan kurang lincah
                'G081' => 0.8, // Lumpuh dan mati
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule16->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 17: DEMAM TIGA HARI ====================
        $penyakit17 = Penyakit::where('kode_penyakit', 'P017')->first();
        if ($penyakit17) {
            $rule17 = Rule::create([
                'kode_rule' => 'R017',
                'penyakit_id' => $penyakit17->id,
                'kondisi_fuzzy' => 'Sedang'
            ]);
            
            $gejalaMap = [
                'G082' => 0.7, // Otot kaku
                'G083' => 0.8, // Tidak bisa berdiri
                'G084' => 0.5, // Sesak dan gemetar
                'G085' => 0.7, // Cairan mata hidung
                'G086' => 0.7, // Denyut jantung meningkat
                'G087' => 0.6, // Produksi susu menurun
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule17->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 18: INGUSAN ====================
        $penyakit18 = Penyakit::where('kode_penyakit', 'P018')->first();
        if ($penyakit18) {
            $rule18 = Rule::create([
                'kode_rule' => 'R018',
                'penyakit_id' => $penyakit18->id,
                'kondisi_fuzzy' => 'Sedang'
            ]);
            
            $gejalaMap = [
                'G088' => 0.7, // Cairan hidung mata
                'G089' => 0.5, // Meneteskan air liur
                'G090' => 0.8, // Moncong kering bernanah
                'G091' => 0.7, // Sulit bernapas
                'G092' => 0.8, // Mata keruh
                'G093' => 0.6, // Kulit mengelupas
                'G094' => 0.1, // Kurus lalu mati
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule18->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 19: KUDIS ====================
        $penyakit19 = Penyakit::where('kode_penyakit', 'P019')->first();
        if ($penyakit19) {
            $rule19 = Rule::create([
                'kode_rule' => 'R019',
                'penyakit_id' => $penyakit19->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G095' => 0.8, // Menggigit tubuh
                'G096' => 0.9, // Menggosok badan
                'G097' => 0.8, // Bulu rontok bernanah
                'G098' => 0.9, // Kerak abu-abu
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule19->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
        
        // ==================== PENYAKIT 20: CACINGAN ====================
        $penyakit20 = Penyakit::where('kode_penyakit', 'P020')->first();
        if ($penyakit20) {
            $rule20 = Rule::create([
                'kode_rule' => 'R020',
                'penyakit_id' => $penyakit20->id,
                'kondisi_fuzzy' => 'Tinggi'
            ]);
            
            $gejalaMap = [
                'G099' => 0.5, // Tidak nafsu makan
                'G100' => 0.9, // Kurus
                'G101' => 0.7, // Dehidrasi
                'G102' => 0.8, // Diare
                'G103' => 0.7, // Lemah
                'G104' => 0.6, // Perut buncit
                'G105' => 1.0, // Pertumbuhan lambat
                'G106' => 0.9, // Bulu kusam
            ];
            
            foreach ($gejalaMap as $kode => $bobot) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    RuleDetail::create([
                        'rule_id' => $rule20->id,
                        'gejala_id' => $gejala->id,
                        'bobot' => $bobot
                    ]);
                }
            }
        }
    }
}