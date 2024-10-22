<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UnauthorizedException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => 'Unauthorized access. Please provide valid credentials.',
        ], 401);
    }
}
