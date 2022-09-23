<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sleeve extends Model
{
    use HasFactory;

    public static function getSleeves() {
        //$categories = Category::with('subcategories')->where(['parent_id'=>NULL,'status'=>1])->get();
        $sleeves = Sleeve::where('status',1)->get();
        //$products = Product::get();
        $sleeves = json_decode(json_encode($sleeves));
        //echo "<pre>"; print_r($sleeves); die;
        return $sleeves;
    }
}
