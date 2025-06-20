<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RedirectEstablishmentUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Só aplica para admin e professional
        if ($user && $user->hasRole(['admin', 'professional'])) {
            // Redireciona para dashboard se estiver na rota raiz ou rota de login
            if ($request->is('/') || $request->is('login')) {
                return redirect()->route('dashboard');
            }

            // Impede acesso a rotas administrativas
            if ($request->is('roles*') ||
                $request->is('permissions*') ||
                $request->is('plans*') ||
                $request->is('menus*') ||
                $request->is('config*') ||
                $request->is('audits*') ||
                $request->is('notifications/send')) {
                abort(403, 'Você não tem permissão para acessar esta área.');
            }
        }

        return $next($request);
    }
}
