<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthenticatedSessionController extends Controller
{
    /**
     * Display the admin login view.
     * Single login: arahkan ke /login agar satu pintu.
     */
    public function create()
    {
        return redirect()->route('login');
    }

    /**
     * Handle an incoming admin authentication request.
     *
     * Only admin and kasir roles are allowed here.
     *
     * @throws ValidationException
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $role = $request->user()->role;

        if (! in_array($role, ['admin', 'kasir'], true)) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Akun ini bukan admin/kasir. Silakan masuk lewat Login User.',
            ]);
        }

        $destination = $role === 'admin'
            ? route('dashboard.index', absolute: false)
            : route('kasir', absolute: false);

        return redirect()->intended($destination);
    }

    /**
     * Destroy an authenticated admin session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
