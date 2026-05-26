<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clear existing regions first
        DB::table('regions')->truncate();
        
        // Insert Cirebon immigration office jurisdiction regions
        DB::table('regions')->insert([
            [
                'name' => 'Kabupaten Cirebon',
                'code' => 'CRB_KAB',
                'country' => 'Indonesia',
                'latitude' => -6.7063,
                'longitude' => 108.5571,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kota Cirebon',
                'code' => 'CRB_KOTA',
                'country' => 'Indonesia',
                'latitude' => -6.7320,
                'longitude' => 108.5520,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kabupaten Indramayu',
                'code' => 'IDM',
                'country' => 'Indonesia',
                'latitude' => -6.3264,
                'longitude' => 108.3200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kabupaten Majalengka',
                'code' => 'MJL',
                'country' => 'Indonesia',
                'latitude' => -6.8363,
                'longitude' => 108.2275,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kabupaten Kuningan',
                'code' => 'KNG',
                'country' => 'Indonesia',
                'latitude' => -6.9756,
                'longitude' => 108.4815,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('regions')->truncate();
    }
};
