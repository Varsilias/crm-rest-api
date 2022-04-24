<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Log;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    "error" => true,
                    "code" => Response::HTTP_FORBIDDEN,
                    "status" => Response::$statusTexts[Response::HTTP_FORBIDDEN],
                    'message' => 'Token is Invalid'
                ], Response::HTTP_FORBIDDEN);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json([
                    "error" => true,
                    "code" => Response::HTTP_UNAUTHORIZED,
                    "status" => Response::$statusTexts[Response::HTTP_UNAUTHORIZED],
                    'message' => 'Token has Expired'
                ], Response::HTTP_UNAUTHORIZED);            
            } else {
                return response()->json([
                    "error" => true,
                    "code" => Response::HTTP_BAD_REQUEST,
                    "status" => Response::$statusTexts[Response::HTTP_BAD_REQUEST],
                    'message' => 'Token was not provided'
                ], Response::HTTP_BAD_REQUEST);            
            }
        }
        return $next($request);
    }
}
