<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        $credentials = $request->only('username', 'password');

        if (! Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['username' => 'Username atau password tidak valid.'])
                ->onlyInput('username');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
