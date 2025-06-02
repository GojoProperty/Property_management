<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyType;

class FrontendPropertyController extends Controller
{
    public function AllProperties(Request $request)
    {
        $query = Property::query();
        $query->where('status', 1);

        if ($request->filled('city')) {
            $query->where('city', 'LIKE', '%' . $request->city . '%');
        }

        if ($request->filled('status')) {
            $query->where('property_status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('ptype_id', $request->type);
        }
        $properties = $query->latest()->paginate(10);
        $types = PropertyType::all(); // To populate dropdown

        return view('frontend.all_properties', compact('properties', 'types'));
    }
}
