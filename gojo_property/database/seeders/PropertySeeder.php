<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Property::create([
            'ptype_id' => '1', // example: house type
            'amenities_id' => '1,2,3', // comma-separated list if stored like this
            'property_name' => 'Elegant Villa',
            'property_slug' => 'elegant-villa',
            'property_code' => 'PROP123',
            'property_status' => 'For Sale',
            'lowest_price' => '500000',
            'max_price' => '600000',
            'property_thambnail' => 'upload/property/thambnail/download.jpg',
            'short_descp' => 'A beautiful and spacious villa.',
            'long_descp' => 'This elegant villa offers comfort, style, and modern amenities.',
            'bedrooms' => '4',
            'bathrooms' => '3',
            'property_size' => '3200',
            'property_video' => 'https://example.com/video.mp4',
            'address' => '123 Luxury St',
            'city' => 'Addis Ababa',
            'state' => 'Addis Ababa',
            'neighborhood' => 'Bole',
            'latitude' => '9.0300',
            'longitude' => '38.7400',
            'featured' => '1',
            'hot' => '1',
            'agent_id' => 1,
            'status' => '1',
        ]);
        Property::create([
            'ptype_id' => '2', // Apartment
            'amenities_id' => '2,4,6',
            'property_name' => 'Modern Apartment',
            'property_slug' => 'modern-apartment',
            'property_code' => 'APT101',
            'property_status' => 'For Rent',
            'lowest_price' => '1500',
            'max_price' => '1800',
            'property_thambnail' => 'upload/property/thambnail/condo.jpg',
            'short_descp' => 'A cozy, modern apartment in the heart of the city.',
            'long_descp' => 'This apartment offers easy access to transportation, great lighting, and modern furnishings.',
            'bedrooms' => '2',
            'bathrooms' => '1',
            'property_size' => '900',
            'property_video' => 'https://example.com/video-apartment.mp4',
            'address' => '456 Urban Ave',
            'city' => 'Addis Ababa',
            'state' => 'Addis Ababa',
            'neighborhood' => 'Kazanchis',
            'latitude' => '9.0250',
            'longitude' => '38.7630',
            'featured' => '0',
            'hot' => '1',
            'agent_id' => 2,
            'status' => '1',
        ]);

        Property::create([
            'ptype_id' => '3', // Office
            'amenities_id' => '1,3,5',
            'property_name' => 'Downtown Office Space',
            'property_slug' => 'downtown-office-space',
            'property_code' => 'OFF456',
            'property_status' => 'For Rent',
            'lowest_price' => '3000',
            'max_price' => '3500',
            'property_thambnail' => 'upload/property/thambnail/office.jpg',
            'short_descp' => 'Premium office space ideal for startups.',
            'long_descp' => 'This downtown office features high-speed internet, meeting rooms, and a reception area.',
            'bedrooms' => '0',
            'bathrooms' => '2',
            'property_size' => '1200',
            'property_video' => 'https://example.com/video-office.mp4',
            'address' => '789 Business Rd',
            'city' => 'Addis Ababa',
            'state' => 'Addis Ababa',
            'neighborhood' => 'Sarbet',
            'latitude' => '9.0100',
            'longitude' => '38.7500',
            'featured' => '1',
            'hot' => '0',
            'agent_id' => 3,
            'status' => '1',
        ]);

        Property::create([
            'ptype_id' => '4', // Land
            'amenities_id' => '',
            'property_name' => 'Spacious Land Plot',
            'property_slug' => 'spacious-land-plot',
            'property_code' => 'LAND789',
            'property_status' => 'For Sale',
            'lowest_price' => '200000',
            'max_price' => '220000',
            'property_thambnail' => 'land.jpg',
            'short_descp' => 'Ideal plot for commercial or residential development.',
            'long_descp' => 'Located in a fast-growing area, this land offers excellent potential for future projects.',
            'bedrooms' => '',
            'bathrooms' => '',
            'property_size' => '10000',
            'property_video' => '',
            'address' => 'Main Highway, Kilinto',
            'city' => 'Addis Ababa',
            'state' => 'Addis Ababa',
            'neighborhood' => 'Kilinto',
            'latitude' => '8.9800',
            'longitude' => '38.7200',
            'featured' => '0',
            'hot' => '0',
            'agent_id' => 4,
            'status' => '1',
        ]);
    }
}
