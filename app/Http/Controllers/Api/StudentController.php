<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $ran = mt_rand(70000, 80000);
        // Validate request data
        $validator = Validator::make(
            $request->all(),
            [

                'FullName' => 'required',
                'Parent_ID' => 'required',
                'grade' => 'required',
                'class' => 'required',
                'Supervisor_ID' => 'required',
                'Image' => 'sometimes|mimes:png,jpg,jpeg',
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
        $student = Student::create(array_merge($validator->validated(), ['ID' => $ran, 'Image' => $imageUrl]));
        return ApiResponse::sendresponse(201, 'Student stored Successfully ', new StudentResource($student));
    }

    public function index()
    {
        $Students = Student::all();
        return ApiResponse::sendresponse(200, 'Students ', StudentResource::collection($Students));
    }

    //Update Student
    public function  update(Request $request, $id)
    {
        // Find the Student
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'student not found'], 404);
        }

        // Validate request data
        $validator = Validator::make(
            $request->only(['FullName', 'Parent_ID', 'grade', 'class', 'Supervisor_ID',]),
            [
                'FullName' => 'sometimes',
                'Parent_ID' => 'sometimes',
                'grade' => 'sometimes',
                'class' => 'sometimes',
                'Supervisor_ID' => 'sometimes',

            ]
        );

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }

        $oldstudent = Student::find($id);
        if (!$oldstudent) {
            return response()->json(['message' => 'student not found'], 404);
        }

        $student->update([
            'FullName' => $request->FullName ?? $oldstudent->FullName,
            'Parent_ID' => $request->Parent_ID ?? $oldstudent->Parent_ID,
            'grade' => $request->grade ?? $oldstudent->grade,
            'class' => $request->class ?? $oldstudent->class,
            'Supervisor_ID' => $request->Supervisor_ID ?? $oldstudent->Supervisor_ID,
        ]);
        $student->save();
        return ApiResponse::sendresponse(201, 'student updated successfully', new StudentResource($student));
    }


    public function getStudent($ID) 
    {
        $Student = Student::findOrFail($ID);
        if ($Student) {

            return Apiresponse::sendresponse(200, "Student", new StudentResource($Student));
        } {
            return $this->apiresponse(null, 'Student Table Not Found', 404);
        }
    }


    public function destroy($id)
    {
        $enrollment = Enrollment::where('student_ID', $id)->first();
        if ($enrollment) {
            $enrollment->where('student_ID', $id)->delete();
        }
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->destroy($id);
        return response()->json(['message' => 'Student deleted successfully'], 200);
    }
}
