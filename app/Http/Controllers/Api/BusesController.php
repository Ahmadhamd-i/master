<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusesInfoResource;
use App\Models\BusInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusesController extends Controller
{

    public function store(Request $request)
    {
        $ran = mt_rand(10000, 20000);
        // Validate request data
        $validator = Validator::make(
            $request->all(),
            [
                'Bus_Supervisor_ID' => 'required',
                'Bus_Driver_ID' => 'required',
                'Bus_Line_Name' => 'required|string',
                'Bus_License' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $Businfo = BusInfo::create(array_merge($validator->validated(), ['ID' => $ran]));
        return ApiResponse::sendresponse(201, 'BusInfo stored Successfully ', new BusesInfoResource($Businfo));
    }

    public function index()
    {
        $Buses = BusInfo::all();

        return ApiResponse::sendresponse(200, 'Buses ', BusesInfoResource::collection($Buses));
    }
    public function getBusInfo($ID)
    {
        $buses = BusInfo::where('ID', $ID)->get();
        if ($buses) {
            return ApiResponse::sendresponse(200, "Bus", $buses);
        } {
            return $this->apiresponse(null, 'Buses Table Not Found', 404);
        }
    }

    public function  update(Request $request, $ID)
    {
        // Find the Bus
        $bus = BusInfo::find($ID);

        if (!$bus) {
            return response()->json(['message' => 'Bus not found'], 404);
        }

        // Validate request data
        $validator = Validator::make(
            $request->only(['ID', 'Bus_Supervisor_ID', 'Bus_Driver_ID', 'Bus_Line_Name',]),
            [
                'ID' => 'sometimes',
                'Bus_Line_Name' => 'string|sometimes',
                'Bus_Supervisor_ID' => 'numeric|sometimes',
                'Bus_Driver_ID' => 'numeric|sometimes',
                'Bus_License' => 'sometimes|string'

            ]
        );

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }

        $oldBusinfo = BusInfo::find($ID);
        if (!$oldBusinfo) {
            return response()->json(['message' => 'Bus not found'], 404);
        }

        $bus->update([
            'ID' => $request->ID ?? $oldBusinfo->ID,
            'Bus_Line_Name' => $request->Bus_Line_Name ?? $oldBusinfo->Bus_Line_Name,
            'Bus_Driver_ID' => $request->Bus_Driver_ID ?? $oldBusinfo->Bus_Driver_ID,
            'Bus_Supervisor_ID' => $request->Bus_Supervisor_ID ?? $oldBusinfo->Bus_Supervisor_ID,
            'Bus_License' => $request->Bus_License ?? $oldBusinfo->Bus_License,
        ]);
        $bus->save();
        return ApiResponse::sendresponse(201, 'Bus Updated Successfuly', new BusesInfoResource($bus));
    }


    public function destroy($id)
    {
        $Bus = BusInfo::find($id);

        if (!$Bus) {
            return response()->json(['message' => 'Bus not found'], 404);
        }

        $Bus->destroy($id);
        return ApiResponse::sendresponse(200, 'Bus Deleted Successfuly');
    }
}
