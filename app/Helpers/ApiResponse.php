<?php

namespace App\Helpers;

class ApiResponse
{
    public static function send($status, $message, $data = null, $code = 200)
    {
        return response()->json([
            'status' => $status,      // true / false
            'message' => $message,    // info message
            'data' => $data           // user/app data if available
        ], $code);
    }
}
