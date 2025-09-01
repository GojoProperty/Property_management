<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Amenities;

class AmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            ['amenities_name' => 'Swimming Pool'],
            ['amenities_name' => 'Gym'],
            ['amenities_name' => 'Parking'],
            ['amenities_name' => 'WiFi'],
        ];

        Amenities::insert($amenities);
    }
}
