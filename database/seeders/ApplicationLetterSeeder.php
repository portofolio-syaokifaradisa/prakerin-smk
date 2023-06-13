<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationLetter;

class ApplicationLetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApplicationLetter::create([
            'letter_number' => "123",
            'agency_id' => 1,
            'student_id' => 1,
            'status' => 'COMPLETE',
            'start_date' => now(),
            'end_date' => '2022-07-22'
        ]);
    }
}
