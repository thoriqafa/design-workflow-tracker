<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@any.com'],
            [
            'name' => 'superadmin',
            'email' => 'superadmin@any.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        User::updateOrCreate(
            ['email' => 'staff@any.com'],
            ['name' => 'staff1',
            'email' => 'staff@any.com',
            'password' => bcrypt('password123'),
            'role' => 'staff'
        ]);

        // 👉 TAMBAH USER BARU DI SINI
        User::updateOrCreate(
            ['email' => 'manager1@any.com'],
            [
                'name' => 'manager1',
                'password' => Hash::make('password123'),
                'role' => 'manager',
            ]
        );
    }
}
