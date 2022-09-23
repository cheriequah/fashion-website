<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    use HasFactory;

    public static function getPatterns() {
        $patterns = Pattern::where('status',1)->get()->toArray();
        //echo "<pre>"; print_r($patterns); die;
        return $patterns;
    }
}
