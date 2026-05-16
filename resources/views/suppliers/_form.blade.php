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

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .checkbox-row {
        display: flex;
        align-items: center;
        gap: 10px;
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
        .form-grid { grid-template-columns: 1fr; }
        .btn { width: 100%; text-align: center; }
    }
</style>

<div class="form-grid">
    <div class="form-group">
        <label for="name">Supplier Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $supplier->name ?? '') }}">
        @error('name')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $supplier->slug ?? '') }}">
        @error('slug')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="contact_person">Contact Person</label>
        <input type="text" name="contact_person" id="contact_person" class="form-control" value="{{ old('contact_person', $supplier->contact_person ?? '') }}">
    </div>

    <div class="form-group">
        <label for="company">Company</label>
        <input type="text" name="company" id="company" class="form-control" value="{{ old('company', $supplier->company ?? '') }}">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $supplier->email ?? '') }}">
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $supplier->phone ?? '') }}">
    </div>

    <div class="form-group">
        <label for="city">City</label>
        <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $supplier->city ?? '') }}">
    </div>

    <div class="form-group">
        <label for="country">Country</label>
        <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $supplier->country ?? '') }}">
    </div>

    <div class="form-group full-width">
        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control">{{ old('address', $supplier->address ?? '') }}</textarea>
    </div>

    <div class="form-group full-width">
        <div class="checkbox-row">
            <input type="checkbox" name="status" id="status" value="1" {{ old('status', $supplier->status ?? true) ? 'checked' : '' }}>
            <label for="status">Active Supplier</label>
        </div>
    </div>

    <div class="form-actions full-width">
        <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
