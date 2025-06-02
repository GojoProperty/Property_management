<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Show the FAQ Page
    public function faq()
    {
        return view('frontend.faq'); // Points to resources/views/frontend/faq.blade.php
    }

    // Show Rent Properties
    public function RentProperties()
{
    $properties = Property::where('status', 'rent')->get();
    return view('frontend.rent_properties', compact('properties'));
}

public function BuyProperties()
{
    $properties = Property::where('status', 'buy')->get();
    return view('frontend.buy_properties', compact('properties'));
}

}
