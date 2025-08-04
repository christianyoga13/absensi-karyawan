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
        Schema::table('absensi', function (Blueprint $table) {
            $table->decimal('latitude_masuk', 10, 8)->nullable()->after('jam_masuk');
            $table->decimal('longitude_masuk', 11, 8)->nullable()->after('latitude_masuk');
            $table->string('alamat_masuk')->nullable()->after('longitude_masuk');
            
            $table->decimal('latitude_keluar', 10, 8)->nullable()->after('jam_keluar');
            $table->decimal('longitude_keluar', 11, 8)->nullable()->after('latitude_keluar');
            $table->string('alamat_keluar')->nullable()->after('longitude_keluar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropColumn([
                'latitude_masuk', 
                'longitude_masuk', 
                'alamat_masuk',
                'latitude_keluar', 
                'longitude_keluar', 
                'alamat_keluar'
            ]);
        });
    }
};
