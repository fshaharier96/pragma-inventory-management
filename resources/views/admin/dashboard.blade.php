@extends('layouts.dashboard')

@section('page_title', 'Dashboard')

@section('content')
<div class="grid grid-4">
    <div class="stat-card">
        <div class="stat-label">Total Categories</div>
        <div class="stat-value">{{ $totalCategories }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Products</div>
        <div class="stat-value">{{ $totalProducts }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Stock Movements</div>
        <div class="stat-value">{{ $totalMovements }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Low Stock Products</div>
        <div class="stat-value">{{ $lowStockProducts }}</div>
    </div>
</div>

<div class="spacer"></div>

<div class="card">
    <h2 class="card-title">Welcome to Inventory Admin Panel</h2>
    <p class="card-text">
        This dashboard gives you one place to access all inventory modules. Your previous category, product,
        and stock movement CRUD pages remain unchanged.
    </p>
</div>

<div class="spacer"></div>

<div class="grid grid-3">
    <a href="{{ route('categories.index') }}" class="quick-link">
        <h3>Categories</h3>
        <p>Manage product categories and parent child relationships.</p>
    </a>

    <a href="{{ route('products.index') }}" class="quick-link">
        <h3>Products</h3>
        <p>Create and manage inventory products with descriptions and categories.</p>
    </a>

    <a href="{{ route('stock-movements.index') }}" class="quick-link">
        <h3>Stock Movements</h3>
        <p>Track stock in, stock out, and inventory adjustments.</p>
    </a>

    <a href="{{ route('suppliers.index') }}" class="quick-link">
        <h3>Suppliers</h3>
        <p>Manage supplier information for purchasing and stock intake.</p>
    </a>

    <a href="{{ route('admin.purchases') }}" class="quick-link">
        <h3>Purchases</h3>
        <p>Record incoming product purchases from suppliers.</p>
    </a>

    <a href="{{ route('admin.sales') }}" class="quick-link">
        <h3>Sales</h3>
        <p>Track outgoing sales and reduce available stock automatically.</p>
    </a>

    <a href="{{ route('admin.customers') }}" class="quick-link">
        <h3>Customers</h3>
        <p>Keep customer records for sales and order history.</p>
    </a>

    <a href="{{ route('admin.reports') }}" class="quick-link">
        <h3>Reports</h3>
        <p>View summaries, low stock reports, and movement history.</p>
    </a>

    <a href="{{ route('admin.settings') }}" class="quick-link">
        <h3>Settings</h3>
        <p>Control system preferences and future configuration options.</p>
    </a>
</div>
@endsection
