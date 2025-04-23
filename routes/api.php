<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PlayerCardController;
use Illuminate\Support\Facades\Log;

//Public routes
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Wrong password',
            'submitted_password' => $request->password,
            'stored_hash' => $user->password
        ], 401);
    }

    Auth::login($user);
    return response()->json(['message' => 'Login success', 'user' => $user]);
});



Route::post('/register', function (Request $request) {
    Log::info('Register incoming request:', $request->all());

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role' => 'required'
    ]);

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $user->assignRole($request->role);
    Auth::login($user);

    Log::info('User registered:', ['id' => $user->id, 'role' => $request->role]);

    return response()->json(['user' => $user]);
});


Route::post('/logout', function () {
    Auth::logout();
    return response()->json(['message' => 'Logged out']);
});

//Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->middleware('role:admin|staff');
    Route::post('/users', [UserController::class, 'store'])->middleware('role:admin|staff');
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware('role:admin|staff');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('role:admin|staff');

    Route::put('/profile', [UserController::class, 'updateOwn'])->middleware('role:player');

    Route::get('/players/{id}/card', [PlayerCardController::class, 'show']);
});
