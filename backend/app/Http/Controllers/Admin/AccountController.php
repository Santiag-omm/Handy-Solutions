<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Gestión de cuenta del administrador autenticado.
 *
 * Permite:
 * - Actualizar nombre/email.
 * - Cambiar contraseña (opcional).
 *
 * Requiere:
 * - Contraseña actual válida para guardar cambios.
 */
class AccountController extends Controller
{
    /**
     * Muestra el formulario de cuenta del administrador.
     */
    public function edit(): View
    {
        return view('admin.account', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Actualiza la cuenta del administrador.
     *
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],

            'current_password' => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'La contraseña actual no es correcta.',
            ]);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Tu cuenta fue actualizada.');
    }
}
