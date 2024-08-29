<?php

namespace App\Http\Requests\Reservation;

use App\Rules\MatchPaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:17'],
            'email' => ['nullable', 'email', 'max:255'],
            'payment_method' => ['required', new MatchPaymentMethod],
            'total_discount' => ['required', 'numeric', 'min:0'],
        ];
    }
}
