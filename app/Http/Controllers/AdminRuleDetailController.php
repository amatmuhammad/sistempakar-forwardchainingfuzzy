<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Rule;
use App\Models\RuleDetail;
use Illuminate\Http\Request;

class AdminRuleDetailController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $allowedPerPage = [5, 10, 25, 50, 100];

        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $ruleDetails = RuleDetail::with(['rule', 'gejala'])
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        $rules = Rule::orderBy('kode_rule', 'asc')->get();
        $gejalas = Gejala::orderBy('kode_gejala', 'asc')->get();

        return view('admin.rule-details.index', compact('ruleDetails', 'rules', 'gejalas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rule_id' => 'required|exists:rules,id',
            'gejala_id' => 'required|exists:gejala,id',
            'bobot' => 'required|numeric|min:0|max:1',
        ]);

        RuleDetail::create([
            'rule_id' => $request->rule_id,
            'gejala_id' => $request->gejala_id,
            'bobot' => $request->bobot,
        ]);

        return redirect()->route('rule-details')->with('success', 'Data rule detail berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $ruleDetail = RuleDetail::findOrFail($id);

        $request->validate([
            'rule_id' => 'required|exists:rules,id',
            'gejala_id' => 'required|exists:gejala,id',
            'bobot' => 'required|numeric|min:0|max:1',
        ]);

        $ruleDetail->update([
            'rule_id' => $request->rule_id,
            'gejala_id' => $request->gejala_id,
            'bobot' => $request->bobot,
        ]);

        return redirect()->route('rule-details')->with('success', 'Data rule detail berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ruleDetail = RuleDetail::findOrFail($id);
        $ruleDetail->update(['rule_id' => null, 'gejala_id' => null]);
        $ruleDetail->delete();

        return redirect()->route('rule-details')->with('success', 'Data rule detail berhasil dihapus!');
    }
}
