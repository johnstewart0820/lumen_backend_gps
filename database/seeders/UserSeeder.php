<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['id' => 1, 'first_name' => 'Krystian', 'last_name' => 'Bartosiak', 'email' => "admin@gmail.com", 'password' => '$2a$10$epVj4MXedq9N6yk7P2uGNewBWKh11NhnnOHgIqnfoIb20jTeM7wbq', 'country' => 1, 'is_valid' => true],

        ];
        foreach($items as $item)
        {
            \App\Models\User::create($item);
        }
    }
}
