@extends('layouts.dashboard')

@section('page_title', 'Create Stock Movement')

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

    .full-width { grid-column: 1 / -1; }

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

    textarea.form-control {
        min-height: 120px;
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

    .btn-primary { background: #2563eb; color: #fff; }
    .btn-secondary { background: #64748b; color: #fff; }

    @media (max-width: 768px) {
        .module-card { padding: 16px; }
        .module-title { font-size: 20px; }
        .form-grid { grid-template-columns: 1fr; }
        .btn { width: 100%; text-align: center; }
    }
</style>

<div class="module-card">
    <h2 class="module-title">Create Stock Movement</h2>

    <form action="{{ route('stock-movements.store') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label for="product_id">Product</label>
                <select name="product_id" id="product_id" class="form-control">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Movement Type</label>
                <select name="type" id="type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Stock In</option>
                    <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Stock Out</option>
                    <option value="adjustment" {{ old('type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                </select>
                @error('type')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ old('quantity') }}">
                @error('quantity')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="note">Note</label>
                <textarea name="note" id="note" class="form-control" placeholder="Optional note">{{ old('note') }}</textarea>
                @error('note')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions full-width">
                <button type="submit" class="btn btn-primary">Save Movement</button>
                <a href="{{ route('stock-movements.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
</div>
@endsection
