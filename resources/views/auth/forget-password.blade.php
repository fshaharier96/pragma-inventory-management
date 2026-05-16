@extends('layouts.auth')

@section('content')
<h1 class="auth-title">Forgot Password</h1>
<p class="auth-subtitle">
    Enter your email address and we will send you a password reset link.
</p>

@if (session('status'))
    <div style="
        background: #dcfce7;
        color: #166534;
        padding: 12px 14px;
        border-radius: 12px;
        margin-bottom: 18px;
        font-size: 14px;
    ">
        {{ session('status') }}
    </div>
@endif

<form action="{{ route('password.forget.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="email">Email Address</label>
        <input
            type="email"
            name="email"
            id="email"
            class="form-control"
            value="{{ old('email') }}"
            placeholder="Enter your email"
            required
        >
        @error('email')
            <div class="error-text">{{ $message }}</div>
        @enderror
        @if(session('error'))
            <div class="alert-error"
            style="
                color: #FF0000;
                padding: 12px 14px;
                border-radius: 12px;
                margin-bottom: 18px;
                font-size: 14px;
            ">
                {{ session('error') }}
            </div>
        @endif

    </div>

    <button type="submit" class="btn">Send Reset Link</button>
</form>

<div class="auth-footer">
    Remember your password? <a href="{{ route('login') }}">Back to Login</a>
</div>
@endsection
