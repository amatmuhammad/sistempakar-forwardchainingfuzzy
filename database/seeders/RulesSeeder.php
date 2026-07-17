<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data rule dengan parameter output fuzzy
        $rules = [
            // ===== PENYAKIT 1: Septicemia Epizootica (Ngorok) =====
            [
                'kode_rule'     => 'R001',
                'penyakit_id'   => 1, // Sesuaikan dengan ID penyakit
                'kondisi_fuzzy' => 'Sangat Yakin',
                'output_a'      => 55,
                'output_b'      => 75,
                'output_c'      => 100,
                'output_d'      => 100,
                'details'       => [
                    ['gejala_id' => 1, 'bobot' => 0.8],  // G001
                    ['gejala_id' => 2, 'bobot' => 0.7],  // G002
                    ['gejala_id' => 3, 'bobot' => 0.7],  // G003
                    ['gejala_id' => 4, 'bobot' => 0.8],  // G004
                ],
            ],
            [
                'kode_rule'     => 'R002',
                'penyakit_id'   => 1,
                'kondisi_fuzzy' => 'Yakin',
                'output_a'      => 25,
                'output_b'      => 45,
                'output_c'      => 55,
                'output_d'      => 75,
                'details'       => [
                    ['gejala_id' => 1, 'bobot' => 0.6],
                    ['gejala_id' => 2, 'bobot' => 0.7],
                ],
            ],
            [
                'kode_rule'     => 'R003',
                'penyakit_id'   => 1,
                'kondisi_fuzzy' => 'Tidak Yakin',
                'output_a'      => 0,
                'output_b'      => 0,
                'output_c'      => 25,
                'output_d'      => 45,
                'details'       => [
                    ['gejala_id' => 1, 'bobot' => 0.4],
                ],
            ],

            // ===== PENYAKIT 2: Anthrax (Radang Limpa) =====
            [
                'kode_rule'     => 'R004',
                'penyakit_id'   => 2,
                'kondisi_fuzzy' => 'Sangat Yakin',
                'output_a'      => 55,
                'output_b'      => 75,
                'output_c'      => 100,
                'output_d'      => 100,
                'details'       => [
                    ['gejala_id' => 5, 'bobot' => 0.9],  // G005: Demam tinggi
                    ['gejala_id' => 6, 'bobot' => 0.8],  // G006: Keluar darah dari lubang tubuh
                    ['gejala_id' => 7, 'bobot' => 0.7],  // G007: Pembengkakan limpa
                ],
            ],
            [
                'kode_rule'     => 'R005',
                'penyakit_id'   => 2,
                'kondisi_fuzzy' => 'Yakin',
                'output_a'      => 25,
                'output_b'      => 45,
                'output_c'      => 55,
                'output_d'      => 75,
                'details'       => [
                    ['gejala_id' => 5, 'bobot' => 0.7],
                    ['gejala_id' => 7, 'bobot' => 0.6],
                ],
            ],
            [
                'kode_rule'     => 'R006',
                'penyakit_id'   => 2,
                'kondisi_fuzzy' => 'Tidak Yakin',
                'output_a'      => 0,
                'output_b'      => 0,
                'output_c'      => 25,
                'output_d'      => 45,
                'details'       => [
                    ['gejala_id' => 5, 'bobot' => 0.4],
                ],
            ],

            // ===== PENYAKIT 3: Brucellosis (Kluron Menular) =====
            [
                'kode_rule'     => 'R007',
                'penyakit_id'   => 3,
                'kondisi_fuzzy' => 'Sangat Yakin',
                'output_a'      => 55,
                'output_b'      => 75,
                'output_c'      => 100,
                'output_d'      => 100,
                'details'       => [
                    ['gejala_id' => 8, 'bobot' => 0.9],  // G008: Keguguran pada trimester akhir
                    ['gejala_id' => 9, 'bobot' => 0.8],  // G009: Pembengkakan sendi
                    ['gejala_id' => 10, 'bobot' => 0.6], // G010: Anak sapi lemah
                ],
            ],
            [
                'kode_rule'     => 'R008',
                'penyakit_id'   => 3,
                'kondisi_fuzzy' => 'Yakin',
                'output_a'      => 25,
                'output_b'      => 45,
                'output_c'      => 55,
                'output_d'      => 75,
                'details'       => [
                    ['gejala_id' => 8, 'bobot' => 0.7],
                    ['gejala_id' => 9, 'bobot' => 0.6],
                ],
            ],
            [
                'kode_rule'     => 'R009',
                'penyakit_id'   => 3,
                'kondisi_fuzzy' => 'Tidak Yakin',
                'output_a'      => 0,
                'output_b'      => 0,
                'output_c'      => 25,
                'output_d'      => 45,
                'details'       => [
                    ['gejala_id' => 10, 'bobot' => 0.5],
                ],
            ],

            // ===== PENYAKIT 4: Mastitis =====
            [
                'kode_rule'     => 'R010',
                'penyakit_id'   => 4,
                'kondisi_fuzzy' => 'Sangat Yakin',
                'output_a'      => 55,
                'output_b'      => 75,
                'output_c'      => 100,
                'output_d'      => 100,
                'details'       => [
                    ['gejala_id' => 11, 'bobot' => 0.9], // G011: Ambing bengkak dan keras
                    ['gejala_id' => 12, 'bobot' => 0.8], // G012: Susu mengandung gumpalan/nanah
                    ['gejala_id' => 13, 'bobot' => 0.7], // G013: Nafsu makan menurun
                ],
            ],
            [
                'kode_rule'     => 'R011',
                'penyakit_id'   => 4,
                'kondisi_fuzzy' => 'Yakin',
                'output_a'      => 25,
                'output_b'      => 45,
                'output_c'      => 55,
                'output_d'      => 75,
                'details'       => [
                    ['gejala_id' => 11, 'bobot' => 0.7],
                    ['gejala_id' => 12, 'bobot' => 0.6],
                ],
            ],
        ];

        // Insert data rule dan detail
        foreach ($rules as $ruleData) {
            $details = $ruleData['details'];
            unset($ruleData['details']);

            // Insert rule
            $ruleId = DB::table('rules')->insertGetId(array_merge($ruleData, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            // Insert rule details
            foreach ($details as $detail) {
                DB::table('rule_details')->insert([
                    'rule_id'    => $ruleId,
                    'gejala_id'  => $detail['gejala_id'],
                    'bobot'      => $detail['bobot'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}