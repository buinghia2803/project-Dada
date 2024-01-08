<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Throwable;

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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof PostTooLargeException) {
            $initSize = ini_get("upload_max_filesize");
            // $message = "Size of attached file should be less :maxSize B";
            $message = trans('error-message.max_size_attachmement', ['maxSize' => $initSize]);
            return response()->failure($message, '', 400, 400);
        }
        if ($exception instanceof AuthenticationException) {
            // $message = 'Unauthenticated or token expired, please login';
            $message = trans('error-message.unauthenticated');
            return response()->failure($message, '', 401, 401);
        }
        if ($exception instanceof ThrottleRequestsException) {
            // $message = 'Too many requests, please slow down';
            $message = trans('error-message.many_request');
            return response()->failure($message, '', 429, 429);
        }
        if ($exception instanceof ModelNotFoundException) {
            $modelClass =  str_replace('App\\', '', $exception->getModel());
            // $message = 'Entry for ' . str_replace('App\\', '', $exception->getModel()) . ' not found';
            $message = trans('error-message.not_found_model', ['model' => $modelClass]);
            return response()->failure($message, '', 404, 404);
        }
        if ($exception instanceof ValidationException) {
            $format = [
                'status' => false,
                'code' => 422,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
                'timestamp' => time(),
                'timezone' => config('app.timezone'),
                'result' => null
            ];
            return response()->json($format, 422);
        }
        if ($exception instanceof QueryException) {
            // $message = 'There was issue with the query' . ', errors:' . $exception;
            $message = trans('error-message.query_ex', ['exception' => $exception]);
            return response()->failure($message, '', 500, 500);
        }
        if ($exception instanceof \Error) {
            // $message = "There was some internal error" . ', errors:' . $exception;
            $message = trans('error-message.error', ['exception' => $exception]);
            return response()->failure($message, '', 500, 500);
        }

        $statusCode = 500;
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        }

        return response()->json(
            [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode()
            ],
            $statusCode
        );
    }
}
