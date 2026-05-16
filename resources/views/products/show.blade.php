@extends('layouts.dashboard')

@section('page_title', 'Product Details')

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
        <h2 class="module-title">Product Details</h2>
        <a href="{{ route('products.index') }}" class="btn">Back</a>
    </div>

    <div class="detail-grid">
        <div class="detail-box">
            <div class="detail-label">Name</div>
            <div>{{ $product->name }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Slug</div>
            <div>{{ $product->slug }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Category</div>
            <div>{{ $product->category->name ?? 'No Category' }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Stock Quantity</div>
            <div>{{ $product->stock_quantity ?? 0 }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Has Variants</div>
            <div>{{ $product->has_variants ? 'Yes' : 'No' }}</div>
        </div>

        <div class="detail-box full-width">
            <div class="detail-label">Description</div>
            <div>{{ $product->description ?: 'N/A' }}</div>
        </div>
    </div>
</div>
@endsection
