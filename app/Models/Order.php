<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // 1 order can have multiple products
    public function orders_products(){
        return $this->hasMany(OrdersProduct::class,'order_id');
    }
}
