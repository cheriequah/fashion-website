<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    public function reviews() {
        Session::put('page','reviews');
        // Get all reviews with user and product details
        $reviews = Review::with(['user','product'])->get()->toArray();
         return view('admin.reviews.reviews')->with(compact('reviews'));
    }

    public function updateReviewStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();

            //if POST request receive is Approved, change the status to 0
            if ($data['status'] == "Approved") {
                $status = 0;
            }
            //else change status to 1
            else {
                $status = 1;
            }
            // find the id that match the current review id and update the status
            Review::where('id',$data['review_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'review_id'=>$data['review_id']]);
        }
    }
}
