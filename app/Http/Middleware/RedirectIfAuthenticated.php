<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Redirigir según el rol
            if ($user->isAdmin()) {
                return redirect()->route('admin.solicitudes-vendedor.index');
            }
            
            if ($user->isVendedor()) {
                return redirect()->route('ganados.index');
            }
            
            // Cliente por defecto
            return redirect()->route('home');
        }

        return $next($request);
    }
}
