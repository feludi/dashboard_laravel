<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Foreigner;
use Carbon\Carbon;

class ForeignerSeeder extends Seeder
{
    /**
     * Seed the database with sample foreigner data
     */
    public function run(): void
    {
        // Sample data for testing the system with new residence permit fields
        $testData = [
            [
                'first_name' => 'Ahmad',
                'last_name' => 'Al-Rahman',
                'nationality' => 'Saudi Arabian',
                'passport_number' => 'SA123456789',
                'date_of_birth' => '1990-03-15',
                'gender' => 'male',
                'occupation' => 'Business Consultant',
                'residence_permit_type' => 'ITAS',
                'residence_permit_status' => 'active',
                'residence_permit_issue_date' => '2024-03-15',
                'residence_permit_expiry_date' => '2026-03-15',
                'current_address' => 'Jl. Ahmad Yani No. 123',
                'city' => 'Harjamukti',
                'state_province' => 'Kota Cirebon',
                'country' => 'Harjamukti',
                'postal_code' => '45121',
                'latitude' => -6.7063,
                'longitude' => 108.5678,
                'phone_number' => '+62812345678901',
                'email' => 'ahmad.rahman@email.com',
                'sponsor_contact_name' => 'PT Indo Konsultan',
                'sponsor_contact_number' => '+6221123456789',
                'entry_date' => '2025-01-15',
                'status' => 'active'
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'nationality' => 'Filipino',
                'passport_number' => 'PH987654321',
                'date_of_birth' => '1985-07-22',
                'gender' => 'female',
                'occupation' => 'Nurse',
                'residence_permit_type' => 'ITAS',
                'residence_permit_status' => 'active',
                'residence_permit_issue_date' => '2024-07-22',
                'residence_permit_expiry_date' => '2026-07-22',
                'current_address' => 'Jl. Siliwangi No. 45',
                'city' => 'Cigugur',
                'state_province' => 'Kabupaten Kuningan',
                'country' => 'Cigugur',
                'postal_code' => '45561',
                'latitude' => -6.9543,
                'longitude' => 108.4621,
                'phone_number' => '+62813456789012',
                'email' => 'maria.santos@email.com',
                'sponsor_contact_name' => 'Rumah Sakit Indonesia',
                'sponsor_contact_number' => '+6222987654321',
                'entry_date' => '2025-02-10',
                'status' => 'active'
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'nationality' => 'American',
                'passport_number' => 'US456789123',
                'date_of_birth' => '1988-11-08',
                'gender' => 'male',
                'occupation' => 'English Teacher',
                'residence_permit_type' => 'ITK',
                'residence_permit_status' => 'active',
                'residence_permit_issue_date' => '2024-11-08',
                'residence_permit_expiry_date' => '2025-11-08',
                'current_address' => 'Jl. Sudirman No. 78',
                'city' => 'Waled',
                'state_province' => 'Kabupaten Cirebon',
                'country' => 'Waled',
                'postal_code' => '45173',
                'latitude' => -6.9080,
                'longitude' => 108.7126,
                'phone_number' => '+62814567890123',
                'email' => 'john.smith@email.com',
                'sponsor_contact_name' => 'International School Cirebon',
                'sponsor_contact_number' => '+6231555666777',
                'entry_date' => '2025-03-05',
                'status' => 'active'
            ],
            [
                'first_name' => 'Li',
                'last_name' => 'Wei',
                'nationality' => 'Chinese',
                'passport_number' => 'CN789123456',
                'date_of_birth' => '1992-05-18',
                'gender' => 'male',
                'occupation' => 'Software Engineer',
                'residence_permit_type' => 'ITAP',
                'residence_permit_status' => 'active',
                'residence_permit_issue_date' => '2020-05-18',
                'residence_permit_expiry_date' => null, // ITAP is permanent, no expiry
                'current_address' => 'Jl. Kartini No. 234',
                'city' => 'Indramayu',
                'state_province' => 'Kabupaten Indramayu',
                'country' => 'Indramayu',
                'postal_code' => '45214',
                'latitude' => -6.3267,
                'longitude' => 108.3199,
                'phone_number' => '+62815678901234',
                'email' => 'li.wei@email.com',
                'sponsor_contact_name' => 'PT Tech Indonesia',
                'sponsor_contact_number' => '+6221444555666',
                'entry_date' => '2025-01-20',
                'status' => 'active'
            ],
            [
                'first_name' => 'Priya',
                'last_name' => 'Sharma',
                'nationality' => 'Indian',
                'passport_number' => 'IN321654987',
                'date_of_birth' => '1987-09-12',
                'gender' => 'female',
                'occupation' => 'Marketing Manager',
                'residence_permit_type' => 'ITAS',
                'residence_permit_status' => 'active',
                'residence_permit_issue_date' => '2024-09-12',
                'residence_permit_expiry_date' => '2026-09-12',
                'current_address' => 'Jl. Diponegoro No. 567',
                'city' => 'Majalengka',
                'state_province' => 'Kabupaten Majalengka',
                'country' => 'Majalengka',
                'postal_code' => '45411',
                'latitude' => -6.8361,
                'longitude' => 108.2278,
                'phone_number' => '+62816789012345',
                'email' => 'priya.sharma@email.com',
                'sponsor_contact_name' => 'PT Marketing Solutions',
                'sponsor_contact_number' => '+6222777888999',
                'entry_date' => '2025-02-28',
                'status' => 'active'
            ],
            [
                'first_name' => 'Hans',
                'last_name' => 'Mueller',
                'nationality' => 'German',
                'passport_number' => 'DE654321789',
                'date_of_birth' => '1983-12-03',
                'gender' => 'male',
                'occupation' => 'Mechanical Engineer',
                'residence_permit_type' => 'ITK',
                'residence_permit_status' => 'active',
                'residence_permit_issue_date' => '2024-12-03',
                'residence_permit_expiry_date' => '2025-12-03',
                'current_address' => 'Jl. Gatot Subroto No. 89',
                'city' => 'Lemahwungkuk',
                'state_province' => 'Kota Cirebon',
                'country' => 'Lemahwungkuk',
                'postal_code' => '45111',
                'latitude' => -6.7324,
                'longitude' => 108.5516,
                'phone_number' => '+62817890123456',
                'email' => 'hans.mueller@email.com',
                'sponsor_contact_name' => 'PT Engineering Indonesia',
                'sponsor_contact_number' => '+6231888999000',
                'entry_date' => '2024-12-03',
                'status' => 'active'
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Brown',
                'nationality' => 'British',
                'passport_number' => 'GB258147369',
                'date_of_birth' => '1984-10-11',
                'gender' => 'male',
                'occupation' => 'Oil & Gas Consultant',
                'residence_permit_type' => 'other',
                'residence_permit_status' => 'expired',
                'residence_permit_issue_date' => '2024-01-15',
                'residence_permit_expiry_date' => '2025-07-15',
                'current_address' => 'Jl. Proklamasi No. 321',
                'city' => 'Pekalipan',
                'state_province' => 'Kota Cirebon',
                'country' => 'Pekalipan',
                'postal_code' => '45131',
                'latitude' => -6.7184,
                'longitude' => 108.5406,
                'phone_number' => '+62821234567890',
                'email' => 'robert.brown@email.com',
                'sponsor_contact_name' => 'Oil & Gas Consulting Ltd',
                'sponsor_contact_number' => '+6221000111222',
                'entry_date' => '2024-07-15',
                'status' => 'expired'
            ]
        ];

        foreach ($testData as $foreigner) {
            Foreigner::create($foreigner);
        }
    }
}
