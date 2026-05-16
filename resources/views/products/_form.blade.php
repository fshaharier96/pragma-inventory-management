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
        transition: .2s ease;
        background: #fff;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .checkbox-row {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 46px;
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
        .form-grid {
            grid-template-columns: 1fr;
        }

        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="form-grid">
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" placeholder="Enter product name">
        @error('name')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $product->slug ?? '') }}" placeholder="enter-product-slug">
        @error('slug')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="stock_quantity">Stock Quantity</label>
        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" min="0">
        @error('stock_quantity')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group full-width">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" placeholder="Write product description">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group full-width">
        <div class="checkbox-row">
            <input type="checkbox" name="has_variants" id="has_variants" value="1" {{ old('has_variants', $product->has_variants ?? false) ? 'checked' : '' }}>
            <label for="has_variants">This product has variants</label>
        </div>
    </div>

    <div class="form-actions full-width">
        <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
