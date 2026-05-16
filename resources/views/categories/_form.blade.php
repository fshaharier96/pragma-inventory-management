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
        <label for="name">Category Name</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-control"
            value="{{ old('name', $category->name ?? '') }}"
            placeholder="Enter category name"
        >
        @error('name')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="slug">Slug</label>
        <input
            type="text"
            name="slug"
            id="slug"
            class="form-control"
            value="{{ old('slug', $category->slug ?? '') }}"
            placeholder="enter-category-slug"
        >
        @error('slug')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group full-width">
        <label for="parent_id">Parent Category</label>
        <select name="parent_id" id="parent_id" class="form-control">
            <option value="">No Parent</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}"
                    {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>
        @error('parent_id')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-actions full-width">
        <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
