<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class DebugController extends Controller
{
    /**
     * Página de diagnóstico para admin
     */
    public function index(Request $request)
    {
        $debug = [
            'user_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name,
            'current_route' => $request->route()?->getName(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'middleware' => $request->route()?->middleware() ?? [],
            'session_data' => session()->all(),
            'csrf_token' => csrf_token(),
        ];

        return response()->json($debug);
    }

    /**
     * Test simple view
     */
    public function testView()
    {
        return view('admin.debug.test');
    }
}
