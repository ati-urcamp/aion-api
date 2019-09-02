<?php

namespace App\Exceptions;

use Auth;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return handleResponses([
                'message' => 'Unprocessable Entity',
                'error' => json_decode(json_encode($exception->validator->getMessageBag()), true),
                'code' => 422
            ]);
        }

        if ($exception instanceof QueryException) {
            $message = 'Ocorreu um erro ao processar a sua ação';

            if (app()->isLocal()) {
                $message = $exception->getMessage();
            }

            return handleResponses([
                'message' => 'Database Error',
                'error' => $message,
                'code' => 400
            ]);
        }

        return parent::render($request, $exception);
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException $e
     * @return array|\Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();

        if ($status === 503) {
            return handleResponses([
                'error' => 'Sistema em manutenção',
                'code' => 503
            ]);
        } else {
            return $this->convertExceptionToResponse($e);
        }
    }
}
