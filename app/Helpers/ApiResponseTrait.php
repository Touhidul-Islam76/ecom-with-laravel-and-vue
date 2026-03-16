<?php

namespace App\Helpers;

trait ApiResponseTrait
{
    public function success($data = null, $message = [], $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);

    }
    public function error($message = [], $code = 422)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], $code);

    }
}
