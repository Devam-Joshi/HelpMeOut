<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        // dd($request->all());
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

        return response()->json([
            'message' => 'User Register Successfully',
            'user' => $user,
        ],201);
    }

    public function login(Request $request){
    //    dd($request->all());
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(),[
            'email' => 'nullable',
            'contact' => 'nullable',
            'password' => 'required',
        ]);


        if($validated->fails()){
            return response()->json([
                'errors' => $validated->errors()
            ],422);
        }

    $user = null;
    if ($request->email) {
        $user = User::where('email', $request->email)->first();
    } elseif ($request->contact) {
        $user = User::where('contact', $request->contact)->first();
    } else {
        return response()->json([
            'message' => 'Email or contact is required to login.'
        ], 400);
    }
    
    if ($user && Hash::check($request->password, $user->password)) {
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'User login successfully',
            'user'    => $user,
            'token' => $token
        ], 200);
    }

    return response()->json([
        'message' => 'Invalid credentials'
    ], 401);
        
    }
}
