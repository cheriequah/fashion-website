<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Occasion;
use App\Models\Pattern;
use App\Models\Product;
use App\Models\ProductsAttributes;
use App\Models\Sleeve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function products() {
        Session::put('page','products');
        $products = Product::with(['category','color','pattern','occasion','sleeve','material'])->get();
        //$products = json_decode(json_encode($products));
        //echo "<pre>"; print_r($products); die;
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request) {
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
            // find the id that match the current product id and update the status
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }

    public function addEditProduct(Request $request, $id=null) {
        //if id pass is empty
        if ($id == "") {
            $title = "Add Product";

            //Add Product 
            $product = new Product();
            $productData = array();       
            $message = "Product has been Added Succesfully!";
        }
        else {
            $title = "Edit Product";
            //Edit Product
            //get details
            $productData = Product::with(['category','color','pattern','occasion','sleeve','material'])->where('id',$id)->first();   
            //to save data
            $product = Product::find($id);   
            $message = "Product Updated Succesfully!";
            //$productData = json_decode(json_encode($productData));
            //echo "<pre>"; print_r($productData); die;
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //Product validation
            $request->validate([
                //name is attribute name from view
                //space and string
                'product_name' => 'regex:/^[a-zA-Z\s]*$/',
                'product_code' => 'regex:/^[\w-]*$/',
                'product_price' => 'numeric',                
            ]);

            if (empty($data['is_featured'])) {
                $is_featured = "No";
            }
            else {
                $is_featured = "Yes";
            }

            if ($request->hasFile('product_img')) {
                $img_tmp = $request->file('product_img');
                if ($img_tmp->isValid()) {
                    $img_name = $img_tmp->getClientOriginalName();
                    $extension = $img_tmp->getClientOriginalExtension();
                    $img_new_name = $img_name.'-'.rand(111,99999).'.'.$extension;
                    //echo "<pre>"; print_r($img_new_name); die;
                    $large_img_path = 'assets/img/product_images/large/'.$img_new_name;
                    $medium_img_path = 'assets/img/product_images/medium/'.$img_new_name;
                    $small_img_path = 'assets/img/product_images/small/'.$img_new_name;
                    Image::make($img_tmp)->save($large_img_path); //W:1040 H:1200
                    Image::make($img_tmp)->resize(400,400)->save($medium_img_path);
                    Image::make($img_tmp)->resize(200,200)->save($small_img_path);
                    $product->image = $img_new_name;
                    

                }
            } 
            else {
                $product->image = "";
            }
    
            // save product in products table
            $product->name = $data['product_name'];
            $product->code = $data['product_code'];
            $product->color_id = $data['color_id'];
            $product->price = $data['product_price'];
            $product->discount = $data['product_discount'];
            $product->description = $data['product_description'];
            $product->category_id = $data['category_id'];
            $product->pattern_id = $data['pattern_id'];
            $product->occasion_id = $data['occasion_id'];
            $product->sleeve_id = $data['sleeve_id'];
            $product->material_id = $data['material_id'];
            $product->is_featured = $is_featured;
            $product->status = 1;
            
            $product->save();
    
            Session::flash('success_message',$message);
            return redirect('admin/products');
        }

        $colors = Color::get();  
        $patterns = Pattern::get();    
        $occasions = Occasion::get();  
        $sleeves = Sleeve::get();  
        $materials = Material::get();         

        $categoryLevels = Category::with(['subcategories'])->where(['parent_id'=>NULL,'status'=>1])->get();
        //$categoryLevels = json_decode(json_encode($categoryLevels));
        //echo "<pre>"; print_r($categoryLevels); die;

        //$getPatterns = json_decode(json_encode($getPatterns));
        //echo "<pre>"; print_r($getPatterns); die;

        $colorArray = array('');
        $patternArray = array('');
        $occasionArray = array('');
        $sleeveArray = array('');
        $materialArray = array('');

        return view('admin.products.add_edit_product')->with(compact('title','categoryLevels','productData','colors','patterns','occasions','sleeves','materials'));
    }

    public function deleteProduct($id) {
        Product::where('id',$id)->delete();

        $message = 'Product has been Deleted Succesfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }

    public function deleteProductImage($id) {
        // Get product image
        $productImg = Product::select('image')->where('id',$id)->first();

        // Get Product image path
        $large_img_path = 'assets/img/product_images/large/';
        $medium_img_path = 'assets/img/product_images/medium/';
        $small_img_path = 'assets/img/product_images/small/';

        // if exists in large folder delete the large image
        if (file_exists($large_img_path.$productImg->image)) {
            unlink($large_img_path.$productImg->image);
        }

        // if exists in medium folder delete the medium image
        if (file_exists($medium_img_path.$productImg->image)) {
            unlink($medium_img_path.$productImg->image);
        }

        // if exists in small folder delete the small image
        if (file_exists($small_img_path.$productImg->image)) {
            unlink($small_img_path.$productImg->image);
        }

        // Delete the product image from products table
        Product::where('id',$id)->update(['image'=>'']);
        $message = 'Product Image has been deleted successfully';
        Session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addAttributes(Request $request, $id) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {

                    // check if sku already exists
                    $checkSKU = ProductsAttributes::where(['sku'=>$value])->count();
                    if ($checkSKU > 0) {
                        $message = 'SKU alaready exists. Please add another SKU!';
                        Session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    // check if size already exists
                    $checkSize = ProductsAttributes::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if ($checkSize > 0) {
                        $message = 'Size alaready exists. Please add another Size!';
                        Session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    $attribute = new ProductsAttributes;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            $message = 'Product Attributes Added Successfully!';
            Session::flash('success_message', $message);
            return redirect()->back();
        }
        $productData = Product::select('id','name','code','color_id','image')->with('color','attributes')->find($id);
        //$productData = json_decode(json_encode($productData));
        //echo "<pre>"; print_r($productData); die;
        $title = "Product Attributes";
        return view('admin.products.add_attributes')->with(compact('productData','title'));
    }

    public function editAttributes(Request $request, $id) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            foreach ($data['attribute_id'] as $key =>$attrId) {
                if (!empty($attrId)) {
                    ProductsAttributes::where(['id'=>$data['attribute_id'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
                }
            }
            $message = 'Product Attributes Updated Successfully!';
            Session::flash('success_message', $message);
            return redirect()->back();
        }
    }

    public function updateAttributeStatus(Request $request) {
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
            // find the id that match the current product id and update the status
            ProductsAttributes::where('id',$data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function deleteAttribute($id) {
        ProductsAttributes::where('id',$id)->delete();

        $message = 'Attribute has been Deleted Succesfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
}
