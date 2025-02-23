<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helpers\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{


    function LoginPage(){
        return view('pages.auth.login-page');
    }

    function RegistrationPage(){
        return view('pages.auth.registration-page');
    }
    function SendOtpPage(){
        return view('pages.auth.send-otp-page');
    }
    function VerifyOTPPage(){
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage(){
        return view('pages.auth.reset-pass-page');
    }
  



    function ProfilePage(){
        return view('pages.dashboard.profile-page');
    }


    // User Registration
    public function UserRegistration(Request $request)
    { 
        
        try {
            $user = User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
               'password' => $request->input('password')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Registration successful',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    // User Login
    public function UserLogin(Request $request)
    {

        
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email','=',$request->input('email') )
        ->where('password','=',$request->input('password'))
        ->select('id')->first();

        if ($user !==null) {
            $token = JWTToken::CreateToken($email,$user->id);
            
// avabe chilo r k
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successful',
                'token' => $token,
            ], 200)->cookie('token',$token,60*24*30);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized',
            ], 401);
        }
    }

    // Send OTP Code
    public function SendOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $user = User::where('email', $email)->first();

        if ($user) {
            // OTP ইমেইল পাঠানো
            Mail::to($email)->send(new OTPMail($otp));

            // OTP এবং সময় আপডেট
            $user->update([
                'otp' => $otp,
                'otp_created_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => '4 digit OTP has been sent to your email',
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found',
            ], 404);
        }
    }

    // Verify OTP
    public function VerifyOtp(Request $request)
    {
        //mail a otp asca tw
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email','=',$email)
                       ->where('otp','=',$otp)->count();

        if($count==1){
        //    Update Otp
        User::where('email','=',$email)->update(['otp'=>'0']);
        // pass reset token issue
        $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
        return response()->json([
            'status' => 'success',
            'message' => 'OTP verification successful'
            
        ], 200)->cookie('token',$token,60*24*30);

        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid or expired OTP',
            ], 401);
        }    
        }
    

    // Reset Password
    public function ResetPassword(Request $request)
    {

        try {
            $email = $request->header('email');
            $password = $request->input('password');

            
            // পাসওয়ার্ড এনক্রিপ্ট করে আপডেট
            User::where('email','=', $email)->update(['password' => $password]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successful',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Request failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function logout(){
        return redirect('/userLogin')->cookie('token', '-1');

    }
           //data fetch fetch kora anar jonnu
           public function UserProfile(Request $request) {
            $email = $request->header('email');  // 1
            $user = User::where('email', '=', $email)->first();  // 2
            return response()->json([       // 3
                'status' => 'success',      // 3.1
                'message' => 'Request Successful', // 3.2
                'data' => $user            // 3.3
            ], status: 200);               // 3.4
        }
        
    

 function updateProfile(Request $request)
            {
                try {
                    // হেডার থেকে ডেটা নেয়া
                    $email = $request->header('email');
                    $firstName = $request->input('firstName');
                    $lastName = $request->input('lastName');
                    $mobile = $request->input('mobile');
                    $password = $request->input('password');
                    
            
                    // ডাটাবেস আপডেট
                    $updated = User::where('email', '=', $email)->update([
                        'firstName' => $firstName,
                        'lastName'  => $lastName,
                        'mobile'    => $mobile,
                        'password'  => $password 
                    ]);
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Profile updated successfully',
                        ], 200);
                       
                } catch (Exception $exception) {
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'No user found with the given email',
                    ], 404);
                }
            }
        
        }
    




