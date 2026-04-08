<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function successResponse($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function errorResponse($message = 'Error', $code = 400, $errors = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

    public function notFoundResponse($message = 'Not Found')
    {
        return response()->json([
            'status'  => false,
            'message' => $message
        ], 404);
    }

    public function validationResponse($errors, $message = 'Validation Error')
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors
        ], 422);
    }
}
