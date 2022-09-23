<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [
            ['id'=>1,'parent_id'=>NULL,'name'=>'Tops','slug'=>'tops','discount'=>0,'status'=>1],
            ['id'=>2,'parent_id'=>'1','name'=>'T-Shirts','slug'=>'t-shirts','discount'=>0,'status'=>1],          
        ];
        Category::insert($categoryRecords);
    }
}
