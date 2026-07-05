<?php

namespace App\Services;

use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class PurchaseService
{

   public function __construct()
   {
       // Initialize any dependencies or configurations here
   }

   public function getAllPurchases()
   {
      $purchases = Purchase::all();
      return $purchases;
   }

   public function getPurchaseById(int $id)
   {
       return Purchase::with('purchaseItems')->find($id);
   }

   public function createPurchase(array $data)
   {
        $purchase = DB::transaction(function () use ($data) {
            $purchase = Purchase::create([
                'purchase_no' => 'PUR-' . now()->format('YmdHis'),
                'supplier_id' => $data['supplier_id'],
                'purchase_date' => $data['purchase_date'],
                'total_amount' => $data['total_amount'],
                'invoice_no' => $data['invoice_no'] ?? null,
                'reference_no' => $data['reference_no'] ?? null,
                'note' => $data['note'] ?? null,
            ]);

            if (isset($data['purchase_items']) && is_array($data['purchase_items'])) {
                foreach ($data['purchase_items'] as $item) {
                    $purchase->purchaseItems()->create([
                        'product_id' => $item['product_id'],
                        'purchase_id' => $purchase->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }
            }

            return $purchase;
       });

       return $purchase;
   }

   public function updatePurchase(int $id, array $data)
   {
        $purchase = Purchase::findOrFail($id);
        $purchaseUpdate = DB::transaction(function () use ($data,$purchase) {
            $purchase->update([
                'supplier_id' => $data['supplier_id'],
                'purchase_date' => $data['purchase_date'],
                'total_amount' => $data['total_amount'],
                'invoice_no' => $data['invoice_no'] ?? null,
                'reference_no' => $data['reference_no'] ?? null,
                'note' => $data['note'] ?? null,
            ]);

            if (isset($data['purchase_items']) && is_array($data['purchase_items'])) {
                foreach ($data['purchase_items'] as $item) {
                    $purchase->purchaseItems()->updateOrCreate([
                        'purchase_id' => $purchase->id,
                        'product_id' => $item['product_id'],
                    ],[
                        'product_id' => $item['product_id'],
                        'purchase_id' => $purchase->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }
            }

            return $purchase->load('purchaseItems');
       });

       return $purchaseUpdate;
   }

   public function deletePurchase(int $id)
   {
       $purchase = Purchase::find($id);
       if ($purchase) {
           $purchase->delete();
           return true;
       }
       return false;
   }
}
