<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Enrollment;
use App\Models\Parents;
use App\Models\Student;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ParentAppController extends Controller
{
    public function getParentChild(Request $request)
    {
        $id = $request->id;
        $Child = Student::where('Parent_ID', $id)->get();
        if ($Child->count() > 0) {
            return ApiResponse::sendresponse(200, 'Children for this Parent', StudentResource::collection($Child));
        } else {
            return ApiResponse::sendresponse(200, 'There are no Children related to this Parent OR Parent ID invalid');
        }
    }
    public function getStudentLoctaion($stID)
    {
        $stdata = Student::where('ID', $stID)->first(['Supervisor_ID']);
        if ($stdata) {
            $supervisorId = $stdata->Supervisor_ID;
            $svLocation = Supervisor::where('ID', $supervisorId)->value('location');
            return ApiResponse::sendresponse(200, 'Location For this Student\'s Supervisor ', $svLocation);
        } else {
            return ApiResponse::sendresponse(200, 'There\'s no Student have this ID');
        }
    }

    public function get_Status($stID)
    {
        $status_data = Enrollment::where('student_ID', $stID)->first();
        if ($status_data) {
            return ApiResponse::sendresponse(200, 'Student Status ', $status_data);
        } else {
            return ApiResponse::sendresponse(200, 'Student not found');
        }
    }

    public function change_password(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Old_Password' => 'string|required',
            'Password' => 'string|required|confirmed',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendresponse(422, 'Password Confirmation error', $validator->errors());
        }
        $parent = Parents::where('ID', $id)->first();
        if ($parent) {
            if (Hash::check($request->Old_Password, $parent->Password)) {
                $parent->update([
                    'Password' => bcrypt($request->Password),
                ]);
                $parent->save();
                return ApiResponse::sendresponse(201, 'Password Changed Successfuly ');
            } else {
                return ApiResponse::sendresponse(200, 'The Password u enterd is Incorrect ');
            }
        } else {
            return ApiResponse::sendresponse(200, 'parent not found');
        }
    }
}
