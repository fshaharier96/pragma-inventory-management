@extends('email.layouts.app')

@section('header_subtitle', 'Secure Password Reset Request')

@section('content')
    <h2 style="margin:0 0 16px; font-size:24px; color:#0f172a;">
        Reset Your Password
    </h2>

    <p style="margin:0 0 16px; font-size:15px; line-height:1.7; color:#475569;">
        Hello,
    </p>

    <p style="margin:0 0 16px; font-size:15px; line-height:1.7; color:#475569;">
        We received a request to reset your password for your account.
        Click the button below to set a new password.
    </p>

    <div style="text-align:center; margin:30px 0;">
        <a href="{{ $resetUrl }}" style="display:inline-block; background:#2563eb; color:#ffffff; text-decoration:none; padding:14px 26px; border-radius:12px; font-size:15px; font-weight:700;">
            Reset Password
        </a>
    </div>

    <p style="margin:0 0 16px; font-size:14px; line-height:1.7; color:#64748b;">
        This password reset link will expire in {{ $expiringTime }} minutes.
    </p>

    <p style="margin:0 0 16px; font-size:14px; line-height:1.7; color:#64748b;">
        If you did not request a password reset, you can safely ignore this email.
    </p>

    <div style="margin-top:28px; padding-top:20px; border-top:1px solid #e2e8f0;">
        <p style="margin:0 0 10px; font-size:13px; color:#64748b; line-height:1.6;">
            If the button does not work, copy and paste this link into your browser:
        </p>
        <p style="margin:0; font-size:13px; color:#2563eb; word-break:break-all; line-height:1.6;">
            {{ $resetUrl }}
        </p>
    </div>
@endsection
