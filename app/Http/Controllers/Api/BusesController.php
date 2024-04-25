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
        // Validate request data
        $validator = Validator::make(
            $request->all(),
            [
                'Bus_ID' => 'required',
                'Bus_Supervisor_ID' => 'required',
                'Bus_Driver_ID' => 'required',
                'Bus_Line_Name' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        BusInfo::create(array_merge($validator->validated()));
        return response()->json([
            'message' => 'Bus Info successfully Stored',
        ], 201);
    }

    public function index()
    {
        $Buses = BusInfo::all();

        return ApiResponse::sendresponse(200, 'Buses ', BusesInfoResource::collection($Buses));
    }
    public function getBusInfo($ID)
    {
        $buses = BusInfo::findOrFail($ID);
        if ($buses) {
            return ApiResponse::sendresponse(200, "Bus", $buses);
            /*  return response()->json([
                'success' => true,
                'Bus' => $Businfo,
            ]); */
        } {
            return $this->apiresponse(null, 'Buses Table Not Found', 404);
        }
    }

    public function  update(Request $request, $id)
    {
        // Find the Student
        $Businfo = BusInfo::find($id);

        if (!$Businfo) {
            return response()->json(['message' => 'Bus not found'], 404);
        }

        // Validate request data
        $validator = Validator::make(
            $request->only(['Bus_ID', 'Bus_Supervisor_ID', 'Bus_Driver_ID', 'Bus_Line_Name']),
            [
                'Bus_ID' => 'sometimes',
                'Bus_Supervisor_ID' => 'sometimes',
                'Bus_Driver_ID' => 'sometimes',
                'Bus_Line_Name' => 'sometimes|string',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }

        $oldBusInfo = BusInfo::find($id);
        if (!$oldBusInfo) {
            return response()->json(['message' => 'Bus not found'], 404);
        }

        $Businfo->update([
            'Bus_ID' => $request->Bus_ID ?? $oldBusInfo->Bus_ID,
            'Bus_Supervisor_ID' => $request->Bus_Supervisor_ID ?? $oldBusInfo->Bus_Supervisor_ID,
            'Bus_Driver_ID' => $request->Bus_Driver_ID ?? $oldBusInfo->Bus_Driver_ID,
            'Bus_Line_Name' => $request->Bus_Line_Name ?? $oldBusInfo->Bus_Line_Name,

        ]);
        $Businfo->save();
        return response()->json(['message' => 'Bus Info updated successfully', 'Businfo' => new BusesInfoResource($Businfo)], 201);
    }
    public function destroy($id)
    {
        $BusInfo = BusInfo::find($id);

        if (!$BusInfo) {
            return response()->json(['message' => 'BusInfo not found'], 404);
        }

        $BusInfo->destroy($id);
        return response()->json(['message' => 'BusInfo deleted successfully'], 200);
    }
}
