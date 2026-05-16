@extends('layouts.auth')

@section('content')
<h1 class="auth-title">Login</h1>
<p class="auth-subtitle">Sign in to access your inventory system.</p>

<form action="{{ route('login.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        @error('email')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
     <div class="forgot-wrap">
        <a href="{{ route('password.forget') }}" class="forgot-link">Forgot your password?</a>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
        @error('password')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="checkbox-row">
        <input type="checkbox" name="remember" id="remember" value="1">
        <label for="remember">Remember me</label>
    </div>

    <button type="submit" class="btn">Login</button>
</form>

<div class="auth-footer">
    Don’t have an account? <a href="{{ route('register') }}">Register</a>
</div>
@endsection
