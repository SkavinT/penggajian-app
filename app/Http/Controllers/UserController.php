<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function create()
    {
        // Return the registration form view
        return view('karyawan.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'karyawan', // atau sesuai kebutuhan
        ]);

        return redirect()->route('dashboard')->with('success', 'Karyawan berhasil didaftarkan!');
    }

    // public function showRegisterForm()
    // {
    //     // Tampilkan form register di halaman welcome
    //     return view('welcome');
    // }

    // public function register(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|string|min:6|confirmed',
    //     ]);

    //     \App\Models\User::create([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'password' => bcrypt($validated['password']),
    //         'role' => 'karyawan', // default role untuk user umum
    //     ]);

    //     return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    // }
}