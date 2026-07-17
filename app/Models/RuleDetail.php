<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RuleDetail extends Model
{
    protected $fillable = [
        'rule_id',
        'gejala_id',
        'bobot',
    ];

    protected $casts = [
        'bobot' => 'float',
    ];

    /**
     * Relasi ke rule
     */
    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class);
    }

    /**
     * Relasi ke gejala
     */
    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class);
    }
}