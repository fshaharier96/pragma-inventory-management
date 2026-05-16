<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier')
            ->latest()
            ->paginate(10);

        return view('purchases.index', compact('purchases'));
    }

    public function show($id)
    {
        $purchase = Purchase::with(['supplier', 'items.product'])->findOrFail($id);

        return view('purchases.show', compact('purchase'));
    }

    public function create()
    {
        $suppliers = Supplier::where('status', true)->orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'purchase_date' => ['required', 'date'],
            'note' => ['nullable', 'string'],
            'product_id' => ['required', 'array', 'min:1'],
            'product_id.*' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'array'],
            'unit_price.*' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($request) {
            $purchase = Purchase::create([
                'purchase_no' => 'PUR-' . now()->format('YmdHis'),
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'total_amount' => 0,
                'note' => $request->note,
            ]);

            $totalAmount = 0;

            foreach ($request->product_id as $index => $productId) {
                $quantity = (int) $request->quantity[$index];
                $unitPrice = (float) $request->unit_price[$index];
                $subtotal = $quantity * $unitPrice;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $product = Product::findOrFail($productId);
                $product->stock_quantity += $quantity;
                $product->save();

                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $quantity,
                    'note' => 'Purchase: ' . $purchase->purchase_no,
                ]);

                $totalAmount += $subtotal;
            }

            $purchase->update([
                'total_amount' => $totalAmount,
            ]);
        });

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase created successfully.');
    }

    public function destroy($id)
    {
        $purchase = Purchase::with('items.product')->findOrFail($id);

        DB::transaction(function () use ($purchase) {
            foreach ($purchase->items as $item) {
                $product = $item->product;

                if ($product) {
                    $product->stock_quantity -= $item->quantity;
                    if ($product->stock_quantity < 0) {
                        $product->stock_quantity = 0;
                    }
                    $product->save();

                    StockMovement::create([
                        'product_id' => $product->id,
                        'type' => 'out',
                        'quantity' => $item->quantity,
                        'note' => 'Purchase deleted: ' . $purchase->purchase_no,
                    ]);
                }
            }

            $purchase->delete();
        });

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase deleted successfully.');
    }
}
