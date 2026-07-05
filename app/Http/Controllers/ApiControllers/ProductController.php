<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\CreateRequest;
use App\Http\Requests\Api\Product\UpdateRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public ProductService $productService)
    {

    }
    public function index(Request $request)
    {
       return response()->json([
           'data'=>$this->productService->getAllProducts(),
       ],200);
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
    public function store(CreateRequest $createRequest)
    {
       $validated = $createRequest->validated();
       $product = $this->productService->createProduct($validated);
       return response()->json([
           'data'=>$product,
       ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $product = $this->productService->getProductById($id);
        return response()->json([
            'data'=>$product,
        ],200);
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
    public function update(UpdateRequest $updateRequest, int $id)
    {
        $validated = $updateRequest->validated();

        $this->productService->updateProduct($id,$validated);
        return response()->json([
            'message' => 'Product updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productService->deleteProduct($id);
        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }
}
