<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gejala', function (Blueprint $table): void {
            $table->id();
            $table->string('kode_gejala', 5)->unique();
            $table->string('nama_gejala', 150);
            $table->double('fuzzy_a')->default(0);
            $table->double('fuzzy_b')->default(0);
            $table->double('fuzzy_c')->default(0);
            $table->double('fuzzy_d')->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gejala');
    }
};
