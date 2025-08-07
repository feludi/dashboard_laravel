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
            'name' => 'Super Administrator',
            'email' => 'superadmin@dashboard.com',
            'password' => Hash::make('admin123'),
            'phone' => '081234567899',
            'bio' => 'Super Administrator Dashboard Pemetaan Orang Asing Kota Cirebon',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dashboard Operator',
            'email' => 'op@dashboard.com',
            'password' => Hash::make('operator123'),
            'phone' => '081234567888',
            'bio' => 'Operator Dashboard untuk Pemetaan dan Monitoring Orang Asing',
            'role' => 'operator',
        ]);
    }
}
