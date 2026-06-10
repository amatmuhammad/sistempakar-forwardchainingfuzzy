<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminGejalaController extends Controller
{
    /**
     * Menampilkan daftar gejala beserta parameter fuzzy
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        
        $query = Gejala::query();
        
        // Filter pencarian
        if ($search) {
            $query->where('kode_gejala', 'LIKE', "%{$search}%")
                  ->orWhere('nama_gejala', 'LIKE', "%{$search}%");
        }
        
        $gejalas = $query->orderBy('kode_gejala')->paginate($perPage);
        
        // Untuk AJAX request, kembalikan JSON
        if ($request->ajax() || $request->has('ajax')) {
            $html = view('admin.gejala.index', compact('gejalas', 'search', 'perPage'))->render();
            
            // Extract only tbody content
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            
            $tbody = $dom->getElementsByTagName('tbody')->item(0);
            $tbodyHtml = '';
            if ($tbody) {
                foreach ($tbody->childNodes as $child) {
                    $tbodyHtml .= $dom->saveHTML($child);
                }
            }
            
            $pagination = (string) $gejalas->appends(['search' => $search, 'per_page' => $perPage])->links();
            
            return response()->json([
                'data' => $tbodyHtml,
                'pagination' => $pagination,
                'total' => $gejalas->total(),
                'from' => $gejalas->firstItem(),
                'to' => $gejalas->lastItem(),
                'current_page' => $gejalas->currentPage(),
                'last_page' => $gejalas->lastPage(),
            ]);
        }
        
        return view('admin.gejala.index', compact('gejalas', 'search', 'perPage'));
    }

    /**
     * Menyimpan data gejala beserta parameter fuzzy ke database
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_gejala' => 'required|string|max:5|unique:gejala,kode_gejala',
            'nama_gejala' => 'required|string|max:255',
            'fuzzy_a'     => 'required|numeric',
            'fuzzy_b'     => 'required|numeric',
            'fuzzy_c'     => 'required|numeric',
            'fuzzy_d'     => 'required|numeric',
        ]);

        Gejala::create($data);

        return redirect()->route('gejala')->with('success', 'Data kriteria gejala dan parameter fuzzy berhasil ditambahkan.');
    }

    /**
     * Memperbarui data gejala dan parameter fuzzy (SUDAH DIPERBAIKI)
     */
    public function update(Request $request, $id)
    {
        // Ambil data gejala berdasarkan ID yang dikirim
        $gejala = Gejala::findOrFail($id);

        $data = $request->validate([
            'kode_gejala' => 'required|string|max:5|unique:gejala,kode_gejala,' . $gejala->id,
            'nama_gejala' => 'required|string|max:255',
            'fuzzy_a'     => 'required|numeric',
            'fuzzy_b'     => 'required|numeric',
            'fuzzy_c'     => 'required|numeric',
            'fuzzy_d'     => 'required|numeric',
        ]);

        $gejala->update($data);

        return redirect()->route('gejala')->with('success', 'Kriteria gejala dan parameter fuzzy berhasil diperbarui.');
    }

    /**
     * Menghapus data gejala
     */
    public function destroy($id)
    {
        $gejala = Gejala::findOrFail($id);

        DB::beginTransaction();
        try {
            // Hapus relasi di tabel anak terlebih dahulu jika ada
            $gejala->ruleDetails()->delete();
            $gejala->delete();

            DB::commit();
            return redirect()->route('gejala')->with('success', 'Data gejala berhasil dihapus dari sistem.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('gejala')->withErrors(['error' => 'Gagal menghapus gejala: ' . $e->getMessage()]);
        }
    }
}