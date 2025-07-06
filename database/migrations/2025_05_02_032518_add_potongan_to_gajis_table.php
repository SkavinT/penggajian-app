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
        Schema::table('gajis', function (Blueprint $table) {
            // $table->integer('potongan')->nullable()->after('tunjangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gajis', function (Blueprint $table) {
            $table->dropColumn('potongan');
        });
    }
};
