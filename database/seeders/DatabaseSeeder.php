<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AttendanceSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\GradeClassSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            DepartmentSeeder::class,
            GradeClassSeeder::class,
            RegionSeeder::class,
            AgencySeeder::class,
            AdminSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
            MentorSeeder::class,
            StudentMentorSeeder::class,
            ApplicationLetterSeeder::class,
            JournalSeeder::class,
            MonitoringSeeder::class,
            AttendanceSeeder::class
        ]);
    }
}
