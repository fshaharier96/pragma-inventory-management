@extends('layouts.dashboard')

@section('page_title', 'Products')

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
        margin-bottom: 20px;
    }

    .module-title {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
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
    .btn-warning { background: #f59e0b; color: #fff; }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-info { background: #0ea5e9; color: #fff; }
    .btn-sm { padding: 8px 12px; font-size: 13px; }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 12px 14px;
        border-radius: 10px;
        margin-bottom: 18px;
    }

    .table-wrap {
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
    }

    th, td {
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
        font-size: 14px;
    }

    th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 999px;
        background: #e2e8f0;
        color: #0f172a;
        font-size: 12px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .module-card { padding: 16px; }
        .module-title { font-size: 20px; }
        .btn { width: 100%; text-align: center; }
        .actions .btn { width: auto; }
    }
</style>

<div class="module-card">
    <div class="module-header">
        <h2 class="module-title">Products</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Variants</th>
                    <th>Description</th>
                    <th width="240">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                        <td>{{ $product->name }}</td>
                        <td><span class="badge">{{ $product->slug }}</span></td>
                        <td>{{ $product->category->name ?? 'No Category' }}</td>
                        <td>{{ $product->stock_quantity ?? 0 }}</td>
                        <td>{{ $product->has_variants ? 'Yes' : 'No' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($product->description, 35) ?: 'N/A' }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 18px;">
        {{ $products->links() }}
    </div>
</div>
@endsection
