<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Reply;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->renderable(function (UnauthorizedHttpException $e){
            return Reply::do(false, "You are not allowed to access this API", null, __FUNCTION__, 401);
        });

        $this->renderable(function (NotFoundHttpException $e){
            return Reply::do(false, "API Not Found", null, __FUNCTION__, 404);
        });

        $this->renderable(function (ValidationException $e){
            $errors = $e->errors();
            $output = [];
            foreach ($errors as $i => $ii) {
                // array_push($output, $ii[0]);
                array_push($output, $ii[0]);
            }

            return Reply::do(false, "There seems to be a problem with your request. Please try again later.", [
                    "errors" => $output 
                ], __FUNCTION__, 422);
        });

        $this->renderable(function (\ErrorException $e){
            return Reply::do(false, "There seems to be a problem with your request. Please try again later.", null, __FUNCTION__, 500);
        });
    }
}
