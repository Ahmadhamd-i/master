<?php

namespace App\Helpers;

class ApiResponse
{
    static function sendresponse($code = 201, $msg = null, $data = null)
    {
        $response = [
            'status' => $code,
            'message' => $msg,
            'data' => $data,
        ];
        return response()->json($response, $code);
    }
}
