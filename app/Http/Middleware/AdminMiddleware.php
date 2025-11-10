<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user(); // ambil user terautentikasi

        if (!$user || $user->role !== UserRole::Admin) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
