<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function subcategories() {
        //in category model has many categories which are subcategories
        //subcategories has many categories, parent_id is the foreign key where it connects to the category table primary key which is id 
        return $this->hasMany(Category::class,'parent_id')->where('status',1);
    }

    public function parentcategory() {
         //in category model it belongs to 1 category, parent_id is the foreign key 
        return $this->belongsTo(Category::class,'parent_id')->select('id','name');
    }

    public static function getCategories() {
        $categories = Category::with('subcategories')->where(['parent_id'=>NULL,'status'=>1])->get();
        $categories = json_decode(json_encode($categories));
        //echo "<pre>"; print_r($categories); die;
        return $categories;
    }

    // relation no need static
    // get the categories and subcategories
    public static function categoryDetails($slug) {
        $categoryDetails = Category::select('id','parent_id','name','slug')->with(['subcategories'=>function($query) {
            $query->select('id','parent_id')->where('status',1);
        }])->where('slug',$slug)->first()->toArray();

        if($categoryDetails['parent_id'] == NULL) {
            // Show Main category in breadcrumb
            $breadcrumbs = '<a href="'.url($categoryDetails['slug']).'" >'.$categoryDetails['name'].'</a>';
        }
        else {
            $parentCategory = Category::select('name','slug')->where('id',$categoryDetails['parent_id'])->first()->toArray();
            // Show Main category in breadcrumb
            $breadcrumbs = '<a href="'.url($parentCategory['slug']).'" >'.$parentCategory['name'].'</a>&nbsp;&nbsp;<a href="'.url($categoryDetails['slug']).'" >'.$categoryDetails['name'].'</a>'; 
        }

        //dd($categoryDetails); die;
        $categoryIds = array();
        $categoryIds[] = $categoryDetails['id'];
        foreach($categoryDetails['subcategories'] as $key => $subcat) {
            $categoryIds[] = $subcat['id'];
        }
        //dd($categoryIds);
        return array('categoryIds'=>$categoryIds,'categoryDetails'=>$categoryDetails,'breadcrumbs'=>$breadcrumbs);
    }
}
