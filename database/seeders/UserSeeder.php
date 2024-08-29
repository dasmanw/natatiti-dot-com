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
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now()
        ])->assignRole(User::SUPER_ADMIN);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now()
        ])->assignRole(User::ADMIN);

        User::create([
            'name' => 'Vendor',
            'email' => 'vendor@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now()
        ])->assignRole(User::VENDOR);

        User::create([
            'name' => 'Salesman',
            'email' => 'salesman@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now()
        ])->assignRole(User::SALESMAN);
    }
}
