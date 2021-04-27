<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $province_items = [
            ['id' => 1, 'name' => 'Dolnośląskie'],
            ['id' => 2, 'name' => 'Kujawsko-pomorskie'],
            ['id' => 3, 'name' => 'Lubuskie'],
            ['id' => 4, 'name' => 'Łódzkie'],
            ['id' => 5, 'name' => 'Lubelskie'],
            ['id' => 6, 'name' => 'Małopolskie'],
            ['id' => 7, 'name' => 'Mazowieckie'],
            ['id' => 8, 'name' => 'Opolskie'],
            ['id' => 9, 'name' => 'Podlaskie'],
            ['id' => 10, 'name' => 'Podkarpackie'],
            ['id' => 11, 'name' => 'Pomorskie'],
            ['id' => 12, 'name' => 'Świętokrzyskie'],
            ['id' => 13, 'name' => 'Śląskie'],
            ['id' => 14, 'name' => 'Warmińsko-mazurskie'],
            ['id' => 15, 'name' => 'Wielkopolskie'],
            ['id' => 16, 'name' => 'Zachodniopomorskie'],
        ];

        $country_items = [
            ['id' => 1, 'name' => 'Polska'],
            ['id' => 2, 'name' => 'England'],
            ['id' => 3, 'name' => 'Germany'],
            ['id' => 4, 'name' => 'Italy'],
            ['id' => 5, 'name' => 'France'],
            ['id' => 6, 'name' => 'Russia'],
            ['id' => 7, 'name' => 'Ireland'],
            ['id' => 8, 'name' => 'Ukraine'],
            ['id' => 9, 'name' => 'Czech'],
            ['id' => 10, 'name' => 'Croatia'],
            ['id' => 11, 'name' => 'Netherland'],
            ['id' => 12, 'name' => 'Belgium'],
            ['id' => 13, 'name' => 'Austria'],
        ];

        $language_items = [
            ['id' => 1, 'name' => 'Polish'],
            ['id' => 2, 'name' => 'English'],
            ['id' => 3, 'name' => 'German'],
            ['id' => 4, 'name' => 'Italian'],
            ['id' => 5, 'name' => 'Spanish'],
            ['id' => 6, 'name' => 'Russian'],
            ['id' => 7, 'name' => 'Ukrainian'],

        ];

        $position_items = [
            ['id' => 1, 'name' => 'Klaster aglomeracyjny'],
            ['id' => 2, 'name' => 'Klaster wydobywczy'],
            ['id' => 3, 'name' => 'Klaster przemysłowy'],
            ['id' => 4, 'name' => 'Klaster turystyczny'],
            ['id' => 5, 'name' => 'Klaster handlowo-usługowy'],
            ['id' => 6, 'name' => 'Klaster rolniczy'],
            ['id' => 7, 'name' => 'Klaster mieszany o profilu rolniczo-handlowo-usługowym'],
            ['id' => 8, 'name' => 'Klaster mieszany o profilu handlowo-usługowo-przemysłowym'],
        ];
        foreach($province_items as $item)
        {
            \App\Models\Province::create($item);
        }
        foreach($country_items as $item)
        {
            \App\Models\Country::create($item);
        }
        foreach($language_items as $item)
        {
            \App\Models\Language::create($item);
        }
        foreach($position_items as $item)
        {
            \App\Models\Position::create($item);
        }
    }
}
