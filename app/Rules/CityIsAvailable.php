<?php

namespace App\Rules;

use App\Models\City;
use App\Models\WarehouseDetail;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CityIsAvailable implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cityIDs = WarehouseDetail::pluck('city_id');

        if (request()->isMethod('PUT')) {
            $warehouse = request('warehouse');
            $cityIDs = WarehouseDetail::whereNot('warehouse_id', $warehouse->id)->pluck('city_id');
            $cities = City::whereNotIn('id', $cityIDs)->pluck('id')->toArray();
        } else {
            $cities = City::whereNotIn('id', $cityIDs)->pluck('id')->toArray();
        }

        if (!(in_array($value, $cities))) {
            $fail('Each City Must be a valid city');
        }
    }
}
