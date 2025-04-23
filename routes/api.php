<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PlayerCardController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\API\AuthController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/users', [UserController::class, 'index'])->middleware('role:admin|staff');
    Route::post('/users', [UserController::class, 'store'])->middleware('role:admin|staff');
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware('role:admin|staff');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('role:admin|staff');

    Route::put('/profile', [UserController::class, 'updateOwn'])->middleware('role:player');

    Route::get('/players/{id}/card', [PlayerCardController::class, 'show']);
});
