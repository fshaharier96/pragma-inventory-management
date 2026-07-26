<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        $token = hash('sha256', Str::random(30));

        $resetUrl = url('/reset-password?token='.$token.'&email='.$request->email);

        $expiringTime = now()->addMinutes(config('auth.passwords.users.expire'));

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now(),
                'expires_at' => $expiringTime,
            ]
        );

        $sentPasswordResetEmail = Mail::to($request->email)->send(new \App\Mail\PasswordResetEmail($resetUrl, $expiringTime->toDateTimeString()));

        if($sentPasswordResetEmail) {
            return response()->json([
                'message' => 'Verification code sent successfully, please check your email inbox.',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Failed to send password reset email. Please try again later.',
            ], 500);
        }
    }
}
