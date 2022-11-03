<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reviewsRecords = [
            ['id'=>1,'user_id'=>'13','product_id'=>'2','review'=>'Good Quality','rating'=>'5','status'=>0],
            ['id'=>2,'user_id'=>'2','product_id'=>'3','review'=>'Fast Delivery','rating'=>'4','status'=>0],
            ['id'=>3,'user_id'=>'2','product_id'=>'1','review'=>'Dress quality not as expected','rating'=>'1','status'=>0],
        ];
        Review::insert($reviewsRecords);
    }
}
