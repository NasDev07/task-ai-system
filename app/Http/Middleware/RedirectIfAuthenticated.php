<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   * @param  string|null  ...$guards
   */
  public function handle(Request $request, Closure $next, ...$guards): Response
  {
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
      if (Auth::guard($guard)->check()) {
        // Redirect authenticated user to their dashboard based on role
        return $this->redirectToDashboard(Auth::guard($guard)->user());
      }
    }

    return $next($request);
  }

  /**
   * Redirect to role-specific dashboard
   */
  private function redirectToDashboard($user)
  {
    $roles = $user->getRoleNames();

    if ($roles->contains('admin')) {
      return redirect()->route('dashboards.admin');
    }

    if ($roles->contains('manager')) {
      return redirect()->route('dashboards.manager');
    }

    return redirect()->route('dashboards.user');
  }
}
