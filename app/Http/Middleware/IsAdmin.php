<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            if (auth()->user()->isActive()) {
                return $next($request);
            }
            auth()->logout();
            return redirect()->route('admin.login')->withErrors(['email' => 'Votre compte administrateur a été suspendu.']);
        }

        return redirect()->route('admin.login')->withErrors(['email' => 'Accès restreint. Veuillez vous connecter en tant qu\'administrateur.']);
    }
}
