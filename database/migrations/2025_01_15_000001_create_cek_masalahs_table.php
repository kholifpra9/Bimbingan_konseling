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
        Schema::create('cek_masalahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->string('kategori_masalah'); // akademik, sosial, pribadi, karir
            $table->json('masalah_terpilih'); // Array masalah yang dipilih siswa
            $table->text('masalah_lain')->nullable(); // Masalah tambahan yang ditulis siswa
            $table->enum('tingkat_urgensi', ['rendah', 'sedang', 'tinggi'])->default('rendah');
            $table->text('deskripsi_tambahan')->nullable(); // Deskripsi tambahan dari siswa
            $table->enum('status', ['pending', 'reviewed', 'follow_up', 'completed'])->default('pending');
            $table->text('catatan_guru')->nullable(); // Catatan dari guru BK
            $table->text('tindak_lanjut')->nullable(); // Rencana tindak lanjut dari guru BK
            $table->timestamp('tanggal_review')->nullable(); // Kapan guru BK mereview
            $table->timestamp('tanggal_tindak_lanjut')->nullable(); // Kapan tindak lanjut dilakukan
            $table->timestamps();

            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade');
            $table->index(['id_siswa', 'status']);
            $table->index('kategori_masalah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cek_masalahs');
    }
};
