<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            ['id'=>1,'name'=>'Floral Dress','code'=>'P001','image'=>'','description'=>'This is a dress','color_id'=>2,'price'=>30,'discount'=>5,'is_featured'=>'No','status'=>1,'category_id'=>1,'pattern_id'=>1,'sleeve_id'=>2,'occasion_id'=>2,'material_id'=>3],
            ['id'=>2,'name'=>'Addidas Dress','code'=>'R001','image'=>'','description'=>'This is a addidas dress','color_id'=>4,'price'=>50,'discount'=>10,'is_featured'=>'Yes','status'=>1,'category_id'=>2,'pattern_id'=>4,'sleeve_id'=>2,'occasion_id'=>3,'material_id'=>2],
        ];
        Product::insert($productRecords);
    }
}
