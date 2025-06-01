<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Ensure2FAIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (
            $user
            && $user->confirmed_2fa
            && !session()->has('2fa_passed')
            && !empty($user->google2fa_secret)
            && !$request->routeIs('two-factor')
            && !$request->routeIs('two-factor.verify')
        ) {
            return redirect()->route('two-factor');
        }

        return $next($request);
    }
}
