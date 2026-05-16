<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'has_variants' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['has_variants'] = $request->has('has_variants');

        if (Product::where('slug', $validated['slug'])->exists()) {
            return back()
                ->withErrors(['slug' => 'The slug has already been taken.'])
                ->withInput();
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'description' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'has_variants' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['has_variants'] = $request->has('has_variants');

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
