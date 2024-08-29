<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchPriceType implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $types = [];
        foreach (Product::$priceTypes as $type) {
            if ($type != 'Per Day') {
                $types[] = $type;
            }
        }

        if (!(in_array($value, $types))) {
            $fail('The :attribute is invalid.');
        }
    }
}
