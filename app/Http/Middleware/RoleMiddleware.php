<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Pas connecté → login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        // Bon rôle → on continue
        if ($userRole === $role) {
            return $next($request);
        }

        // Mauvais rôle → redirection vers son propre dashboard
        if ($userRole === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('client.dashboard');
    }
}