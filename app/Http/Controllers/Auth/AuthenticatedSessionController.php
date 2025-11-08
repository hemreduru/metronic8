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

        // Kullanıcının rolü varsa rol seçimine yönlendir
        $user = Auth::user();
        $rolesCount = $user->roles()->count();

        if ($rolesCount === 0) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Hesabınıza henüz bir rol atanmamıştır. Lütfen yöneticinizle iletişime geçiniz.');
        }

        if ($rolesCount === 1) {
            // Tek rol varsa otomatik seç
            $role = $user->roles()->first();
            $user->setCurrentRole($role->id);
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Birden fazla rol varsa seçim sayfasına yönlendir
        return redirect()->route('role.select');
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
