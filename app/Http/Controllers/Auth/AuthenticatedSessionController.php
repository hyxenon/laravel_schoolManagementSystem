<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Role-based redirection
        if ($user->isRegistrar()) {
            return redirect()->route('registrar');
        } elseif ($user->isTeacher()) {
            return redirect()->route('teacher');
        } elseif ($user->isStudent()) {
            return redirect()->route('student');
        } elseif ($user->isTreasury()) {
            return redirect()->route('treasury');
        } elseif ($user->isProfHead()) {
            return redirect()->route('program_head');
        }

        // Default redirection to dashboard if no specific role is matched
        return redirect()->route('dashboard');
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
