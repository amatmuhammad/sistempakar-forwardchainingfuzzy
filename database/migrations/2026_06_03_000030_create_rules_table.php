<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rules', function (Blueprint $table): void {
            $table->id();
            $table->string('kode_rule', 5)->unique();
            $table->foreignId('penyakit_id')->constrained('penyakit')->onDelete('cascade');
            $table->enum('kondisi_fuzzy', ['Rendah', 'Sedang', 'Tinggi']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
