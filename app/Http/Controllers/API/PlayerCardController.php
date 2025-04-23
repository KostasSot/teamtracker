<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;

class PlayerCardController extends Controller
{
    public function show($id)
    {
        $user = auth()->user();

        if ($user->hasRole('player') && $user->id != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $player = User::findOrFail($id);

        return response()->json([
            'id' => $player->id,
            'name' => $player->name,
            'age' => $player->age,
            'email' => $player->email,
            'statistics' => [] // placeholder
        ]);
    }
}
