<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\RuleDetail;
use Illuminate\Http\Request;

class AdminRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validasi per_page
        $perPage = $request->get('per_page', 10);
        $allowedPerPage = [5, 10, 25, 50, 100];
        
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        // Ambil data rules dengan relasi
        $rules = Rule::with(['penyakit', 'ruleDetails.gejala'])
            ->orderBy('kode_rule', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        // Ambil data untuk dropdown
        $penyakits = Penyakit::orderBy('nama_penyakit', 'asc')->get();
        $gejalas = Gejala::orderBy('kode_gejala', 'asc')->get();

        return view('admin.rules.index', compact('rules', 'penyakits', 'gejalas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_rule'      => 'required|string|max:5|unique:rules,kode_rule',
            'penyakit_id'    => 'required|exists:penyakit,id',
            'kondisi_fuzzy'  => 'required|in:Tidak Yakin,Yakin,Sangat Yakin',
            'gejala'         => 'required|array|min:1',
            'gejala.*.id'    => 'required|exists:gejala,id',
            'gejala.*.bobot' => 'required|numeric|min:0|max:1',
        ]);

        $rule = Rule::create([
            'kode_rule'     => $request->kode_rule,
            'penyakit_id'   => $request->penyakit_id,
            'kondisi_fuzzy' => $request->kondisi_fuzzy,
        ]);

        // PERBAIKAN: Loop tanpa key, ambil ID dari $data['id']
        foreach ($request->gejala as $data) {
            $rule->ruleDetails()->create([
                'gejala_id' => $data['id'],  // ✅ Ambil ID gejala dari array
                'bobot'     => $data['bobot'],
            ]);
        }

        return redirect()->route('rules')->with('success', 'Rule berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $rule = Rule::findOrFail($id);
        
        $request->validate([
            'kode_rule'      => 'required|string|max:5|unique:rules,kode_rule,' . $id,
            'penyakit_id'    => 'required|exists:penyakit,id',
            'kondisi_fuzzy'  => 'required|in:Tidak Yakin,Yakin,Sangat Yakin',
            'gejala'         => 'required|array|min:1',
            'gejala.*.id'    => 'required|exists:gejala,id',
            'gejala.*.bobot' => 'required|numeric|min:0|max:1',
        ]);

        $rule->update([
            'kode_rule'     => $request->kode_rule,
            'penyakit_id'   => $request->penyakit_id,
            'kondisi_fuzzy' => $request->kondisi_fuzzy,
        ]);

        // Hapus rule details lama
        $rule->ruleDetails()->delete();
        
        // PERBAIKAN: Loop tanpa key, ambil ID dari $data['id']
        foreach ($request->gejala as $data) {
            $rule->ruleDetails()->create([
                'gejala_id' => $data['id'],  // ✅ Ambil ID gejala dari array
                'bobot'     => $data['bobot'],
            ]);
        }

        return redirect()->route('rules')->with('success', 'Rule berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rule = Rule::findOrFail($id);
        
        // Hapus rule details terlebih dahulu
        $rule->ruleDetails()->delete();
        
        // Hapus rule
        $rule->delete();

        return redirect()->route('rules')->with('success', 'Rule berhasil dihapus!');
    }
}