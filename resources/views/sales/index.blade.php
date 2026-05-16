@extends('layouts.dashboard')

@section('page_title', 'Sales')

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
    .btn-info { background: #0ea5e9; color: #fff; }
    .btn-warning { background: #f59e0b; color: #fff; }
    .btn-danger { background: #dc2626; color: #fff; }
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
        min-width: 950px;
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

    @media (max-width: 768px) {
        .module-card { padding: 16px; }
        .module-title { font-size: 20px; }
        .btn { width: 100%; text-align: center; }
        .actions .btn { width: auto; }
    }
</style>

<div class="module-card">
    <div class="module-header">
        <h2 class="module-title">Sales</h2>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">+ Add Sale</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sale No</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th width="260">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $loop->iteration + ($sales->currentPage() - 1) * $sales->perPage() }}</td>
                        <td>{{ $sale->sale_no }}</td>
                        <td>{{ $sale->customer_name ?: 'Walk-in Customer' }}</td>
                        <td>{{ $sale->sale_date->format('d M Y') }}</td>
                        <td>{{ number_format($sale->total_amount, 2) }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Delete this sale?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No sales found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 18px;">
        {{ $sales->links() }}
    </div>
</div>
@endsection
