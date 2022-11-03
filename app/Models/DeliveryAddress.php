<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DeliveryAddress extends Model
{
    use HasFactory;

    public static function deliveryAddresses() {
        $user_id = Auth::user()->id;
        $deliveryAddresses = DeliveryAddress::with('country')->where('user_id',$user_id)->get()->toArray();
        return $deliveryAddresses;
    }

    public function country() {
        // in product model, it belongs to a country where it compares country_id with primary key of country table
        return $this->belongsTo(Country::class,'country_id')->select('id','country_name');
    }

}
