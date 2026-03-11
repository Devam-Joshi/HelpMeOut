<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\CategoryUser;
use App\Models\Compalin;
use App\Models\TakeComplaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComplainController extends Controller
{
    public function CreateComplain(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            // 'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'video' => 'nullable|max:10000',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
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
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id,
            'image' => "storage/" . $imagePath,
            'video' => "storage/" . $videoPath,
        ]);

        return ApiResponse::send(true, "Complain Created Successfully", $complain, 201);
    }

    public function updateStatus(Request $request)
    {
        // dd('update status');
        $validated = validator::make($request->all(), [
            'id' => 'required',
            'status_id' => 'required'
        ]);
        if ($validated->fails()) {
            return ApiResponse::send(false, "Complain Id Must Required", $validated->errors(), 422);
        } else {
            $complain = Compalin::where('id', $request->id)->first();
            // dd($complain);

            if ($request->id) {


                $complain->status = $request->status_id;
                $complain->save();

                return ApiResponse::send(true, "Compalin Updated Sucessfully", [
                    'id' => $request->id,
                    'status_id' => $request->status_id
                ], 201);
            } else {
                return ApiResponse::send(false, "Invalid Request", $validated->errors(), 422);
            }
        }
    }

    public function getcompalinbyid(Request $request)
    {
        $user = Auth::user();

        $complains = Compalin::with('category:id,name')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($complain) {
                return [
                    'id' => $complain->id,
                    'title' => $complain->title,
                    'category_id' => $complain->category_id,
                    'category_name' => $complain->category?->name,
                    'image' => $complain->image,
                    'video' => $complain->video,
                    'created_at' => $complain->created_at,
                ];
            });

        return ApiResponse::send(
            true,
            "Complains Fetched Successfully",
            $complains,
            200
        );
    }


    public function getcomplainbycatergory()
    {
        $user = Auth::user();

        // Get all category IDs for the user
        $categoryIds = CategoryUser::where('user_id', $user->id)
            ->pluck('category_id')
            ->toArray();

        // Fetch all complaints for those categories
        $complains = Compalin::whereIn('category_id', $categoryIds)
            ->get();

        return ApiResponse::send(true, "Complains fetched successfully", $complains, 200);
    }

    public function getcomplainbycomplainid(Request $request)
    {
        $complain = Compalin::with([
            'user:id,name',
            'category:id,name'
        ])->find($request->complain_id);

        if (!$complain) {
            return ApiResponse::send(false, "Complain Not Found", null, 404);
        }

        $response = [
            'id' => $complain->id,
            'title' => $complain->title,
            'user_id' => $complain->user_id,
            'user_name' => $complain->user?->name,
            'category_id' => $complain->category_id,
            'category_name' => $complain->category?->name,
            'image' => $complain->image,
            'video' => $complain->video,
            'created_at' => $complain->created_at,
        ];

        return ApiResponse::send(
            true,
            "Complain Fetch Successfully",
            $response,
            200
        );
    }



    public function getcomplainbystatus(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'status_id' => 'required'
        ]);

        $complain = Compalin::where('status', $request->status_id)->get();

        return ApiResponse::send(true, "Complains fetched successfully", $complain, 200);
    }

    public function getallcomplain()
    {
        $complain = Compalin::all();
        // dd($complain);
        return ApiResponse::send(true, "Complains fetched successfully", $complain, 200);
    }

    public function takeComplaint(Request $request)
    {
        $authUser = auth()->user();

        $validator = Validator::make($request->all(), [
            'complaint_id' => 'required|exists:complains,id',
            'agent_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return ApiResponse::send(
                false,
                'Validation Error',
                $validator->errors(),
                422
            );
        }

        // Get validated data
        $data = $validator->validated();

        // Decide agent
        $agentId = $data['agent_id'] ?? $authUser->id;

        // Prevent duplicate assignment
        $alreadyAssigned = TakeComplaint::where('complaint_id', $data['complaint_id'])->exists();

        if ($alreadyAssigned) {
            return ApiResponse::send(
                false,
                'Complaint already assigned',
                null,
                409
            );
        }

        // Create assignment
        $takeComplaint = TakeComplaint::create([
            'complaint_id' => $data['complaint_id'],
            'agent_id' => $agentId,
        ]);

        // Update complaint status
        Compalin::where('id', $data['complaint_id'])->update([
            'status' => 4,
            'user_id' => $agentId,
        ]);

        $message = isset($data['agent_id'])
            ? 'Complaint assigned to agent successfully'
            : 'Complaint taken successfully';

        return ApiResponse::send(
            true,
            $message,
            $takeComplaint,
            201
        );
    }

    public function agentTakenComplaints(Request $request)
    {
        $agent = auth()->user();

        $takenComplaints = TakeComplaint::with([
            'complaint:id,title,description,category_id,status,priority,image,video,created_at'
        ])
            ->where('agent_id', $agent->id)
            ->latest()
            ->paginate(10);

        return ApiResponse::send(
            true,
            'Your taken complaints fetched successfully',
            $takenComplaints,
            200
        );
    }
}
