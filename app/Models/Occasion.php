<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occasion extends Model
{
    use HasFactory;

    public static function getOccasions() {
        $occasions = Occasion::where('status',1)->get();
        $occasions = json_decode(json_encode($occasions));
        //echo "<pre>"; print_r($occasions); die;
        return $occasions;
    }
}
