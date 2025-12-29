<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:100'],
            'email' => ['required','email','max:150','unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone' => ['nullable','string','max:30'],
            'address' => ['nullable','string','max:500'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            // jika kamu sudah pakai cast "hashed" di User, boleh langsung assign
            'password' => $validated['password'],
            'role' => 'customer',
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Register success',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Optional: hapus token lama biar 1 device 1 token
        // $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'data' => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        // hapus token yg dipakai saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout success'
        ]);
    }
}
