<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category() {
        // in product model, it belongs to a category where it compares category_id with primary key of category table
        return $this->belongsTo(Category::class,'category_id')->select('id','parent_id','name');
    }

    public function color() {
        // in product model, it belongs to a pattern where it compares pattern_id with primary key of pattern table
        return $this->belongsTo(Color::class,'color_id')->select('id','type');
    }

    public function pattern() {
        // in product model, it belongs to a pattern where it compares pattern_id with primary key of pattern table
        return $this->belongsTo(Pattern::class,'pattern_id')->select('id','name');
    }

    public function occasion() {
        // in product model, it belongs to a occasion where it compares occasion_id with primary key of occasion table
        return $this->belongsTo(Occasion::class,'occasion_id')->select('id','type');
    }

    public function sleeve() {
        // in product model, it belongs to a sleeve where it compares sleeve_id with primary key of sleeve table
        return $this->belongsTo(Sleeve::class,'sleeve_id')->select('id','type');
    }

    public function material() {
        // in product model, it belongs to a material where it compares material_id with primary key of material table
        return $this->belongsTo(Material::class,'material_id')->select('id','type');
    }

    public function attributes() {
        return $this->hasMany(ProductsAttributes::class,'product_id');
    }

    public static function productFilters() {
        $productFilters['patternArray'] = array('Cotton','Polyster','Wool');
        return $productFilters;
    }
}
