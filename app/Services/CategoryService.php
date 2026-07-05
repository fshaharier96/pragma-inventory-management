<?php

namespace App\Services;

use App\Models\Category;


class CategoryService
{

   public function __construct()
   {
       // Initialize any dependencies or configurations here
   }

   public function getAllCategories()
   {
      $categories = Category::all();
      return $categories;
   }

   public function createCategory(array $validated){
      $category = Category::create($validated);
      return $category;
   }

   public function getCategoryById(string $id){
      $category = Category::find($id);
      return $category;
   }

   public function updateCategory(string $id, array $validated){
      $category = Category::find($id);
      $category->update($validated);
      return $category;
   }

   public function deleteCategory(string $id){
      $category = Category::find($id);
      $category->delete();
      return $category;
   }
}
