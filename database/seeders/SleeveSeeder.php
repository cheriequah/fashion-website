<?php

namespace Database\Seeders;

use App\Models\Sleeve;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SleeveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sleeveRecords = [
            ['id'=>1,'type'=>'Half Sleeve','status'=>1],
            ['id'=>2,'type'=>'Long Sleeve','status'=>1],  
            ['id'=>3,'type'=>'Sleeveless','status'=>1],         
        ];
        Sleeve::insert($sleeveRecords);
    }
}
