<?php

namespace App\Exceptions;

use App\Dtos\ErrorResponse;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ErpValidationException) {
            $response = new ErrorResponse($exception->getCode(), $exception->getMessage());
            return response()->json($response, 400);
        } else if ($exception instanceof ErpException) {
            $response = new ErrorResponse($exception->getCode(), $exception->getMessage());
            return response()->json($response, $exception->getCode());
        } else if($exception instanceof QueryException) {
            $response = new ErrorResponse(500, $exception->getMessage());
            return response()->json($response, 500);
        }

        return parent::render($request, $exception);
    }
}
