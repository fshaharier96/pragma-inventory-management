<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{

   public function __construct()
   {
       // Initialize any dependencies or configurations here
   }

   public function getAllProducts()
   {
      $products = Product::all();
      return $products;
   }

   public function createProduct(array $validated){
    $product  =  DB::transaction(function() use ($validated){
           $product_arr = [
             "name" => $validated['name'],
             "slug" => $validated['slug'],
             "description" => $validated['description'],
             "category_id" => $validated['category_id'],
           ];
           $product = Product::create($product_arr);
           $variant_default_name = $product->name.' Default';
           $product_variant_arr =[
               "product_id" => $product->id,
               "name" =>  $variant_default_name,
               "sku" => $validated['sku'],
               "purchase_price" => $validated['purchase_price'],
               "selling_price" => $validated['selling_price'],
               "status" => $validated['status'],
               "is_default" => true,
               "min_stock_quantity" => $validated['min_stock_quantity'],
           ];
            $product_variant = $product->productVariants()->create($product_variant_arr);
            $product->has_variants = true;
            $product->save();
            $product->refresh();
           // $product->productVariants()->refresh();

            $variant_inventory_arr = [
                "product_variant_id" => $product_variant->id,
            ];
            $product_variant->inventory()->create($variant_inventory_arr);

           return $product;
      });

       return $product;
   }

   public function getProductById(int $id){
       $product = Product::with('productVariants')->find($id);
       return $product;
   }

   public function updateProduct(int $id, array $validated){
       $product = Product::find($id);
       $product->update($validated);
       return $product;
   }

   public function deleteProduct(int $id){
       $product = Product::find($id);
       $product->delete();
       return $product;
   }
}
