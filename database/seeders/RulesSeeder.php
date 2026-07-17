<?php
// database/seeders/RuleSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rule;
use App\Models\Penyakit;

class RulesSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua penyakit: [kode_penyakit => id]
        $penyakit = Penyakit::pluck('id', 'kode_penyakit');

        // Parameter output fuzzy untuk setiap kondisi
        $outputParams = [
            'Tidak Yakin'  => ['output_a' => 0,  'output_b' => 0,  'output_c' => 25, 'output_d' => 45],
            'Yakin'        => ['output_a' => 25, 'output_b' => 45, 'output_c' => 55, 'output_d' => 75],
            'Sangat Yakin' => ['output_a' => 55, 'output_b' => 75, 'output_c' => 100, 'output_d' => 100],
        ];

        // Daftar aturan: [kode_rule, kode_penyakit, kondisi_fuzzy]
        $rules = [
            // P001 – Septicemia Epizootica
            ['R001', 'P001', 'Yakin'],

            // P002 – Anthraks
            ['R002', 'P002', 'Yakin'],
            ['R003', 'P002', 'Sangat Yakin'],
            ['R004', 'P002', 'Tidak Yakin'],

            // P003 – ParaTuberculosis
            ['R005', 'P003', 'Yakin'],
            ['R006', 'P003', 'Tidak Yakin'],

            // P004 – Keluron
            ['R007', 'P004', 'Sangat Yakin'],
            ['R008', 'P004', 'Yakin'],

            // P005 – Tuberculosis
            ['R009', 'P005', 'Yakin'],
            ['R010', 'P005', 'Sangat Yakin'],
            ['R011', 'P005', 'Tidak Yakin'],

            // P006 – Botulismus
            ['R012', 'P006', 'Sangat Yakin'],

            // P007 – Mastitis
            ['R013', 'P007', 'Yakin'],
            ['R014', 'P007', 'Tidak Yakin'],

            // P008 – Tetanus
            ['R015', 'P008', 'Yakin'],
            ['R016', 'P008', 'Sangat Yakin'],

            // P009 – Erysipelas
            ['R017', 'P009', 'Yakin'],
            ['R018', 'P009', 'Sangat Yakin'],
            ['R019', 'P009', 'Tidak Yakin'],

            // P010 – Leptospirosis
            ['R020', 'P010', 'Yakin'],
            ['R021', 'P010', 'Tidak Yakin'],

            // P011 – Listeriosis
            ['R022', 'P011', 'Yakin'],
            ['R023', 'P011', 'Sangat Yakin'],

            // P012 – Rabies
            ['R024', 'P012', 'Yakin'],
            ['R025', 'P012', 'Sangat Yakin'],

            // P013 – PMK
            ['R026', 'P013', 'Yakin'],
            ['R027', 'P013', 'Sangat Yakin'],

            // P014 – Surra
            ['R028', 'P014', 'Yakin'],
            ['R029', 'P014', 'Tidak Yakin'],

            // P015 – Kuku Busuk
            ['R030', 'P015', 'Yakin'],

            // P016 – Kembung Perut
            ['R031', 'P016', 'Yakin'],
            ['R032', 'P016', 'Tidak Yakin'],

            // P017 – Demam Tiga Hari
            ['R033', 'P017', 'Yakin'],
            ['R034', 'P017', 'Tidak Yakin'],

            // P018 – Ingusan
            ['R035', 'P018', 'Yakin'],
            ['R036', 'P018', 'Tidak Yakin'],

            // P019 – Kudis
            ['R037', 'P019', 'Yakin'],
            ['R038', 'P019', 'Sangat Yakin'],

            // P020 – Cacingan
            ['R039', 'P020', 'Yakin'],
            ['R040', 'P020', 'Sangat Yakin'],
            ['R041', 'P020', 'Tidak Yakin'],
        ];

        foreach ($rules as $rule) {
            $kodeRule     = $rule[0];
            $kodePenyakit = $rule[1];
            $kondisi      = $rule[2];
            $out          = $outputParams[$kondisi];

            Rule::create([
                'kode_rule'     => $kodeRule,
                'penyakit_id'   => $penyakit[$kodePenyakit],
                'kondisi_fuzzy' => $kondisi,
                'output_a'      => $out['output_a'],
                'output_b'      => $out['output_b'],
                'output_c'      => $out['output_c'],
                'output_d'      => $out['output_d'],
            ]);
        }
    }
}