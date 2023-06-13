<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::create([
            'name' => "Guru Prakerin",
            'nip' => "123456789012345678",
            'user_id' => 4,
            'position' => "Guru Pembimbing",
            'grade_class_id' => 7
        ]);
    }
}
