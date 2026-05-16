@extends('layouts.dashboard')

@section('page_title', 'Create Purchase')

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
        min-height: 110px;
        resize: vertical;
    }

    .item-box {
        border: 1px solid #e2e8f0;
        padding: 16px;
        border-radius: 14px;
        margin-bottom: 14px;
        background: #f8fafc;
    }

    .item-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 12px;
        align-items: end;
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
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-add { background: #16a34a; color: #fff; }

    .error-text {
        color: #dc2626;
        font-size: 13px;
        margin-top: 6px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 12px;
    }

    @media (max-width: 900px) {
        .form-grid,
        .item-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .module-card { padding: 16px; }
        .module-title { font-size: 20px; }
        .btn { width: 100%; text-align: center; }
    }
</style>

<div class="module-card">
    <h2 class="module-title">Create Purchase</h2>

    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label for="supplier_id">Supplier</label>
                <select name="supplier_id" id="supplier_id" class="form-control">
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="purchase_date">Purchase Date</label>
                <input type="date" name="purchase_date" id="purchase_date" class="form-control" value="{{ old('purchase_date', date('Y-m-d')) }}">
                @error('purchase_date')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="note">Note</label>
                <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
            </div>

            <div class="form-group full-width">
                <label>Purchase Items</label>

                <div id="items-wrapper">
                    <div class="item-box item-row">
                        <div class="item-grid">
                            <div class="form-group">
                                <label>Product</label>
                                <select name="product_id[]" class="form-control">
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="quantity[]" class="form-control" min="1" placeholder="Qty">
                            </div>

                            <div class="form-group">
                                <label>Unit Price</label>
                                <input type="number" name="unit_price[]" class="form-control" step="0.01" min="0" placeholder="Price">
                            </div>

                            <button type="button" class="btn btn-danger remove-item">Remove</button>
                        </div>
                    </div>
                </div>

                @error('product_id')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full-width">
                <button type="button" class="btn btn-add" id="add-item">Add More Item</button>
            </div>

            <div class="form-actions full-width">
                <button type="submit" class="btn btn-primary">Save Purchase</button>
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-item').addEventListener('click', function () {
        const wrapper = document.getElementById('items-wrapper');
        const firstRow = wrapper.querySelector('.item-row');
        const cloned = firstRow.cloneNode(true);

        cloned.querySelectorAll('select, input').forEach(field => field.value = '');
        wrapper.appendChild(cloned);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-item')) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                e.target.closest('.item-row').remove();
            }
        }
    });
</script>
@endsection
