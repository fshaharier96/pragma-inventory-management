<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sale\StoreRequest;
use App\Http\Requests\Sale\UpdateRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::latest()->paginate(10);

        return view('sales.index', compact('sales'));
    }

    public function show($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);

        return view('sales.show', compact('sale'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        $customers = Customer::orderBy('name')->get();

        return view('sales.create', compact('products', 'customers'));
    }

    public function store(StoreRequest $request)
    {

        $validatedData = $request->validated();

        DB::transaction(function () use ($validatedData) {
            $sale = Sale::create([
                'sale_no' => 'SAL-' . now()->format('YmdHis'),
                'customer_name' => $validatedData['customer_name'],
                'sale_date' => $validatedData['sale_date'],
                'total_amount' => 0,
                'note' => $validatedData['note'],
            ]);

            $totalAmount = 0;

            foreach ($validatedData['product_id'] as $index => $productId) {
                $quantity = (int) $validatedData['quantity'][$index];
                $unitPrice = (float) $validatedData['unit_price'][$index];
                $subtotal = $quantity * $unitPrice;

                $product = Product::findOrFail($productId);

                if ($product->stock_quantity < $quantity) {
                    return back()
                        ->withErrors(['quantity' => 'Not enough stock for product: ' . $product->name])
                        ->withInput();
                }

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $product->stock_quantity -= $quantity;
                $product->save();

                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $quantity,
                    'note' => 'Sale: ' . $sale->sale_no,
                ]);

                $totalAmount += $subtotal;
            }

            $sale->update([
                'total_amount' => $totalAmount,
            ]);
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale created successfully.');
    }

    public function edit($id)
    {
        $sale = Sale::with('items')->findOrFail($id);
        $products = Product::orderBy('name')->get();

        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);

        $validatedData = $request->validated();

        DB::transaction(function () use ($validatedData, $sale) {
            foreach ($sale->items as $oldItem) {
                if ($oldItem->product) {
                    $oldItem->product->stock_quantity += $oldItem->quantity;
                    $oldItem->product->save();

                    StockMovement::create([
                        'product_id' => $oldItem->product->id,
                        'type' => 'in',
                        'quantity' => $oldItem->quantity,
                        'note' => 'Sale updated rollback: ' . $sale->sale_no,
                    ]);
                }
            }

            $sale->items()->delete();

            $totalAmount = 0;

            foreach ($validatedData['product_id'] as $index => $productId) {
                $quantity = (int) $validatedData['quantity'][$index];
                $unitPrice = (float) $validatedData['unit_price'][$index];
                $subtotal = $quantity * $unitPrice;

                $product = Product::findOrFail($productId);

                if ($product->stock_quantity < $quantity) {
                    abort(422, 'Not enough stock for product: ' . $product->name);
                }

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $product->stock_quantity -= $quantity;
                $product->save();

                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $quantity,
                    'note' => 'Sale updated: ' . $sale->sale_no,
                ]);

                $totalAmount += $subtotal;
            }

            $sale->update([
                'customer_name' => $validatedData['customer_name'],
                'sale_date' => $validatedData['sale_date'],
                'note' => $validatedData['note'],
                'total_amount' => $totalAmount,
            ]);
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale updated successfully.');
    }

    public function destroy($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);

        DB::transaction(function () use ($sale) {
            foreach ($sale->items as $item) {
                $product = $item->product;

                if ($product) {
                    $product->stock_quantity += $item->quantity;
                    $product->save();

                    StockMovement::create([
                        'product_id' => $product->id,
                        'type' => 'in',
                        'quantity' => $item->quantity,
                        'note' => 'Sale deleted: ' . $sale->sale_no,
                    ]);
                }
            }

            $sale->delete();
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale deleted successfully.');
    }
}
