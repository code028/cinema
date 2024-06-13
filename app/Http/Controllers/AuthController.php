<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginView()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request) :RedirectResponse
    {
        $request->only('login', 'password');

        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        $loginValue = $request->login;

        $login = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials =  [
            $login => $loginValue,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended();
        }

        return redirect('/login')->withErrors([
            'login' => 'Invalid credentials'
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect('/login')->with('destroyed', true);
    }

    public function registerView()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|min:4|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:4',
            'phone' => 'required|string',
            'birthday' => 'required|date',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'birthday' => $request->birthday,
        ]);

        return redirect('/login')->with('success', 'Registration successful');
    }
}
