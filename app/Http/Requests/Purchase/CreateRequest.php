<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //'purchase_no' => 'required|string|max:255',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'invoice_no' => 'nullable|string|max:255',
            'reference_no' => 'nullable|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
            'purchase_date' => 'required',
            'purchase_items' => 'required|array',
            'purchase_items.*.product_id' => 'required|integer|exists:products,id',
            'purchase_items.*.quantity' => 'required|integer|min:1',
            'purchase_items.*.unit_price' => 'required|numeric|min:0',
            'purchase_items.*.subtotal' => 'nullable|numeric|min:0',
        ];
    }
}
