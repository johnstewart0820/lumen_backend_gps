<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['id' => 1, 'name' => 'About Login/Register'],
            ['id' => 2, 'name' => 'About Forgot Password'],
            ['id' => 3, 'name' => 'About Usage'],

        ];
        foreach($items as $item)
        {
            \App\Models\Topic::create($item);
        }
    }
}
