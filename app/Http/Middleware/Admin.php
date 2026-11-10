<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Belum login: arahkan ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Sudah login tapi bukan admin: tolak
        if (Auth::user()->level !== 'admin') {
            return redirect()
                ->route('rents.index')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}

