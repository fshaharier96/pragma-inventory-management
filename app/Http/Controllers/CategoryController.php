<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')
            ->latest()
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::with(['parent', 'children'])->findOrFail($id);

        return view('categories.show', compact('category'));
    }

    public function create()
    {
        $parents = Category::orderBy('name')->get();

        return view('categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'parent_id' => ['nullable', 'exists:categories,id'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        if (Category::where('slug', $validated['slug'])->exists()) {
            return back()
                ->withErrors(['slug' => 'The slug has already been taken.'])
                ->withInput();
        }

        Category::create($validated);

        return redirect('/categories')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $parents = Category::where('id', '!=', $id)
            ->orderBy('name')
            ->get();

        return view('categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($category->id),
            ],
            'parent_id' => ['nullable', 'exists:categories,id'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        if ((int) $request->parent_id === (int) $category->id) {
            return back()
                ->withErrors(['parent_id' => 'A category cannot be its own parent.'])
                ->withInput();
        }

        $category->update($validated);

        return redirect('/categories')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect('/categories')->with('success', 'Category deleted successfully.');
    }
}
