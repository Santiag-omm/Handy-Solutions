<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::whereHas('role', fn ($q) => $q->where('slug', 'cliente'))
            ->withCount('solicitudes');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $clientes = $query->latest()->paginate(15)->withQueryString();

        return view('admin.clientes.index', compact('clientes'));
    }
}
