<?php
// app/Models/Penyakit.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penyakit extends Model
{
    protected $table = 'penyakit';
    
    protected $fillable = [
        'kode_penyakit',
        'nama_penyakit',
        'definisi',
        'saran_penanganan'
    ];

    /**
     * Relasi ke model Rule
     */
    public function rules(): HasMany
    {
        return $this->hasMany(Rule::class, 'penyakit_id');
    }

    /**
     * Relasi ke konsultasi
     */
    public function konsultasis(): HasMany
    {
        return $this->hasMany(Konsultasi::class, 'penyakit_id');
    }
}