<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [];

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (ThrottleRequestsException $e, $request) {
            return response()->json([
                'error' => 'Too Many Requests',
                'message' => 'You have exceeded the allowed number of requests.',
                'retry_after_seconds' => $e->getHeaders()['Retry-After'] ?? null,
            ], 429);
        });
    }
}