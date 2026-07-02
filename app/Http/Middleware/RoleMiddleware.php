<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if the user's role is in the allowed roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // If unauthorized, redirect to their corresponding dashboard
        if ($user->role === 'pengajar') {
            return redirect()->route('pengajar.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman siswa.');
        } elseif ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman pengajar.');
        }

        Auth::logout();
        return redirect()->route('login')->with('error', 'Akses ditolak.');
    }
}
