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
        $validator = Validator::make(
            $request->all(),
            [
                'ID' => 'required',
                'Full_Name' => 'required',
                'Email' => 'required|email',
                'Phone' => 'numeric',
                'Password' => 'required ',
                'Address' => 'string',
                'location' => 'string'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        Supervisor::create(array_merge(
            $validator->validated(),
            ['Password' => bcrypt($request->Password)]
        ));
        return response()->json([
            'message' => 'SuperVisor successfully Stored',
        ], 201);
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
            /*  return response()->json([
                'success' => true,
                'Bus' => $Businfo,
            ]); */
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
            return response()->json(['message' => 'student not found'], 404);
        }

        $supervisor->update([
            'Full_Name' => $request->Full_Name ?? $oldsupervisor->Full_Name,
            'Email' => $request->Email ?? $oldsupervisor->Email,
            'Phone' => $request->Phone ?? $oldsupervisor->Phone,
            'Address' => $request->Address ?? $oldsupervisor->Address,
            'location' => $request->location ?? $oldsupervisor->location,
        ]);
        $supervisor->save();
        return response()->json(['message' => 'Supervisor updated successfully', 'supervisor' => new SupervisorResource($supervisor)], 201);
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
