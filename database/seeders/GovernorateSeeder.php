<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governoratesNames = [
            'Capital - Asima',
            'Camps',
            'Hawalli',
            'Ahmedi',
            'Jahra',
            'Farwaniya'
        ];

        foreach ($governoratesNames as $name) {
            $governorates[] = ['name' => $name];
        }

        Governorate::insert($governorates);
    }
}
