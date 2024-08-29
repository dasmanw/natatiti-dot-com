<?php

namespace App\Http\Requests\Cart;

use App\Rules\MatchPriceType;
use Carbon\Carbon;
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
        $time = Carbon::now()->subMinutes(10)->format('Y-m-d\TH:i');

        return [
            'product_id' => ['required', 'exists:products,id'],
            // 'discount' => ['required', 'numeric', 'min:0', 'max:999999'],
            'price_type' => ['required', new MatchPriceType],
            'city_id' => ['required', 'exists:cities,id'],
            'pickup_date_time' => ['required', 'date_format:Y-m-d\TH:i', 'after_or_equal:' . $time],
            'dropoff_date_time' => ['required', 'date_format:Y-m-d\TH:i', 'after_or_equal:pickup_date_time']
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'The product ID is required.',
            'product_id.exists' => 'The selected product is invalid.',
            'product_id.numeric' => 'The product ID must be a number.',
            'discount.required' => 'The discount is required.',
            'discount.numeric' => 'The discount must be a number.',
            'discount.min' => 'The discount must be at least :min.',
            'discount.max' => 'The discount must not be greater than :max.',
            'price_type.required' => 'The price type is required.',
            'pickup_date_time.required' => 'The pickup date and time are required.',
            'pickup_date_time.date_format' => 'The pickup date and time must be in the format :format.',
            'pickup_date_time.after_or_equal' => 'The pickup date and time must be after or equal to :time.',
            'dropoff_date_time.required' => 'The dropoff date and time are required.',
            'dropoff_date_time.date_format' => 'The dropoff date and time must be in the format :format.',
            'dropoff_date_time.after_or_equal' => 'The dropoff date and time must be after or equal to the pickup date and time.',
        ];
    }
}
