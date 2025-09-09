<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();  // Kolom id sebagai auto_increment primary key
            $table->unsignedBigInteger('id_user');  // Kolom id_user tidak perlu auto_increment
            $table->string('nis', 10);
            $table->string('nama', 50);
            $table->string('kelas', 15);
            $table->string('jurusan', 30);
            $table->string('jenis_kelamin', 20);
            $table->string('no_tlp', 15);
            $table->string('alamat', 50);
            $table->timestamps();
        
            // Definisikan foreign key untuk id_user
            $table->foreign('id_user')
                ->references('id')
                ->on('users')  // Pastikan tabel referensi benar, dalam hal ini 'users' bukan 'user'
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
