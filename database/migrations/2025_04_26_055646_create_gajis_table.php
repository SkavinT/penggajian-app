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
        Schema::create('gajis', function (Blueprint $table) {
            $table->id(); // <-- Tambahkan baris ini
            $table->foreignId('pegawai_id')->constrained()->onDelete('cascade');
            $table->integer('gaji_pokok');
            $table->integer('tunjangan')->nullable();
            $table->integer('potongan')->nullable();
            $table->integer('total_gaji');
            $table->timestamps(); // opsional, jika ingin created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
