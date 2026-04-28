<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     * @param  string|array  $roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // User doesn't have required role - redirect to their dashboard
        return $this->redirectToDashboard($user);
    }

    /**
     * Redirect user to their role-specific dashboard
     */
    private function redirectToDashboard($user)
    {
        $roles = $user->getRoleNames(); // Get collection of role names

        if ($roles->contains('admin')) {
            return redirect()->route('dashboards.admin');
        }

        if ($roles->contains('manager')) {
            return redirect()->route('dashboards.manager');
        }

        // Default to user dashboard
        return redirect()->route('dashboards.user');
    }
}
