<?php

namespace App\Services;

use App\Models\Supplier;

class SupplierService
{

   public function __construct()
   {
       // Initialize any dependencies or configurations here
   }

   public function getAllSuppliers()
   {
      $suppliers = Supplier::all();
      return $suppliers;
   }

    public function getSupplierById(int $id)
    {
        return Supplier::find($id);
    }

   public function createSupplier(array $data)
   {
       return Supplier::create($data);
   }

   public function updateSupplier(int $id, array $data)
   {
       $supplier = Supplier::find($id);
       if ($supplier) {
           $supplier->update($data);
           return $supplier;
       }
       return null;
   }

   public function deleteSupplier(int $id)
   {
       $supplier = Supplier::find($id);
       if ($supplier) {
           $supplier->delete();
           return true;
       }
       return false;
   }


}
