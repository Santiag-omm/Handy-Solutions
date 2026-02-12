<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Autenticación web del panel de administración.
 *
 * Nota:
 * - Este flujo es exclusivo para administradores.
 * - Si un usuario no-admin intenta autenticar, se invalida la sesión.
 */
class LoginController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa el login web.
     *
     * @throws ValidationException
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => __('Las credenciales no coinciden con nuestros registros.'),
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (! $user || ! $user->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'No tienes permisos para acceder al panel de administración.',
            ]);
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Cierra sesión del panel.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
