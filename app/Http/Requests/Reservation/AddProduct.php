<?php

namespace App\Http\Requests\Reservation;

use App\Rules\MatchPriceType;
use Illuminate\Foundation\Http\FormRequest;

class AddProduct extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product' => ['required', 'exists:products,id'],
            'reservation_id' => ['required', 'exists:reservations,id'],
            'price_type' => ['required', new MatchPriceType],
        ];
    }
}
