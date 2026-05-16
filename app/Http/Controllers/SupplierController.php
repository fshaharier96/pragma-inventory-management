<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('suppliers.show', compact('supplier'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:suppliers,slug'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:suppliers,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['status'] = $request->has('status');

        if (Supplier::where('slug', $validated['slug'])->exists()) {
            return back()
                ->withErrors(['slug' => 'The slug has already been taken.'])
                ->withInput();
        }

        Supplier::create($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier created successfully.');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('suppliers', 'slug')->ignore($supplier->id),
            ],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('suppliers', 'email')->ignore($supplier->id),
            ],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['status'] = $request->has('status');

        $supplier->update($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}
