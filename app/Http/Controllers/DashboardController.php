<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalMovements = StockMovement::count();
        $lowStockProducts = Product::where('stock_quantity', '<=', 5)->count();

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalMovements',
            'lowStockProducts'
        ));
    }
}
