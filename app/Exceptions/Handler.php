<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Response;
use Lang;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
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
    public function render($request, Exception $exception)
    {
        if(strpos($request->getUri(), '/api'))
        {
            if ($exception instanceof APIException) {
                return Response::json([
                    'status' => 0,
                    'error_code'=> 1,
                    'msg'   => $exception->getErrors()
                ]);
            }
            if ($exception instanceof BadRequestHttpException || $exception instanceof MethodNotAllowedHttpException)
                return response(Lang::get('messages.bad_request'),400);
            if ($exception instanceof UnauthorizedHttpException)
                return response(Lang::get('messages.unauthorized'),401);
            if ($exception instanceof AccessDeniedHttpException)
                return response(Lang::get('messages.forbidden'),403);
            if ($exception instanceof NotFoundHttpException)
                return response(Lang::get('messages.not_found'),404);
            if ($exception instanceof ConflictHttpException)
                return response(Lang::get('messages.confrict'),409);
            if ($exception instanceof ModelNotFoundException)
                return response(Lang::get('messages.not_found'),404);
            if ($exception instanceof HttpException || $exception instanceof ServiceUnavailableHttpException)
                return response(Lang::get('messages.error_system'),$exception->getStatusCode());
        }
        return parent::render($request, $exception);
    }
}
