<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            ['id' => 1, 'name' => 'Multimedia'],
            ['id' => 2, 'name' => 'Teknik Alat Berat'],
            ['id' => 3, 'name' => 'Teknis Bisnis Sepeda Motor']
        ];

        Department::insert($departments);
    }
}
