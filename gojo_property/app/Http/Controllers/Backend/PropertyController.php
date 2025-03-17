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
use Illuminate\Support\Facades\Storage;



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
    } // End Method 

    public function storeProperty(Request $request)
    {
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

        // Insert facilities linked to the property
        if (!empty($request->facility_name)) {
            for ($i = 0; $i < count($request->facility_name); $i++) {
                $property->facilities()->create([
                    'facility_name' => $request->facility_name[$i],
                    'distance' => $request->distance[$i],
                ]);
            }
        }

        return redirect()->route('all.property')->with([
            'message' => 'Property Inserted Successfully',
            'alert-type' => 'success'
        ]);
    } // End Method 

    public function editProperty($id) //to keep the data that is gonna be edited
    {
        $property = Property::findOrFail($id);
        $facilities = Facility::where('property_id', $id)->get();
        $type = $property->amenities_id;
        $property_amin = explode(',', $type);
        $multiImage = MultiImage::where('property_id', $id)->get();
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        return view('backend.property.edit_property', compact('property', 'propertytype', 'amenities', 'activeAgent', 'property_amin', 'multiImage', 'facilities'));
    } // End Method 

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
    } // End Method 

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
    } // End Method 

    public function UpdatePropertyMultiimage(Request $request)
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
            if ($imgRecord->photo_name && Storage::exists($imgRecord->photo_name)) {
                Storage::delete($imgRecord->photo_name);
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
    } // End Method 

    public function propertyMultiImageDelete($id)
    {
        $oldImg = MultiImage::find($id);
        if (!$oldImg) {
            return redirect()->back()->with([
                'message' => 'Image not found!',
                'alert-type' => 'error'
            ]);
        }
        if ($oldImg->photo_name && Storage::exists($oldImg->photo_name)) {
            Storage::delete($oldImg->photo_name);
        }
        $oldImg->delete();
        return redirect()->back()->with([
            'message' => 'Property Multi-Image Deleted Successfully!',
            'alert-type' => 'success'
        ]);
    } // End Method 

    public function storeNewMultiimage(Request $request)
    {

        $new_multi = $request->imageid;
        $image = $request->file('multi_img');

        $make_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $uploadPath = 'upload/property/multi-image/' . $make_name;
        $imgManager = new ImageManager(new Driver());
        $imgManager->read($image)->resize(770, 520)->save(public_path($uploadPath));

        MultiImage::insert([
            'property_id' => $new_multi,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Property Multi Image Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 

    public function updatePropertyFacilities(Request $request)
    {
        $pid = $request->id;
        if ($request->facility_name == NULL) {
            return redirect()->back();
        } else {
            Facility::where('property_id', $pid)->delete();
            $facilities = Count($request->facility_name);
            for ($i = 0; $i < $facilities; $i++) {
                $fcount = new Facility();
                $fcount->property_id = $pid;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
            } // end for 
        }
        $notification = array(
            'message' => 'Property Facility Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 
    public function deleteProperty($id)
    {
        $property = Property::findOrFail($id);
        if ($property->property_thambnail && Storage::exists($property->property_thambnail)) {
            Storage::delete($property->property_thambnail);
        }
        $images = MultiImage::where('property_id', $id)->get();
        foreach ($images as $image) {
            if ($image->photo_name && Storage::exists($image->photo_name)) {
                Storage::delete($image->photo_name);
            }
        }
        MultiImage::where('property_id', $id)->delete();
        Facility::where('property_id', $id)->delete();
        $property->delete();

        return redirect()->back()->with([
            'message' => 'Property Deleted Successfully',
            'alert-type' => 'success',
        ]);
    } //End Method

    public function DetailsProperty($id)
    {

        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        return view('backend.property.details_property', compact('property', 'propertytype', 'amenities', 'activeAgent', 'property_ami', 'multiImage', 'facilities'));
    } // End Method 

    public function InactiveProperty(Request $request)
    {
        $pid = $request->id;
        Property::findOrFail($pid)->update([
            'status' => 0,
        ]);
        $notification = array(
            'message' => 'Property Inactive Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.property')->with($notification);
    } // End Method 

    public function ActiveProperty(Request $request)
    {
        $pid = $request->id;
        Property::findOrFail($pid)->update([
            'status' => 1,
        ]);
        $notification = array(
            'message' => 'Property Active Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.property')->with($notification);
    } // End Method 
}
