<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed admin and user accounts
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'), // Password: admin123
                'role' => 'admin', // Admin role
                'gender' => 'female', // Menambahkan gender
                'dob' => '2008-04-21', // Menambahkan tanggal lahir
            ],
            [
                'name' => 'User',
                'email' => 'user@mail.com',
                'password' => Hash::make('user123'), // Password: user123
                'role' => 'user', // User role
                'gender' => 'male', // Menambahkan gender
                'dob' => '2008-04-18', // Menambahkan tanggal lahir
            ],
        ];

        // Menambahkan pengguna ke database
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
