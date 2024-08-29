<?php

namespace App\Rules;

use App\Models\Reservation;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchPaymentMethod implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $methods = [];
        foreach (Reservation::$paymentMethods as $method) {
            $methods[] = $method;
        }

        if (!(in_array($value, $methods))) {
            $fail('The :attribute is invalid.');
        }
    }
}
