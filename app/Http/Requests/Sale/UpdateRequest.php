<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'customer_name' => ['nullable', 'string', 'max:255'],
            'sale_date' => ['required', 'date'],
            'note' => ['nullable', 'string'],
            'product_id' => ['required', 'array', 'min:1'],
            'product_id.*' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'array'],
            'unit_price.*' => ['required', 'numeric', 'min:0'],
        ];
    }
}
