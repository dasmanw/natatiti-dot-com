<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryNames = ['Soapy Play Inflatables', 'Inflatables', 'Mascot Costume', 'Foam Machine', 'Electronic Games', 'Hantour & Pony', 'Traditional Games', 'Activities', 'Arcade Games', 'Food and Breverage', 'Challenging Games', 'Events Preparations', 'Tents and Booths', 'Carnival Games'];

        $categories = [];
        foreach ($categoryNames as $name) {
            $categories[] = [
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        Category::insert($categories);
    }
}
