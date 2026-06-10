<?php
// app/Models/Konsultasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';
    
    protected $fillable = [
        'nama_pemilik',
        'nama_ternak',
        'tanggal_periksa',
        'penyakit_id',
        'nilai_keyakinan'
    ];

    protected $casts = [
        'tanggal_periksa' => 'datetime',
        'nilai_keyakinan' => 'float'
    ];

    /**
     * Relasi ke model Penyakit
     */
    public function penyakit(): BelongsTo
    {
        return $this->belongsTo(Penyakit::class, 'penyakit_id');
    }

    /**
     * Relasi ke model KonsultasiDetail
     */
    public function konsultasiDetails(): HasMany
    {
        return $this->hasMany(KonsultasiDetail::class, 'konsultasi_id');
    }
}