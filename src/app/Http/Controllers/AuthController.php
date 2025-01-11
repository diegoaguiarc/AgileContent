<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validated) {

            if (auth()->attempt($request->only('email', 'password'))) {

                $user = auth()->user();
                $token = $user->createToken('Login Token')->plainTextToken;

                return response()->json([
                    'message' => 'Login successful',
                    'user' => auth()->user()->name,
                    'token' => $token,
                ], 200);

            }

            return response()->json([
                'message' => 'Login failed',
            ], 401);

        }


    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ], 200);

    }
}
