@extends('layouts.auth')

@section('content')
<h1 class="auth-title">Register</h1>
<p class="auth-subtitle">Create your inventory admin account.</p>

<form action="{{ route('register.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        @error('name')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        @error('email')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
        @error('password')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>

    <button type="submit" class="btn">Register</button>
</form>

<div class="auth-footer">
    Already have an account? <a href="{{ route('login') }}">Login</a>
</div>
@endsection
