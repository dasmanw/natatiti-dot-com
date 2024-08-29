<?php

namespace App\Http\Requests\Product;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'location' => ['required'],
            'pickup_date_time' => ['required', 'date_format:Y-m-d\TH:i', 'after_or_equal:' . $time],
            'dropoff_date_time' => ['required', 'date_format:Y-m-d\TH:i', 'after_or_equal:pickup_date_time'],
            'category' => ['nullable', 'numeric'],
            'length' => ['nullable', 'numeric', 'min:1', 'digits_between:1,9'],
            'height' => ['nullable', 'numeric', 'min:1', 'digits_between:1,9'],
            'width' => ['nullable', 'numeric', 'min:1', 'digits_between:1,9'],
            'name' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'location.required' => 'The location field is required.',
            'location.exists' => 'The selected location is invalid.',
            'pickup_date_time.required' => 'The pickup date and time field is required.',
            'pickup_date_time.date_format' => 'The pickup date and time must be in the format Y-m-d\TH:i.',
            'pickup_date_time.after_or_equal' => 'The pickup date and time must be after or equal to the current time.',
            'dropoff_date_time.required' => 'The drop-off date and time field is required.',
            'dropoff_date_time.date_format' => 'The drop-off date and time must be in the format Y-m-d\TH:i.',
            'dropoff_date_time.after_or_equal' => 'The drop-off date and time must be after or equal to the pickup date and time.',
        ];
    }
}
