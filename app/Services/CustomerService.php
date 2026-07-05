<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{

   public function __construct()
   {
       // Initialize any dependencies or configurations here
   }

   public function getAllCustomers()
   {
      $customers = Customer::all();
      return $customers;
   }

   public function getCustomerById(int $id)
   {
       return Customer::find($id);
   }

   public function createCustomer(array $data)
   {   $slug ="customer-".strtolower($data['name']);
       $data['slug'] = $slug;
       return Customer::create($data);
   }

   public function updateCustomer(int $id, array $data)
   {
       $customer = Customer::find($id);
       if ($customer) {
           $customer->update($data);
           return $customer;
       }
       return null;
   }

   public function deleteCustomer(int $id)
   {
       $customer = Customer::find($id);
       if ($customer) {
           $customer->delete();
           return true;
       }
       return false;
   }
}
