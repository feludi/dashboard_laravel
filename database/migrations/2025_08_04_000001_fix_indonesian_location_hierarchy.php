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
        // Fix the Indonesian location hierarchy where data was stored in wrong fields
        // Current incorrect mapping:
        // - city contains subdistrict names (should contain city/regency)
        // - state_province contains city names (should contain subdistrict)
        // - country contains village names (correct)
        
        DB::statement("
            UPDATE foreigners 
            SET 
                city = CASE 
                    WHEN state_province = 'Kota Cirebon' THEN 'Kota Cirebon'
                    WHEN state_province = 'Kabupaten Cirebon' THEN 'Kabupaten Cirebon'
                    WHEN state_province = 'Kabupaten Indramayu' THEN 'Kabupaten Indramayu'
                    WHEN state_province = 'Kabupaten Kuningan' THEN 'Kabupaten Kuningan'
                    WHEN state_province = 'Kabupaten Majalengka' THEN 'Kabupaten Majalengka'
                    ELSE state_province
                END,
                state_province = CASE
                    WHEN city IN ('Harjamukti', 'Kejaksan', 'Lemahwungkuk', 'Pekalipan', 'Kesambi') THEN city
                    ELSE city
                END
            WHERE city IS NOT NULL AND state_province IS NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the fix by swapping the data back
        DB::statement("
            UPDATE foreigners 
            SET 
                state_province = CASE 
                    WHEN city = 'Kota Cirebon' THEN 'Kota Cirebon'
                    WHEN city = 'Kabupaten Cirebon' THEN 'Kabupaten Cirebon'
                    WHEN city = 'Kabupaten Indramayu' THEN 'Kabupaten Indramayu'
                    WHEN city = 'Kabupaten Kuningan' THEN 'Kabupaten Kuningan'
                    WHEN city = 'Kabupaten Majalengka' THEN 'Kabupaten Majalengka'
                    ELSE city
                END,
                city = CASE
                    WHEN state_province IN ('Harjamukti', 'Kejaksan', 'Lemahwungkuk', 'Pekalipan', 'Kesambi') THEN state_province
                    ELSE state_province
                END
            WHERE city IS NOT NULL AND state_province IS NOT NULL
        ");
    }
};
