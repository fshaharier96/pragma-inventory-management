@extends('layouts.auth')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
   
</div>

<h1 class="auth-title">Reset Password</h1>
<p class="auth-subtitle">
    Enter your email and choose a new password for your account.
</p>

@if(session('error'))
    <div style="
        background: #fee2e2;
        color: #991b1b;
        padding: 12px 14px;
        border-radius: 12px;
        margin-bottom: 18px;
        font-size: 14px;
        border: 1px solid #fecaca;
    ">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('password.reset.store') }}" method="POST">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label for="email">Email Address</label>
        <input
            type="email"
            name="email"
            id="email"
            class="form-control"
            value="{{ request()->email ?? old('email') }}"
            required
            readonly
        >
        @error('email')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">New Password</label>
        <input
            type="password"
            name="password"
            id="password"
            class="form-control"
            required
        >
        @error('password')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="form-control"
            required
        >
    </div>

    <button type="submit" class="btn">Reset Password</button>
</form>

<div class="auth-footer">
    Back to <a href="{{ route('login') }}">Login</a>
</div>
@endsection
