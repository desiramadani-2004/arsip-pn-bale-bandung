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
        Schema::create('kategori_bagians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bagian'); // cth: Kepaniteraan Pidana
            $table->string('kelompok'); // cth: Kepaniteraan / Kesekretariatan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_bagians');
    }
};
