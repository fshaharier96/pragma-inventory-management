<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\CreateRequest;
use App\Http\Requests\Supplier\UpdateRequest;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public SupplierService $supplierService)
    {

    }
    public function index(Request $request)
    {
        return response()->json([
            'data' => $this->supplierService->getAllSuppliers(),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $validated = $request->validated();
        $this->supplierService->createSupplier($request->validated());
        return response()->json([
            'message' => 'Supplier created successfully',
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return response()->json([
            'data' => $this->supplierService->getSupplierById($id),
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
    public function update(UpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $this->supplierService->updateSupplier($id, $request->validated());
        return response()->json([
            'message' => 'Supplier updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->supplierService->deleteSupplier($id);
        return response()->json([
            'message' => 'Supplier deleted successfully',
        ], 200);
    }
}
