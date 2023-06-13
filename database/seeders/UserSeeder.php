<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'email' => "superadmin@prakerin.com",
                'password' => Hash::make("asd"),
                'role' => "SUPERADMIN",
                'code_verification' => '1',
                'is_verified' => true,
            ],[
                'id' => 2,
                'email' => "admin_tu@prakerin.com",
                'password' => Hash::make("asd"),
                'role' => "ADMIN",
                'code_verification' => '2',
                'is_verified' => true,
            ],[
                'id' => 3,
                'email' => "siswa@prakerin.com",
                'password' => Hash::make("asd"),
                'role' => "STUDENT",
                'code_verification' => '3',
                'is_verified' => false,
            ],[
                'id' => 4,
                'email' => "guru@prakerin.com",
                'password' => Hash::make("asd"),
                'role' => "TEACHER",
                'code_verification' => '4',
                'is_verified' => true,
            ],
            [
                'id' => 5,
                'email' => "siswa2@prakerin.com",
                'password' => Hash::make("asd"),
                'role' => "STUDENT",
                'code_verification' => '5',
                'is_verified' => true,
            ],
        ];

        User::insert($users);
    }
}
