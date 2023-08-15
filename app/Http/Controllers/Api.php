<?php

namespace App\Http\Controllers;

use App\Models\Property;
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
    public function properties(){
        $data=Property::where('status',1)->with('documents')->get();
        if($data)
        return response()->json([
            'message' => 'success',
            'data' => $data
        ],200);
        else
        return response()->json(['message' => 'Something went wrong!'], 401);
    }
}
