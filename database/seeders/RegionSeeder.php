<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            [
                'name' => 'Northern Region',
                'code' => 'NR',
                'country' => 'Country',
                'latitude' => 10.123456,
                'longitude' => -5.654321,
                'population' => 1500000,
                'description' => 'Northern region with major cities and industrial areas'
            ],
            [
                'name' => 'Southern Region',
                'code' => 'SR',
                'country' => 'Country',
                'latitude' => 8.987654,
                'longitude' => -4.321098,
                'population' => 1200000,
                'description' => 'Southern region known for agriculture and tourism'
            ],
            [
                'name' => 'Eastern Region',
                'code' => 'ER',
                'country' => 'Country',
                'latitude' => 9.456789,
                'longitude' => -3.789456,
                'population' => 980000,
                'description' => 'Eastern region with coastal areas and fishing industry'
            ],
            [
                'name' => 'Western Region',
                'code' => 'WR',
                'country' => 'Country',
                'latitude' => 9.654321,
                'longitude' => -6.123789,
                'population' => 1100000,
                'description' => 'Western region with mining and forestry'
            ],
            [
                'name' => 'Central Region',
                'code' => 'CR',
                'country' => 'Country',
                'latitude' => 9.321654,
                'longitude' => -5.456123,
                'population' => 2000000,
                'description' => 'Central region containing the capital and government offices'
            ]
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
