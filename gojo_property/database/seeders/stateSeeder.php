<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    public function run()
    {
        $states = [
            [
                'state_name' => 'Addis Ababa',
                'state_image' => 'upload/states/addis.jpg',
            ],
            [
                'state_name' => 'Oromia',
                'state_image' => 'upload/states/oromia.jpg',
            ],
            [
                'state_name' => 'Amhara',
                'state_image' => 'upload/states/amhara.jpg',
            ],
            [
                'state_name' => 'Tigray',
                'state_image' => 'upload/states/tigray.jpg',
            ],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}
