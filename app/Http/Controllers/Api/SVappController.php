<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class SVappController extends Controller
{
    public function getrelatedStudents(Request $request)
    {
        $id = $request->id;
        $students = Student::where('Supervisor_ID', $id)->get();
        if ($students->count() > 0) {
            return ApiResponse::sendresponse(200, 'Students with this Supervisor', StudentResource::collection($students));
        } else {
            return ApiResponse::sendresponse(200, 'There are no students related to this Supervisor OR Supervisor ID invalid');
        }
    }
}
