<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Product;
use App\Models\Warehouse;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function model(array $row)
    // {
    //     $warehouse = Warehouse::where('name', $row['warehouse'])->first('id');
    //     $category = Category::where('name', $row['category'])->first('id');
    //     $array = [
    //         'warehouse_id'     => $warehouse->id,
    //         'category_id'    => $category->id,
    //         'name' => $row['name'],
    //         'length' => $row['length'],
    //         'height' => $row['height'],
    //         'width' => $row['width'],
    //         'prices' => $row['prices'],
    //         'image_link' => $row['image_link'],
    //     ];
    //     return new Product($array);
    // }

    public function collection(Collection $rows)
    {
        $governorate = null;
        foreach ($rows as $row) {
            $row = $row->toArray();
            if ($row['governorate']) {
                $governorate = Governorate::where('name', 'LIKE', "%" . $row['governorate'] . "%")->first('id');
            }
            if ($row['city']) {
                City::create([
                    'name' => [
                        'en' => $row['city'],
                        'ar' => $row['arabic']
                    ],
                    'governorate_id' => $governorate->id,
                ]);
            }
        }
    }
}
