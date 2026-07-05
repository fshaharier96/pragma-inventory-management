<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json([
                'data' => "Invalid email address.",
            ],401);
        }

        $password  = Hash::check($credentials['password'], $user->password);

        if (!$password) {
            return response()->json([
                'data' => "Invalid password.",
            ],401);
        }

        Log::info("user",['email'=> $credentials['email'], 'password'=> $password ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }
}
