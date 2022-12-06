<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard() {
        Session::put('page','dashboard');
        $categoryCount = Category::all()->count();
        $productCount = Product::all()->count();
        $orderCount = Order::all()->count();
        $orderSales = Order::select('total')->sum('total');
        return view('admin.dashboard')->with(compact('categoryCount','productCount','orderCount','orderSales'));
    }

    public function settings() {
        //id is the attribute name
        //Auth::user()->id; for default authentication
        //user() currently authenticated user
        //echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first();
        return view('admin.settings')->with(compact('adminDetails'));
        
    }

    public function chkCurrentPw(Request $request) {
        $data = $request->all();
        echo "<pre>"; print_r($data); die;
    }

    public function login(Request $request) {
        //echo $password = Hash::make("12345678"); die;
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            /*$request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required',
                ],
                [
                    'email.email' => 'Valid Email is required',
                ]
            );
    */
    //$this->validate($request,$rules,$customMessages);

            // If the authentication admin guard check that the email and password is correct
            if (Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password']])) {
                return redirect('admin/dashboard');
            }
            else {
                Session::flash('err_msg','Invalid Email or Password');
                return redirect()->back();
            }
        }
        return view('admin.login');
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
