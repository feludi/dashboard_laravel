<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Log critical errors
            if ($this->shouldReport($e)) {
                \Log::error('Application Error', [
                    'exception' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'url' => request()->fullUrl(),
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'user_id' => auth()->id(),
                ]);
            }
        });
    }

    public function render($request, Throwable $e)
    {
        // Custom error pages for production
        if (app()->environment('production')) {
            if ($e instanceof NotFoundHttpException) {
                return response()->view('errors.404', [], 404);
            }

            if ($e instanceof ModelNotFoundException) {
                return response()->view('errors.404', [], 404);
            }

            // Generic server error
            if (!$e instanceof ValidationException) {
                return response()->view('errors.500', [], 500);
            }
        }

        return parent::render($request, $e);
    }
}
