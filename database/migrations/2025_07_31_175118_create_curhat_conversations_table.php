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
        Schema::create('curhat_conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('konsultasi_id');
            $table->unsignedBigInteger('sender_id');
            $table->enum('sender_type', ['siswa', 'gurubk']);
            $table->text('message');
            $table->string('attachment')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('konsultasi_id')->references('id')->on('konsultasi')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['konsultasi_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curhat_conversations');
    }
};
