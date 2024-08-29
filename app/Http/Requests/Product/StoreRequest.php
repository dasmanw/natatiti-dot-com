<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'warehouse' => ['required', 'exists:warehouses,id'],
            'category' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:100'],
            'length' => ['nullable', 'numeric', 'min:1', 'digits_between:1,9'],
            'height' => ['nullable', 'numeric', 'min:1', 'digits_between:1,9'],
            'width' => ['nullable', 'numeric', 'min:1', 'digits_between:1,9'],
            'description' => ['nullable', 'string', 'max:3000'],
            // 'quantity' => ['nullable', 'numeric', 'min:1', 'digits_between:1,6'],
            'image' => ['required', 'mimes:jpeg,png']
        ];

        foreach (Product::$priceTypes as $price) {
            $field = strtolower(str_replace(' ', '_', $price));
            $rules[$field] = ['required', 'numeric', 'min:1', 'digits_between:1,9'];
        }

        if (is_super_admin() || is_admin()) {
            $rules['vendor'] = ['required', 'exists:accounts,id'];
        }

        return $rules;
    }
}
