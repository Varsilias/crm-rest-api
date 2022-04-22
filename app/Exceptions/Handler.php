<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (\Exception $e, $request) {

            if ($request->is("api/*")) {
                
                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        "error" => true,
                        "code" => Response::HTTP_NOT_FOUND, 
                        "status" => Response::$statusTexts[Response::HTTP_NOT_FOUND], 
                        "message" => "Record Not found"
                    ])->setStatusCode(Response::HTTP_NOT_FOUND);
                }

            }
        });
    }
}
