<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $userRole = auth()->user()->role;

        // Check if the user's role is allowed
        if (!in_array($userRole, $roles)) {
            // Redirect to appropriate dashboard if the user is logged in
            return redirect($this->getDashboardRoute($userRole));
        }

        return $next($request);
    }

    /**
     * Get the dashboard route based on the user's role.
     */
    protected function getDashboardRoute(string $role): string
    {
        return match ($role) {
            'superadmin' => route('superadmin.dashboard'),
            'schooladmin' => route('schooladmin.dashboard'),
            'teacher' => route('teacher.dashboard'),
            default => route('login'), // Default redirection for unknown roles
        };
    }
}
