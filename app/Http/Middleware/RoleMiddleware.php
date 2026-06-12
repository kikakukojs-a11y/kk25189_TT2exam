<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
   public function handle(Request $request, Closure $next, string $role): Response
    {

        if (!auth()->check()) {
            abort(403, 'Unauthorized action.');
        }
        
        if (auth()->user()->role === 'Admin') {
            return $next($request);
        }


        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized action. You do not have the required role.');
        }

        return $next($request);
    }
}