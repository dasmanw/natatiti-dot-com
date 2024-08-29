<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Capital - Asima' => [
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
            ],
            'Hawalli' => [
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
            ],
            'Ahmedi' => [
                'Abu Hulaifa',
                'Al Ahmadi',
                'Al Khairan',
                'Al Thabaeiya',
                'Al Zoor',
                'Ali Sabah Al Salem',
                'Bneidar',
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
                'Mina Abdullah',
                'Nuwaiseeb',
                'Riqqa',
                'Sabah Al Ahmad City',
                'Sabahiya',
                'South Subahiya',
                'Wafra',
            ],
            'Jahra' => [
                'Al Abdali',
                'Kabd',
                'Naeem',
                'Nasseem',
                'Old Jahra',
                'Oyoun',
                'Qasr',
                'Saad Al Abdullah',
                'Sabiya',
                'Sulaibiya',
                'Waha',
            ],
            'Farwaniya' => [
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
        ];

        $governorates = Governorate::pluck('id', 'name');
        foreach ($data as $governorateName => $cityNames) {
            foreach ($cityNames as $cityName) {
                $cities[] = [
                    'governorate_id' => $governorates[$governorateName],
                    'name' => $cityName
                ];
            }
        }

        City::insert($cities);
    }
}
