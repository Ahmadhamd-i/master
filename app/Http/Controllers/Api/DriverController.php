<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make(
            $request->all(),
            [
                'ID' => 'required',
                'Full_Name' => 'required',
                'Phone' => 'required|numeric',
                'Email' => 'email',

            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        Driver::create(array_merge($validator->validated()));
        return response()->json([
            'message' => 'Driver successfully Stored',
        ], 201);
    }

    public function index()
    {
        $driver = Driver::all();
        return ApiResponse::sendresponse(200, 'Dreivers ', DriverResource::collection($driver));
        // return response()->json(['Drivers' => DriverResource::collection($driver)], 200);
    }

    public function getDriver($ID)
    {
        $Driver = Driver::findOrFail($ID);
        if ($Driver) {
            return ApiResponse::sendresponse(200, "Driver", new DriverResource($Driver));
            /* return response()->json([
                'success' => true,
                'Driver' => new DriverResource($Driver), 200
            ]); */
        } {
            return $this->apiresponse(null, 'Driver Table Not Found', 404);
        }
    }
    public function  update(Request $request, $id)
    {
        // Find the supervisor
        $supervisor = Driver::find($id);

        if (!$supervisor) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        // Validate request data
        $validator = Validator::make(
            $request->only(['ID', 'Full_Name', 'Email', 'Phone',]),
            [
                'ID' => 'sometimes',
                'Full_Name' => 'sometimes',
                'Phone' => 'sometimes|numeric',
                'Email' => 'email',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }

        $olddriver = Driver::find($id);
        if (!$olddriver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        $supervisor->update([
            'ID' => $request->ID ?? $olddriver->ID,
            'Full_Name' => $request->Full_Name ?? $olddriver->Full_Name,
            'Email' => $request->Email ?? $olddriver->Email,
            'Phone' => $request->Phone ?? $olddriver->Phone,

        ]);
        $supervisor->save();
        return response()->json(['message' => 'Driver updated successfully', 'Driver' => new DriverResource($supervisor)], 201);
    }

    public function destroy($id)
    {
        $Driver = Driver::find($id);

        if (!$Driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        $Driver->destroy($id);
        return response()->json(['message' => 'Driver deleted successfully'], 200);
    }
}
