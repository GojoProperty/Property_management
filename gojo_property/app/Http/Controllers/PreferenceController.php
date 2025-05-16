<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preference;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public function create()
    {
        $preference = Preference::firstOrNew(['user_id' => Auth::id()]);
        $propertyTypes = PropertyType::all(); // Fetch all property types to populate the dropdown
        return view('preferences.form', compact('preference', 'propertyTypes'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'city' => 'nullable|string|max:255',
            'max_price' => 'nullable|numeric|min:0',
            'property_type' => 'nullable|integer|exists:property_types,id',
            'bathrooms' => 'nullable|string|max:255',
            'bedrooms' => 'nullable|string|max:255'
        ]);

        $validated['user_id'] = Auth::id(); // ← Add this line
        Preference::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );


        return redirect()->back()->with('success', 'Preferences saved successfully!');
    }
}
