<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colorRecords = [
            ['id'=>1,'type'=>'Blue','status'=>1],
            ['id'=>2,'type'=>'Red','status'=>1],  
            ['id'=>3,'type'=>'Violet','status'=>1], 
            ['id'=>4,'type'=>'Black','status'=>1], 
            ['id'=>5,'type'=>'White','status'=>1], 
        ];
        Color::insert($colorRecords);
    }
}
