<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
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
        if ($request->expectsJson()) {
            if ($exception instanceof AuthorizationException) {
                return api_response(null, json_decode($exception->getMessage(), true), null, 401);
            }

            if ($exception instanceof NotFoundHttpException) {
                return api_response(null, $exception->getMessage(), null, 404);
            }

            if ($exception instanceof ValidationException) {
                return api_response(null, $exception->getMessage(), $exception->validator, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($exception instanceof ServerException) {
                return api_response(null, $exception->getMessage(), null, 500);
            }

            if ($exception instanceof ClientException) {
                if (Str::contains($exception->getMessage(), 'response:')) {
                    $message = __('api.invalid_email');
                    $x = explode('response:', $exception->getMessage());
                    $a = explode(',"message', $x[1]);
                    $error_decode = json_decode($a[0] . '}', true);

                    if (is_array($error_decode) && array_key_exists('error_description', $error_decode)) {
                        $message = $error_decode['error_description'];
                    }
                    return api_response(null, $message, null, $exception->getCode());
                }
                return api_response(null, $exception->getMessage(), null, $exception->getCode());
            }

            if ($exception instanceof ModelNotFoundException) {
                return api_response(null, $exception->getMessage(), null, 404);
            }

            if ($exception instanceof BadRequestHttpException) {
                return api_response(null, $exception->getMessage(), null, 200);
            }
            if ($exception instanceof HttpException) {
                return api_response(null, $exception->getMessage(), null, 403);
            }
        }
        return parent::render($request, $exception);
    }
}
