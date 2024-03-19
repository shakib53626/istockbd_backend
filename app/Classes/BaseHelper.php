<?php

namespace App\Classes;

class BaseHelper
{
    public static function sendResponse($result, $message, $code = 200)
    {
        $response = [
            "success" => true,
            "message" => $message,
            "result"  => $result
        ];

        return response()->json($response, $code);
    }

    public static function sendError($message, $code = 400){

        $response = [
            "success" => false,
            "message" => $message,
        ];

        return response()->json($response, $code);
    }
}
