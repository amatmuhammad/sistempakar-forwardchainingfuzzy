<?php
// database/seeders/RuleDetailSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RuleDetail;
use App\Models\Rule;
use App\Models\Gejala;

class RuleDetailSeeder extends Seeder
{
    public function run()
    {
        // Ambil mapping kode rule => id, kode gejala => id
        $rules  = Rule::pluck('id', 'kode_rule');
        $gejala = Gejala::pluck('id', 'kode_gejala');

        // Data detail aturan: [kode_rule, kode_gejala, bobot]
        $details = [
            // R001 – Septicemia Epizootica (Yakin)
            ['R001', 'G001', 0.8], ['R001', 'G002', 0.7], ['R001', 'G003', 0.7], ['R001', 'G004', 0.8],

            // R002 – Anthraks (Yakin)
            ['R002', 'G005', 0.7],

            // R003 – Anthraks (Sangat Yakin)
            ['R003', 'G006', 1.0], ['R003', 'G007', 0.9], ['R003', 'G010', 0.9],

            // R004 – Anthraks (Tidak Yakin)
            ['R004', 'G008', 0.5], ['R004', 'G009', 0.6],

            // R005 – ParaTuberculosis (Yakin)
            ['R005', 'G011', 0.8], ['R005', 'G012', 0.8], ['R005', 'G013', 0.7],

            // R006 – ParaTuberculosis (Tidak Yakin)
            ['R006', 'G014', 0.6],

            // R007 – Keluron (Sangat Yakin)
            ['R007', 'G015', 1.0],

            // R008 – Keluron (Yakin)
            ['R008', 'G016', 0.8], ['R008', 'G017', 0.7],

            // R009 – TBC (Yakin)
            ['R009', 'G018', 0.8], ['R009', 'G019', 0.8], ['R009', 'G023', 0.8],

            // R010 – TBC (Sangat Yakin)
            ['R010', 'G021', 0.9], ['R010', 'G022', 0.9],

            // R011 – TBC (Tidak Yakin)
            ['R011', 'G020', 0.6],

            // R012 – Botulismus (Sangat Yakin)
            ['R012', 'G024', 0.9], ['R012', 'G025', 0.9],

            // R013 – Mastitis (Yakin)
            ['R013', 'G026', 0.8], ['R013', 'G027', 0.7], ['R013', 'G028', 0.8],

            // R014 – Mastitis (Tidak Yakin)
            ['R014', 'G029', 0.5],

            // R015 – Tetanus (Yakin)
            ['R015', 'G030', 0.8], ['R015', 'G031', 0.8], ['R015', 'G035', 0.8],
            ['R015', 'G036', 0.8], ['R015', 'G037', 0.8],

            // R016 – Tetanus (Sangat Yakin)
            ['R016', 'G032', 0.9], ['R016', 'G033', 0.9], ['R016', 'G034', 0.9],

            // R017 – Erysipelas (Yakin)
            ['R017', 'G038', 0.7], ['R017', 'G039', 0.7],

            // R018 – Erysipelas (Sangat Yakin)
            ['R018', 'G041', 1.0],

            // R019 – Erysipelas (Tidak Yakin)
            ['R019', 'G040', 0.6],

            // R020 – Leptospirosis (Yakin)
            ['R020', 'G044', 0.8], ['R020', 'G045', 0.7], ['R020', 'G046', 0.7],

            // R021 – Leptospirosis (Tidak Yakin)
            ['R021', 'G042', 0.5], ['R021', 'G043', 0.3], ['R021', 'G047', 0.1], ['R021', 'G048', 0.6],

            // R022 – Listeriosis (Yakin)
            ['R022', 'G049', 0.8], ['R022', 'G050', 0.7], ['R022', 'G051', 0.7],
            ['R022', 'G052', 0.8], ['R022', 'G053', 0.8],

            // R023 – Listeriosis (Sangat Yakin)
            ['R023', 'G054', 0.9],

            // R024 – Rabies (Yakin)
            ['R024', 'G055', 0.8], ['R024', 'G058', 0.7], ['R024', 'G059', 0.7],

            // R025 – Rabies (Sangat Yakin)
            ['R025', 'G056', 0.9], ['R025', 'G057', 0.9], ['R025', 'G060', 0.9], ['R025', 'G061', 1.0],

            // R026 – PMK (Yakin)
            ['R026', 'G063', 0.7], ['R026', 'G064', 0.7], ['R026', 'G065', 0.8],
            ['R026', 'G066', 0.8], ['R026', 'G068', 0.7],

            // R027 – PMK (Sangat Yakin)
            ['R027', 'G062', 0.9], ['R027', 'G067', 0.9],

            // R028 – Surra (Yakin)
            ['R028', 'G069', 0.8], ['R028', 'G070', 0.7], ['R028', 'G072', 0.7],

            // R029 – Surra (Tidak Yakin)
            ['R029', 'G071', 0.5],

            // R030 – Kuku Busuk (Yakin)
            ['R030', 'G073', 0.7], ['R030', 'G074', 0.8], ['R030', 'G075', 0.7], ['R030', 'G076', 0.8],

            // R031 – Kembung Perut (Yakin)
            ['R031', 'G077', 0.8], ['R031', 'G079', 0.7], ['R031', 'G080', 0.7], ['R031', 'G081', 0.8],

            // R032 – Kembung Perut (Tidak Yakin)
            ['R032', 'G078', 0.3],

            // R033 – Demam Tiga Hari (Yakin)
            ['R033', 'G082', 0.7], ['R033', 'G083', 0.8], ['R033', 'G085', 0.7], ['R033', 'G086', 0.7],

            // R034 – Demam Tiga Hari (Tidak Yakin)
            ['R034', 'G084', 0.5], ['R034', 'G087', 0.6],

            // R035 – Ingusan (Yakin)
            ['R035', 'G088', 0.7], ['R035', 'G090', 0.8], ['R035', 'G091', 0.7], ['R035', 'G092', 0.8],

            // R036 – Ingusan (Tidak Yakin)
            ['R036', 'G089', 0.5], ['R036', 'G093', 0.6], ['R036', 'G094', 0.1],

            // R037 – Kudis (Yakin)
            ['R037', 'G095', 0.8], ['R037', 'G097', 0.8],

            // R038 – Kudis (Sangat Yakin)
            ['R038', 'G096', 0.9], ['R038', 'G098', 0.9],

            // R039 – Cacingan (Yakin)
            ['R039', 'G101', 0.7], ['R039', 'G102', 0.8], ['R039', 'G103', 0.7],

            // R040 – Cacingan (Sangat Yakin)
            ['R040', 'G100', 0.9], ['R040', 'G105', 1.0], ['R040', 'G106', 0.9],

            // R041 – Cacingan (Tidak Yakin)
            ['R041', 'G099', 0.5], ['R041', 'G104', 0.6],
        ];

        foreach ($details as $detail) {
            RuleDetail::create([
                'rule_id'   => $rules[$detail[0]],
                'gejala_id' => $gejala[$detail[1]],
                'bobot'     => $detail[2],
            ]);
        }
    }
}