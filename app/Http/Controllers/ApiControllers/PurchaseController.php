<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\CreateRequest;
use App\Http\Requests\Purchase\UpdateRequest;
use App\Services\PurchaseService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public PurchaseService $purchaseService){

    }
    public function index()
    {
        return response()->json([
            'data' => $this->purchaseService->getAllPurchases(),
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
        $purchase = $this->purchaseService->createPurchase($validated);
        return response()->json([
            'data' => $purchase,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $purchase = $this->purchaseService->getPurchaseById($id);
        return response()->json([
            'data' => $purchase,
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
    public function update(UpdateRequest $request, int $id)
    {
        $validated = $request->validated();
        $purchase = $this->purchaseService->updatePurchase($id, $validated);
        return response()->json([
            'data' => $purchase,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->purchaseService->deletePurchase($id);
        return response()->json([
            'message' => 'Purchase deleted successfully',
        ], 200);
    }
}
