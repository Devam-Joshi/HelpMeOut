<?php

namespace App\Http\Controllers;

use App\Models\Compalin;
use App\Models\User;
use App\Helpers\ApiResponse;
use App\Models\UserOtp;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\Random;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'contact' => 'required|integer',
            'status' => 'nullable',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact' => $request->contact,
            'status' => $request->status,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::send(true, "User Registered Successfully", [
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'nullable',
            'contact' => 'nullable',
            'password' => 'required',
        ]);

        if ($validated->fails()) {
            return ApiResponse::send(false, "Validation Error", $validated->errors(), 422);
        }

        $user = null;
        if ($request->email) {
            $user = User::where('email', $request->email)->first();
        } elseif ($request->contact) {
            $user = User::where('contact', $request->contact)->first();
        } else {
            return ApiResponse::send(false, "Email or Contact is required to login", null, 400);
        }

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return ApiResponse::send(true, "Login Successful", [
                'user' => $user,
                'token' => $token
            ]);
        }

        return ApiResponse::send(false, "Invalid Credentials", null, 401);
    }

    public function getuser(Request $request)
    {
        $user = auth()->user();

        if (!$user)
            return ApiResponse::send(false, "Unauthorized or Invalid Token", null, 401);

        return ApiResponse::send(true, "User Found", $user);
    }

    public function edituser(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:20',
            'status' => 'nullable|in:active,inactive',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->name)
            $user->name = $request->name;
        if ($request->contact)
            $user->contact = $request->contact;
        if ($request->status)
            $user->status = $request->status;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile_images'), $filename);
            $user->profile_image = 'profile_images/' . $filename;
        }

        $user->save();

        return ApiResponse::send(true, "User Updated Successfully", $user);
    }

    public function forgotPasswordMail(Request $request)
    {
        // dd($request->email);
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        $user_id = $request->id;
        // dd($email);
        if (!$user) {
            return ApiResponse::send(false, "User Not Found", $user);
        }

        $otp = rand(1000, 9999);
        // dd($otp);
        $userotp = UserOtp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10)
        ]);

        Mail::send('emails.forgot_password_otp', ['name' => $user->name, 'otp' => $otp], function ($msg) use ($user) {
            $msg->to($user->email)
                ->subject('Forgot Password OTP - ' . config('app.name'));
        });


        return ApiResponse::send(true, "OTP sent successfully", $otp);
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'email',
            'otp' => 'required',
        ]);
        // dd($request->otp);
        $user = User::where('email', $request->email)->first();
        $userotp = UserOtp::where('user_id', $user->id)->latest()->first();
        // dd($userotp->otp);
        // dd($otp);
        $user_id = $user->id;
        if ($request->otp == $userotp->otp) {

            if (now()->greaterThan($userotp->expires_at)) {
                return ApiResponse::send(false, "OTP Time Out", $userotp);
                // dd($userotp);
            }

            return ApiResponse::send(true, "OTP Verified Sucessfully", $userotp);

        } else {
            return ApiResponse::send(false, "OTP Invalid ");
        }
    }

    public function forgotPassword(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'password' => 'required',
            'confirmpassword' => 'required',
            'email' => 'required'
        ]);

        if ($request->password == $request->confirmpassword) {

            $userpassword = User::where('email', $request->email)->first();

            $userpassword->password = Hash::make($request->password);
            $userpassword->save();

            return ApiResponse::send(true, "Password Changed Successfully", $userpassword);
        } else {
            return ApiResponse::send(true, "Password Not Matched");
        }
    }

    public function getuserlist()
    {
        // dd('getuserlist');
        $getuserlist = User::all();
        return ApiResponse::send(true, "User Fetch Successfully", $getuserlist);
    }

    public function changepassword(Request $request)
    {
        // dd('changepassowrd');

        $validated = validator::make($request->all(), [
            'id' => 'required',
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirmnewpassword' => 'required'
        ]);
        if ($request->newpassword != $request->confirmnewpassword) {
            return ApiResponse::send(false, "Both New Password Not Matched", $validated->errors(), 422);
        }
        $user = User::where('id', $request->id)->first();
        if (!Hash::check($request->oldpassword, $user->password)) {
            return ApiResponse::send(false, "Old Password Not Matched", 422);
        }
        if ($request->newpassword != $request->confirmnewpassword) {
            return ApiResponse::send(false, "Both New Password Not Matched", $validated->errors(), 422);
        } else {
            $user->password = $request->newpassword;
            $user->save();
            return ApiResponse::send(true, "Password Changed Successfully", $user);
        }

    }

    public function getGlobalDashboard(){
        $userId = Auth::user()->id;

        $pendingComplain = Compalin::where('status',1)->where('user_id',$userId)->count();
        $inprogressComplain = Compalin::where('status',2)->where('user_id',$userId)->count();
        $completedComplain = Compalin::where('status',3)->where('user_id',$userId)->count();

        $data = [
            'pending_count' => $pendingComplain,
            'inprogress_count' => $inprogressComplain,
            'completed_count' => $completedComplain,
        ];

        return ApiResponse::send(true,"Dashboard",$data);
    }

    public function getSuperDashboard(){
        $userId = Auth::user()->id;

        $pendingComplain = Compalin::where('status',1)->count();
        $inprogressComplain = Compalin::where('status',2)->count();
        $completedComplain = Compalin::where('status',3)->count();

        $data = [
            'pending_count' => $pendingComplain,
            'inprogress_count' => $inprogressComplain,
            'completed_count' => $completedComplain,
        ];

        return ApiResponse::send(true,"Dashboard",$data);
    }

}