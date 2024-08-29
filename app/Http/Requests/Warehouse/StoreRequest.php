<?php

namespace App\Http\Requests\Warehouse;

use App\Rules\CityIsAvailable;
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'cities' => ['required', 'array'],
            'cities.*' => [new CityIsAvailable]
        ];
    }

    public function messages()
    {
        return [
            'cities.*' => ['Some cities are invalid.']
        ];
    }
}
