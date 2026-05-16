<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return view('customers.show', compact('customer'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:customers,slug'],
            'email' => ['nullable', 'email', 'max:255', 'unique:customers,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['status'] = $request->has('status');

        if (Customer::where('slug', $validated['slug'])->exists()) {
            return back()
                ->withErrors(['slug' => 'The slug has already been taken.'])
                ->withInput();
        }

        Customer::create($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('customers', 'slug')->ignore($customer->id),
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customer->id),
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

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
