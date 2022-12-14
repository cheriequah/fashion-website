<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\JsonDecoder;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function categories() {
        Session::put('page','categories');
        $categories = Category::with(['parentcategory'])->get();
        //$categories = json_decode(json_encode($categories));
        //echo "<pre>"; print_r($categories); die;
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            //if POST request receive is Active change the status to 0
            if ($data['status'] == "Active") {
                $status = 0;
            }
            //else change status to 1
            else {
                $status = 1;
            }
            // find the id that match the current category id and update the status
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id=null) {
        //if id pass is empty
        if ($id == "") {
            $title = "Add Category";

            //$categoryLevels = json_decode(json_encode($categoryLevels));
            //echo "<pre>"; print_r($categoryLevels); die;

            //Add Category 
            $category = new Category;
            //create empty array
            $categoryData = array();       
            $message = "Category has been Added Succesfully!";
        }
        else {
            $title = "Edit category";
            //Edit Category
            //get details
            $categoryData = Category::where('id',$id)->first();

            //to save data
            $category = Category::find($id);
            $message = "Category Updated Succesfully!";
            //$categoryData = json_decode(json_encode($categoryData));
            //echo "<pre>"; print_r($categoryData); die;
        }

        // with() Calls the subcategories method in model, get data where parent id is main category and status is active
        $categoryLevels = Category::with(['subcategories'])->where(['parent_id'=>NULL,'status'=>1])->get();

        if ($request->isMethod('post')) {
            $data = $request->all();
            //$data = json_decode(json_encode($data));
            //echo "<pre>"; print_r($data); die;

            //Category validation
            $request->validate([
                //name is attribute name from view
                //doesnt accept space
                'category_name' => 'regex:/^[a-zA-Z -]+$/u',
            ]);

            if ($request->hasFile('category_img')) {
                $img_tmp = $request->file('category_img');
                if ($img_tmp->isValid()) {
                    // returns original file name
                    $img_name = $img_tmp->getClientOriginalName();

                    // return original file extension
                    $extension = $img_tmp->getClientOriginalExtension();

                    // creates a new file name
                    $img_new_name = $img_name.'-'.rand(111,99999).'.'.$extension;

                    // set the path for different size image
                    $large_img_path = 'assets/img/category_images/large/'.$img_new_name;
                    $medium_img_path = 'assets/img/category_images/medium/'.$img_new_name;
                    $small_img_path = 'assets/img/category_images/small/'.$img_new_name;
                    Image::make($img_tmp)->save($large_img_path); //W:1040 H:1200

                    // resize image
                    Image::make($img_tmp)->resize(400,400)->save($medium_img_path);
                    Image::make($img_tmp)->resize(200,200)->save($small_img_path);
                    $category->image = $img_new_name;
                }
            } 
            else {
                $category->image = "";
            }

            //$data["name: input that is POST form the view"]
            $category->parent_id = $data['parent_id'];
            $category->name = $data['category_name'];
            $category->slug = $data['category_slug'];
            $category->discount = $data['category_discount'];
            $category->status = 1;
            $category->save();

            Session::flash('success_message',$message);
            return redirect('admin/categories');
        }
            
        return view('admin.categories.add_edit_category')->with(compact('title','categoryLevels','categoryData'));
    }

    public function deleteCategory($id) {
        Category::where('id',$id)->delete();

        $message = 'Category has been Deleted Succesfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
}
