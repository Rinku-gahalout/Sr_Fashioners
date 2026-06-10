<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(){
        return view('wl-admin.wl-auth.login');
    }

    public function authentication(Request $request)
        {
            $credentials = $request->validate([
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]);

            $remember = $request->boolean('remember');

            if (Auth::guard('admin')->attempt($credentials, $remember)) {

                $request->session()->regenerate();

                return redirect()
                    ->route('admin.dashboard')
                    ->with('success', 'Login successful.');
            }

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Invalid email or password.',
                ]);
        }
}
