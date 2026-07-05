<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SaleService
{

   public function __construct()
   {
       // Initialize any dependencies or configurations here
   }

   public function getAllSales()
   {
      $sales = Sale::with('saleItems')->get();
      return $sales;
   }

   public function getSaleById(int $id)
   {
       return Sale::with('saleItems')->find($id);
   }

   public function createSale(array $data)
   {
        $sale = DB::transaction(function () use ($data) {
            $sale = Sale::create([
               'sale_no' => "SAL-".now()->format('YmdHis'),
               'customer_id' => $data['customer_id'],
               'total_amount' => $data['total_amount'],
               'sale_date' => $data['sale_date'],
               'note' => $data['note'],
            ]);

            foreach ($data['sale_items'] as $item) {
                $sale->saleItems()->create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

           return  $sale->load('saleItems');
       });
       return $sale;
   }

   public function updateSale(int $id, array $data)
   {
       $sale = Sale::findOrFail($id);

       $saleUpdate = DB::transaction(function () use ($data, $sale) {
            $sale->update([
               'customer_id' => $data['customer_id'],
               'total_amount' => $data['total_amount'],
               'sale_date' => $data['sale_date'],
               'note' => $data['note'],
            ]);

            foreach ($data['sale_items'] as $item) {
                $sale->saleItems()->updateOrCreate(
                [
                    'product_id' => $item['product_id'],
                    'sale_id' => $sale->id,
                ],
                [
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

           return  $sale->load('saleItems');
       });
       return $saleUpdate;
   }

   public function deleteSale(int $id)
   {
       $sale = Sale::find($id);
       if ($sale) {
           $sale->delete();
           return true;
       }
       return false;
   }
}
