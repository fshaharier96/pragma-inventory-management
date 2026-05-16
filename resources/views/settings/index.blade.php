@extends('layouts.dashboard')

@section('page_title', 'Settings')

@section('content')
<style>
    .module-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
    }

    .module-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #0f172a;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 12px 14px;
        border-radius: 10px;
        margin-bottom: 18px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        margin-bottom: 8px;
        font-weight: 600;
        color: #334155;
    }

    .form-control {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 14px;
        outline: none;
        background: #fff;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .error-text {
        color: #dc2626;
        font-size: 13px;
        margin-top: 6px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 8px;
    }

    .btn {
        display: inline-block;
        text-decoration: none;
        padding: 11px 16px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-primary {
        background: #2563eb;
        color: #fff;
    }

    @media (max-width: 768px) {
        .module-card {
            padding: 16px;
        }

        .module-title {
            font-size: 20px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="module-card">
    <h2 class="module-title">System Settings</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label for="company_name">Company Name</label>
                <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name', $setting->company_name) }}">
                @error('company_name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="company_email">Company Email</label>
                <input type="email" name="company_email" id="company_email" class="form-control" value="{{ old('company_email', $setting->company_email) }}">
                @error('company_email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="company_phone">Company Phone</label>
                <input type="text" name="company_phone" id="company_phone" class="form-control" value="{{ old('company_phone', $setting->company_phone) }}">
                @error('company_phone')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="currency">Currency</label>
                <input type="text" name="currency" id="currency" class="form-control" value="{{ old('currency', $setting->currency) }}">
                @error('currency')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="timezone">Timezone</label>
                <input type="text" name="timezone" id="timezone" class="form-control" value="{{ old('timezone', $setting->timezone) }}">
                @error('timezone')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="low_stock_limit">Low Stock Limit</label>
                <input type="number" name="low_stock_limit" id="low_stock_limit" class="form-control" min="0" value="{{ old('low_stock_limit', $setting->low_stock_limit) }}">
                @error('low_stock_limit')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="company_address">Company Address</label>
                <textarea name="company_address" id="company_address" class="form-control">{{ old('company_address', $setting->company_address) }}</textarea>
                @error('company_address')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions full-width">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </div>
    </form>
</div>
@endsection
