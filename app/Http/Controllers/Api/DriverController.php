<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function store(Request $request)
    {
        $ran = mt_rand(20001, 30000);
        // Validate request data
        $validator = Validator::make(
            $request->all(),
            [

                'Full_Name' => 'required',
                'Phone' => 'required|numeric',
                'Email' => 'email',
                'Image' => 'required|image|mimes:jpeg,png,jpg|max:1024'
            ]
        );
        // Read the image file

        // Get the uploaded file
        //$imageFile = $request->file('Image')->save(storage_path(path:'Images/'.$request->Image->hash_Name()));

        if ($request->hasFile('Image')) {
            /*  $imageFile = $request->file('Image');
            $imageName = $imageFile->getClientOriginalName();
            $imageFile->storeAs('storage', $imageName, 'storage'); */
            $imageFile = $request->file('Image');
            $imageName = $imageFile->getClientOriginalName();

            $imageFile->storeAs('public', $imageName);

            // Generate the URL for accessing the stored image
            $imageUrl = asset('storage/' . $imageName);
        } else {
            return response()->json(['error' => 'No file uploaded'], 400);
        }


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $driverinfo = Driver::create(array_merge($validator->validated(), ['ID' => $ran, 'Image' => $imageUrl]));
        return ApiResponse::sendresponse(201, 'Driver stored Successfully ', new DriverResource($driverinfo));
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
        // Find the driver
        $driver = Driver::find($id);

        if (!$driver) {
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

        $driver->update([
            'ID' => $request->ID ?? $olddriver->ID,
            'Full_Name' => $request->Full_Name ?? $olddriver->Full_Name,
            'Email' => $request->Email ?? $olddriver->Email,
            'Phone' => $request->Phone ?? $olddriver->Phone,

        ]);
        $driver->save();
        return response()->json(['message' => 'Driver updated successfully', 'Driver' => new DriverResource($driver)], 201);
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
