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
        Schema::table('konsultasi', function (Blueprint $table) {
            // Drop the existing enum constraint and recreate with new values
            $table->dropColumn('status_baca');
        });
        
        Schema::table('konsultasi', function (Blueprint $table) {
            // Add the column back with updated enum values
            $table->enum('status_baca', [
                'belum dibaca', 
                'sudah dibaca', 
                'dalam percakapan',
                'selesai'
            ])->default('belum dibaca')->after('tgl_curhat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->dropColumn('status_baca');
        });
        
        Schema::table('konsultasi', function (Blueprint $table) {
            // Restore original enum values
            $table->enum('status_baca', ['belum dibaca', 'sudah dibaca'])
                  ->default('belum dibaca')
                  ->after('tgl_curhat');
        });
    }
};
