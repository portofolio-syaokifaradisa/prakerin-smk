<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agencies = [
            [
                'id' => 1, 
                'name' => 'Milda Printing', 
                'region_id' => 1, 
                'address' => 'Pajukungan, Barabai Kab, HST', 
                'phone' => '085821634327',
                'leader' => "A",
                'nip' => '123456789012345678',
                'characteristic' => 'asd, zxc, qwe',
                'limit' => 5
            ],[
                'id' => 2, 
                'name' => "Rusadi Art Print", 
                'region_id' => 1, 
                'address' => 'Palajau Kec. Pandawan Kab. HST', 
                'phone' => '085392190777',
                'leader' => "B",
                'nip' => '123456789012345678',
                'characteristic' => 'asd, zxc, qwe',
                'limit' => 5
            ],[
                'id' => 3, 
                'name' => "FR Printing", 
                'region_id' => 1, 
                'address' => 'Jln. Ir. P. H. M. Noor Kampung Arab Kab. HST', 
                'phone' => '081346544697',
                'leader' => "C",
                'nip' => '123456789012345678',
                'characteristic' => 'asd, zxc, qwe',
                'limit' => 5
            ]
        ];

        Agency::insert($agencies);
    }
}
