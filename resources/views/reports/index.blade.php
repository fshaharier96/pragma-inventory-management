@extends('layouts.dashboard')

@section('page_title', 'Reports')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .stat-card,
    .module-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
    }

    .stat-label {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 18px;
        color: #0f172a;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    .table-wrap {
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 500px;
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
        background: #fee2e2;
        color: #991b1b;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-card,
        .module-card {
            padding: 16px;
        }
    }
</style>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Products</div>
        <div class="stat-value">{{ $totalProducts }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Suppliers</div>
        <div class="stat-value">{{ $totalSuppliers }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Customers</div>
        <div class="stat-value">{{ $totalCustomers }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Purchases</div>
        <div class="stat-value">{{ $totalPurchases }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Sales</div>
        <div class="stat-value">{{ $totalSales }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Stock Movements</div>
        <div class="stat-value">{{ $totalStockMovements }}</div>
    </div>
</div>

<div class="content-grid">
    <div class="module-card">
        <h2 class="section-title">Low Stock Products</h2>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td><span class="badge">{{ $product->stock_quantity }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">No low stock products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="module-card">
        <h2 class="section-title">Recent Sales</h2>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Sale No</th>
                        <th>Customer</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSales as $sale)
                        <tr>
                            <td>{{ $sale->sale_no }}</td>
                            <td>{{ $sale->customer_name ?: 'Walk-in Customer' }}</td>
                            <td>{{ number_format($sale->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No sales found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="module-card">
    <h2 class="section-title">Recent Purchases</h2>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Purchase No</th>
                    <th>Supplier</th>
                    <th>Date</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPurchases as $purchase)
                    <tr>
                        <td>{{ $purchase->purchase_no }}</td>
                        <td>{{ $purchase->supplier->name ?? 'N/A' }}</td>
                        <td>{{ $purchase->purchase_date->format('d M Y') }}</td>
                        <td>{{ number_format($purchase->total_amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No purchases found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
