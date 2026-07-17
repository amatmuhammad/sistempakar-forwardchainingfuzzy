<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use Illuminate\Http\Request;

class AdminPenyakitController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        
        // Validasi per_page agar aman
        $allowedPerPage = [5, 10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $penyakits = Penyakit::orderBy('id', 'asc')->paginate($perPage)->withQueryString();

        return view('admin.penyakit.index', compact('penyakits'));
    }

    public function create()
    {
        return view('penyakit.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_penyakit' => 'required|string|max:5|unique:penyakit,kode_penyakit',
            'nama_penyakit' => 'required|string|max:100',
            'definisi' => 'nullable|string',
            'saran_penanganan' => 'nullable|string',
        ]);

        Penyakit::create($data);
        return redirect()->route('penyakit')->with('success', 'Penyakit dibuat.');
    }

    public function edit(Penyakit $penyakit)
    {
        return view('admin.penyakit.edit', compact('penyakit'));
    }

    public function update(Request $request, $id)
    {
        $penyakit = Penyakit::findOrFail($id);

        $data = $request->validate([
            'kode_penyakit' => 'required|string|max:5|unique:penyakit,kode_penyakit,' . $penyakit->id,
            'nama_penyakit' => 'required|string|max:100',
            'definisi' => 'nullable|string',
            'saran_penanganan' => 'nullable|string',
        ]);

        $penyakit->update($data);
        return redirect()->route('penyakit')->with('success', 'Penyakit diperbarui.');
    }

    public function destroy($id)
    {
        $penyakit = Penyakit::findOrFail($id);
        $penyakit->delete();
        return redirect()->route('penyakit')->with('success', 'Penyakit dihapus.');
    }
}
