<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Models\Amenities;
use App\Models\PropertyType;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CustomerPropertyController extends Controller
{
    public function addProperty()
    {
        $user = Auth::user();

        if ($user->role !== 'customer') {
            // Redirect back or show error if user is not a customer
            return redirect()->route('/login')->with('error', 'Unauthorized access.');
        }

        $propertyCount = Property::where('customer_id', $user->id)->count();

        if ($propertyCount >= 1) {
            $notification = [
                'message' => 'You have already posted a property. Please become an agent to post more.',
                'alert-type' => 'warning',
            ];
            return redirect()->route('dashboard')->with($notification);
        }

        $propertyTypes = PropertyType::all();
        $amenities = Amenities::all();

        return view('customer.property.add_property', compact('propertyTypes', 'amenities'));
    }


    public function CustomerStoreProperty(Request $request)
    {
        $id = Auth::user()->id;

        // Handle amenities
        $amenities = implode(",", $request->amenities_id ?? []);

        // Generate property code
        $pcode = IdGenerator::generate([
            'table' => 'properties',
            'field' => 'property_code',
            'length' => 5,
            'prefix' => 'PC'
        ]);

        // Handle thumbnail
        if ($request->hasFile('property_thambnail')) {
            $image = $request->file('property_thambnail');
            $imgManager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $imgManager->read($image)->resize(370, 250)->save('upload/property/thambnail/' . $name_gen);
            $save_url = 'upload/property/thambnail/' . $name_gen;
        } else {
            $save_url = null;
        }

        // Create property
        $property = Property::create([
            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenities,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_code' => $pcode,
            'property_status' => $request->property_status,
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'customer_id' => $id,
            'status' => 1,
            'property_thambnail' => $save_url,
        ]);

        // Upload multiple images
        if ($request->hasFile('multi_img')) {
            foreach ($request->file('multi_img') as $img) {
                $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
                $imgManager->read($img)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
                $uploadPath = 'upload/property/multi-image/' . $make_name;

                $property->multiImages()->create([
                    'photo_name' => $uploadPath,
                ]);
            }
        }

        // Insert facilities
        if (!empty($request->facility_name)) {
            for ($i = 0; $i < count($request->facility_name); $i++) {
                $property->facilities()->create([
                    'facility_name' => $request->facility_name[$i],
                    'distance' => $request->distance[$i],
                ]);
            }
        }

        return redirect()->route('customer.all.property')->with([
            'message' => 'Property Submitted Successfully',
            'alert-type' => 'success'
        ]);
    }


    public function allProperty()
    {
        $customer = Auth::user();
        $properties = Property::where('customer_id', $customer->id)->latest()->get();
        return view('customer.property.all_property', compact('properties'));
    }

    public function CustomerEditProperty($id)
    {
        $property = Property::findOrFail($id);
        $facilities = Facility::where('property_id', $id)->get();
        $type = $property->amenities_id;
        $property_amin = explode(',', $type);
        $multiImage = MultiImage::where('property_id', $id)->get();
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();

        return view('customer.property.edit_property', compact(
            'property',
            'propertytype',
            'amenities',
            'property_amin',
            'multiImage',
            'facilities'
        ));
    }

    public function CustomerUpdateProperty(Request $request)
    {
        $amen = $request->amenities_id ?? [];
        $amenites = implode(",", $amen);
        $property_id = $request->id;

        Property::findOrFail($property_id)->update([
            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenites,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_status' => $request->property_status,
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'customer_id' => Auth::user()->id, // 
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('customer.all.property')->with([
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function CustomerUpdatePropertyThambnail(Request $request)
    {
        $pro_id = $request->id;
        $oldImage = $request->old_img;
        $image = $request->file('property_thambnail');

        $imgManager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $imgManager->read($image)->resize(370, 250)->save('upload/property/thambnail/' . $name_gen);
        $save_url = 'upload/property/thambnail/' . $name_gen;

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        Property::findOrFail($pro_id)->update([
            'property_thambnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->back()->with([
            'message' => 'Property Thumbnail Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function CustomerUpdatePropertyMultiimage(Request $request)
    {
        $imgs = $request->multi_img;

        if (!$imgs || count($imgs) == 0) {
            return redirect()->back()->with([
                'message' => 'No images were selected for update.',
                'alert-type' => 'warning'
            ]);
        }

        foreach ($imgs as $id => $img) {
            $imgRecord = MultiImage::find($id);
            if (!$imgRecord) {
                continue;
            }

            if ($imgRecord->photo_name && file_exists(public_path($imgRecord->photo_name))) {
                unlink(public_path($imgRecord->photo_name));
            }

            $imgManager = new ImageManager(new Driver());
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            $uploadPath = 'upload/property/multi-image/' . $make_name;
            $imgManager->read($img)->resize(770, 520)->save(public_path($uploadPath));

            $imgRecord->update([
                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Property Multi-Image Updated Successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function CustomerPropertyMultiimgDelete($id)
    {
        $oldImg = MultiImage::findOrFail($id);
        if ($oldImg->photo_name && file_exists(public_path($oldImg->photo_name))) {
            unlink(public_path($oldImg->photo_name));
        }

        $oldImg->delete();

        return redirect()->back()->with([
            'message' => 'Property Multi Image Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function CustomerStoreNewMultiimage(Request $request)
    {
        $propertyId = $request->imageid;
        $image = $request->file('multi_img');

        $make_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $uploadPath = 'upload/property/multi-image/' . $make_name;

        $imgManager = new ImageManager(new Driver());
        $imgManager->read($image)->resize(770, 520)->save(public_path($uploadPath));

        MultiImage::insert([
            'property_id' => $propertyId,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with([
            'message' => 'Property Multi Image Added Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function CustomerUpdatePropertyFacilities(Request $request)
    {
        $pid = $request->id;

        if (empty($request->facility_name)) {
            return redirect()->back()->with([
                'message' => 'No facilities to update.',
                'alert-type' => 'warning'
            ]);
        }

        Facility::where('property_id', $pid)->delete();

        foreach ($request->facility_name as $i => $name) {
            Facility::create([
                'property_id' => $pid,
                'facility_name' => $name,
                'distance' => $request->distance[$i] ?? '',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Property Facility Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function CustomerDeleteProperty($id)
    {
        $property = Property::findOrFail($id);

        // Check ownership
        if ($property->customer_id != Auth::id()) {
            abort(403);
        }
        // Mark it inactive instead of deleting
        $property->status = 0;
        $property->save();

        return redirect()->back()->with('success', 'Property has been marked as inactive.');
    }


    public function CustomerDashboard()
    {
        $customer = Auth::user();
        $propertyCount = \App\Models\Property::where('customer_id', $customer->id)->count();

        return view('customer.customer_dashboard', compact('propertyCount'));
    }

    public function CustomerDetailsProperty($id)
    {

        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_amin = explode(',', $type);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeCustomer = User::where('status', 'active')->where('role', 'customer')->latest()->get();

        return view('customer.property.details_property', compact('property', 'propertytype', 'amenities', 'activeCustomer', 'property_amin', 'multiImage', 'facilities'));
    } // End Method 


}
