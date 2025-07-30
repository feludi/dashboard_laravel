<?php

namespace Database\Seeders;

use App\Models\Movement;
use App\Models\Foreigner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foreigners = Foreigner::all();
        
        if ($foreigners->count() == 0) {
            $this->command->info('No foreigners found. Please seed foreigners first.');
            return;
        }

        // Sample movement data for different time periods
        $movements = [
            // Real-time movements (last 24 hours)
            [
                'foreigner_id' => $foreigners->random()->id,
                'from_latitude' => -6.7063,
                'from_longitude' => 108.5571,
                'from_location' => 'Jl. Karanggetas No.7, Karanggetas, Cirebon',
                'to_latitude' => -6.7158,
                'to_longitude' => 108.5492,
                'to_location' => 'Keraton Kasepuhan Cirebon',
                'movement_type' => 'visit',
                'purpose' => 'Kunjungan wisata ke Keraton Kasepuhan',
                'movement_date' => Carbon::now()->subHours(2),
                'status' => 'active',
            ],
            [
                'foreigner_id' => $foreigners->random()->id,
                'from_latitude' => -6.7200,
                'from_longitude' => 108.5600,
                'from_location' => 'Hotel Bentani Cirebon',
                'to_latitude' => -6.7063,
                'to_longitude' => 108.5571,
                'to_location' => 'Jl. Tuparev No.15, Cirebon',
                'movement_type' => 'relocation',
                'purpose' => 'Pindah alamat tinggal',
                'movement_date' => Carbon::now()->subHours(5),
                'status' => 'active',
            ],
            [
                'foreigner_id' => $foreigners->random()->id,
                'from_latitude' => -6.7100,
                'from_longitude' => 108.5500,
                'from_location' => 'Jl. Bypass Cirebon',
                'to_latitude' => -6.7320,
                'to_longitude' => 108.5420,
                'to_location' => 'Grage Mall Cirebon',
                'movement_type' => 'visit',
                'purpose' => 'Berbelanja dan makan',
                'movement_date' => Carbon::now()->subHours(8),
                'status' => 'completed',
            ],
            
            // This week movements
            [
                'foreigner_id' => $foreigners->random()->id,
                'from_latitude' => -6.7063,
                'from_longitude' => 108.5571,
                'from_location' => 'Cirebon Kota',
                'to_latitude' => -6.8500,
                'to_longitude' => 108.4800,
                'to_location' => 'Kuningan, Jawa Barat',
                'movement_type' => 'temporary_stay',
                'purpose' => 'Kunjungan kerja selama 3 hari',
                'movement_date' => Carbon::now()->subDays(2),
                'arrival_date' => Carbon::now()->subDays(2),
                'departure_date' => Carbon::now()->addDay(),
                'status' => 'active',
            ],
            [
                'foreigner_id' => $foreigners->random()->id,
                'from_latitude' => -6.7063,
                'from_longitude' => 108.5571,
                'from_location' => 'Cirebon',
                'to_latitude' => -6.5950,
                'to_longitude' => 108.4489,
                'to_location' => 'Indramayu, Jawa Barat',
                'movement_type' => 'visit',
                'purpose' => 'Mengunjungi rekan bisnis',
                'movement_date' => Carbon::now()->subDays(4),
                'status' => 'completed',
            ],
            
            // This month movements
            [
                'foreigner_id' => $foreigners->random()->id,
                'from_latitude' => -6.7063,
                'from_longitude' => 108.5571,
                'from_location' => 'Cirebon',
                'to_latitude' => -6.2088,
                'to_longitude' => 106.8456,
                'to_location' => 'Jakarta Pusat',
                'movement_type' => 'visit',
                'purpose' => 'Meeting dengan klien di Jakarta',
                'movement_date' => Carbon::now()->subWeeks(1),
                'status' => 'completed',
            ],
            [
                'foreigner_id' => $foreigners->random()->id,
                'from_latitude' => -6.9175,
                'from_longitude' => 107.6191,
                'from_location' => 'Bandung, Jawa Barat',
                'to_latitude' => -6.7063,
                'to_longitude' => 108.5571,
                'to_location' => 'Cirebon, Jawa Barat',
                'movement_type' => 'relocation',
                'purpose' => 'Pindah kerja ke Cirebon',
                'movement_date' => Carbon::now()->subWeeks(2),
                'status' => 'completed',
            ],
            [
                'foreigner_id' => $foreigners->random()->id,
                'from_latitude' => -6.7063,
                'from_longitude' => 108.5571,
                'from_location' => 'Cirebon',
                'to_latitude' => -7.7956,
                'to_longitude' => 110.3695,
                'to_location' => 'Yogyakarta',
                'movement_type' => 'temporary_stay',
                'purpose' => 'Pelatihan kerja selama 1 minggu',
                'movement_date' => Carbon::now()->subWeeks(3),
                'arrival_date' => Carbon::now()->subWeeks(3),
                'departure_date' => Carbon::now()->subWeeks(2)->addDay(),
                'status' => 'completed',
            ],
        ];

        foreach ($movements as $movement) {
            Movement::create($movement);
        }

        $this->command->info('Sample movement data created successfully!');
    }
}
