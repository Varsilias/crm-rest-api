<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request)
    {

        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        /**
         * If we implement Mailing feature, this is where we send to email to the user either through queued jobs or other means
         * We would Log the token to the "laravel.log" and also return it
         * So that we can use it in our next request
         */
        return response()->json([
            "error" => false,
            "status" => Response::$statusTexts[Response::HTTP_OK],
            "message" => "Password reset token sent to your email this token is valid for 1 hour",
            "token" => $token
        ]);    
    }

    public function resetPassword(ResetPasswordRequest $request)
    {

        $update = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();

        if(!$update){
            return response()->json([
                "error" => true,
                "code" => Response::HTTP_BAD_REQUEST,
                "status" => Response::$statusTexts[Response::HTTP_BAD_REQUEST],
                "message" => "Invalid email or password reset token",
            ], Response::HTTP_BAD_REQUEST);        }

        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        // Delete password_resets record
        if ($user) {
            DB::table('password_resets')->where(['email'=> $request->email])->delete();
        }

        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK,
            "status" => Response::$statusTexts[Response::HTTP_OK],
            "message" => "Password reset successful",
        ]);  

    }
}
