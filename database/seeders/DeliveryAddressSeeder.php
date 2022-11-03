<?php

namespace Database\Seeders;

use App\Models\DeliveryAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords = [
            ['id'=>1,'user_id'=>1,'name'=>'Cherie','mobile'=>'018297292','address'=>'Test','city'=>'Bayan Lepas','state'=>'Penang','country_id'=>1,'postcode'=>11900,'status'=>1],
            ['id'=>2,'user_id'=>1,'name'=>'Cherie','mobile'=>'018293892','address'=>'Test','city'=>'Bayan Lepas','state'=>'Penang','country_id'=>1,'postcode'=>11900,'status'=>1]
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}
