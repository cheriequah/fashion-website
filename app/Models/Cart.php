<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;

    // Function to return user cart Items
    public static function userCartItems() {
        // When user logged In
        // Get carts based on user id
        if (Auth::check()) {
            $userCartItems = Cart::with(['product'=>function($query){
                $query->select('id','name','code','discount','image','color_id');
            }])->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
            //$cartCount = count($userCartItems);
        }
        // When user not logged In
        // Get carts based on session id
        else {
            $userCartItems = Cart::with(['product'=>function($query){
                $query->select('id','name','code','discount','image','color_id');
            }])->where('session_id',Session::get('session_id'))->orderBy('id','Desc')->get()->toArray();
            //$cartCount = count($userCartItems);
        }
        return $userCartItems;
    }

    // In cart, it belongs to a product model where foreign key is product_id 
    public function product() {
        return $this->belongsTo(Product::class,'product_id');
    }

    // Get product price based on size
    public static function getProductPriceAttr($product_id,$size) {
        $priceAttr = ProductsAttributes::select('price')->where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        return $priceAttr['price'];
    }
}
