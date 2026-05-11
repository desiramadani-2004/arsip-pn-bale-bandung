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
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen');
            $table->string('judul_arsip');
            $table->text('deskripsi_metadata');
            $table->string('file_path');
            $table->enum('status_akses', ['public', 'private'])->default('private');

            // Relasi tabel
            $table->foreignId('kategori_bagian_id')->constrained('kategori_bagians')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();

            // Index Full-Text Search untuk MySQL
            $table->fullText(['nomor_dokumen', 'judul_arsip', 'deskripsi_metadata']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};
