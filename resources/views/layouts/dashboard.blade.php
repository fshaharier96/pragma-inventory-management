<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Inventory Admin Panel' }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #2563eb;
            --page-bg: #f4f7fb;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            --radius: 18px;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--page-bg);
            color: var(--text-main);
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 270px;
            background: var(--sidebar-bg);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            padding: 24px 16px;
            z-index: 1000;
            transition: transform .3s ease;
        }

        .brand {
            font-size: 24px;
            font-weight: 700;
            padding: 10px 14px;
            margin-bottom: 18px;
        }

        .menu-group {
            margin-bottom: 24px;
        }

        .menu-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            padding: 0 14px;
            margin-bottom: 10px;
        }

        .menu {
            list-style: none;
        }

        .menu li {
            margin-bottom: 8px;
        }

        .menu a {
            display: block;
            text-decoration: none;
            color: #cbd5e1;
            padding: 12px 14px;
            border-radius: 12px;
            transition: .25s ease;
            font-size: 15px;
            font-weight: 500;
        }

        .menu a:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .menu a.active {
            background: var(--sidebar-active);
            color: #fff;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #cbd5e1;
            padding: 12px 14px;
            border-radius: 12px;
            transition: .25s ease;
            font-size: 15px;
            font-weight: 500;
        }

        .menu-icon {
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }

        .main {
            margin-left: 270px;
            width: calc(100% - 270px);
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
        }

        .menu-toggle {
            display: none;
            border: none;
            background: #111827;
            color: #fff;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
        }

        .content {
            padding: 24px;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
        }

        .card-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .card-text {
            color: var(--text-muted);
            line-height: 1.7;
        }

        .grid {
            display: grid;
            gap: 20px;
        }

        .grid-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .stat-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px;
            box-shadow: var(--shadow);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 700;
        }

        .quick-link {
            display: block;
            text-decoration: none;
            color: var(--text-main);
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px;
            box-shadow: var(--shadow);
            transition: .25s ease;
        }

        .quick-link:hover {
            transform: translateY(-3px);
        }

        .quick-link h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .quick-link p {
            color: var(--text-muted);
            line-height: 1.6;
            font-size: 14px;
        }

        .spacer {
            height: 24px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th, td {
            text-align: left;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
        }

        th {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 700;
            background: #f8fafc;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        @media (max-width: 1100px) {
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }

            .grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
                width: 100%;
            }

            .menu-toggle {
                display: inline-block;
            }
        }

        @media (max-width: 640px) {
            .content {
                padding: 16px;
            }

            .topbar {
                padding: 16px;
            }

            .page-title {
                font-size: 22px;
            }

            .card,
            .stat-card,
            .quick-link {
                padding: 18px;
            }

            .grid-4,
            .grid-3 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="brand">Pragma Admin</div>

            <div class="menu-group">
                <div class="menu-title">Main</div>
                <ul class="menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="menu-icon"><i class="fas fa-gauge-high"></i></span>
                            Dashboard
                        </a>
                    </li>
                </ul>
            </div>

            <div class="menu-group">
                <div class="menu-title">Modules</div>
                <ul class="menu">
                    <li>
                        <a href="{{ route('categories.index') }}">
                            <span class="menu-icon"><i class="fas fa-layer-group"></i></span>
                            Categories
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}">
                            <span class="menu-icon"><i class="fas fa-box"></i></span>
                            Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('stock-movements.index') }}">
                            <span class="menu-icon"><i class="fas fa-arrows-rotate"></i></span>
                            Stock Movements
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('suppliers.index') }}">
                            <span class="menu-icon"><i class="fas fa-truck"></i></span>
                            Suppliers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('purchases.index') }}">
                            <span class="menu-icon"><i class="fas fa-cart-plus"></i></span>
                            Purchases
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sales.index') }}">
                            <span class="menu-icon"><i class="fas fa-cash-register"></i></span>
                            Sales
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customers.index') }}">
                            <span class="menu-icon"><i class="fas fa-users"></i></span>
                            Customers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}">
                            <span class="menu-icon"><i class="fas fa-chart-column"></i></span>
                            Reports
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.index') }}">
                            <span class="menu-icon"><i class="fas fa-gear"></i></span>
                            Settings
                        </a>
                    </li>
                    <li>
                    <form action="{{ route('logout') }}" method="POST" style="margin-top: 20px;">
                        @csrf
                        <button type="submit" style="width:100%; padding:12px; border:none; border-radius:10px; background:#dc2626; color:#fff; font-weight:600; cursor:pointer;">
                            Logout
                        </button>
                    </form>

                    </li>
                </ul>
            </div>
        </aside>

        <main class="main">
            <div class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" onclick="toggleSidebar()">Menu</button>
                    <h1 class="page-title">@yield('page_title', 'Dashboard')</h1>
                </div>
            </div>

            <div class="content">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
</body>
</html>
