<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComplainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
// Route::post('/getuser',[AuthController::class,'getuser']);
Route::middleware('auth:sanctum')->group(function () {

    // Get logged-in user details
    Route::get('/getuser', [AuthController::class, 'getuser']);
    Route::post('forgot-password',[AuthController::class,'forgotPassword']);
    Route::post('forgot-password-mail',[AuthController::class,'forgotPasswordMail']);
    Route::Post('verify-otp',[AuthController::class,'verifyOtp']);

    // Update/Edit user profile (name, contact, image, status, etc.)
    Route::post('/edituser', [AuthController::class, 'edituser']);
    Route::post('create-category',[CategoryController::class,'createCategopry']);
    Route::get('getcategory',[CategoryController::class,'getcategory']);
    Route::post('category-to-user',[CategoryController::class,'CategoryToUser']);

    Route::post('create-complain',[ComplainController::class,'CreateComplain']);
});

