<?php

namespace Database\Seeders;

use App\Models\Foreigner;
use App\Models\Region;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users first
        $this->call(UserSeeder::class);
        
        // Create regions first
        $regions = [
            [
                'name' => 'Jakarta',
                'code' => 'JKT',
                'country' => 'Indonesia',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'population' => 10770000,
                'description' => 'Capital city of Indonesia'
            ],
            [
                'name' => 'Bali',
                'code' => 'BAL',
                'country' => 'Indonesia',
                'latitude' => -8.3405,
                'longitude' => 115.0920,
                'population' => 4300000,
                'description' => 'Popular tourist destination'
            ],
            [
                'name' => 'Yogyakarta',
                'code' => 'YOG',
                'country' => 'Indonesia',
                'latitude' => -7.7956,
                'longitude' => 110.3695,
                'population' => 420000,
                'description' => 'Cultural center of Java'
            ],
            [
                'name' => 'Surabaya',
                'code' => 'SBY',
                'country' => 'Indonesia',
                'latitude' => -7.2575,
                'longitude' => 112.7521,
                'population' => 2800000,
                'description' => 'Second largest city in Indonesia'
            ]
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }

        // Create sample foreigners
        $foreigners = [
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'nationality' => 'United States',
                'passport_number' => 'US123456789',
                'date_of_birth' => '1985-05-15',
                'gender' => 'male',
                'occupation' => 'Software Engineer',
                'visa_type' => 'B211B',
                'visa_expiry_date' => '2025-12-31',
                'current_address' => 'Jl. Sudirman No. 123',
                'city' => 'Jakarta',
                'state_province' => 'Jakarta',
                'postal_code' => '12190',
                'country' => 'Indonesia',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'phone_number' => '+62812345678',
                'email' => 'john.smith@email.com',
                'emergency_contact_name' => 'Jane Smith',
                'emergency_contact_phone' => '+1234567890',
                'entry_date' => '2024-06-15',
                'entry_point' => 'Soekarno-Hatta International Airport',
                'notes' => 'Working for tech company',
                'status' => 'active'
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Garcia',
                'nationality' => 'Spain',
                'passport_number' => 'ES987654321',
                'date_of_birth' => '1990-08-22',
                'gender' => 'female',
                'occupation' => 'Digital Nomad',
                'visa_type' => 'B211B',
                'visa_expiry_date' => '2025-08-15',
                'current_address' => 'Jl. Monkey Forest Road',
                'city' => 'Ubud',
                'state_province' => 'Bali',
                'postal_code' => '80571',
                'country' => 'Indonesia',
                'latitude' => -8.5069,
                'longitude' => 115.2625,
                'phone_number' => '+6281987654',
                'email' => 'maria.garcia@email.com',
                'emergency_contact_name' => 'Carlos Garcia',
                'emergency_contact_phone' => '+34123456789',
                'entry_date' => '2024-02-20',
                'entry_point' => 'Ngurah Rai International Airport',
                'notes' => 'Freelance graphic designer',
                'status' => 'active'
            ],
            [
                'first_name' => 'Hiroshi',
                'last_name' => 'Tanaka',
                'nationality' => 'Japan',
                'passport_number' => 'JP456789123',
                'date_of_birth' => '1978-12-03',
                'gender' => 'male',
                'occupation' => 'Business Consultant',
                'visa_type' => 'B211A',
                'visa_expiry_date' => '2025-03-10',
                'current_address' => 'Jl. Malioboro No. 45',
                'city' => 'Yogyakarta',
                'state_province' => 'Yogyakarta',
                'postal_code' => '55213',
                'country' => 'Indonesia',
                'latitude' => -7.7956,
                'longitude' => 110.3695,
                'phone_number' => '+62813456789',
                'email' => 'h.tanaka@email.com',
                'emergency_contact_name' => 'Yuki Tanaka',
                'emergency_contact_phone' => '+81234567890',
                'entry_date' => '2024-09-05',
                'entry_point' => 'Adisutcipto International Airport',
                'notes' => 'Setting up regional office',
                'status' => 'active'
            ],
            [
                'first_name' => 'Emma',
                'last_name' => 'Wilson',
                'nationality' => 'Australia',
                'passport_number' => 'AU789123456',
                'date_of_birth' => '1992-03-18',
                'gender' => 'female',
                'occupation' => 'English Teacher',
                'visa_type' => 'B211B',
                'visa_expiry_date' => '2024-01-30',
                'current_address' => 'Jl. Pemuda No. 67',
                'city' => 'Surabaya',
                'state_province' => 'Surabaya',
                'postal_code' => '60271',
                'country' => 'Indonesia',
                'latitude' => -7.2575,
                'longitude' => 112.7521,
                'phone_number' => '+62814567890',
                'email' => 'emma.wilson@email.com',
                'emergency_contact_name' => 'Robert Wilson',
                'emergency_contact_phone' => '+61234567890',
                'entry_date' => '2023-07-15',
                'entry_point' => 'Juanda International Airport',
                'notes' => 'Teaching at international school',
                'status' => 'expired'
            ],
            [
                'first_name' => 'Pierre',
                'last_name' => 'Dubois',
                'nationality' => 'France',
                'passport_number' => 'FR321654987',
                'date_of_birth' => '1987-11-07',
                'gender' => 'male',
                'occupation' => 'Chef',
                'visa_type' => 'B211B',
                'visa_expiry_date' => '2025-11-20',
                'current_address' => 'Jl. Seminyak No. 12',
                'city' => 'Seminyak',
                'state_province' => 'Bali',
                'postal_code' => '80361',
                'country' => 'Indonesia',
                'latitude' => -8.6905,
                'longitude' => 115.1729,
                'phone_number' => '+62815678901',
                'email' => 'pierre.dubois@email.com',
                'emergency_contact_name' => 'Marie Dubois',
                'emergency_contact_phone' => '+33123456789',
                'entry_date' => '2024-05-10',
                'entry_point' => 'Ngurah Rai International Airport',
                'notes' => 'Working at luxury resort',
                'status' => 'active'
            ]
        ];

        foreach ($foreigners as $foreigner) {
            Foreigner::create($foreigner);
        }
    }
}
