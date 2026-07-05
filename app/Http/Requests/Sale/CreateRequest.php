<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|integer|exists:customers,id',
            'total_amount' => 'required|numeric',
            'sale_date' => 'required|string',
            'note' => 'nullable|string',
            'sale_items' => 'required|array',
            'sale_items.*.product_id' => 'required|integer|exists:products,id',
            'sale_items.*.quantity' => 'required|integer',
            'sale_items.*.unit_price' => 'required|numeric',
            'sale_items.*.subtotal' => 'required|numeric',
        ];
    }
}
