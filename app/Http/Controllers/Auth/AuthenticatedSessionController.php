<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Get the appropriate redirect path based on user role
        $redirectTo = $this->getRedirectPath();
        return redirect()->intended($redirectTo);
    }

    protected function getRedirectPath()
    {
        if (auth()->user()->role === 'superadmin') {
            return route('superadmin.dashboard');
        }
        if (auth()->user()->role === 'schooladmin') {
            return route('schooladmin.dashboard');
        }
        if (auth()->user()->role === 'teacher') {
            return route('teacher.dashboard');
        }
        return route('login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
