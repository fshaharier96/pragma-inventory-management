@extends('layouts.dashboard')

@section('page_title', 'Purchase Details')

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
        margin-bottom: 24px;
    }

    .module-title {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .detail-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
    }

    .detail-box.full-width {
        grid-column: 1 / -1;
    }

    .detail-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .btn {
        display: inline-block;
        text-decoration: none;
        padding: 11px 16px;
        border-radius: 10px;
        background: #64748b;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
    }

    .table-wrap {
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    th, td {
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
    }

    th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .module-card { padding: 16px; }
        .module-title { font-size: 20px; }
        .detail-grid { grid-template-columns: 1fr; }
        .btn { width: 100%; text-align: center; }
    }
</style>

<div class="module-card">
    <div class="module-header">
        <h2 class="module-title">Purchase Details</h2>
        <a href="{{ route('purchases.index') }}" class="btn">Back</a>
    </div>

    <div class="detail-grid">
        <div class="detail-box">
            <div class="detail-label">Purchase No</div>
            <div>{{ $purchase->purchase_no }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Supplier</div>
            <div>{{ $purchase->supplier->name }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Purchase Date</div>
            <div>{{ $purchase->purchase_date->format('d M Y') }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Total Amount</div>
            <div>{{ number_format($purchase->total_amount, 2) }}</div>
        </div>

        <div class="detail-box full-width">
            <div class="detail-label">Note</div>
            <div>{{ $purchase->note ?: 'N/A' }}</div>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
