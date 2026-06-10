<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penyakit', function (Blueprint $table): void {
            $table->id();
            $table->string('kode_penyakit', 5)->unique();
            $table->string('nama_penyakit', 100);
            $table->text('definisi')->nullable();
            $table->text('saran_penanganan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyakit');
    }
};
