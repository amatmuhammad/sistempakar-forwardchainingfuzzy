<?php
// database/seeders/RuleDetailsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleDetailsSeeder extends Seeder
{
    public function run()
    {
        DB::table('rule_details')->insert([

            // ==================== R001 - SEPTICEMIA EPIZOOTICA ====================
            ['rule_id' => 1, 'gejala_id' => 1, 'bobot' => 0.8],
            ['rule_id' => 1, 'gejala_id' => 2, 'bobot' => 0.7],
            ['rule_id' => 1, 'gejala_id' => 3, 'bobot' => 0.7],
            ['rule_id' => 1, 'gejala_id' => 4, 'bobot' => 0.8], // Tambahan

            // ==================== R002 - ANTHRAKS ====================
            ['rule_id' => 2, 'gejala_id' => 5, 'bobot' => 0.7],
            ['rule_id' => 2, 'gejala_id' => 6, 'bobot' => 1.0],
            ['rule_id' => 2, 'gejala_id' => 7, 'bobot' => 0.9],
            ['rule_id' => 2, 'gejala_id' => 8, 'bobot' => 0.5],
            ['rule_id' => 2, 'gejala_id' => 9, 'bobot' => 0.6],
            ['rule_id' => 2, 'gejala_id' => 10, 'bobot' => 0.9],

            // ==================== R003 - PARATUBERCULOSIS ====================
            ['rule_id' => 3, 'gejala_id' => 11, 'bobot' => 0.8],
            ['rule_id' => 3, 'gejala_id' => 12, 'bobot' => 0.8],
            ['rule_id' => 3, 'gejala_id' => 13, 'bobot' => 0.7],
            ['rule_id' => 3, 'gejala_id' => 14, 'bobot' => 0.6],

            // ==================== R004 - KELURON ====================
            ['rule_id' => 4, 'gejala_id' => 15, 'bobot' => 1.0],
            ['rule_id' => 4, 'gejala_id' => 16, 'bobot' => 0.8],
            ['rule_id' => 4, 'gejala_id' => 17, 'bobot' => 0.7],

            // ==================== R005 - TUBERCULOSIS ====================
            ['rule_id' => 5, 'gejala_id' => 18, 'bobot' => 0.8],
            ['rule_id' => 5, 'gejala_id' => 19, 'bobot' => 0.8],
            ['rule_id' => 5, 'gejala_id' => 20, 'bobot' => 0.6],
            ['rule_id' => 5, 'gejala_id' => 21, 'bobot' => 0.9],
            ['rule_id' => 5, 'gejala_id' => 22, 'bobot' => 0.9],
            ['rule_id' => 5, 'gejala_id' => 23, 'bobot' => 0.8],

            // ==================== R006 - BOTULISMUS ====================
            ['rule_id' => 6, 'gejala_id' => 24, 'bobot' => 0.9],
            ['rule_id' => 6, 'gejala_id' => 25, 'bobot' => 0.9],

            // ==================== R007 - MASTITIS ====================
            ['rule_id' => 7, 'gejala_id' => 26, 'bobot' => 0.8],
            ['rule_id' => 7, 'gejala_id' => 27, 'bobot' => 0.7],
            ['rule_id' => 7, 'gejala_id' => 28, 'bobot' => 0.8],
            ['rule_id' => 7, 'gejala_id' => 29, 'bobot' => 0.5],

            // ==================== R008 - TETANUS ====================
            ['rule_id' => 8, 'gejala_id' => 30, 'bobot' => 0.8],
            ['rule_id' => 8, 'gejala_id' => 31, 'bobot' => 0.8],
            ['rule_id' => 8, 'gejala_id' => 32, 'bobot' => 0.9],
            ['rule_id' => 8, 'gejala_id' => 33, 'bobot' => 0.9],
            ['rule_id' => 8, 'gejala_id' => 34, 'bobot' => 0.9],
            ['rule_id' => 8, 'gejala_id' => 35, 'bobot' => 0.8],
            ['rule_id' => 8, 'gejala_id' => 36, 'bobot' => 0.8],
            ['rule_id' => 8, 'gejala_id' => 37, 'bobot' => 0.8],

            // ==================== R009 - ERYSIPELAS ====================
            ['rule_id' => 9, 'gejala_id' => 38, 'bobot' => 0.7],
            ['rule_id' => 9, 'gejala_id' => 39, 'bobot' => 0.7],
            ['rule_id' => 9, 'gejala_id' => 40, 'bobot' => 0.6],
            ['rule_id' => 9, 'gejala_id' => 41, 'bobot' => 1.0],

            // ==================== R010 - LEPTOSPIROSIS ====================
            ['rule_id' => 10, 'gejala_id' => 42, 'bobot' => 0.5],
            ['rule_id' => 10, 'gejala_id' => 43, 'bobot' => 0.3],
            ['rule_id' => 10, 'gejala_id' => 44, 'bobot' => 0.8],
            ['rule_id' => 10, 'gejala_id' => 45, 'bobot' => 0.7],
            ['rule_id' => 10, 'gejala_id' => 46, 'bobot' => 0.7],
            ['rule_id' => 10, 'gejala_id' => 47, 'bobot' => 0.1],
            ['rule_id' => 10, 'gejala_id' => 48, 'bobot' => 0.6],

            // ==================== R011 - LISTERIOSIS ====================
            ['rule_id' => 11, 'gejala_id' => 49, 'bobot' => 0.8],
            ['rule_id' => 11, 'gejala_id' => 50, 'bobot' => 0.7],
            ['rule_id' => 11, 'gejala_id' => 51, 'bobot' => 0.7],
            ['rule_id' => 11, 'gejala_id' => 52, 'bobot' => 0.8],
            ['rule_id' => 11, 'gejala_id' => 53, 'bobot' => 0.8],
            ['rule_id' => 11, 'gejala_id' => 54, 'bobot' => 0.9],

            // ==================== R012 - RABIES ====================
            ['rule_id' => 12, 'gejala_id' => 55, 'bobot' => 0.8],
            ['rule_id' => 12, 'gejala_id' => 56, 'bobot' => 0.9],
            ['rule_id' => 12, 'gejala_id' => 57, 'bobot' => 0.9],
            ['rule_id' => 12, 'gejala_id' => 58, 'bobot' => 0.7],
            ['rule_id' => 12, 'gejala_id' => 59, 'bobot' => 0.7],
            ['rule_id' => 12, 'gejala_id' => 60, 'bobot' => 0.9],
            ['rule_id' => 12, 'gejala_id' => 61, 'bobot' => 1.0],

            // ==================== R013 - PMK ====================
            ['rule_id' => 13, 'gejala_id' => 62, 'bobot' => 0.9],
            ['rule_id' => 13, 'gejala_id' => 63, 'bobot' => 0.7],
            ['rule_id' => 13, 'gejala_id' => 64, 'bobot' => 0.7],
            ['rule_id' => 13, 'gejala_id' => 65, 'bobot' => 0.8],
            ['rule_id' => 13, 'gejala_id' => 66, 'bobot' => 0.8],
            ['rule_id' => 13, 'gejala_id' => 67, 'bobot' => 0.9],
            ['rule_id' => 13, 'gejala_id' => 68, 'bobot' => 0.7],

            // ==================== R014 - SURRA ====================
            ['rule_id' => 14, 'gejala_id' => 69, 'bobot' => 0.8],
            ['rule_id' => 14, 'gejala_id' => 70, 'bobot' => 0.7],
            ['rule_id' => 14, 'gejala_id' => 71, 'bobot' => 0.5],
            ['rule_id' => 14, 'gejala_id' => 72, 'bobot' => 0.7],

            // ==================== R015 - KUKU BUSUK ====================
            ['rule_id' => 15, 'gejala_id' => 73, 'bobot' => 0.7],
            ['rule_id' => 15, 'gejala_id' => 74, 'bobot' => 0.8],
            ['rule_id' => 15, 'gejala_id' => 75, 'bobot' => 0.7],
            ['rule_id' => 15, 'gejala_id' => 76, 'bobot' => 0.8],

            // ==================== R016 - KEMBUNG PERUT ====================
            ['rule_id' => 16, 'gejala_id' => 77, 'bobot' => 0.8],
            ['rule_id' => 16, 'gejala_id' => 78, 'bobot' => 0.3],
            ['rule_id' => 16, 'gejala_id' => 79, 'bobot' => 0.7],
            ['rule_id' => 16, 'gejala_id' => 80, 'bobot' => 0.7],
            ['rule_id' => 16, 'gejala_id' => 81, 'bobot' => 0.8],

            // ==================== R017 - DEMAM TIGA HARI ====================
            ['rule_id' => 17, 'gejala_id' => 82, 'bobot' => 0.7],
            ['rule_id' => 17, 'gejala_id' => 83, 'bobot' => 0.8],
            ['rule_id' => 17, 'gejala_id' => 84, 'bobot' => 0.5],
            ['rule_id' => 17, 'gejala_id' => 85, 'bobot' => 0.7],
            ['rule_id' => 17, 'gejala_id' => 86, 'bobot' => 0.7],
            ['rule_id' => 17, 'gejala_id' => 87, 'bobot' => 0.6],

            // ==================== R018 - INGUSAN ====================
            ['rule_id' => 18, 'gejala_id' => 88, 'bobot' => 0.7],
            ['rule_id' => 18, 'gejala_id' => 89, 'bobot' => 0.5],
            ['rule_id' => 18, 'gejala_id' => 90, 'bobot' => 0.8],
            ['rule_id' => 18, 'gejala_id' => 91, 'bobot' => 0.7],
            ['rule_id' => 18, 'gejala_id' => 92, 'bobot' => 0.8],
            ['rule_id' => 18, 'gejala_id' => 93, 'bobot' => 0.6],
            ['rule_id' => 18, 'gejala_id' => 94, 'bobot' => 0.1],

            // ==================== R019 - KUDIS ====================
            ['rule_id' => 19, 'gejala_id' => 95, 'bobot' => 0.8],
            ['rule_id' => 19, 'gejala_id' => 96, 'bobot' => 0.9],
            ['rule_id' => 19, 'gejala_id' => 97, 'bobot' => 0.8],
            ['rule_id' => 19, 'gejala_id' => 98, 'bobot' => 0.9],

            // ==================== R020 - CACINGAN ====================
            ['rule_id' => 20, 'gejala_id' => 99, 'bobot' => 0.5],
            ['rule_id' => 20, 'gejala_id' => 100, 'bobot' => 0.9],
            ['rule_id' => 20, 'gejala_id' => 101, 'bobot' => 0.7],
            ['rule_id' => 20, 'gejala_id' => 102, 'bobot' => 0.8],
            ['rule_id' => 20, 'gejala_id' => 103, 'bobot' => 0.7],
            ['rule_id' => 20, 'gejala_id' => 104, 'bobot' => 0.6],
            ['rule_id' => 20, 'gejala_id' => 105, 'bobot' => 1.0],
            ['rule_id' => 20, 'gejala_id' => 106, 'bobot' => 0.9],
        ]);
    }
}