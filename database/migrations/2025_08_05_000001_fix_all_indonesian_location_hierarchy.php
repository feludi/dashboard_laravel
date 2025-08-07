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
        // First, let's see what data we have and fix it systematically
        
        // Known Indonesian administrative hierarchy:
        // Kota/Kabupaten (Cities/Regencies): Kota Cirebon, Kabupaten Cirebon, etc.
        // Kecamatan (Subdistricts): Harjamukti, Kejaksan, Lemahwungkuk, Pekalipan, Kesambi
        // Kelurahan/Desa (Villages): Kesenden, Sukapura, etc.
        
        $cities = ['Kota Cirebon', 'Kabupaten Cirebon', 'Kabupaten Indramayu', 'Kabupaten Kuningan', 'Kabupaten Majalengka'];
        $subdistricts = ['Harjamukti', 'Kejaksan', 'Lemahwungkuk', 'Pekalipan', 'Kesambi'];
        $villages = ['Kesenden', 'Sukapura', 'Larangan', 'Pegambiran', 'Kebonbaru'];
        
        // Fix records where city contains subdistrict names
        foreach ($subdistricts as $subdistrict) {
            DB::statement("
                UPDATE foreigners 
                SET 
                    state_province = city,
                    city = CASE 
                        WHEN state_province IN ('" . implode("','", $cities) . "') THEN state_province
                        WHEN country IN ('" . implode("','", $cities) . "') THEN country
                        ELSE 'Kota Cirebon'
                    END
                WHERE city = ?
            ", [$subdistrict]);
        }
        
        // Fix records where city contains village names
        foreach ($villages as $village) {
            DB::statement("
                UPDATE foreigners 
                SET 
                    country = city,
                    city = CASE 
                        WHEN state_province IN ('" . implode("','", $cities) . "') THEN state_province
                        WHEN country IN ('" . implode("','", $cities) . "') THEN country
                        ELSE 'Kota Cirebon'
                    END,
                    state_province = CASE 
                        WHEN state_province IN ('" . implode("','", $subdistricts) . "') THEN state_province
                        WHEN country IN ('" . implode("','", $subdistricts) . "') THEN country
                        ELSE 'Harjamukti'
                    END
                WHERE city = ?
            ", [$village]);
        }
        
        // Fix records where state_province contains city names
        foreach ($cities as $city) {
            DB::statement("
                UPDATE foreigners 
                SET 
                    city = state_province,
                    state_province = CASE 
                        WHEN city IN ('" . implode("','", $subdistricts) . "') THEN city
                        WHEN country IN ('" . implode("','", $subdistricts) . "') THEN country
                        ELSE 'Harjamukti'
                    END
                WHERE state_province = ?
            ", [$city]);
        }
        
        // Fix records where state_province contains village names
        foreach ($villages as $village) {
            DB::statement("
                UPDATE foreigners 
                SET 
                    country = state_province,
                    state_province = CASE 
                        WHEN city IN ('" . implode("','", $subdistricts) . "') THEN city
                        WHEN country IN ('" . implode("','", $subdistricts) . "') THEN country
                        ELSE 'Harjamukti'
                    END
                WHERE state_province = ?
            ", [$village]);
        }
        
        // Fix records where country contains city names
        foreach ($cities as $city) {
            DB::statement("
                UPDATE foreigners 
                SET 
                    city = country,
                    country = CASE 
                        WHEN city IN ('" . implode("','", $villages) . "') THEN city
                        WHEN state_province IN ('" . implode("','", $villages) . "') THEN state_province
                        ELSE 'Kesenden'
                    END
                WHERE country = ?
            ", [$city]);
        }
        
        // Fix records where country contains subdistrict names
        foreach ($subdistricts as $subdistrict) {
            DB::statement("
                UPDATE foreigners 
                SET 
                    state_province = country,
                    country = CASE 
                        WHEN city IN ('" . implode("','", $villages) . "') THEN city
                        WHEN state_province IN ('" . implode("','", $villages) . "') THEN state_province
                        ELSE 'Kesenden'
                    END
                WHERE country = ?
            ", [$subdistrict]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is a data fix, reversal would be complex and not recommended
        // The original incorrect data would be lost anyway
    }
};
