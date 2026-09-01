<?php

namespace App\Http\Responses;

use App\Enums\ApiStatus;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(
        string $message = 'Success',
        mixed $data = null,
        int $code = 200
    ): JsonResponse {
        return response()->json([
            'status' => ApiStatus::SUCCESS->value,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error(
        string $message = 'Something went wrong',
        mixed $data = null,
        int $code = 400
    ): JsonResponse {
        return response()->json([
            'status' => ApiStatus::ERROR->value,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}