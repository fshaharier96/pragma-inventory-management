@extends('layouts.dashboard')

@section('page_title', 'Stock Movements')

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
        min-width: 900px;
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

    .badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .badge-success { background: #dcfce7; color: #166534; }
    .badge-danger { background: #fee2e2; color: #991b1b; }
    .badge-warning { background: #fef3c7; color: #92400e; }

    @media (max-width: 768px) {
        .module-card { padding: 16px; }
        .module-title { font-size: 20px; }
        .btn { width: 100%; text-align: center; }
    }
</style>

<div class="module-card">
    <div class="module-header">
        <h2 class="module-title">Stock Movements</h2>
        <a href="{{ route('stock-movements.create') }}" class="btn btn-primary">+ Add Movement</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Note</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $movement)
                    <tr>
                        <td>{{ $loop->iteration + ($movements->currentPage() - 1) * $movements->perPage() }}</td>
                        <td>{{ $movement->product->name }}</td>
                        <td>
                            @if($movement->type === 'in')
                                <span class="badge badge-success">Stock In</span>
                            @elseif($movement->type === 'out')
                                <span class="badge badge-danger">Stock Out</span>
                            @else
                                <span class="badge badge-warning">Adjustment</span>
                            @endif
                        </td>
                        <td>{{ $movement->quantity }}</td>
                        <td>{{ $movement->note ?: 'N/A' }}</td>
                        <td>{{ $movement->created_at->format('d M Y h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No stock movements found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 18px;">
        {{ $movements->links() }}
    </div>
</div>
@endsection
