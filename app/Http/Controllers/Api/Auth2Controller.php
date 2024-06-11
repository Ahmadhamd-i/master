<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Parents;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

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
            if (Hash::check($request->Password, $supervisor->Password)) {
                $supervisor = Supervisor::where('email', $request->Email)->first();
                //remove the old token 
                $existingToken = $supervisor->tokens()->where('name', 'SV' . $supervisor->Full_Name)->first();
                if ($existingToken) {
                    $existingToken->delete();
                }
                //create new Token
                $data['token'] = $supervisor->createToken('SV' . $supervisor->Full_Name)->plainTextToken;
                $data['Supervisor ID'] = $supervisor->ID;
                $data['Supervisor Name'] = $supervisor->Full_Name;
                $data['Supervisor email'] = $supervisor->Email;
                $data['Supervisor Image'] = $supervisor->Image;
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


        if ($Parent = Parents::where('email', $request->Email)->first()) {
            if (Hash::check($request->Password, $Parent->Password)) {
                //Remove Old Token
                $Parent = Parents::where('email', $request->Email)->first();
                $existingToken = $Parent->tokens()->where('name', 'Parent' . $Parent->Full_Name)->first();
                if ($existingToken) {
                    $existingToken->delete();
                }

                $data['token'] = $Parent->createToken('Parent' . $Parent->Full_Name)->plainTextToken;
                $data['Parent ID'] = $Parent->ID;
                $data['Parent Name'] = $Parent->Full_Name;
                $data['Parent email'] = $Parent->Email;
                $data['Parent Image'] = $Parent->Image;
                return ApiResponse::sendresponse(200, 'Logged In Successfully', $data);
            } else {
                return ApiResponse::sendresponse(422, 'Login Failed Check the email OR the password again', null);
            }
        } else {
            return ApiResponse::sendresponse(401, 'Enter a valid email', null);
        }
    }

    public function Flogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendresponse(200, 'Logged Out Successfully');
    }


    /* public function refresh(Request $request)
    {
        $request->user()->currentAccessToken();
        return $this->createNewToken(Auth()->guard('sanctum')->refresh());
    } */
}
