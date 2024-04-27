<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Parents;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Auth2Controller extends Controller
{
    public function SVlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Email' => ['required', 'email', 'max:255'],
            'Password' => ['required'],
        ], [], [
            'Email' => 'Email',
            'Password' => 'Password',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendresponse(422, 'Login Validation errors', $validator->errors());
        }


        if ($supervisor = Supervisor::where('email', $request->Email)->first()) {
            if (($request->Password) == ($supervisor->Password)) {
                $supervisor = Supervisor::where('email', $request->Email)->first();
                $data['token'] = $supervisor->createToken('SupervisorToken')->plainTextToken;
                $data['Supervisor ID'] = $supervisor->ID;
                $data['Supervisor Name'] = $supervisor->Full_Name;
                $data['Supervisor email'] = $supervisor->Email;
                return ApiResponse::sendresponse(200, 'Logged In Successfully', $data);
            } else {
                return ApiResponse::sendresponse(422, 'Login Failed Check the email and password again', null);
            }
        } else {
            return ApiResponse::sendresponse(401, 'Enter a valid email', null);
        }
    }

    public function ParentLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Email' => ['required', 'email', 'max:255'],
            'Password' => ['required'],
        ], [], [
            'Email' => 'Email',
            'Password' => 'Password',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendresponse(422, 'Login Validation errors', $validator->errors());
        }


        $parent = parents::where('Email', $request->Email)->first();
        //[]
        if (($request->Password) == ($parent->Password)) {
            $parent = parents::where('email', $request->Email)->first();
            $data['token'] = $parent->createToken('ParentToken')->plainTextToken;
            $data['Parent ID'] = $parent->ID;
            $data['Parent Name'] = $parent->Full_Name;
            $data['Parent email'] = $parent->Email;
            return ApiResponse::sendresponse(200, 'Logged In Successfully', $data);
        } else {
            return ApiResponse::sendresponse(422, 'Login Failed Check the email and password again', null);
        }
    }

    public function Flogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendresponse(200, 'Logged Out Successfully');
    }
}
