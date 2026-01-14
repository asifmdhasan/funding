<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if (Auth::user()->is_admin) {
                        return redirect()->route('admin.dashboard');
                } else {
                    Auth::logout();
                    return redirect()->route('login')->withErrors([
                        'username' => __('login.not_admin')
                    ]);
                }
            }

            return redirect()->back()->withErrors([
                'email' =>  __('login.login_failed'),
            ]);

    }


    



    public function logout()
    {
        Auth::logout();
        return redirect('/');
        // return redirect()->route('/');
    }
}
