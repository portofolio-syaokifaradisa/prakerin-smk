<?php

namespace Database\Seeders;

use App\Models\StudentMentor;
use Illuminate\Database\Seeder;

class StudentMentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentMentor::create([
            'student_id' => 1,
            'mentor_id' => 1
        ]);
    }
}
