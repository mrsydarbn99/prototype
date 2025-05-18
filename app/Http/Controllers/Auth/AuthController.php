<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status == 2) {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'status' => 'Your account is inactive. Please contact admin.'
                ])->withInput();
            }

            return redirect()->intended('dashboard');
        }

        // Authentication failed
        return redirect()->route('login')->withErrors([
            'status' => 'Your username or password is incorrect.'
        ])->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        
        User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        return redirect('/login')->with('success', 'Registration successful. Please login.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
