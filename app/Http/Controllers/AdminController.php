<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\Rule;
use App\Models\Konsultasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Mengambil hitungan total data secara riil dari database
        $totalPenyakit = Penyakit::count();
        $totalGejala = Gejala::count();
        $totalRules = Rule::count();
        $totalKonsultasi = Konsultasi::count();

        // 2. Pemetaan nama hari ke Bahasa Indonesia
        $daysMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        // 3. Mengambil data konsultasi 7 hari terakhir secara efisien
        $records = Konsultasi::where('tanggal_periksa', '>=', Carbon::now()->subDays(6)->startOfDay())->get();

        $chartLabels = [];
        $chartValues = [];

        // Loop untuk menyusun data grafik ke belakang (dari 6 hari lalu sampai hari ini)
        for ($i = 6; $i >= 0; $i--) {
            $dateObj = Carbon::now()->subDays($i);
            $dateKey = $dateObj->format('Y-m-d');
            $englishDay = $dateObj->format('l');
            $indonesianDay = $daysMap[$englishDay] ?? $englishDay;

            // Filter data yang cocok dengan tanggal terkait
            $count = $records->filter(function($record) use ($dateKey) {
                // Pastikan format tanggal_periksa dicocokkan sebagai Y-m-d
                return $record->tanggal_periksa ? $record->tanggal_periksa->format('Y-m-d') === $dateKey : false;
            })->count();

            $chartLabels[] = $indonesianDay;
            $chartValues[] = $count;
        }

        // 4. Mengambil 5 riwayat diagnosa terbaru dengan eager loading relasi penyakit
        $recentKonsultasi = Konsultasi::with('penyakit')
            ->orderBy('tanggal_periksa', 'desc')
            ->limit(5)
            ->get();

        // 5. Mengirimkan seluruh variabel ke view dashboard admin
        return view('admin.dashboard', compact(
            'totalPenyakit', 
            'totalGejala', 
            'totalRules', 
            'totalKonsultasi',
            'chartLabels',
            'chartValues',
            'recentKonsultasi'
        ));
    }
}
