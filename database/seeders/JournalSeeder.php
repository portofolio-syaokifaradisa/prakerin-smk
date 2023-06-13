<?php

namespace Database\Seeders;

use App\Models\Journal;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i< 10; $i++){
            Journal::create([
                'student_id' => 1,
                'application_letter_id' => 1,
                'date' => date('Y-m-d', strtotime("2022-07-{$i}")),
                'activity' => $i . 'aaaaaaaaaaaaaa'
            ]);
        }
    }
}
