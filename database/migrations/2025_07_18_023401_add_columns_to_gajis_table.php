<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gajis', function (Blueprint $table) {
            $table->integer('tunjangan_transport')->default(0);
            $table->integer('tunjangan_makan')->default(0);
            $table->integer('potongan_pinjaman')->default(0);
            $table->integer('potongan_keterlambatan')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('gajis', function (Blueprint $table) {
            $table->dropColumn([
                'tunjangan_transport',
                'tunjangan_makan',
                'potongan_pinjaman',
                'potongan_keterlambatan'
            ]);
        });
    }
};