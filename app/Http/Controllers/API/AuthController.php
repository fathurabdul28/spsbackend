<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Sinkronisasi donasi tamu yang memiliki no HP yang sama
        Donation::whereNull('user_id')
            ->where('donor_phone', $request->phone)
            ->update(['user_id' => $user->id]);

        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Kata Sandi salah'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Sinkronisasi donasi tamu berdasarkan no HP (jika user punya phone)
        if ($user->phone) {
            Donation::whereNull('user_id')
                ->where('donor_phone', $user->phone)
                ->update(['user_id' => $user->id]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function googleLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'name'  => 'required|string|max:255',
        ]);

        // Cari user berdasarkan email, jika tidak ada buat baru
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make(Str::random(24)), // Random secure password
                'phone' => '', // Default phone empty string
            ]
        );

        $token = $user->createToken('auth_token')->plainTextToken;

        // Sinkronisasi donasi tamu jika ada no telp yang tersimpan
        if ($user->phone) {
            Donation::whereNull('user_id')
                ->where('donor_phone', $user->phone)
                ->update(['user_id' => $user->id]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login success via Google',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user,
        ]);
    }
}
