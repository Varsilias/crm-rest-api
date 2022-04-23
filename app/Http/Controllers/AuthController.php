<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserSignUpRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;


class AuthController extends Controller
{
    public function signUp(UserSignUpRequest $request)
    {
        $validated = $request->safe()->only(['name', 'email', "password"]);

        // Request is valid, create new user
        $user = User::create([
            'uuid' => Str::uuid()->toString(),
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($validated['password'])
        ]);

        return response()->json([
            "error" => false,
            "code" => Response::HTTP_BAD_REQUEST, 
            "status" => Response::$statusTexts[Response::HTTP_BAD_REQUEST],
            'message' => 'SignUp successfully',
            'data' => new UserResource($user),
        ], Response::HTTP_OK);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->safe()->only(['email', "password"]);
        $refreshToken = JWTAuth::claims([
            "iss" => env("APP_URL", "http://localhost:8000"),
            "exp" => now()->addSeconds(86400)
        ])->attempt($credentials);

        try {
            if (!$token = JWTAuth::claims([
                "iss" => env("APP_URL", "http://localhost:8000"),
                "exp" => now()->addSeconds(3600)
            ])->attempt($credentials)) {
                return response()->json([
                    "error" => true,
                    "code" => Response::HTTP_BAD_REQUEST,
                    "status" => Response::$statusTexts[Response::HTTP_BAD_REQUEST], 
                	'message' => 'Invalid Login Credentials',
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (JWTException $e) {
            return response()->json([
                "error" => true,
                "code" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "status" => Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR], 
                'message' => 'Something went wrong'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK, 
            "status" => Response::$statusTexts[Response::HTTP_OK],
            'access_token' => $token,
            "expires_in" => Config::get("jwt.ttl") * 60,
            "refresh_token" => $refreshToken,
            "refresh_expiry" => Config::get("jwt.ttl") * 60 * 24
        ], Response::HTTP_OK);

        
    }

    public function refresh(Request $request)
    {
        $user = User::findOrFail($request->header('sub'));

        $accessToken = JWTAuth::claims([
            "iss" => env("APP_URL", "http://localhost:8000"),
            "exp" => now()->addSeconds(3600)        
        ])->fromUser($user);
        $refreshToken = JWTAuth::claims([
            "iss" => env("APP_URL", "http://localhost:8000"),
            "exp" => now()->addSeconds(86400)
        ])->fromUser($user);


        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK, 
            "status" => Response::$statusTexts[Response::HTTP_OK],
            'access_token' => $accessToken,
            "expires_in" => Config::get("jwt.ttl") * 60,
            "refresh_token" => $refreshToken,
            "refresh_expiry" => Config::get("jwt.ttl") * 60 * 24
        ], Response::HTTP_OK);
    }
}
