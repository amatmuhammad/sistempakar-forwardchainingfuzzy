<?php
// app/Models/Gejala.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gejala extends Model
{
    protected $table = 'gejala';
    
    protected $fillable = [
        'kode_gejala',
        'nama_gejala',
        'fuzzy_a',
        'fuzzy_b',
        'fuzzy_c',
        'fuzzy_d'
    ];

    /**
     * Relasi ke RuleDetail
     */
    public function ruleDetails(): HasMany
    {
        return $this->hasMany(RuleDetail::class, 'gejala_id');
    }

    /**
     * Ambil parameter fuzzy sebagai array
     */
    public function getFuzzyParams(): array
    {
        return [
            'a' => $this->fuzzy_a,
            'b' => $this->fuzzy_b,
            'c' => $this->fuzzy_c,
            'd' => $this->fuzzy_d,
        ];
    }
}