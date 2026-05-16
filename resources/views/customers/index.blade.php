@extends('layouts.dashboard')

@section('page_title', 'Customers')

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
        font-size: 12px;
        font-weight: 700;
    }

    .badge-success { background: #dcfce7; color: #166534; }
    .badge-danger { background: #fee2e2; color: #991b1b; }

    @media (max-width: 768px) {
        .module-card { padding: 16px; }
        .module-title { font-size: 20px; }
        .btn { width: 100%; text-align: center; }
        .actions .btn { width: auto; }
    }
</style>

<div class="module-card">
    <div class="module-header">
        <h2 class="module-title">Customers</h2>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">+ Add Customer</a>
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
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>City</th>
                    <th>Status</th>
                    <th width="240">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email ?: 'N/A' }}</td>
                        <td>{{ $customer->phone ?: 'N/A' }}</td>
                        <td>{{ $customer->company ?: 'N/A' }}</td>
                        <td>{{ $customer->city ?: 'N/A' }}</td>
                        <td>
                            @if($customer->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Delete this customer?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 18px;">
        {{ $customers->links() }}
    </div>
</div>
@endsection
