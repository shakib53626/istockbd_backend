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

    public static function checkPaginateSize($paginate = null)
    {
        $maxPaginate     = config('crud.paginate.max');
        $defaultPaginate = config('crud.paginate.default');
        $paginate        = $paginate ?? $defaultPaginate;
        $paginate        = $paginate > $maxPaginate ? $maxPaginate : $paginate;

        return $paginate;
    }

    public static function getOldPath($path, $imageName)
    {
        // Use pathinfo to extract the filename
        $pathInfo = pathinfo($imageName);

        // Get the filename from pathinfo
        $filename = $pathInfo["basename"];

        return public_path($path . "/" . $filename);
    }
}
