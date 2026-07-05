<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\CreateRequest;
use App\Http\Requests\Sale\UpdateRequest;
use App\Services\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public SaleService $saleService)
    {
    }

    public function index()
    {
        return response()->json([
           'data'=> $this->saleService->getAllSales(),
        ],200);
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
    {   $validated = $request->validated();
        $this->saleService->createSale($validated);
        return response()->json([
            'message'=>'Sale created successfully',
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'data'=> $this->saleService->getSaleById($id),
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
    public function update(UpdateRequest $request,string $id)
    {
        $validated = $request->validated();
        $this->saleService->updateSale($id, $validated);
        return response()->json([
            'message'=>'Sale updated successfully',
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->saleService->deleteSale($id);
        return response()->json([
            'message'=>'Sale deleted successfully',
        ],200);
    }
}
