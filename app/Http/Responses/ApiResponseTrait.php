<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait ApiResponseTrait
{
    protected function sendSuccess($data = [], $message = '', $statusCode = 200): JsonResponse
    {
        $contents = [
            'success' => true,
            'message' => $message,
        ];

        $data =
            $data instanceof JsonResource
            ? (array) $data->response()->getData()
            : ['data' => $data];
        $contents = array_merge($contents, $data);

        return response()->json($contents, $statusCode, [], JSON_UNESCAPED_SLASHES);
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
