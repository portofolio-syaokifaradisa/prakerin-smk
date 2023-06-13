<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create([
            'name' => "Siswa Prakerin",
            'nisn' => "1234567890",
            'user_id' => 3,
            'grade_class_id' => 7
        ]);

        Student::create([
            'name' => "Siswa Prakerin 2",
            'nisn' => "1111111",
            'user_id' => 5,
            'grade_class_id' => 7
        ]);
    }
}
