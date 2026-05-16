<style>
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
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-add { background: #16a34a; color: #fff; }

    @media (max-width: 900px) {
        .form-grid,
        .item-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>

@php
    $saleItems = old('product_id')
        ? collect(old('product_id'))->map(function ($productId, $index) {
            return [
                'product_id' => $productId,
                'quantity' => old('quantity')[$index] ?? '',
                'unit_price' => old('unit_price')[$index] ?? '',
            ];
        })->toArray()
        : (isset($sale) && $sale->items->count()
            ? $sale->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                ];
            })->toArray()
            : [['product_id' => '', 'quantity' => '', 'unit_price' => '']]);
@endphp

<div class="form-grid">
    <div class="form-group">
        <label for="customer_name">Customer Name</label>
        <input
            type="text"
            name="customer_name"code
            id="customer_name"
            class="form-control"
            value="{{ old('customer_name', $sale->customer_name ?? '') }}"
            placeholder="Enter customer name"
        >
        @error('customer_name')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="sale_date">Sale Date</label>
        <input
            type="date"
            name="sale_date"
            id="sale_date"
            class="form-control"
            value="{{ old('sale_date', isset($sale) ? $sale->sale_date->format('Y-m-d') : date('Y-m-d')) }}"
        >
        @error('sale_date')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group full-width">
        <label for="note">Note</label>
        <textarea
            name="note"
            id="note"
            class="form-control"
            placeholder="Optional note"
        >{{ old('note', $sale->note ?? '') }}</textarea>
        @error('note')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group full-width">
        <label>Sale Items</label>

        <div id="items-wrapper">
            @foreach($saleItems as $item)
                <div class="item-box item-row">
                    <div class="item-grid">
                        <div class="form-group">
                            <label>Product</label>
                            <select name="product_id[]" class="form-control">
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ (string) $item['product_id'] === (string) $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Quantity</label>
                            <input
                                type="number"
                                name="quantity[]"
                                class="form-control"
                                min="1"
                                value="{{ $item['quantity'] }}"
                                placeholder="Qty"
                            >
                        </div>

                        <div class="form-group">
                            <label>Unit Price</label>
                            <input
                                type="number"
                                step="0.01"
                                name="unit_price[]"
                                class="form-control"
                                min="0"
                                value="{{ $item['unit_price'] }}"
                                placeholder="Price"
                            >
                        </div>

                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                    </div>
                </div>
            @endforeach
        </div>

        @error('product_id')
            <div class="error-text">{{ $message }}</div>
        @enderror
        @error('product_id.*')
            <div class="error-text">{{ $message }}</div>
        @enderror
        @error('quantity.*')
            <div class="error-text">{{ $message }}</div>
        @enderror
        @error('unit_price.*')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group full-width">
        <button type="button" class="btn btn-add" id="add-item">Add More Item</button>
    </div>

    <div class="form-actions full-width">
        <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('items-wrapper');
        const addButton = document.getElementById('add-item');

        addButton.addEventListener('click', function () {
            const firstRow = wrapper.querySelector('.item-row');
            const cloned = firstRow.cloneNode(true);

            cloned.querySelectorAll('select, input').forEach(field => {
                field.value = '';
            });

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
    });
</script>
