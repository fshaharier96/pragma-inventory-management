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

        html {
            overflow-x: hidden;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--page-bg);
            color: var(--text-main);
            overflow-x: hidden;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
            min-width: 0;
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
            min-width: 0;
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
            min-width: 0;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            overflow-wrap: anywhere;
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
            max-width: 100%;
            min-width: 0;
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
            min-width: 0;
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
            min-width: 0;
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
            min-width: 0;
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
            max-width: 100%;
            -webkit-overflow-scrolling: touch;
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
            body.sidebar-open {
                overflow: hidden;
            }

            .sidebar {
                transform: translateX(-100%);
                width: min(270px, 86vw);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.45);
                opacity: 0;
                pointer-events: none;
                transition: opacity .25s ease;
                z-index: 900;
            }

            body.sidebar-open .sidebar-backdrop {
                opacity: 1;
                pointer-events: auto;
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
                padding: 14px;
            }

            .topbar {
                align-items: flex-start;
                padding: 14px;
            }

            .page-title {
                font-size: 20px;
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

        @media (min-width: 901px) {
            .sidebar-backdrop {
                display: none;
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

    <div class="sidebar-backdrop" id="sidebar-backdrop" onclick="closeSidebar()"></div>

    <style>
        .content *,
        .topbar *,
        .sidebar * {
            min-width: 0;
        }

        .module-card,
        .card,
        .stat-card,
        .quick-link {
            max-width: 100%;
            overflow-wrap: anywhere;
        }

        .module-header,
        .form-actions,
        .actions {
            min-width: 0;
        }

        .table-wrap {
            max-width: 100% !important;
            overflow-x: auto !important;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
        }

        table {
            max-width: none;
        }

        th,
        td {
            vertical-align: top;
        }

        .form-grid,
        .item-grid {
            grid-template-columns: repeat(auto-fit, minmax(min(240px, 100%), 1fr)) !important;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .form-control,
        input,
        select,
        textarea,
        button {
            max-width: 100%;
        }

        .btn,
        button {
            white-space: normal;
        }

        .actions {
            align-items: center;
        }

        .actions form {
            display: inline-flex;
            margin: 0;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            overflow-x: auto;
            max-width: 100%;
        }

        img,
        svg,
        canvas,
        video {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .module-card,
            .card,
            .stat-card,
            .quick-link {
                border-radius: 14px !important;
                padding: 16px !important;
            }

            .module-header {
                align-items: stretch !important;
                gap: 12px !important;
            }

            .module-header > * {
                width: 100%;
            }

            .form-actions > .btn,
            .form-actions > button,
            .form-actions > a,
            .module-header > .btn,
            .module-header > a.btn {
                width: 100% !important;
                text-align: center;
            }

            .actions .btn,
            .actions button {
                width: auto !important;
                min-height: 36px;
            }

            th,
            td {
                padding: 11px 10px !important;
                font-size: 13px !important;
            }

            .item-box {
                padding: 12px !important;
            }
        }

        @media (max-width: 420px) {
            .content {
                padding: 10px;
            }

            .topbar-left {
                width: 100%;
            }

            .menu-toggle {
                flex: 0 0 auto;
                padding: 9px 11px;
            }
        }
    </style>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
            document.body.classList.toggle('sidebar-open', sidebar.classList.contains('show'));
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('show');
            document.body.classList.remove('sidebar-open');
        }

        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', closeSidebar);
        });
    </script>
</body>
</html>
