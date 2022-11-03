<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Country;
use App\Models\DeliveryAddress;
use App\Models\Material;
use App\Models\Occasion;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\Pattern;
use App\Models\Product;
use App\Models\ProductsAttributes;
use App\Models\Review;
use App\Models\Sleeve;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{/*
    public function shop() {
        $categoryProducts = Product::get()->toArray();
        return view('front.shop')->with(compact('categoryProducts'));
    }
*/
    public function products(Request $request) {
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

                // if color filter selected
                if (isset($data['color']) && !empty($data['color'])) {
                    $categoryProducts->whereIn('color_id',$data['color']);
                }

                // if sleeve filter selected
                if (isset($data['sleeve']) && !empty($data['sleeve'])) {
                    $categoryProducts->whereIn('sleeve_id',$data['sleeve']);
                }

                // if material filter selected
                if (isset($data['material']) && !empty($data['material'])) {
                    $categoryProducts->whereIn('material_id',$data['material']);
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
                $categoryProducts = $categoryProducts->paginate(3);
                //echo "<pre>"; print_r($categoryProducts); die;
                return view('front.products.ajax_products')->with(compact('categoryDetails','categoryProducts','slug','data'));
            }
            else {
                abort(404);
            }
        }
        else {
            $slug = Route::getFacadeRoot()->current()->uri(); 
            //check for form post
            if ($request->isMethod('post')) {
                $data = $request->all();
            }
            $categoryCount = Category::where(['slug'=>$slug,'status'=>1])->count();
            if ($categoryCount > 0) {
                //echo "Category exist"; die;
                $categoryDetails = Category::categoryDetails($slug);
                //echo "<pre>"; print_r($categoryDetails); 
                //check category_id column with value from the array, get products by category
                $categoryProducts = Product::whereIn('category_id',$categoryDetails['categoryIds'])->where('status',1);             
                $categoryProducts = $categoryProducts->paginate(3);
                //echo "<pre>"; print_r($categoryProducts); die;

                // Get Product Filters
                $categories = Category::getCategories();
                $colors = Color::getColors();
                $materials = Material::getMaterials();
                $occasions = Occasion::getOccasions();
                $patterns = Pattern::getPatterns();
                $sleeves = Sleeve::getSleeves();

                //$colorCount = Color::where(['status'=>1])->count();

                //$productFilters = Product::productFilters();
                //$patternArray = $productFilters['patternArray'];
                //echo "<pre>"; print_r($colorCount); die;
                return view('front.shop')->with(compact('categoryDetails','categoryProducts','slug','categories','colors','materials','occasions','patterns','sleeves'));
            }
            else {
                abort(404);
            }
        }
    }

    public function productDetail($id) {
        // find product details that match the id
        $productDetails = Product::with(['attributes'=>function($query){
            // Only display the attributes(size) that are active
            $query->where('status',1);
        },'category','color','pattern','occasion','material','sleeve'])->find($id)->toArray();
        //dd($productDetails);
        $total_stock = ProductsAttributes::where('product_id',$id);
        // Get related products based on the current product category id where the id not includes itself
        $relatedProducts = Product::where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->get()->toArray();
        //dd($relatedProducts);

        // Get Reviews of all products
        $reviews = Review::with('user')->where(['product_id'=>$id,'status'=>1])->orderBy('id','desc')->get()->toArray();
        //dd($reviews);

        // Get Average Rating of Product
        $ratingSum = Review::where(['product_id'=>$id,'status'=>1])->sum('rating');
        $ratingsCount = Review::where(['product_id'=>$id,'status'=>1])->count();
        
        if ($ratingsCount > 0) {
            $avgRating = round($ratingSum/$ratingsCount,2);
            $avgStarRating = round($ratingSum/$ratingsCount);
        }else {
            $avgRating = 0;
            $avgStarRating = 0;
        }
        
        return view('front.products.product_detail')->with(compact('productDetails','relatedProducts','reviews','ratingsCount','ratingsCount','avgRating','avgStarRating'));
    }

    public function getProductPrice(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $getDiscountAttrPrice = Product::getDiscountAttrPrice($data['product_id'],$data['size']);
            return $getDiscountAttrPrice;
        }
    }

    public function addToCart(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            
            // Get stock available for the size chosen
            $getStock = ProductsAttributes::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first()->toArray();
            //echo $getStock['stock']; die;

            // Check Product Stock is available or not
            if ($getStock['stock'] < $data['quantity']) {
                $message = "Please reduce quantity! ";
                Session::flash('error_message',$message);
                return redirect()->back();
            }

            // Generate session id if not exists
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }

            // Count the current product that exists in cart 
            // When User is logged in
            if (Auth::check()) {
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'user_id'=>Auth::user()->id,'size'=>$data['size']])->count();
            }
            // When user not logged in
            else {
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'session_id'=>Session::get('session_id'),'size'=>$data['size']])->count();
            }

            // If the current product more than 0(exists), then display error message
            if ($countProducts > 0) {
                $message = "Product already exists in Cart!";
                Session::flash('error_message',$message);
                return redirect()->back();
            }
            // Save Product in Cart
            //Cart::insert(['session_id'=>$session_id,'user_id'=>1,'product_id'=>$data['product_id'],'size'=>$data['size'],'quantity'=>$data['quantity']]);

            if (Auth::check()) {
                $user_id = Auth::user()->id;
            }else {
                $user_id = NULL;
            }

            $cart = new Cart;
            $cart->session_id = $session_id;
            $cart->user_id = $user_id;
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->save();

            $message = "Product has been added succesfully in cart!";
            Session::flash('success_message',$message);
            return redirect('cart');
        }
    }

    public function cart() {
        $userCartItems = Cart::userCartItems();
        //echo "<pre>"; print_r($userCartItems); die;
        return view('front.products.cart')->with(compact('userCartItems'));
    }

    public function updateQtyCartItem(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            // Get cart details
            $cartDetails = Cart::find($data['cart_id']);

            // Get Available Product Stock
            $availableStock = ProductsAttributes::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();
            //echo "Demanded Quantity for Stock: ".$data['qty'];
            //echo "<br>";
            //echo "Available Stock: ".$availableStock['stock']; die;

            // Check Stock if available
            // If quantity demand is more than available stock
            if ($data['qty'] > $availableStock['stock']) {
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    // send status false to ajax
                    'status'=>false,
                    'message'=>"Product Stock is not available!",
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }

            // Check if size available
            $availableSize = ProductsAttributes::where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size'],'status'=>1])->count();
            if ($availableSize == 0) {
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    // send status false to ajax
                    'status'=>false,
                    'message'=>"Product Size is not available!",
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }
            Cart::where('id',$data['cart_id'])->update(['quantity'=>$data['qty']]);
            $totalCartItems = totalCartItems();
            $userCartItems = Cart::userCartItems();
            // Send to ajax
            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }

    public function removeCartItem(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            Cart::where('id',$data['cart_id'])->delete();
            $totalCartItems = totalCartItems();
            $userCartItems = Cart::userCartItems();
            return response()->json([
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }

    public function checkout(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if (empty($data['address_id'])) {
                $message = "Please select a Delivery Address for your Order!";
                Session::flash('err_msg',$message);
                return redirect()->back();
            }
            if (empty($data['payment_method'])) {
                $message = "Please select a Payment method!";
                Session::flash('err_msg',$message);
                return redirect()->back();
            }

            if ($data['payment_method'] == 'COD') {
                $payment_method = "COD";
            }else {
                echo "Coming Soon"; die;
                $payment_method = "paypal";
            }
            // Get Delivery Address based on address_id
            $deliveryAddress = DeliveryAddress::with('country')->where('id',$data['address_id'])->first()->toArray();
            //dd($deliveryAddress);
            $user_id = Auth::user()->id;

            DB::beginTransaction();
            // Insert Order Detials
            $order = new Order;
            $order->user_id = $user_id;
            $order->name = $deliveryAddress['name'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country']['country_name'];
            $order->postcode = $deliveryAddress['postcode'];
            $order->email = Auth::user()->email;
            $order->shipping_fee = 0;
            $order->order_status = "New";
            $order->payment_method = $payment_method;
            $order->total = Session::get('total');
            $order->save();

            // Get last inserted order id
            $order_id = DB::getPdo()->lastInsertId();
            //dd($order_id); 
            // get user cart items
            $cartItems = Cart::where('user_id',$user_id)->get()->toArray();
            foreach ($cartItems as $key => $item) {
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = $user_id;
                $getProductDetails = Product::select('code','name','color_id')->with('color')->where('id',$item['product_id'])->first()->toArray();       
                  
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['code'];
                $cartItem->product_name = $getProductDetails['name'];
                $cartItem->product_color = $getProductDetails['color']['type'];
                $cartItem->product_size = $item['size'];
                // to get the discounted price if after discount
                $getDiscountAttrPrice = Product::getDiscountAttrPrice($item['product_id'],$item['size']);
                $cartItem->product_price = $getDiscountAttrPrice['final_price'];
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();
            }       

            // Insert order Id in Session variable
            Session::put('order_id',$order_id);
            DB::commit();

            if ($data['payment_method'] == "COD") {
                // Send Order Email
                $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
                
                //echo "<pre>"; print_r($orderDetails); die;
                // Send Place Order Email
                $email = Auth::user()->email;
                $messageEmail = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails
                ];
                Mail::send('emails.order',$messageEmail,function($message) use($email) {
                    $message->to($email)->subject('Order Placed - Pearl Wonder Website');
                });
                return redirect('/thanks');
            }else {
                echo "Paypal Method Coming Soon"; die;
            }
            //echo "Order Placed";
        }
        $userCartItems = Cart::userCartItems();
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        //dd($deliveryAddresses);
        return view('front.products.checkout')->with(compact('userCartItems','deliveryAddresses'));
    }

    public function thanks() {
        $user_id = Auth::user()->id;

        if (Session::has('order_id')) {
            // Empty User Cart after order places
            Cart::where('user_id',$user_id)->delete();
            return view('front.products.thanks');
        }else {
            // If user refresh the page 
            return redirect('orders');
        }
        
    }

    public function addEditDeliveryAddress(Request $request,$id=null) {
        if ($id == "") {
            // Add Delivery Address
            $title = "Add Delivery Addresss";
            $address = new DeliveryAddress;
            $message = "Delivery Address has been Added Successfully!";
        }else {
            // Edit Delivery Address
            $title = "Edit Delivery Address";
            $address = DeliveryAddress::with('country')->find($id);
            $message = "Delivery Address has been Updated Successfully!";
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $request->validate([
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|numeric|digits:10',
                'address' => 'required',
                'city' => 'required|regex:/^[\pL\s\-]+$/u',
                'state' => 'required|regex:/^[\pL\s\-]+$/u',
                'postcode' => 'required|numeric',

                
            ]);
            $user_id = Auth::user()->id;
            $address->user_id = $user_id;
            $address->name = $data['name'];
            $address->mobile = $data['mobile'];
            $address->address = $data['address'];
            $address->city = $data['city'];
            $address->state = $data['state'];
            $address->country_id = $data['country_id'];
            $address->postcode = $data['postcode'];
            $address->status = 1;
            $address->save();
            
            Session::put('success_message',$message);
            return redirect('/checkout');
        }   
        $countries = Country::get()->toArray();
        return view('front.products.add_edit_delivery_address')->with(compact('title','countries','address'));
    }

    public function removeDeliveryAddress($id) {
        DeliveryAddress::where('id',$id)->delete();
        $message = "Delivery Address Deleted Succefully!";
        Session::flash('success_message',$message);
        return redirect()->back();
    }
}
