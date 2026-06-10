<?php
// app/Models/RuleDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RuleDetail extends Model
{
    protected $table = 'rule_details';
    
    protected $fillable = [
        'rule_id',
        'gejala_id',
        'bobot'
    ];

    /**
     * Relasi ke model Rule
     */
    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class, 'rule_id');
    }

    /**
     * Relasi ke model Gejala
     */
    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class, 'gejala_id');
    }
}