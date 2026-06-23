<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->hasActiveSubscription()) {
            return redirect()->route('inspira.tarifs')
                ->withErrors(['subscription' => 'Vous devez avoir un abonnement actif pour accéder à cette page.']);
        }

        return $next($request);
    }
}
