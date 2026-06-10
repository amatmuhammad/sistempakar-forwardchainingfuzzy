<?php
// app/Models/KonsultasiDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KonsultasiDetail extends Model
{
    protected $table = 'konsultasi_details';
    
    protected $fillable = [
        'konsultasi_id',
        'gejala_id',
        'nilai_crisp'
    ];

    protected $casts = [
        'nilai_crisp' => 'float'
    ];

    /**
     * Relasi ke model Konsultasi
     */
    public function konsultasi(): BelongsTo
    {
        return $this->belongsTo(Konsultasi::class, 'konsultasi_id');
    }

    /**
     * Relasi ke model Gejala
     */
    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class, 'gejala_id');
    }
}