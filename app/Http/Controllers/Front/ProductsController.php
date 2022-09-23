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

class ProductsController extends Controller
{
 
    public function products($slug, Request $request) {
        //if filter is selcted only ajax is called
        if ($request->ajax()) {
            //get data from ajax
            $data = $request->all();     
            //echo "<pre>"; print_r($data); die;
            $slug = $data['slug'];
            $categoryCount = Category::where(['slug'=>$slug,'status'=>1])->count();
            if ($categoryCount > 0) {
                //echo "Category exist"; die;
                $categoryDetails = Category::categoryDetails($slug);
                //echo "<pre>"; print_r($categoryDetails); 
                //check category_id column with value from the array, get products by category
                $categoryProducts = Product::whereIn('category_id',$categoryDetails['categoryIds'])->where('status',1);
                
                // if pattern filter selected
                if (isset($data['pattern']) && !empty($data['pattern'])) {
                    $categoryProducts->whereIn('pattern_id',$data['pattern']);
                }

                // if occasion filter selected
                if (isset($data['occasion']) && !empty($data['occasion'])) {
                    $categoryProducts->whereIn('occasion_id',$data['occasion']);
                }

                if (isset($data['orderby']) && !empty($data['orderby'])) {
                    if ($data['orderby'] == "sort_latest") {
                        $categoryProducts->orderBy('id','Desc');
                    }else if($data['orderby'] == "sort_a_z") {
                        $categoryProducts->orderBy('name','Asc');
                    }else if($data['orderby'] == "sort_z_a") {
                        $categoryProducts->orderBy('name','Desc');
                    }else if($data['orderby'] == "price_lowest") {
                        $categoryProducts->orderBy('price','Asc');
                    }else if($data['orderby'] == "price_highest") {
                        $categoryProducts->orderBy('price','Desc');
                    }
                }
                else {
                    $categoryProducts->orderBy('id','Desc');
                }
                $categoryProducts = $categoryProducts->paginate(4);
                //echo "<pre>"; print_r($categoryProducts); die;
                return view('front.products.ajax_products')->with(compact('categoryDetails','categoryProducts','slug'));
            }
            else {
                abort(404);
            }
        }
        else {

            //check for form post
            if ($request->isMethod('post')) {
                $data = $request->all();
                //echo "<pre>"; print_r($data); die;
            }
            $categoryCount = Category::where(['slug'=>$slug,'status'=>1])->count();
            if ($categoryCount > 0) {
                //echo "Category exist"; die;
                $categoryDetails = Category::categoryDetails($slug);
                //echo "<pre>"; print_r($categoryDetails); 
                //check category_id column with value from the array, get products by category
                $categoryProducts = Product::whereIn('category_id',$categoryDetails['categoryIds'])->where('status',1);             
                $categoryProducts = $categoryProducts->paginate(4);
                //echo "<pre>"; print_r($categoryProducts); die;

                // Get Product Filters
                $categories = Category::getCategories();
                $colors = Color::getColors();
                $materials = Material::getMaterials();
                $occasions = Occasion::getOccasions();
                $patterns = Pattern::getPatterns();
                $sleeves = Sleeve::getSleeves();

                //$productFilters = Product::productFilters();
                //$patternArray = $productFilters['patternArray'];
                //echo "<pre>"; print_r($patternArray); die;
                return view('front.shop')->with(compact('categoryDetails','categoryProducts','slug','categories','colors','materials','occasions','patterns','sleeves'));
            }
            else {
                abort(404);
            }
        }
    }
}
