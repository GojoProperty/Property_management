<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Notifications\TransactionReferenceNotification;
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
        $pendingTransaction = Transaction::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($pendingTransaction) {
            return back()->with([
                'message' => 'You already have a pending request. Please wait until it is processed before making another request.',
                'alert-type' => 'warning',
            ]);
        }

        // ✅ Generate the reference code
        $referenceCode = Str::upper(Str::random(10));

        Transaction::create([
            'user_id'        => Auth::id(),
            'property_id'    => $property->id,
            'agent_id'       => $property->agent_id,
            'transaction_type' => 'buy',
            'price'          => $property->max_price,
            'reference_code' => $referenceCode,
            'status'         => 'pending',
            'request_date'   => now(),
        ]);

        // ✅ Now notify with that reference code
        Auth::user()->notify(new TransactionReferenceNotification($referenceCode));

        $notification = array(
            'message' => 'Purchase request submitted! Check your email for your reference code.',
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

        // ✅ Generate reference code
        $referenceCode = Str::upper(Str::random(10));

        Transaction::create([
            'user_id'        => Auth::id(),
            'property_id'    => $property->id,
            'agent_id'       => $property->agent_id,
            'transaction_type' => 'rent',
            'price'          => $property->max_price,
            'reference_code' => $referenceCode,
            'status'         => 'pending',
            'request_date'   => now(),
        ]);

        // ✅ Now send notification
        Auth::user()->notify(new TransactionReferenceNotification($referenceCode));

        $notification = array(
            'message' => 'Rent request submitted! Check your email for your reference code.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    // Show all transaction details
    public function TransactionDetails()
    {
        // Load transactions with related user, property, and agent info
        $transactions = Transaction::with(['user', 'property', 'agent'])->latest()->get();
        return view('backend.transaction.transaction_detail', compact('transactions'));
    }

    // Update transaction status
    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();

        return redirect()->back()->with('success', 'Transaction status updated successfully.');
    }

    // Delete transaction
    public function deleteTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaction deleted successfully.');
    }
}
