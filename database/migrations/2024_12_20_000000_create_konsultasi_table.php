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
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->text('isi_curhat');
            $table->timestamp('tgl_curhat');
            $table->enum('status_baca', ['belum dibaca', 'sudah dibaca'])->default('belum dibaca');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_siswa')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
