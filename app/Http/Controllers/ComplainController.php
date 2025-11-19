<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Compalin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplainController extends Controller
{
    public function CreateComplain(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'video' => 'nullable|max:10000'
        ]);

        if ($validated->fails()) {
            return ApiResponse::send(false, "Validation Error", $validated->errors(), 422);
        }

        // Upload Image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('complains/images', 'public');
        }

        // Upload Video
        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('complains/videos', 'public');
        }

        $complain = Compalin::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'image' => "storage/".$imagePath,
            'video' => "storage/".$videoPath,
        ]);

        return ApiResponse::send(true, "Complain Created Successfully", $complain, 201);
    }
}
