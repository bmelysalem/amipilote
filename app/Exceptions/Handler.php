<?php
namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
                return response()->json(['message' => 'Resource not found'], 404);
            }

            if ($exception instanceof ValidationException) {
                return response()->json(['message' => 'Validation failed', 'errors' => $exception->errors()], 422);
            }

            if ($exception instanceof AuthenticationException) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }

            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
