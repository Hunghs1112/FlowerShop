<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

/**
 * Standardized AJAX Response Helper
 * 
 * Provides consistent JSON response format across all AJAX endpoints
 */
class AjaxResponse
{
    /**
     * Success response
     */
    public static function success(
        string $message,
        array $data = [],
        int $statusCode = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Error response
     */
    public static function error(
        string $message,
        array $data = [],
        int $statusCode = 422
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Validation error response
     */
    public static function validationError(
        array $errors,
        string $message = 'Dữ liệu không hợp lệ'
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }

    /**
     * Created response (201)
     */
    public static function created(
        string $message,
        array $data = []
    ): JsonResponse {
        return self::success($message, $data, 201);
    }

    /**
     * Updated response
     */
    public static function updated(
        string $message,
        array $data = []
    ): JsonResponse {
        return self::success($message, $data, 200);
    }

    /**
     * Deleted response
     */
    public static function deleted(
        string $message = 'Xóa thành công'
    ): JsonResponse {
        return self::success($message, [], 200);
    }

    /**
     * Not found response
     */
    public static function notFound(
        string $message = 'Không tìm thấy'
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 404);
    }

    /**
     * Unauthorized response
     */
    public static function unauthorized(
        string $message = 'Không được phép'
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 403);
    }

    /**
     * Server error response
     */
    public static function serverError(
        string $message = 'Lỗi máy chủ'
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 500);
    }
}
