<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\EnrollmentResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\SupervisorResource;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function Sharelocation(Request $request, $id)
    {

        // Find the supervisor
        $supervisor = Supervisor::find($id);

        if (!$supervisor) {
            return response()->json(['message' => 'Supervisor not found'], 404);
        }

        // Validate request data
        $validator = Validator::make(
            $request->only(['location']),
            [
                'location' => 'string',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }


        $supervisor->update([
            'location' => $request->location,
        ]);
        $supervisor->save();
        $data = $supervisor->location;
        return response()->json(['message' => 'Supervisor Location sent successfully', 'Location ' => $data], 201);
    }

    public function change_status(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'student_ID' => 'required|numeric',
                'Student_Status' => 'string',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $student = Student::find($request->student_ID);
        if (!$student) {
            return ApiResponse::sendresponse(200, 'Student_ID is incorrect');
        }
        $enrollment = Enrollment::where('student_ID', $request->student_ID)->first();
        if ($enrollment) {
            $enrollment->where('student_ID', $request->student_ID)->update([
                'Student_Status' => $request->Student_Status,
            ]);
            $enrollment->save();
            return ApiResponse::sendresponse(201, 'Status Updated Successfully ', new EnrollmentResource($enrollment));
        } else {
            $studentStatus = Enrollment::create(array_merge($validator->validated()));
            return ApiResponse::sendresponse(201, 'Status Stored Successfully ', new EnrollmentResource($studentStatus));
        }
    }
}
