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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nama');
            $table->string('email')->unique();   // ← Tambahkan kolom email di sini
            $table->string('jabatan');
            $table->integer('gaji_pokok');
            $table->text('alamat');
            $table->string('telepon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
