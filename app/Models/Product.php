<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category() {
        // in product model, it belongs to a category where it compares category_id with primary key of category table
        return $this->belongsTo(Category::class,'category_id')->select('id','parent_id','name','slug');
    }

    public function color() {
        // in product model, it belongs to a color where it compares color_id with primary key of color table
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

    // Product attribute Ex: size
    public function attributes() {
        return $this->hasMany(ProductsAttributes::class,'product_id');
    }

    public static function productFilters() {
        $productFilters['patternArray'] = array('Cotton','Polyster','Wool');
        return $productFilters;
    }

    public static function getDiscountPrice($product_id) {
        // Get product details
        $productDetails = Product::select('price','discount','category_id')->where('id',$product_id)->first()->toArray();
        //echo "<pre>"; print_r($productDetails); die;
        $categoryDetails = Category::select('discount')->where('id',$productDetails['category_id'])->first()->toArray();
        // If product discount greater than 0
        if ($productDetails['discount'] > 0) {
            // Calculation for discounted price
            $discountedPrice = $productDetails['price'] - ($productDetails['price']*$productDetails['discount']/100);

        } // If Product discount not > 0 and category discount > 0
        else if ($categoryDetails['discount'] > 0) {
            $discountedPrice = $productDetails['price'] - ($productDetails['price']*$categoryDetails['discount']/100);    
        }else {
            $discountedPrice = 0;
        }
        return $discountedPrice;
    }

    // Get discounted price for the size 
    public static function getDiscountAttrPrice($product_id,$size) {
        $productAttrPrice = ProductsAttributes::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        $productDetails = Product::select('discount','category_id')->where('id',$product_id)->first()->toArray();
        $categoryDetails = Category::select('discount')->where('id',$productDetails['category_id'])->first()->toArray();

        // If product discount greater than 0
        if ($productDetails['discount'] > 0) {
            // Calculation for discounted price
            $finalPrice = $productAttrPrice['price'] - ($productAttrPrice['price']*$productDetails['discount']/100);
            $discount = $productAttrPrice['price'] - $finalPrice;
        } // If Product discount not > 0 and category discount > 0
        else if ($categoryDetails['discount'] > 0) {
            $finalPrice = $productAttrPrice['price'] - ($productAttrPrice['price']*$categoryDetails['discount']/100);    
            $discount = $productAttrPrice['price'] - $finalPrice;
        }else {
            $finalPrice = $productAttrPrice['price'];
            $discount = 0;
        }
        return array('product_price'=>$productAttrPrice['price'],'final_price'=>$finalPrice,'discount'=>$discount);
    }

    public static function getProductImage($product_id) {
        $getProductImage = Product::select('image')->where('id',$product_id)->first()->toArray();
        return $getProductImage['image']; 
    }
}
