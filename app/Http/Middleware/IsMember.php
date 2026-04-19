<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsMember
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika pengguna tidak login ATAU peran (role_id) adalah '2' (Member),
        // maka izinkan request dilanjutkan.
        if (!Auth::check() || Auth::user()->role_id == '2') {
            return $next($request);
        }
        
        // Jika pengguna login tetapi BUKAN Member (misalnya Admin), 
        // arahkan ke halaman dashboard admin.
        return redirect('/admin/dashboard');
    }
}
