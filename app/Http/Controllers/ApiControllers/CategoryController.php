<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(public CategoryService $categoryService)
    {

    }
    public function index(Request $request)
    {
       return response()->json([
           'data' => $this->categoryService->getAllCategories(),
       ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            "name"=>"required|string|max:255|unique:categories,name",
            "description"=>"nullable|string|max:255",
            "slug"=>"nullable|string|max:50|unique:categories,slug",
            "parent_id"=>"nullable|integer",
        ]);

        $this->categoryService->createCategory($validated);
        return response()->json([
            'message' => 'Category created successfully',
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return response()->json([
            'data' => $category,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "name" => [
                "required",
                "string",
                "max:255",
                Rule::unique("categories", "name")->ignore($id),
            ],
            "description" => "nullable|string|max:255",
            "slug" => [
                "nullable",
                "string",
                "max:50",
                Rule::unique("categories", "slug")->ignore($id),
            ],
            "parent_id" => "nullable|integer|exists:categories,id",
        ]);

        $this->categoryService->getCategoryById($id)->update($validated);
        return response()->json([
            'message' => 'Category updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->categoryService->deleteCategory($id);
        return response()->json([
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
