<?php

namespace Database\Seeders;

use App\Models\Monitoring;
use Illuminate\Database\Seeder;

class MonitoringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 15; $i++){
            Monitoring::create([
                'date' => "22-07-{$i}",
                'description' => "abc{$i}de{$i}fgh{$i}i",
                'application_letter_id' => 1,
                'teacher_id' => 1
            ]);
        }
    }
}
