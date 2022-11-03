<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReviewsController extends Controller
{
    public function addreview(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            // Check if user is logged In
            if (!Auth::check()) {
                $message = "Please login to leave a review!";
                Session::flash('error_message',$message);
                return redirect()->back();
            }

            // Check if user selected at least 1 star rating
            if (!isset($data['rating'])) {
                $message = " Please Add at least 1 Star Rating for this Product";
                Session::flash('error_message',$message);
                return redirect()->back();
            }

            $reviewCount = Review::where(['user_id'=>Auth::user()->id,'product_id'=>$data['product_id']])->count();
            // Check if user have placed a review 
            if ($reviewCount > 0) {
                $message = " Your rating already exists";
                Session::flash('error_message',$message);
                return redirect()->back();
            }else {
                // Create New Review
                $review = new Review;
                $review->user_id = Auth::user()->id;
                $review->product_id = $data['product_id'];
                $review->review = $data['review'];
                $review->rating = $data['rating'];
                $review->status = 0;
                $review->save();
                $message = "Thanks for you review! It will be displayed once approved";
                Session::flash('success_message',$message);
                return redirect()->back();
            }
            
        }
    }
}
