<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@dashboard.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'bio' => 'Administrator Dashboard Pemetaan Orang Asing Kota Cirebon',
        ]);

        User::create([
            'name' => 'Operator Dashboard',
            'email' => 'operator@dashboard.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'bio' => 'Operator Dashboard Pemetaan Orang Asing',
        ]);
    }
}
