<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = auth('api')->login($user);

        return response()->json([
            'token' => $token,
            'user'  => $user,
        ]);
    }

    public function login(Request $request)
    {
        \Log::info('Login attempt', $request->only('email', 'password'));

        $credentials = $request->only('email', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            \Log::warning('Login failed for', ['email' => $request->email]);
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        \Log::info('Login success for', ['user' => auth('api')->user()]);

        return response()->json([
            'token' => $token,
            'user'  => auth('api')->user(),
        ]);
    }


    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Logged out']);
    }
}
