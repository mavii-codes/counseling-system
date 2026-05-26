<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(prepend: [
            \App\Http\Middleware\UseRequestRootUrl::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (TokenMismatchException $e, Request $request): ?Response {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Page expired. Refresh and try again.'], 419);
            }

            if ($request->isMethod('GET')) {
                return null;
            }

            $form = $request->path() === 'register' ? 'register' : 'login';

            return redirect()
                ->route($form)
                ->withInput($request->except('password', 'password_confirmation', '_token'))
                ->with('warning', 'Your session expired before the form was sent (419). Please try again — if this keeps happening, use the same address as in your browser bar (match localhost vs 127.0.0.1) and refresh the page first.');
        });
    })->create();
