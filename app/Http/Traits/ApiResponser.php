<?php

namespace App\Http\Traits;

use Illuminate\Http\Response;

trait ApiResponser {

    public function responseSuccess($message, $result, $code=Response::HTTP_OK) {
        return response()->json([
            'message' => $message,
            'data' => $result,
            'code' => $code,
        ], 200);
    }

    public function responseError($message, $code) {
        return response()->json([
            'message' => $message,
            'code' => $code,
        ], $code);
    }
}