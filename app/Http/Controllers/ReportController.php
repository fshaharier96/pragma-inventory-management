<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\Customer;

class ReportController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();
        $totalCustomers = Customer::count();
        $totalPurchases = Purchase::count();
        $totalSales = Sale::count();
        $totalStockMovements = StockMovement::count();

        $lowStockProducts = Product::where('stock_quantity', '<=', 5)
            ->orderBy('stock_quantity')
            ->take(10)
            ->get();

        $recentSales = Sale::latest()->take(5)->get();
        $recentPurchases = Purchase::with('supplier')->latest()->take(5)->get();

        return view('reports.index', compact(
            'totalProducts',
            'totalSuppliers',
            'totalCustomers',
            'totalPurchases',
            'totalSales',
            'totalStockMovements',
            'lowStockProducts',
            'recentSales',
            'recentPurchases'
        ));
    }
}
