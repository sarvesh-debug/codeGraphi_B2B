<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\QueryException;

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

    public function render($request, Throwable $exception)
{
    // if ($exception->getStatusCode() == 500) {
    //     return response()->view('errors.500', [], 500);
    // }
    // Check for duplicate entry exception
    if ($exception instanceof QueryException && $exception->getCode() == 23000) {
        // Return a custom message
        return redirect()->back()->with('error', 'The email or username already exists. Please use a different one.');
    }

    // Default render behavior for other exceptions
    return parent::render($request, $exception);
}

// public function render($request, Throwable $e)
// {
//     // Check if the application is in debug mode
//     if (config('app.debug')) {
//         return parent::render($request, $e); // Show Laravel's default error page
//     }

//     // Show a custom error page
//     return response()->view('errors.general', [], 500);
// }
}
