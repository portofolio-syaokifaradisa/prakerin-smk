<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            ['id' => 1, 'name' => 'Kab. Hulu Sungai Tengah', 'city' => 'Kab. Hulu Sungai Tengah'],
            ['id' => 2, 'name' => 'Kab. Hulu Sungai Selatan', 'city' => 'Kab. Hulu Sungai Selatan'],
            ['id' => 3, 'name' => 'Kota Banjarbaru', 'city' => 'Kota Banjarbaru']
        ];

        Region::insert($regions);
    }
}
