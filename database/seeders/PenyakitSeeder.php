<?php
// database/seeders/PenyakitSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penyakit;

class PenyakitSeeder extends Seeder
{
    public function run()
    {
        $penyakit = [
            [
                'kode_penyakit' => 'P001',
                'nama_penyakit' => 'Septicemia Epizootica (Ngorok)',
                'definisi' => 'Penyakit yang menyerang sistem pernapasan dan pencernaan sapi yang disebabkan oleh bakteri. Ditandai dengan pembengkakan pada kulit kepala, leher, dan selaput lendir.',
                'saran_penanganan' => '1. Isolasi sapi yang sakit\n2. Berikan antibiotik sesuai resep dokter hewan\n3. Jaga kebersihan kandang\n4. Berikan vitamin untuk meningkatkan imunitas'
            ],
            [
                'kode_penyakit' => 'P002',
                'nama_penyakit' => 'Anthraks',
                'definisi' => 'Penyakit menular akut yang disebabkan oleh bakteri Bacillus anthracis. Ditandai dengan pendarahan pada lubang tubuh dan darah tidak membeku.',
                'saran_penanganan' => '1. Laporkan ke dinas peternakan setempat\n2. Jangan membuka bangkai sapi\n3. Lakukan vaksinasi pada ternak yang sehat\n4. Karantina area yang terinfeksi'
            ],
            [
                'kode_penyakit' => 'P003',
                'nama_penyakit' => 'ParaTuberculosis',
                'definisi' => 'Penyakit kronis pada saluran pencernaan sapi yang disebabkan oleh bakteri Mycobacterium avium subspecies paratuberculosis.',
                'saran_penanganan' => '1. Pisahkan sapi yang sakit\n2. Perbaiki manajemen pakan\n3. Lakukan sanitasi kandang secara rutin\n4. Lakukan pemeriksaan berkala'
            ],
            [
                'kode_penyakit' => 'P004',
                'nama_penyakit' => 'Keluron (Keguguran)',
                'definisi' => 'Keguguran pada sapi yang disebabkan oleh infeksi bakteri Brucella abortus atau faktor lainnya.',
                'saran_penanganan' => '1. Pisahkan sapi yang keguguran\n2. Lakukan pemeriksaan brucellosis\n3. Vaksinasi sapi betina\n4. Sanitasi kandang secara intensif'
            ],
            [
                'kode_penyakit' => 'P005',
                'nama_penyakit' => 'Tuberculosis (TBC)',
                'definisi' => 'Penyakit kronis yang disebabkan oleh bakteri Mycobacterium bovis, menyerang paru-paru dan organ lainnya.',
                'saran_penanganan' => '1. Isolasi sapi yang terinfeksi\n2. Lakukan uji tuberkulin secara berkala\n3. Afkir sapi yang positif TBC\n4. Pasteurisasi susu sebelum dikonsumsi'
            ],
            [
                'kode_penyakit' => 'P006',
                'nama_penyakit' => 'Botulismus',
                'definisi' => 'Keracunan yang disebabkan oleh toksin bakteri Clostridium botulinum yang menyerang sistem saraf.',
                'saran_penanganan' => '1. Hentikan pemberian pakan yang dicurigai\n2. Berikan antitoksin jika tersedia\n3. Lakukan terapi suportif\n4. Jaga kebersihan pakan dan minum'
            ],
            [
                'kode_penyakit' => 'P007',
                'nama_penyakit' => 'Mastitis (Radang Kelenjar Air Susu)',
                'definisi' => 'Peradangan pada kelenjar ambing yang disebabkan oleh infeksi bakteri, umum terjadi pada sapi perah.',
                'saran_penanganan' => '1. Perah susu secara teratur dan bersih\n2. Berikan antibiotik intramammary\n3. Kompres dingin pada ambing yang bengkak\n4. Jaga kebersihan kandang dan alat perah'
            ],
            [
                'kode_penyakit' => 'P008',
                'nama_penyakit' => 'Tetanus',
                'definisi' => 'Penyakit yang disebabkan oleh toksin Clostridium tetani yang masuk melalui luka, menyebabkan kekakuan otot.',
                'saran_penanganan' => '1. Bersihkan luka dengan antiseptik\n2. Berikan antitoksin tetanus\n3. Tempatkan sapi di ruangan gelap dan tenang\n4. Lakukan vaksinasi tetanus'
            ],
            [
                'kode_penyakit' => 'P009',
                'nama_penyakit' => 'Erysipelas',
                'definisi' => 'Penyakit yang disebabkan oleh bakteri Erysipelothrix rhusiopathiae, ditandai dengan lesi kulit berbentuk belah ketupat.',
                'saran_penanganan' => '1. Isolasi sapi yang sakit\n2. Berikan antibiotik (penisilin)\n3. Lakukan vaksinasi\n4. Jaga kebersihan kandang'
            ],
            [
                'kode_penyakit' => 'P010',
                'nama_penyakit' => 'Leptospirosis',
                'definisi' => 'Penyakit zoonosis yang disebabkan oleh bakteri Leptospira, menyerang ginjal dan hati.',
                'saran_penanganan' => '1. Berikan antibiotik (streptomisin, doksisiklin)\n2. Lakukan vaksinasi\n3. Deratisasi untuk mengendalikan tikus\n4. Sanitasi lingkungan'
            ],
            [
                'kode_penyakit' => 'P011',
                'nama_penyakit' => 'Listeriosis',
                'definisi' => 'Penyakit yang disebabkan oleh bakteri Listeria monocytogenes, menyerang sistem saraf pusat.',
                'saran_penanganan' => '1. Berikan antibiotik (ampisilin, tetrasiklin)\n2. Hentikan pemberian silase yang tercemar\n3. Lakukan terapi suportif\n4. Jaga kebersihan pakan'
            ],
            [
                'kode_penyakit' => 'P012',
                'nama_penyakit' => 'Rabies',
                'definisi' => 'Penyakit virus fatal yang menyerang sistem saraf pusat, bersifat zoonosis sangat berbahaya.',
                'saran_penanganan' => '1. Laporkan segera ke dinas peternakan\n2. Isolasi ketat sapi yang sakit\n3. Vaksinasi rabies pada ternak\n4. Petugas harus menggunakan APD lengkap'
            ],
            [
                'kode_penyakit' => 'P013',
                'nama_penyakit' => 'Penyakit Mulut dan Kuku (PMK)',
                'definisi' => 'Penyakit virus yang sangat menular pada hewan berkuku belah, ditandai dengan lepuhan di mulut, lidah, dan area kuku.',
                'saran_penanganan' => '1. Isolasi total sapi yang sakit\n2. Laporkan ke dinas peternakan\n3. Lakukan vaksinasi PMK\n4. Disinfeksi kandang secara menyeluruh'
            ],
            [
                'kode_penyakit' => 'P014',
                'nama_penyakit' => 'SURRA (Trypanosomiasis)',
                'definisi' => 'Penyakit yang disebabkan oleh parasit Trypanosoma evansi, ditularkan melalui lalat tabanus.',
                'saran_penanganan' => '1. Berikan obat antiprotozoa (suramin, quinapyramine)\n2. Kontrol populasi lalat\n3. Jaga kebersihan kandang\n4. Pisahkan sapi yang sakit'
            ],
            [
                'kode_penyakit' => 'P015',
                'nama_penyakit' => 'Kuku Busuk (Foot Rot)',
                'definisi' => 'Infeksi bakteri pada kuku sapi yang menyebabkan pembusukan dan pincang.',
                'saran_penanganan' => '1. Bersihkan dan potong kuku yang rusak\n2. Rendam kaki dengan larutan antiseptik\n3. Berikan antibiotik\n4. Jaga kebersihan kandang tetap kering'
            ],
            [
                'kode_penyakit' => 'P016',
                'nama_penyakit' => 'Kembung Perut (Bloat)',
                'definisi' => 'Penumpukan gas dalam rumen yang tidak dapat dikeluarkan, menyebabkan perut membesar.',
                'saran_penanganan' => '1. Pasang slang/ trokar untuk mengeluarkan gas\n2. Berikan minyak mineral atau bahan anti busa\n3. Hindari pemberian pakan berfermentasi berlebihan\n4. Atur pakan hijauan secara bertahap'
            ],
            [
                'kode_penyakit' => 'P017',
                'nama_penyakit' => 'Demam Tiga Hari (BEF - Bovine Ephemeral Fever)',
                'definisi' => 'Penyakit virus yang ditularkan oleh vektor (nyamuk), ditandai dengan demam tinggi dan kekakuan otot.',
                'saran_penanganan' => '1. Berikan obat antiinflamasi dan antipiretik\n2. Istirahatkan sapi\n3. Berikan cairan infus jika perlu\n4. Lakukan vaksinasi BEF'
            ],
            [
                'kode_penyakit' => 'P018',
                'nama_penyakit' => 'Ingusan (Bovine Rhinotracheitis/IBR)',
                'definisi' => 'Penyakit saluran pernapasan atas yang disebabkan oleh virus herpes pada sapi.',
                'saran_penanganan' => '1. Isolasi sapi yang sakit\n2. Berikan antibiotik untuk mencegah infeksi sekunder\n3. Lakukan vaksinasi IBR\n4. Jaga ventilasi kandang'
            ],
            [
                'kode_penyakit' => 'P019',
                'nama_penyakit' => 'Kudis (Mange/Scabies)',
                'definisi' => 'Penyakit kulit yang disebabkan oleh tungau (mite), menyebabkan gatal parah dan kerak pada kulit.',
                'saran_penanganan' => '1. Mandikan dengan akarisida\n2. Berikan injeksi ivermectin\n3. Semprot kandang dengan akarisida\n4. Isolasi sapi yang sakit'
            ],
            [
                'kode_penyakit' => 'P020',
                'nama_penyakit' => 'Cacingan (Helminthiasis)',
                'definisi' => 'Infeksi cacing parasit pada saluran pencernaan yang menyebabkan penurunan berat badan dan diare.',
                'saran_penanganan' => '1. Berikan obat cacing (anthelmintik)\n2. Lakukan rotasi padang rumput\n3. Jaga kebersihan kandang\n4. Lakukan pemeriksaan feses berkala'
            ],
        ];
        
        foreach ($penyakit as $p) {
            Penyakit::create($p);
        }
    }
}