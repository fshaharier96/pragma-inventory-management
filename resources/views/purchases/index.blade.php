@extends('layouts.dashboard')

@section('page_title', 'Purchases')

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
        <h2 class="module-title">Purchases</h2>
        <a href="{{ route('purchases.create') }}" class="btn btn-primary">+ Add Purchase</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Purchase No</th>
                    <th>Supplier</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th width="220">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                    <tr>
                        <td>{{ $loop->iteration + ($purchases->currentPage() - 1) * $purchases->perPage() }}</td>
                        <td>{{ $purchase->purchase_no }}</td>
                        <td>{{ $purchase->supplier->name }}</td>
                        <td>{{ $purchase->purchase_date->format('d M Y') }}</td>
                        <td>{{ number_format($purchase->total_amount, 2) }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-info btn-sm">View</a>
                                <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" onsubmit="return confirm('Delete this purchase?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No purchases found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 18px;">
        {{ $purchases->links() }}
    </div>
</div>
@endsection
