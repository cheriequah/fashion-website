<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Measurement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class UsersController extends Controller
{
    // Login Register Page
    public function loginRegister() {
        return view('front.users.login_register');
    }

    public function registerUser(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            // Check if user already exist
            $userCount = User::where('email',$data['email'])->count();
            if ($userCount > 0) {
                $message = "Email already exists";
                Session::flash('err_msg',$message);
                return redirect()->back();
            }else {
                $request->validate([
                    'mobile' => 'numeric|digits:10',
                    'password' => 'min:6'
                ]);

                // Register the user
                $user = new User();
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->mobile = $data['mobile'];
                $user->address = "";
                $user->city = "";
                $user->state = "";
                $user->country_id = 1;
                $user->postcode = "";
                $user->password = bcrypt($data['password']);
                $user->save();  
                
                // Send Confirmation Email
                $email = $data['email'];
                $messageEmail = [
                    'email' => $data['email'],
                    'name' =>$data['name'],
                    'code' => base64_encode($data['email']),
                ];
                Mail::send('emails.confirmation',$messageEmail,function($message) use($email) {
                    $message->to($email)->subject('Confirm your email for Pearl Wonder Website');
                });

                // Redirect user back with success message
                $message = "Please check and confirm your email to activate your account!";
                Session::flash('success_message',$message);
                return redirect()->back();
                /*
                if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])) {
                    //echo "<pre>"; print_r(Auth::user()); die;
                    // Update user cart for user id
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }
                    
                    // Send register email
                    $email = $data['email'];
                    $messageEmail = [
                        'email' => $data['email'],
                        'name' =>$data['name'],
                        'mobile' => $data['mobile']
                    ];
                    Mail::send('emails.register',$messageEmail,function($message) use($email) {
                        $message->to($email)->subject('Welcome to Pearl Wonder Website');
                    });
                    return redirect('/');
                }*/
            }
        }
    }

    public function confirmAccount($email) {
        Session::forget('err_msg');
        Session::forget('success_message');

        // Decode User Email
        $email = base64_decode($email);

        // Check if User Email Exists
        $userCount = User::where('email',$email)->count();
        // If exists
        if ($userCount > 0) {
            // Check if email already activated
            $userDetails = User::where('email',$email)->first();
            // If already activated
            if ($userDetails->status == 1) {
                $message = "Your Email Account has already been activated. Please Login.";
                Session::flash('err_msg',$message);
                return redirect('login-register');
            }else {
                // User Status to 1 to activated account
                User::where('email',$email)->update(['status'=>1]);

                    // Send register email
                    $messageEmail = [
                        'email' => $userDetails['email'],
                        'name' =>$userDetails['name'],
                        'mobile' => $userDetails['mobile']
                    ];
                    Mail::send('emails.register',$messageEmail,function($message) use($email) {
                        $message->to($email)->subject('Welcome to Pearl Wonder Website');
                    });
                    // After account activated, redirect user to login/register page
                    $message = "Your Email Account has been Activated Successfully. You may login now.";
                    Session::flash('success_message',$message);
                    return redirect('login-register');
            } // Not activated
        }else {
            abort(404);
        }
    }

    public function loginUser(Request $request) {
        if ($request->isMethod('post')) {
            Session::forget('err_msg');
            Session::forget('success_message');
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            // If the email and password match with database (record found)
            if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])) {

                // Check if Email is activated
                $userStatus = User::where('email',$data['email'])->first();
                if ($userStatus->status == 0) {
                    Auth::logout();
                    $message = "Your Account is not activated yet! Please activate your account.";
                    Session::put('err_msg',$message);
                    return redirect()->back();
                }
                // Update user cart for user id
                if (!empty(Session::get('session_id'))) {
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    return redirect('cart');
                }
                return redirect('/');
            }else {
                $message = "Invalid Username or Password";
                Session::flash('err_msg',$message);
                return redirect()->back();
            }
        }
    }

    public function logoutUser() {
        Auth::logout();
        return redirect('/');
    }

    public function account(Request $request) {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id)->toArray();
        $countries = Country::get()->toArray();
        //dd($userDetails);

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            // When data is post, previous err and success msg will be removed
            Session::forget('err_msg');
            Session::forget('success_message');
            
            // Jquery and html can conflict with other script and stop working, laravel validation always work
            $request->validate([
                'name' => 'required',
                'mobile' => 'required|numeric|digits:10',
                
            ]);
            
            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->mobile = $data['mobile'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country_id = $data['country_id'];
            $user->postcode = $data['postcode'];
            $user->save();
            $message = "Your Account Details has been Updated!";
            Session::put('success_message',$message);
            return redirect()->back();
        }
        return view('front.users.account')->with(compact('userDetails','countries'));
    }

    public function preferences() {
        return view('front.users.preferences');
    }

    public function sizeCalculator(Request $request) {
        // Create empty array
        $sizeCalculatedTops = array('size'=>"",'note'=>"");
        $sizeCalculatedBottoms = array('size'=>"",'note'=>"");
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $sizeCalculatedTops = User::getCalculatedTops($data['bust'], $data['waist']);
            $sizeCalculatedBottoms = User::getCalculatedBottoms($data['waist'], $data['hip']);
        }
        
        return view('front.users.calculator')->with(compact('sizeCalculatedTops','sizeCalculatedBottoms'));
    }

    /*public function sizeCalculatorTops(Request $request) {
        // Create empty array
        $sizeCalculatedTops = array('size'=>"",'note'=>"");
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $sizeCalculatedTops = User::getCalculatedTops($data['bust'], $data['waist']);
            
        }
        return view('front.users.calculator')->with(compact('sizeCalculatedTops'));
    }

    public function sizeCalculatorBottoms(Request $request) {
        // Create empty array
        $sizeCalculatedBottoms = array('size'=>"",'note'=>"");
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $sizeCalculatedBottoms = User::getCalculatedBottoms($data['waist'], $data['hip']);
            //dd($sizeCalculated['size'],$sizeCalculated['note']);
        }
        return view('front.users.calculator')->with(compact('sizeCalculatedBottoms'));
    }*/

    public function measurement(Request $request) {
        $user_id = Auth::user()->id;

        // Create empty array
        $sizeCalculatedTops = array('size'=>"",'note'=>"");
        $sizeCalculatedBottoms = array('size'=>"",'note'=>"");
        $measurementCount = Measurement::where(['user_id'=>$user_id])->count();
        // If user measurement details exist
        if ($measurementCount > 0) {
            $measurementDetails = Measurement::where(['user_id'=>$user_id])->first()->toArray();
        }else {
            $measurementDetails = array();
        }
        
        //dd($measurementDetails);
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
        
            $sizeCalculatedTops = User::getCalculatedTops($data['bust'], $data['waist']);
            $sizeCalculatedBottoms = User::getCalculatedBottoms($data['waist'], $data['hip']);

            // For Edit Measurement
            if ($measurementCount > 0) {
                $measurement = Measurement::where(['user_id'=>$user_id])->first();  
                //dd($measurement); 
                $measurement->bust = $data['bust'];
                $measurement->waist = $data['waist'];
                $measurement->hip = $data['hip'];
                $measurement->save();
                $message = "Your Measurement has been updated successfully!";
                Session::flash('success_message',$message);
                return redirect()->back()->with(compact('sizeCalculatedTops','sizeCalculatedBottoms'));
            }else {
                // Add measurement
                $measurement = new Measurement;
                $measurement->user_id = $user_id;
                $measurement->bust = $data['bust'];
                $measurement->waist = $data['waist'];
                $measurement->hip = $data['hip'];
                $measurement->save();
                $message = "Your Measurement has been saved successfully!";
                Session::flash('success_message',$message);
                return redirect()->back()->with(compact('sizeCalculatedTops','sizeCalculatedBottoms'));
            }
            //return redirect()->back();
            //echo "<pre>"; print_r($sizeCalculatedTops); die;
        }
        return view('front.users.measurement')->with(compact('measurementDetails','sizeCalculatedTops','sizeCalculatedBottoms'));
    }

    public function PythonScript() {
    /*$process = new Process(['python','C:/xampp/htdocs/Laravel/fashion-website/app/PythonScript/test.py']);
    $process->run();
    
    if (!$process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }*/
    $data = exec('python C:/xampp/htdocs/Laravel/fashion-website/app/PythonScript/train.py');

    //$data = $process->getOutput();

    dd($data);
    }
}
