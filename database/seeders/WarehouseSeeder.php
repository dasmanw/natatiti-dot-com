<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouseNames = [['name' => 'Hijin'], ['name' => 'Wafra'], ['name' => 'Abdali']];
        Warehouse::insert($warehouseNames);

        $data = [
            'Hijin' => [
                'Abdullah Al Salem',
                'Adailiya',
                'Al Nahdha',
                'Al Rai',
                'Bnaid Al Qar',
                'Daiya',
                'Dasma',
                'Dasman',
                'Doha',
                'Faiha',
                'Ghirnata',
                'Jaber Al Ahmed',
                'Kaifan',
                'Khaldiya',
                'Kuwait City',
                'Mansouriya',
                'North West Sulaibikhat',
                'Nuzha',
                'Qadsiya',
                'Qayrawan',
                'Qortuba',
                'Rawda',
                'Shamiya',
                'Shuwaikh',
                'Sulaibikhat',
                'Surra',
                'Yarmouk',
                'Al Bedae',
                'Bayan',
                'Hawally',
                'Hitteen',
                'Jabriya',
                'Mishrif',
                'Mubarak Al Abdullah',
                'Rumaithiya',
                'Salam',
                'Salmiya',
                'Salwa',
                'Shaab',
                'Shuhada',
                'Siddiq',
                'Zahra',
                'Abu Hulaifa',
                'Al Ahmadi',
                'Ali Sabah Al Salem',
                'Dhaher',
                'Egaila',
                'Fahad Al Ahmed',
                'Fahaheel',
                'Fintas',
                'Hadiya',
                'Jaber Al Ali',
                'Chalet Julaia',
                'Mahboula',
                'Mangaf',
                'Riqqa',
                'Sabahiya',
                'South Subahiya',
                'Kabd',
                'Naeem',
                'Nasseem',
                'Old Jahra',
                'Oyoun',
                'Qasr',
                'Saad Al Abdullah',
                'Sulaibiya',
                'Waha',
                'Abdullah Al Mubarak',
                'Abraq Khaitan',
                'Andalous',
                'Ardhiya',
                'Farwaniya',
                'Ferdous',
                'Ishbilya',
                'Khaitan',
                'Omariya',
                'Reggai',
                'Rehab',
                'Sabah Al Nasser',
                'Shedadiya',
                'West Abdullah AlMubarak',
                'Mubarak AlKabeer',
                'Abu Ftaira',
                'Abu Hasaniya',
                'Adan',
                'AlMassayel',
                'Funaitees',
                'Messila',
                'Mubarak Al Kabir',
                'Qurain',
                'Qusour',
                'Rabiya',
                'Sabah Al Salem',
                'Sabhan',
            ],
            'Wafra' => [
                'Al Khairan',
                'Al Thabaeiya',
                'Al Zoor',
                'Bneidar',
                'Mina Abdullah',
                'Nuwaiseeb',
                'Sabah Al Ahmad City',
                'Wafra'
            ],
            'Abdali' => [
                'Al Abdali',
                'Sabiya'
            ],
        ];

        $warehouses = Warehouse::pluck('id', 'name');
        $cities = City::pluck('id', 'name');
        foreach ($data as $warehouseName => $cityNames) {
            foreach ($cityNames as $cityName) {
                $warehouseDetails[] = [
                    'warehouse_id' => $warehouses[$warehouseName],
                    'city_id' => $cities[$cityName]
                ];
            }
        }

        WarehouseDetail::insert($warehouseDetails);
    }
}
