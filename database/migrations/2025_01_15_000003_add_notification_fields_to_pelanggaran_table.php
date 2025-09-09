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
        Schema::table('pelanggaran', function (Blueprint $table) {
            $table->boolean('notifikasi_terkirim')->default(false)->after('point_pelanggaran');
            $table->timestamp('tanggal_notifikasi')->nullable()->after('notifikasi_terkirim');
            $table->text('pesan_notifikasi')->nullable()->after('tanggal_notifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggaran', function (Blueprint $table) {
            $table->dropColumn(['notifikasi_terkirim', 'tanggal_notifikasi', 'pesan_notifikasi']);
        });
    }
};
