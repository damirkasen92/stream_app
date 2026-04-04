<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class GlobalExceptionHandler
{
    public static function handler(Exceptions $exceptions): void
    {
        $exceptions->render(function (StreamException $e, Request $request): JsonResponse {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        });

        $exceptions->render(function (ValidationException $e): JsonResponse {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        $exceptions->render(function (AuthenticationException $e): JsonResponse {
            return response()->json([
                'message' => 'Authentication Error',
            ], Response::HTTP_UNAUTHORIZED);
        });

        $exceptions->render(function (\Throwable $e, Request $request): ?JsonResponse {
            return response()->json([
                'message' => $e->getMessage(),
                'type' => class_basename($e),
                'code' => $e->getCode(),
                'timestamp' => now()->toIso8601String(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }
}
