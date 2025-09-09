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
        // Add new columns to cek_masalahs table
        Schema::table('cek_masalahs', function (Blueprint $table) {
            $table->json('kategori_masalah_multiple')->nullable()->after('kategori_masalah');
            $table->json('skor_per_kategori')->nullable()->after('masalah_terpilih');
            $table->json('nomor_masalah_per_kategori')->nullable()->after('skor_per_kategori');
            $table->integer('total_masalah')->default(0)->after('nomor_masalah_per_kategori');
            $table->decimal('persentase_keseluruhan', 5, 2)->default(0)->after('total_masalah');
        });

        // Add new columns to siswa table
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('no_tlp_ortu')->nullable()->after('no_tlp');
            $table->integer('total_poin_pelanggaran')->default(0)->after('no_tlp_ortu');
            $table->timestamp('last_notification_sent')->nullable()->after('total_poin_pelanggaran');
        });

        // Add new columns to pelanggaran table
        Schema::table('pelanggaran', function (Blueprint $table) {
            $table->integer('poin')->default(0)->after('jenis_pelanggaran');
            $table->boolean('notification_sent')->default(false)->after('poin');
            $table->timestamp('notification_sent_at')->nullable()->after('notification_sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cek_masalahs', function (Blueprint $table) {
            $table->dropColumn([
                'kategori_masalah_multiple',
                'skor_per_kategori',
                'nomor_masalah_per_kategori',
                'total_masalah',
                'persentase_keseluruhan'
            ]);
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn([
                'no_tlp_ortu',
                'total_poin_pelanggaran',
                'last_notification_sent'
            ]);
        });

        Schema::table('pelanggaran', function (Blueprint $table) {
            $table->dropColumn([
                'poin',
                'notification_sent',
                'notification_sent_at'
            ]);
        });
    }
};
