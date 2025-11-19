<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\CategoryUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;

class CategoryController extends Controller
{
    public function createCategopry(Request $request){
        // dd($request->all());
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validated->fails()) {
            return ApiResponse::send(false, "Validation Error", $validated->errors(), 422);
        }

        $category = Category::create([
            'name' => $request->name
        ]);

         return ApiResponse::send(true, "Category Created Successfully", [
            'name' => $category,
        ], 201);

    }

    public function getcategory(){
        // dd('getcategory');
        $category = Category::all();
        return ApiResponse::send(true, "Category Found", $category);
    }

    public function CategoryToUser(Request $request){
        // dd($request->all());
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'category_id' =>'required|integer',
            'user_id' =>'required|integer',
        ]);

        if ($validated->fails()) {
            return ApiResponse::send(false, "Validation Error", $validated->errors(), 422);
        }

        $categoryId = Category::where('id',$request->category_id)->first();
        if(!$categoryId){
             return ApiResponse::send(false, "Category Not Found", $validated->errors(), 422);
        }

        $CategoryUser = CategoryUser::create([
            'category_id' => $request->category_id,
            'user_id' => $request->user_id
        ]);

        return ApiResponse::send(true, "User Linked To Category Successfully", [
            'CategoryUser' => $CategoryUser
        ], 201);
    }

    
}
