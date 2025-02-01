<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function loginView() {
        return view('auth.login', [
            'pageTitle' => 'Masuk'
        ]);
    }

    public function loginStore(Request $request) {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            Log::info('User login : ' . Auth::user()->username);

            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'username' => 'Akun tidak ditemukan'
        ])->onlyInput('username');
    }

    public function logout(Request $request) {
        Log::info('User logout : ' . Auth::user()->username);

        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();

    
        return redirect()->route('loginView');
    }
}
