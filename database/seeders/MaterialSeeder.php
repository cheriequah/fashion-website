<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materialRecords = [
            ['id'=>1,'type'=>'Cotton','status'=>1],
            ['id'=>2,'type'=>'Silk','status'=>1],  
            ['id'=>3,'type'=>'Spandex','status'=>1], 
            ['id'=>4,'type'=>'Nylon','status'=>1], 
            ['id'=>5,'type'=>'PU Leather','status'=>1], 
        ];
        Material::insert($materialRecords);
    }
}
