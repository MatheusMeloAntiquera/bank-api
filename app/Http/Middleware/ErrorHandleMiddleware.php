<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Exceptions\WithHttpsCodeException;
use Symfony\Component\HttpFoundation\Response;

class ErrorHandleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse|Response
    {
        $response = $next($request);

        if (!empty($response->exception)) {

            return response()->json(
                [
                    "message" => $response->exception->getMessage()
                ],
                $response->exception instanceof WithHttpsCodeException ? $response->exception->statusCode : 500
            );

        }
        return $response;
    }
}
