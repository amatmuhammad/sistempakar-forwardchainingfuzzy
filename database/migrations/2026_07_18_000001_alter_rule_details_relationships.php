<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rule_details', function (Blueprint $table) {
            $table->dropForeign(['rule_id']);
            $table->dropForeign(['gejala_id']);
        });

        Schema::table('rule_details', function (Blueprint $table) {
            $table->foreignId('rule_id')->nullable()->change();
            $table->foreignId('gejala_id')->nullable()->change();
        });

        Schema::table('rule_details', function (Blueprint $table) {
            $table->foreign('rule_id')->references('id')->on('rules')->nullOnDelete();
            $table->foreign('gejala_id')->references('id')->on('gejala')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rule_details', function (Blueprint $table) {
            $table->dropForeign(['rule_id']);
            $table->dropForeign(['gejala_id']);
        });

        Schema::table('rule_details', function (Blueprint $table) {
            $table->foreignId('rule_id')->nullable(false)->change();
            $table->foreignId('gejala_id')->nullable(false)->change();
        });

        Schema::table('rule_details', function (Blueprint $table) {
            $table->foreign('rule_id')->references('id')->on('rules')->cascadeOnDelete();
            $table->foreign('gejala_id')->references('id')->on('gejala')->cascadeOnDelete();
        });
    }
};
