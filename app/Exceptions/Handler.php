<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;
class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($request->expectsJson()){
            return response()->json(['message' => 'UnAuthenticated'], 401);
        }
        $guard=Arr::get($exception->guards(),'0');
        switch($guard){
            case 'admin':
                $login="/admin/login";
            break;

            default:
                $login="/login";
        }

        return Redirect()->guest($login);
    }
    
    public function render($request, Throwable $exception)
    {
        // Force JSON for API requests
        if ($request->expectsJson()) {
            $status = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
    
            return response()->json([
                'message' => $exception->getMessage(),
                'error' => class_basename($exception),
            ], $status);
        }
    
        return parent::render($request, $exception);
    }


    // public function render($request, Throwable $exception)
    // {
    //     if (
    //         $exception instanceof \ErrorException &&
    //         str_contains($exception->getMessage(), 'on null') &&
    //         str_contains($exception->getFile(), 'resources/views')
    //     ) {
    //         \Log::error('Blade view error: tried to access property on null in ' . $exception->getFile() . ' line ' . $exception->getLine());
    //         return response()->view('errors.500', [], 500); // or return back with error
    //     }
    
    //     return parent::render($request, $exception);
    // }
    
}
