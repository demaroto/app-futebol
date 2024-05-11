<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create()
    {
        return view('session.create');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // Autenticação
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect(route('home'));
        }

        return back()->withErrors([
            'email' => 'E-mail ou senha inválidos.',
        ])->onlyInput('email');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect(route('home'));
    }
}
