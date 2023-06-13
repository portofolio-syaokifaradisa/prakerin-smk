<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 10; $i++){
            Attendance::create([
                'student_id' => 1,
                'date' => date('Y-m-d', strtotime("2022-07-{$i}")),
                'in' => date("H:m", strtotime("07:{$i}")),
                'out' => date("H:m", strtotime("16:{$i}")),
                'isPermit' => $i % 3 == 0 ? true : false,
                'isAlpha' => $i % 7 == 0 ? true : false,
                'isSick' => $i % 10 == 0 ? true : false,
                'description' => "asd{$i}dd{$i}",
                'application_letter_id' => 1
            ]);

            if($i % 2 == 0){
                Attendance::create([
                    'student_id' => 2,
                    'date' => date('Y-m-d', strtotime("2022-07-{$i}")),
                    'in' => date("H:m", strtotime("07:{$i}")),
                    'out' => date("H:m", strtotime("16:{$i}")),
                    'isPermit' => $i % 3 == 0 ? true : false,
                    'isAlpha' => $i % 7 == 0 ? true : false,
                    'isSick' => $i % 10 == 0 ? true : false,
                    'description' => "asd{$i}dd{$i}",
                    'application_letter_id' => 1
                ]);
            }
        }
    }
}
