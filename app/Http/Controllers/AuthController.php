<?php

namespace App\Http\Controllers;

use App\Services\PlayerService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.create');
    }

    public function store(Request $request)
    {
        $inputUsers = $request->only(['name', 'email', 'password', 'nickname', 'password_confirmation']);
        $userService = new UserService();
        $user = $userService->createUser($inputUsers);
        
        $playerService = new PlayerService();
        $player = $playerService->createPlayer($user->id, 1, false); 

        if (Auth::attempt(['email' => $inputUsers['email'], 'password' => $inputUsers['password']])) {
            $request->session()->regenerate();
            return redirect(route('home'));
        }

        return back()->withErrors([
            'email' => 'Oops! Alguma coisa deu errado.',
        ])->onlyInput('email');
    }
}
