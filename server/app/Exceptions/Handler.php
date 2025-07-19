<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($e->getMessage() === 'Unauthenticated.') {
                return response()->json([
                    'message' => 'Faça login para continuar',
                    'error' => true,
                ], 500);
            }
            Log::channel('errors')
                ->warning(
                    'ERRO AUTENTICAÇÃO',
                    [
                        'ExceptionType' => get_class($e),
                        'errorMessage' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]
                );

            return response()->json([
                'message' => 'Ooops, parece que houve um erro na sua autenticação. Contate o suporte!',
                'error' => true,
            ], 500);
        });

        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'messages' => $e->errors(),
                'error' => $e->getResponse()->original['error'],
            ], 406);
        });

        $this->renderable(function (\Throwable $e, $request) {
            Log::channel('errors')
                ->warning(
                    'ERRO NÃO TRATADO',
                    [
                        'ExceptionType' => get_class($e),
                        'errorMessage' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]
                );

            return response()->json([
                'message' => 'Ooops, parece que houve um erro. Contate o suporte!',
                'error' => true,
            ], 500);
        });
    }
}
