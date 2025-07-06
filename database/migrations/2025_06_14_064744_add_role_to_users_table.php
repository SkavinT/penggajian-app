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
        Schema::table('users', function (Blueprint $table) {
            // jika kolom belum ada, tambahkan
            if (! Schema::hasColumn('users','role')) {
                $table->string('role')->default('user')->after('password');
            }
            // jika ingin ubah panjang/tipe, gunakan change()
            // $table->string('role',50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // hanya drop kalau kolom benar-benar ada
            if (Schema::hasColumn('users','role')) {
                $table->dropColumn('role');
            }
        });
    }
};
