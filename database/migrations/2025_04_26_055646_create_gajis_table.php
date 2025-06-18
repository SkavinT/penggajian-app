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
            $table->id();

            $table->foreignId('pegawai_id')->constrained()->onDelete('cascade');
            $table->foreignId('potongan_id')->nullable()->constrained('potongans')->onDelete('set null');
            $table->integer('gaji_pokok');
            $table->integer('tunjangan')->nullable();
            $table->integer('total_gaji');
            $table->date('tanggal');
            $table->timestamps();

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
