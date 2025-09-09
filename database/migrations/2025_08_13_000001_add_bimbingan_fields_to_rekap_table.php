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
        Schema::table('rekap', function (Blueprint $table) {
            $table->text('masalah')->nullable()->after('keterangan');
            $table->text('solusi')->nullable()->after('masalah');
            $table->text('tindak_lanjut')->nullable()->after('solusi');
            $table->string('status', 50)->nullable()->after('tindak_lanjut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekap', function (Blueprint $table) {
            $table->dropColumn([
                'masalah',
                'solusi',
                'tindak_lanjut',
                'status'
            ]);
        });
    }
};
