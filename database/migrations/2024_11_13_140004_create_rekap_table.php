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
        Schema::create('rekap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->string('jenis_bimbingan', 50);
            $table->date('tgl_bimbingan');
            $table->text('keterangan');
            $table->text('balasan')->nullable();
            $table->timestamps();

            $table->foreign('id_siswa')
            ->references('id')
            ->on('siswa')  // Pastikan tabel referensi benar, dalam hal ini 'users' bukan 'user'
            ->onUpdate('cascade')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap');
    }
};
