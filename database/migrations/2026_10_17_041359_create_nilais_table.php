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
        Schema::create('t003_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('t003_mahasiswa')->cascadeOnDelete();
            $table->foreignId('matakuliah_id')->constrained('t003_matakuliah')->cascadeOnDelete();
            $table->unsignedTinyInteger('nilai_angka');
            $table->string('nilai_huruf', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t003_nilai');
    }
};
