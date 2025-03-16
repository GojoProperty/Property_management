<?php

namespace App\Http\Controllers\Backend;

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
use Illuminate\Support\Facades\Log;


$imgmanager = new ImageManager(new Driver());

class PropertyController extends Controller
{
    public function getAllProperty()
    {
        $property = Property::latest()->get();
        return view('backend.property.all_property', compact('property'));
    }

    public function addProperty()
    {
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();
        return view('backend.property.add_property', compact('propertytype', 'amenities', 'activeAgent'));
    }

    public function storeProperty(Request $request)
    {

        /* $amen = $request->amenities_id;
        //$amen = $amen ?? []; // If $amen is null, assign an empty array
        $amenites = implode(",", $amen);
        $pcode = IdGenerator::generate(['table' => 'properties', 'field' => 'property_code', 'length' => 5, 'prefix' => 'PC']);
        $image = $request->file('property_thambnail');
        if ($image) {
            $imgmanager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $imgmanager->read($image)->resize(370, 250)->save('upload/property/thambnail/' . $name_gen);
            $save_url = 'upload/property/thambnail/' . $name_gen;
        } else {
            $save_url = null; // Handle case where no image is uploaded
        }
        $property_id = Property::insertGetId([

            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenites,
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
            //'postal_code' => $request->postal_code,
            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => $request->agent_id,
            'status' => 1,
            'property_thambnail' => $save_url,
            'created_at' => Carbon::now(),
        ]); */
        $amenities = implode(",", $request->amenities_id ?? []);

        $pcode = IdGenerator::generate([
            'table' => 'properties',
            'field' => 'property_code',
            'length' => 5,
            'prefix' => 'PC'
        ]);

        if ($request->hasFile('property_thambnail')) {
            $image = $request->file('property_thambnail');
            $imgManager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $imgManager->read($image)->resize(370, 250)->save('upload/property/thambnail/' . $name_gen);
            $save_url = 'upload/property/thambnail/' . $name_gen;
        } else {
            $save_url = null;
        }

        // **Create property and get the inserted model**
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
            'agent_id' => $request->agent_id,
            'status' => 1,
            'property_thambnail' => $save_url,
        ]);

        // **Upload multiple images and attach to property**
        if ($request->hasFile('multi_img')) {
            foreach ($request->file('multi_img') as $img) {
                //dd($request->file('multi_img'));
                $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
                $imgManager->read($img)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
                $uploadPath = 'upload/property/multi-image/' . $make_name;

                $property->multiImages()->create([
                    'photo_name' => $uploadPath,
                ]);
            }
        }
        /* $images = $request->file('multi_img');
        if (!is_array($images)) {
            $images = [$images]; // Ensure it's an array
        }
        foreach ($images as $img) {

            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            $imgmanager->read($img)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
            $uploadPath = 'upload/property/multi-image/' . $make_name;

            MultiImage::insert([

                'property_id' => $property_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),

            ]);
        }*/

        // **Insert facilities linked to the property**
        if (!empty($request->facility_name)) {
            for ($i = 0; $i < count($request->facility_name); $i++) {
                $property->facilities()->create([
                    'facility_name' => $request->facility_name[$i],
                    'distance' => $request->distance[$i],
                ]);
            }
        }
        // Redirect with success message
        return redirect()->route('all.property')->with([
            'message' => 'Property Inserted Successfully',
            'alert-type' => 'success'
        ]);
    }

    /*$facilities = Count($request->facility_name);

        if ($facilities != NULL) {
            for ($i = 0; $i < $facilities; $i++) {
                $fcount = new Facility();
                $fcount->property_id = $property_id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
            }
        }
        $notification = array(
            'message' => 'Property Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);
    }*/
    public function editProperty($id) //to keep the data that is gonna be edited
    {

        $property = Property::findOrFail($id);
        $type = $property->amenities_id;
        $property_amin = explode(',', $type);
        $multiImage = MultiImage::where('property_id', $id)->get();
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        return view('backend.property.edit_property', compact('property', 'propertytype', 'amenities', 'activeAgent', 'property_amin', 'multiImage'));
    }
    public function updateProperty(Request $request)
    {

        $amen = $request->amenities_id;
        $amen = $amen ?? []; // If $amen is null, assign an empty array
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
            //'postal_code' => $request->postal_code,

            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => $request->agent_id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);
    }
    public function updatePropertyThambnail(Request $request)
    {

        $pro_id = $request->id;
        $oldImage = $request->old_img;
        $image = $request->file('property_thambnail');
        $imgmanager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $imgmanager->read($image)->resize(370, 250)->save('upload/property/thambnail/' . $name_gen);
        $save_url = 'upload/property/thambnail/' . $name_gen;

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        Property::findOrFail($pro_id)->update([

            'property_thambnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Property Image Thambnail Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
