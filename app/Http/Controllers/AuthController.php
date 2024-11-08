<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Fungsi untuk registrasi pengguna baru.
     * Peran 'mahasiswa' akan ditetapkan secara otomatis.
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Membuat user baru dengan peran 'mahasiswa' secara otomatis
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
            'role' => 'mahasiswa', // Set peran otomatis sebagai 'mahasiswa'
        ]);

        // Membuat token autentikasi
        $token = $user->createToken('auth_token')->plainTextToken;

        // Mengembalikan token
        return response()->json(['token' => $token], 201);
    }

    /**
     * Fungsi untuk login.
     * Jika kredensial valid, mengembalikan token autentikasi.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Verifikasi password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Membuat token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Mengembalikan token
        return response()->json(['token' => $token], 200);
    }
}
