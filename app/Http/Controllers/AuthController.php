<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return back()->with('error', 'Email not found. Please check your email address.');
        }

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
            return back()->with('status', 'If your email is registered, you will receive a password reset link.');
        }else{
            return back()->with('error', 'Failed to send password reset email. Please try again later.');
        }
    }

    public function showForgetPassword()
    {
        return view('auth.forget-password');
    }

    public function resetPasswordForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        $passResetToken = DB::table('password_reset_tokens')->where('email', $email)->where('token', $token)->first();

        if (!$passResetToken || now()->greaterThan($passResetToken->expires_at)) {
            return redirect()->route('password.forget')->with('error', 'Invalid or expired password reset token. Please request a new password reset link.');
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request){
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email not found. Please check your email address.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset successfully. You can now log in with your new password.');
    }
}
