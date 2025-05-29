<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



class TransactionController extends Controller
{
    public function purchaseRequest(Request $request)
{
    

    $request->validate([
        'property_id' => 'required|exists:properties,id',
    ]);

    $property = Property::findOrFail($request->property_id);

    if ($property->status != 1 || $property->property_status != 'buy') {
        return back()->with('error', 'Property not available for purchase.');
    }

    $exists = Transaction::where('user_id', Auth::id())
                ->where('property_id', $property->id)
                ->first();

    if ($exists) {
        $notification = array(
            'message' => 'You already requested to purchase this property.',
            'alert-type' => 'warning'
        );
        return back()->with($notification);
    }

    Transaction::create([
        'user_id'        => Auth::id(),
        'property_id'    => $property->id,
        'agent_id'       => $property->agent_id,
        'transaction_type' => 'buy',
        'price'          => $property->max_price,
        'reference_code' => Str::upper(Str::random(10)),
        'status'         => 'pending',
        'request_date'   => now(),
    ]);

    // Send the email notification
    Auth::user()->notify(new TransactionReferenceNotification($referenceCode));
    $notification = array(
        'message' => 'Purchase request submitted! Check your email for your reference code..',
        'alert-type' => 'success'
    );

    return back()->with($notification);
}


    // Handle Rent Request
   public function rentRequest(Request $request)
{


    $request->validate([
        'property_id' => 'required|exists:properties,id',
    ]);

    $property = Property::findOrFail($request->property_id);

    if ($property->status != 1 || $property->property_status != 'rent') {
        return back()->with('error', 'Property not available for rent.');
    }

    $exists = Transaction::where('user_id', Auth::id())
                ->where('property_id', $property->id)
                ->first();

    if ($exists) {
        $notification = array(
            'message' => 'You already requested to rent this property.',
            'alert-type' => 'warning'
        );
        return back()->with($notification);
    }

    Transaction::create([
        'user_id'        => Auth::id(),
        'property_id'    => $property->id,
        'agent_id'       => $property->agent_id,
        'transaction_type' => 'rent',
        'price'          => $property->max_price,
        'reference_code' => Str::upper(Str::random(10)),
        'status'         => 'pending',
        'request_date'   => now(),
    ]);

    $notification = array(
        'message' => 'Rent request submitted successfully.',
        'alert-type' => 'success'
    );

    return back()->with($notification);
}


}
