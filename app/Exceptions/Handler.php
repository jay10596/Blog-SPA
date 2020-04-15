<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if($exception instanceof TokenBlacklistedException)
        {
            return response(['error'=>"Token is blacklisted"], 500);
        }
        else if($exception instanceof TokenInvalidException)
        {
            return response(['error'=>"Token is invalid"], 500);
        }
        else if($exception instanceof TokenExpiredException)
        {
            return response(['error'=>"Token is expired"], 500);
        }
        else if($exception instanceof JWTException)
        {
            return response(['error'=>"Token is not provided"], 500);
        }
        return parent::render($request, $exception);
    }
}
