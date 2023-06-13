<?php

namespace Database\Seeders;

use App\Models\GradeClass;
use Illuminate\Database\Seeder;

class GradeClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gradeClass = [
            ['id' => 1, 'grade' => '10', 'department_id' => 1],
            ['id' => 2, 'grade' => '10', 'department_id' => 2],
            ['id' => 3, 'grade' => '10', 'department_id' => 3],

            ['id' => 4, 'grade' => '11', 'department_id' => 1],
            ['id' => 5, 'grade' => '11', 'department_id' => 2],
            ['id' => 6, 'grade' => '11', 'department_id' => 3],

            ['id' => 7, 'grade' => '12', 'department_id' => 1],
            ['id' => 8, 'grade' => '12', 'department_id' => 2],
            ['id' => 9, 'grade' => '12', 'department_id' => 3]
        ];

        GradeClass::insert($gradeClass);
    }
}
