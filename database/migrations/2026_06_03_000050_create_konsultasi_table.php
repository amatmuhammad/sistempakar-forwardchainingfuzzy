<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('konsultasi', function (Blueprint $table): void {
            $table->id();
            $table->string('nama_pemilik', 100);
            $table->string('nama_ternak', 50);
            $table->timestamp('tanggal_periksa')->useCurrent();
            $table->foreignId('penyakit_id')->nullable()->constrained('penyakit')->nullOnDelete();
            $table->double('nilai_keyakinan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
