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
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'company' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company'=>$request->company,
        ]);

        return response()->json([
            'user' => $user,
        ], 200);
    }

    public function logout(Request $request){   
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }

    public function sendPasswordResetLink(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        $verification_code = rand(100000, 999999);
        $user->verification_code = $verification_code;
        $user->save();

        // Here you would typically send the verification code via email or SMS.
        // For this example, we'll just return it in the response.

        return response()->json([
            'message' => 'Verification code sent successfully',
            'verification_code' => $verification_code,
        ], 200);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|string|min:8|confirmed',
            'verification_code' => 'required|integer',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password reset successful',
        ], 200);
    }
}
