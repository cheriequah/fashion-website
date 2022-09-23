<?php

namespace Database\Seeders;

use App\Models\ProductsAttributes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productAttributesRecords = [
            ['id'=>1,'product_id'=>'1','size'=>'XL','price'=>100,'stock'=>20,'sku'=>'P001-xl','status'=>1],
            ['id'=>2,'product_id'=>'1','size'=>'2XL','price'=>110,'stock'=>20,'sku'=>'P001-2xl','status'=>1],
            ['id'=>3,'product_id'=>'1','size'=>'3XL','price'=>120,'stock'=>10,'sku'=>'P001-3xl','status'=>1],
        ];
        ProductsAttributes::insert($productAttributesRecords);
    }
}
