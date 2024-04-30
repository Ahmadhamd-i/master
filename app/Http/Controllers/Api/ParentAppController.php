<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class ParentAppController extends Controller
{
    public function getParentChild(Request $request)
    {
        $id = $request->id;
        $Child = Student::where('Parent_ID', $id)->get();
        if ($Child->count() > 0) {
            return ApiResponse::sendresponse(200, 'Children for this Parent', StudentResource::collection($Child));
        } else {
            return ApiResponse::sendresponse(200, 'There are no Children related to this Supervisor OR Supervisor ID invalid');
        }
    }
}