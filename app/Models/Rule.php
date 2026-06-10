<?php
// app/Models/Rule.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rule extends Model
{
    protected $table = 'rules';
    
    protected $fillable = [
        'kode_rule',
        'penyakit_id',
        'kondisi_fuzzy'
    ];

    /**
     * Relasi ke model Penyakit
     */
    public function penyakit(): BelongsTo
    {
        return $this->belongsTo(Penyakit::class, 'penyakit_id');
    }

    /**
     * Relasi ke model RuleDetail (nama: details)
     */
    public function details(): HasMany
    {
        return $this->hasMany(RuleDetail::class, 'rule_id');
    }

    /**
     * Alias untuk details
     */
    public function ruleDetails(): HasMany
    {
        return $this->hasMany(RuleDetail::class, 'rule_id');
    }
}