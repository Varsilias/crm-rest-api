<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserSignUpRequest;
use Illuminate\Support\Facades\Validator;


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
        $validated = $request->safe()->only(['email', "password"]);

        // Request is valid, create new user
        $user = User::create([
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
}
