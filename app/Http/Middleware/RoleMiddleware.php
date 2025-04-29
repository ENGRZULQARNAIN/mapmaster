<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page');
        }

        // Check if user has the required role
        if (Auth::user()->role !== $role) {
            // Redirect to a specific route or show a 403 forbidden page
            return redirect()->route('notAllowed')->with('error', 'You do not have permission to access this page');
        }

        return $next($request);
    }
}
