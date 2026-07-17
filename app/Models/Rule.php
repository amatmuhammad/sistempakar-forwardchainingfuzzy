<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rule extends Model
{
    protected $fillable = [
        'kode_rule',
        'penyakit_id',
        'kondisi_fuzzy',
        'output_a',
        'output_b',
        'output_c',
        'output_d',
    ];

    protected $casts = [
        'output_a' => 'float',
        'output_b' => 'float',
        'output_c' => 'float',
        'output_d' => 'float',
    ];

    /**
     * Daftar kondisi fuzzy yang tersedia
     */
    const KONDISI_TIDAK_YAKIN = 'Tidak Yakin';
    const KONDISI_YAKIN = 'Yakin';
    const KONDISI_SANGAT_YAKIN = 'Sangat Yakin';

    /**
     * Relasi ke penyakit
     */
    public function penyakit(): BelongsTo
    {
        return $this->belongsTo(Penyakit::class);
    }

    /**
     * Relasi ke detail rule (gejala + bobot)
     */
    public function ruleDetails(): HasMany
    {
        return $this->hasMany(RuleDetail::class);
    }

    /**
     * Scope untuk filter berdasarkan kondisi fuzzy
     */
    public function scopeKondisiFuzzy($query, string $kondisi)
    {
        return $query->where('kondisi_fuzzy', $kondisi);
    }

    /**
     * Scope untuk filter berdasarkan penyakit
     */
    public function scopePenyakitId($query, int $penyakitId)
    {
        return $query->where('penyakit_id', $penyakitId);
    }

    /**
     * Ambil parameter output sebagai array
     */
    public function getOutputParams(): array
    {
        return [
            'a' => $this->output_a,
            'b' => $this->output_b,
            'c' => $this->output_c,
            'd' => $this->output_d,
        ];
    }

    /**
     * Cek apakah rule ini untuk kondisi Tidak Yakin
     */
    public function isTidakYakin(): bool
    {
        return $this->kondisi_fuzzy === self::KONDISI_TIDAK_YAKIN;
    }

    /**
     * Cek apakah rule ini untuk kondisi Yakin
     */
    public function isYakin(): bool
    {
        return $this->kondisi_fuzzy === self::KONDISI_YAKIN;
    }

    /**
     * Cek apakah rule ini untuk kondisi Sangat Yakin
     */
    public function isSangatYakin(): bool
    {
        return $this->kondisi_fuzzy === self::KONDISI_SANGAT_YAKIN;
    }
}