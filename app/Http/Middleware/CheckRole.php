<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil nama role pengguna yang sedang login
        $userRole = Auth::user()->role->nama_role ?? '';

        // 3. Cek apakah role pengguna ada di daftar role yang diizinkan
        if (!in_array($userRole, $roles)) {
            // Jika TIDAK diizinkan, hentikan akses dan lempar HTTP 403
            abort(403, 'Akses ditolak. Anda tidak memiliki wewenang untuk membuka halaman ini.');
        }

        return $next($request);
    }
}