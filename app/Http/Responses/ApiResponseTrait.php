<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected function sendSuccess($data = [], $message = '', $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function sendError($message = 'An error occurred', $statusCode = 500): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }

    protected function sendNotFound($message = 'Resource not found'): JsonResponse
    {
        return $this->sendError($message, 404);
    }
}
