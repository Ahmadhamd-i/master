<?php

namespace App\Http\Controllers\Api;


use App\Models\Supervisor;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SupervisorResource;


class SupervisorController extends Controller
{

    public function store(Request $request)
    {
        // Validate request data
        $ran = mt_rand(60000, 70000);
        $validator = Validator::make(
            $request->all(),
            [
                'Full_Name' => 'required',
                'Email' => 'required|email',
                'Phone' => 'numeric',
                'Password' => 'required ',
                'Address' => 'string',
                'location' => 'string',
                'Image' => 'required|mimes:png,jpg,jpeg'
            ]
        );

        if ($request->hasFile('Image')) {
            $imageFile = $request->file('Image');
            $imageName = $imageFile->getClientOriginalName();

            $imageFile->storeAs('public', $imageName);
            $imageUrl = asset('storage/' . $imageName);
        } else {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $supervisorinfo = Supervisor::create(array_merge(
            $validator->validated(),
            ['ID' => $ran, 'Password' => bcrypt($request->Password), 'Image' => $imageUrl]
        ));
        return ApiResponse::sendresponse(201, 'Supervisor stored Successfully ', new SupervisorResource($supervisorinfo));
    }

    public function index()
    {
        $supervisors = Supervisor::all();

        return ApiResponse::sendresponse(200, 'Supervisors ', SupervisorResource::collection($supervisors));
    }


    public function getSupervisor($ID)
    {
        $Supervisor = Supervisor::findOrFail($ID);
        if ($Supervisor) {
            return ApiResponse::sendresponse(200, "Bus", new SupervisorResource($Supervisor));
        } {
            return $this->apiresponse(null, 'Supervisor Table Not Found', 404);
        }
    }


    //Update Function
    public function  update(Request $request, $id)
    {
        // Find the supervisor
        $supervisor = Supervisor::find($id);

        if (!$supervisor) {
            return response()->json(['message' => 'Supervisor not found'], 404);
        }

        // Validate request data
        $validator = Validator::make(
            $request->only(['Full_Name', 'Email', 'Phone', 'Address', 'location']),
            [
                'Full_Name' => 'sometimes',
                'Email' => 'sometimes|email',
                'Phone' => 'numeric',
                'Address' => 'string',
                'location' => 'string',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }

        $oldsupervisor = Supervisor::find($id);
        if (!$oldsupervisor) {
            return response()->json(['message' => 'Supervisor not found'], 404);
        }

        $supervisor->update([
            'Full_Name' => $request->Full_Name ?? $oldsupervisor->Full_Name,
            'Email' => $request->Email ?? $oldsupervisor->Email,
            'Phone' => $request->Phone ?? $oldsupervisor->Phone,
            'Address' => $request->Address ?? $oldsupervisor->Address,
            'location' => $request->location ?? $oldsupervisor->location,
        ]);
        $supervisor->save();
        return ApiResponse::sendresponse(201, 'Supervisor updated successfully', new SupervisorResource($supervisor));
    }

    //Delete Function
    public function destroy($id)
    {
        $supervisor = Supervisor::find($id);

        if (!$supervisor) {
            return response()->json(['message' => 'Supervisor not found'], 404);
        }

        $supervisor->destroy($id);
        return response()->json(['message' => 'Supervisor deleted successfully'], 200);
    }
}
