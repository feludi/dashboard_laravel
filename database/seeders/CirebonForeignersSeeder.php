<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CirebonForeignersSeeder extends Seeder
{
    public function run(): void
    {
        // Sample foreigner data for Cirebon immigration office jurisdiction
        $foreigners = [
            [
                'name' => 'Wang Wei',
                'nationality' => 'China',
                'passport_number' => 'G12345678',
                'visa_type' => 'Visit',
                'entry_date' => '2024-01-15',
                'expiry_date' => '2024-07-15',
                'address' => 'Jl. Kesambi Raya No. 123, Kesambi',
                'city' => 'Cirebon',
                'state_province' => 'Kota Cirebon',
                'postal_code' => '45133',
                'latitude' => -6.7320,
                'longitude' => 108.5520,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Akira Tanaka',
                'nationality' => 'Japan',
                'passport_number' => 'TH9876543',
                'visa_type' => 'Work',
                'entry_date' => '2023-12-01',
                'expiry_date' => '2025-12-01',
                'address' => 'Jl. Ahmad Yani No. 45, Indramayu',
                'city' => 'Indramayu',
                'state_province' => 'Kabupaten Indramayu',
                'postal_code' => '45211',
                'latitude' => -6.3264,
                'longitude' => 108.3200,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sarah Johnson',
                'nationality' => 'United States',
                'passport_number' => 'US5551234',
                'visa_type' => 'Tourist',
                'entry_date' => '2024-06-10',
                'expiry_date' => '2024-09-10',
                'address' => 'Jl. Raya Majalengka No. 67, Majalengka',
                'city' => 'Majalengka',
                'state_province' => 'Kabupaten Majalengka',
                'postal_code' => '45411',
                'latitude' => -6.8363,
                'longitude' => 108.2275,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mohamed Ali',
                'nationality' => 'Malaysia',
                'passport_number' => 'MY7778888',
                'visa_type' => 'Business',
                'entry_date' => '2024-03-20',
                'expiry_date' => '2024-09-20',
                'address' => 'Jl. Siliwangi No. 89, Kuningan',
                'city' => 'Kuningan',
                'state_province' => 'Kabupaten Kuningan',
                'postal_code' => '45511',
                'latitude' => -6.9756,
                'longitude' => 108.4815,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pavel Novak',
                'nationality' => 'Czech Republic',
                'passport_number' => 'CZ1112222',
                'visa_type' => 'Student',
                'entry_date' => '2024-02-01',
                'expiry_date' => '2025-02-01',
                'address' => 'Jl. Veteran No. 12, Sumber',
                'city' => 'Cirebon',
                'state_province' => 'Kabupaten Cirebon',
                'postal_code' => '45611',
                'latitude' => -6.7063,
                'longitude' => 108.5571,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Priya Sharma',
                'nationality' => 'India',
                'passport_number' => 'IN3334444',
                'visa_type' => 'Work',
                'entry_date' => '2023-11-15',
                'expiry_date' => '2025-11-15',
                'address' => 'Jl. Raya Patrol No. 34, Patrol',
                'city' => 'Indramayu',
                'state_province' => 'Kabupaten Indramayu',
                'postal_code' => '45256',
                'latitude' => -6.2500,
                'longitude' => 108.2800,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Clear existing data first (optional)
        // DB::table('foreigners')->truncate();

        // Insert the sample data
        DB::table('foreigners')->insert($foreigners);
    }
}
