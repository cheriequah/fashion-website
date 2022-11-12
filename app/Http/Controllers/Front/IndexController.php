<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Occasion;
use App\Models\Pattern;
use App\Models\Product;
use App\Models\Sleeve;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        $categories = Category::select('name','slug','image')->get()->toArray();
        $featuredProductsCount = Product::where('is_featured','Yes')->count();
        $featuredProducts = Product::where('is_featured','Yes')->get()->toArray();
        //$featuredProductsChunk = array_chunk($featuredProducts, 4);
        //echo "<pre>"; print_r($featuredProductsChunk); die;
        //dd($category); die;
        return view('front.index')->with(compact('featuredProducts','categories'));
    }

    
}
