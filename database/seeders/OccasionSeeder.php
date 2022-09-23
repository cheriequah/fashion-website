<?php

namespace Database\Seeders;

use App\Models\Occasion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccasionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $occasionRecords = [
            ['id'=>1,'type'=>'Party','status'=>1],
            ['id'=>2,'type'=>'Business','status'=>1],  
            ['id'=>3,'type'=>'Formal','status'=>1], 
            ['id'=>4,'type'=>'Wedding','status'=>1], 
            ['id'=>5,'type'=>'Sports','status'=>1], 
        ];
        Occasion::insert($occasionRecords);
    }
}
