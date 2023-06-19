<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function loginView()
    {
        if (Auth::check() && Auth::user()->role == "warehouse") {
            return redirect('warehouse/dashboard');
        }

        if (Auth::check() && Auth::user()->role == "finance") {
            return redirect('finance/invoice');
        }

        if (Auth::check() && Auth::user()->role == "purchasing") {
            return redirect('purchasing/purchase');
        }

        if (Auth::check() && Auth::user()->role == "marketing") {
            return redirect('marketing/order');
        }

        return view('Auth.Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('warehouse/dashboard');
        };
        
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
