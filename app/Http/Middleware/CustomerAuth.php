<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('user.sign.in');
        }

        if (Auth::user()->role !== 'customer') {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}