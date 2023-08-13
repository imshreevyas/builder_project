<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Api extends Controller
{
    //

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth')->plainTextToken;

            return response()->json([
                'message' => 'success',
                'user' => $user,
                'token' => $token,
            ],200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
