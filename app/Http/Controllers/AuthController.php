<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\ApiResponse;
use Hash;
use Illuminate\Http\Request;

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

        if (!$user) return ApiResponse::send(false, "Unauthorized or Invalid Token", null, 401);

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

        if ($request->name) $user->name = $request->name;
        if ($request->contact) $user->contact = $request->contact;
        if ($request->status) $user->status = $request->status;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile_images'), $filename);
            $user->profile_image = 'profile_images/' . $filename;
        }

        $user->save();

        return ApiResponse::send(true, "User Updated Successfully", $user);
    }
}
