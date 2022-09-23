<?php

namespace Database\Seeders;

use App\Models\Pattern;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patternRecords = [
            ['id'=>1,'name'=>'Plain','status'=>1],
            ['id'=>2,'name'=>'Cartoon','status'=>1],  
            ['id'=>3,'name'=>'Striped','status'=>1], 
            ['id'=>4,'name'=>'Floral','status'=>1], 
            ['id'=>5,'name'=>'Plants','status'=>1], 
        ];
        Pattern::insert($patternRecords);
    }
}
