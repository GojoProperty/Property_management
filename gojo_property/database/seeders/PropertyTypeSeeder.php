<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PropertyType;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'type_name' => 'Apartment',
                'type_icon' => 'icon 1',
            ],
            [
                'type_name' => 'House',
                'type_icon' => 'icon 2'
            ],
            [
                'type_name' => 'Villa',
                'type_icon' => 'icon 3'
            ],
            [
                'type_name' => 'Condo',
                'type_icon' => 'icon 4'
            ],
        ];

        PropertyType::insert($types);
    }
}
