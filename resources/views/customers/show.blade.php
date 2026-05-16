@extends('layouts.dashboard')

@section('page_title', 'Customer Details')

@section('content')
<style>
    .module-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
    }

    .module-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .module-title {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .detail-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
    }

    .detail-box.full-width {
        grid-column: 1 / -1;
    }

    .detail-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .btn {
        display: inline-block;
        text-decoration: none;
        padding: 11px 16px;
        border-radius: 10px;
        background: #64748b;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .module-card { padding: 16px; }
        .module-title { font-size: 20px; }
        .detail-grid { grid-template-columns: 1fr; }
        .btn { width: 100%; text-align: center; }
    }
</style>

<div class="module-card">
    <div class="module-header">
        <h2 class="module-title">Customer Details</h2>
        <a href="{{ route('customers.index') }}" class="btn">Back</a>
    </div>

    <div class="detail-grid">
        <div class="detail-box">
            <div class="detail-label">Name</div>
            <div>{{ $customer->name }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Slug</div>
            <div>{{ $customer->slug }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Email</div>
            <div>{{ $customer->email ?: 'N/A' }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Phone</div>
            <div>{{ $customer->phone ?: 'N/A' }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Company</div>
            <div>{{ $customer->company ?: 'N/A' }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">City</div>
            <div>{{ $customer->city ?: 'N/A' }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Country</div>
            <div>{{ $customer->country ?: 'N/A' }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Status</div>
            <div>{{ $customer->status ? 'Active' : 'Inactive' }}</div>
        </div>

        <div class="detail-box full-width">
            <div class="detail-label">Address</div>
            <div>{{ $customer->address ?: 'N/A' }}</div>
        </div>
    </div>
</div>
@endsection
