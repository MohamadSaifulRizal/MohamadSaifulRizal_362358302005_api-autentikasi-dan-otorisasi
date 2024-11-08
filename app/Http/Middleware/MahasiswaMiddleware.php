<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MahasiswaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Memeriksa apakah pengguna memiliki peran "mahasiswa" dan permintaan bukan `GET`
        if ($request->user()->role === 'mahasiswa' && $request->method() !== 'GET') {
            // Jika bukan `GET`, kembalikan respons 403 Unauthorized
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Jika permintaan `GET`, lanjutkan ke permintaan berikutnya
        return $next($request);
    }
}
