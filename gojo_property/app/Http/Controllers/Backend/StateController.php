<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyType;
use App\Models\State;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use Intervention\Image\Facades\Image;

class StateController extends Controller
{
    public function AllState(){

        $state = State::latest()->get();
        return view('backend.state.all_state',compact('state'));

    } 
     public function AddState(){
        return view('backend.state.add_state');

    } 
    public function StoreState(Request $request){
            if ($request->hasFile('state_image')){
            
            $image = $request->file('state_image');
            $imgmanager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $imgmanager->read($image)->resize(370,250)->save('upload/state/'.$name_gen);
            $save_url = 'upload/state/'.$name_gen; 
           }else { 
            $save_url = null;}
    State::insert([
        'state_name' => $request->state_name,
        'state_image' => $save_url, 
    ]);

     $notification = array(
            'message' => 'State Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.state')->with($notification);
  }
  public function EditState($id){

        $state = State::findOrFail($id);
        return view('backend.state.edit_state',compact('state'));

    }
    public function UpdateState(Request $request){

        $state_id = $request->id;

        if ($request->file('state_image')) {
    $image = $request->file('state_image');
    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    $manager = new ImageManager(new Driver());
    $manager->read($image)->resize(370, 275)->save(public_path('upload/state/' . $name_gen));
    $save_url = 'upload/state/'.$name_gen;

    State::findOrFail($state_id)->update([
        'state_name' => $request->state_name,
        'state_image' => $save_url, 
    ]);

     $notification = array(
            'message' => 'State Updated with Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.state')->with($notification);

        }else{

       State::findOrFail($state_id)->update([
        'state_name' => $request->state_name, 
    ]);

     $notification = array(
            'message' => 'State Updated without Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.state')->with($notification);

        }

    }
    public function DeleteState($id){

        $state = State::findOrFail($id);
        $img = $state->state_image;

        State::findOrFail($id)->delete();

         $notification = array(
            'message' => 'State Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }
}