<?php

namespace App\Http\Requests\Supplier;

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
        $supplierId = $this->route('id');
        return [
            "name" => "required|string|max:255|unique:suppliers,name," . $supplierId,
            "contact_person" => "nullable|string|max:255",
            "email" => "required|email|max:255|unique:suppliers,email," . $supplierId,
            "phone" => "required|string|max:20",
            "city" => "nullable|string|max:255",
            "country" => "nullable|string|max:255",
            "address" => "nullable|string|max:255",
            "status" => "nullable|boolean",
        ];
    }
}
