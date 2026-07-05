<?php

namespace App\Http\Requests\Api\Product;

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
            'name' => 'required|string|max:255|unique:products,name',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string|max:255',
            'sku' => 'required|string|max:255|unique:product_variants,sku',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'status' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'reorder_level'=> 'nullable|integer',
        ];
    }
}
