<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    public static function getColors() {
        $colors = Color::where('status',1)->get();
        $colors = json_decode(json_encode($colors));
        //echo "<pre>"; print_r($colors); die;
        return $colors;
        
    }
}
