<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role_type' => \App\Http\Middleware\RoleTypeMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
         $exceptions->render(function (PostTooLargeException $e, $request) {
        return redirect()->back()->with('error', 'Votre fichier est trop volumineux.');
    });
    })->create();