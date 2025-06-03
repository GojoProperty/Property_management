<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\Amenities;
use App\Models\PropertyType;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\PackagePlan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\state;
use App\Models\schedule;



class AgentPropertyController extends Controller
{
    public function AgentAllProperty()
    {

        $id = Auth::user()->id;
        $property = Property::where('agent_id', $id)->latest()->get();
        return view('agent.property.all_property', compact('property'));
    } // End Method 

    public function AgentAddProperty()
    {
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $pstate = State::latest()->get();
        $id = Auth::user()->id;
        $property = User::where('role', 'agent')->where('id', $id)->first();
        $pcount = $property->credit;
        // dd($pcount);

        if ($pcount == 1 || $pcount == 7) {
            return redirect()->route('buy.package');
        } else {

            return view('agent.property.add_property', compact('propertytype', 'amenities', 'pstate'));
        }
    } // End Method 

    public function AgentStoreProperty(Request $request)
    {
        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nid = $uid->credit;

        // ✅ Validate all inputs
        $validated = $request->validate([
            'property_name'     => 'required|string|max:255',
            'property_status'   => 'required|in:rent,buy',
            'max_price'         => ['required', 'regex:/^\d{1,3}(,\d{3})*(\.\d{1,2})?$/'], // e.g., 1,000 or 1,000.00
            'property_thambnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'multi_img.*'       => 'image|mimes:jpeg,png,jpg|max:2048',
            'bedrooms'          => 'required|integer|min:0',
            'bathrooms'         => 'required|integer|min:0',
            'address'           => 'required|string|max:255',
            'city'              => 'required|string|max:255',
            'state'             => 'required|exists:states,id',
            'property_size'     => 'required|string|max:50',
            'property_video'    => 'nullable|string|max:255',
            'latitude'          => 'nullable|regex:/^-?\d{1,3}\.\d+$/',
            'longitude'         => 'nullable|regex:/^-?\d{1,3}\.\d+$/',
            'ptype_id'          => 'required|exists:property_types,id',
            'agent_id'          => 'required|exists:users,id',
            'short_descp'       => 'required|string|max:500',
            'long_descp'        => 'required|string|max:5000',
            'amenities_id'      => 'nullable|array',
            'amenities_id.*'    => 'string',
            'facility_name.*'   => 'nullable|string',
            'distance.*'        => 'nullable|string',
        ], [
            'max_price.numeric' => 'Price must be a number.',
            'bedrooms.numeric' => 'Bedrooms must be a number.',
            'bathrooms.numeric' => 'Bathrooms must be a number.',
            'property_thambnail.required' => 'Main thumbnail is required.',
            'short_descp.required' => 'Short description is required.',
            'long_descp.required' => 'Long description is required.',
        ]);

        // Clean and convert price to float (e.g., 1,000.00 => 1000.00)
        $validated['max_price'] = floatval(str_replace(',', '', $validated['max_price']));

        // ✅ Get current user and prepare variables

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
            'agent_id' => Auth::user()->id,
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

        User::where('id', $id)->update([
            'credit' => DB::raw('1+' . $nid),
        ]);

        return redirect()->route('agent.all.property')->with([
            'message' => 'Property Inserted Successfully',
            'alert-type' => 'success'
        ]);
    } // End Method 


    public function AgentEditProperty($id) //to keep the data that is gonna be edited
    {
        $property = Property::findOrFail($id);
        $facilities = Facility::where('property_id', $id)->get();
        $type = $property->amenities_id;
        $property_amin = explode(',', $type);
        $multiImage = MultiImage::where('property_id', $id)->get();
        $pstate = State::latest()->get();
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();


        return view('agent.property.edit_property', compact('property', 'propertytype', 'amenities',  'property_amin', 'multiImage', 'facilities', 'pstate'));
    } // End Method 

    public function AgentUpdateProperty(Request $request)
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
            'agent_id' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('agent.all.property')->with($notification);
    } // End Method 

    public function AgentUpdatePropertyThambnail(Request $request)
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

    public function AgentUpdatePropertyMultiimage(Request $request)
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

    public function AgentPropertyMultiimgDelete($id)
    {

        $oldImg = MultiImage::findOrFail($id);
        unlink($oldImg->photo_name);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Property Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 
    public function AgentStoreNewMultiimage(Request $request)
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

    public function AgentUpdatePropertyFacilities(Request $request)
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

    public function AgentDeleteProperty($id)
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

    public function AgentDetailsProperty($id)
    {

        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_amin = explode(',', $type);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        return view('agent.property.details_property', compact('property', 'propertytype', 'amenities', 'activeAgent', 'property_amin', 'multiImage', 'facilities'));
    } // End Method 


    public function BuyPackage()
    {

        return view('agent.package.buy_package');
    } // End Method 

    public function BuyBusinessPlan()
    {

        $id = Auth::user()->id;
        $data = User::find($id);
        return view('agent.package.business_plan', compact('data'));
    } // End Method


    public function StoreBusinessPlan(Request $request)
    {

        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nid = $uid->credit;

        PackagePlan::insert([

            'user_id' => $id,
            'package_name' => 'Business',
            'package_credits' => '3',
            'invoice' => 'ERS' . mt_rand(10000000, 99999999),
            'package_amount' => '20',
            'created_at' => Carbon::now(),
        ]);

        User::where('id', $id)->update([
            'credit' => DB::raw('3 + ' . $nid),
        ]);



        $notification = array(
            'message' => 'You have purchase Basic Package Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('agent.all.property')->with($notification);
    } // End Method 

    public function BuyProfessionalPlan()
    {

        $id = Auth::user()->id;
        $data = User::find($id);
        return view('agent.package.professional_plan', compact('data'));
    } // End Method  


    public function StoreProfessionalPlan(Request $request)
    {

        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nid = $uid->credit;

        PackagePlan::insert([

            'user_id' => $id,
            'package_name' => 'Professional',
            'package_credits' => '10',
            'invoice' => 'ERS' . mt_rand(10000000, 99999999),
            'package_amount' => '50',
            'created_at' => Carbon::now(),
        ]);

        User::where('id', $id)->update([
            'credit' => DB::raw('10 + ' . $nid),
        ]);



        $notification = array(
            'message' => 'You have purchase Professional Package Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('agent.all.property')->with($notification);
    } // End Method 

    public function PackageHistory()
    {

        $id = Auth::user()->id;
        $packagehistory = PackagePlan::where('user_id', $id)->get();
        return view('agent.package.package_history', compact('packagehistory'));
    } // End Method 

    public function AgentPackageInvoice($id)
    {

        $packagehistory = PackagePlan::where('id', $id)->first();

        $pdf = Pdf::loadView('agent.package.package_history_invoice', compact('packagehistory'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    } // End Method 

    public function AgentScheduleRequest()
    {
        $id = Auth::user()->id;
        $usermsg = Schedule::with(['user', 'property'])
            ->where('agent_id', $id)
            ->get();
        // dd($usermsg->toArray()); 
        return view('agent.schedule.schedule_request', compact('usermsg'));
    } // end method

    public function AgentDetailsSchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('agent.schedule.schedule_details', compact('schedule'));
    } // End Method

    public function AgentUpdateSchedule(Request $request)
    {

        $sid = $request->id;

        Schedule::findOrFail($sid)->update([
            'status' => '1',

        ]);

        $notification = array(
            'message' => 'You have Confirm Schedule Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('agent.schedule.request')->with($notification);
    } // End Method 


}
