<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public static function getMaterials() {
        $materials = Material::where('status',1)->get();
        $materials = json_decode(json_encode($materials));
        //echo "<pre>"; print_r($materials); die;
        return $materials;
        
    }
}
