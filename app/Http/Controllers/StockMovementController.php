<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with('product')->latest()->paginate(10);

        return view('stock-movements.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('stock-movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:in,out,adjustment'],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['type'] === 'out' && $product->stock_quantity < $validated['quantity']) {
            return back()
                ->withErrors(['quantity' => 'Not enough stock available.'])
                ->withInput();
        }

        if ($validated['type'] === 'in') {
            $product->stock_quantity += $validated['quantity'];
        } elseif ($validated['type'] === 'out') {
            $product->stock_quantity -= $validated['quantity'];
        } elseif ($validated['type'] === 'adjustment') {
            $product->stock_quantity = $validated['quantity'];
        }

        $product->save();

        StockMovement::create($validated);

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Stock movement recorded successfully.');
    }
}
