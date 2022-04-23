<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use Tymon\JWTAuth\Providers\JWT\Namshi;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use App\Models\User;

class GetUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->refresh_token) {
            return response()->json([
                "error" => true,
                "code" => Response::HTTP_BAD_REQUEST,
                "status" => Response::$statusTexts[Response::HTTP_BAD_REQUEST],
                'message' => 'Refresh token was not provided'
            ]);
        }
        try {
            $tokenParts = explode(".", $request->refresh_token);  
            $tokenHeader = base64_decode($tokenParts[0]);
            $tokenPayload = base64_decode($tokenParts[1]);
            $jwtHeader = json_decode($tokenHeader);
            $jwtPayload = json_decode($tokenPayload);

            if (!$jwtHeader || !$jwtPayload) {
                throw new InvalidArgumentException("Invalid Refresh Token", 400);
            }

            $request->headers->set('sub', $jwtPayload->sub);
            return $next($request);

        } catch (Exception $e) {
            return response()->json([
                "error" => true,
                "code" => Response::HTTP_BAD_REQUEST,
                "status" => Response::$statusTexts[Response::HTTP_BAD_REQUEST],
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        

        
    }
}
