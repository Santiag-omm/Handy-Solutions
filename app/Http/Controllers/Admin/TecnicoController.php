<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Tecnico;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TecnicoController extends Controller
{
    public function index(): View
    {
        $tecnicos = Tecnico::with('user')->withCount('ordenesTrabajo')->paginate(15);

        return view('admin.tecnicos.index', compact('tecnicos'));
    }

    public function create(): View
    {
        $zonas = Zona::where('activo', true)->orderBy('nombre')->get();

        return view('admin.tecnicos.create', compact('zonas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'especialidades' => ['nullable', 'string', 'max:255'],
            'zonas' => ['array'],
            'zonas.*' => ['exists:zonas,id'],
        ]);

        $role = Role::where('slug', 'tecnico')->firstOrFail();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role_id' => $role->id,
        ]);

        $tecnico = Tecnico::create([
            'user_id' => $user->id,
            'especialidades' => $validated['especialidades'] ?? null,
            'activo' => true,
        ]);

        if (! empty($validated['zonas'])) {
            $tecnico->zonas()->sync($validated['zonas']);
        }

        return redirect()->route('admin.tecnicos.index')->with('success', 'Técnico registrado.');
    }

    public function edit(Tecnico $tecnico): View
    {
        $tecnico->load('user', 'zonas');
        $zonas = Zona::where('activo', true)->orderBy('nombre')->get();

        return view('admin.tecnicos.edit', compact('tecnico', 'zonas'));
    }

    public function update(Request $request, Tecnico $tecnico): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $tecnico->user_id],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'especialidades' => ['nullable', 'string', 'max:255'],
            'zonas' => ['array'],
            'zonas.*' => ['exists:zonas,id'],
            'activo' => ['boolean'],
        ]);

        $tecnico->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        if (! empty($validated['password'])) {
            $tecnico->user->update(['password' => Hash::make($validated['password'])]);
        }

        $tecnico->update([
            'especialidades' => $validated['especialidades'] ?? null,
            'activo' => $request->boolean('activo'),
        ]);

        $tecnico->zonas()->sync($validated['zonas'] ?? []);

        return redirect()->route('admin.tecnicos.index')->with('success', 'Técnico actualizado.');
    }

    public function destroy(Tecnico $tecnico): RedirectResponse
    {
        $tecnico->update(['activo' => false]);

        return redirect()->route('admin.tecnicos.index')->with('success', 'Técnico desactivado.');
    }
}
