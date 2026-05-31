<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )


    ->withMiddleware(function (Middleware $middleware) {
        
        // Define os nomes dos nossos middlewares
        $middleware->alias([
            'verificar.login' => \App\Http\Middleware\VerificarLogin::class,
            'controle.acesso' => \App\Http\Middleware\ControleAcesso::class,
        ]);

    })
 

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();