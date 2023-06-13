<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'id' => 1,
                'name' => "Superadmin",
                'user_id' => 1
            ],[
                'id' => 2,
                'name' => "Admin TU 1",
                'user_id' => 2
            ]
        ];

        Admin::insert($admins);
    }
}
