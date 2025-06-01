<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        return view('admin.adminIndex');
    } // End method

    public function adminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect('/login');
    }

    public function adminLogin()
    {
        return view('admin.admin_login');
    }

    public function adminProfile()
    {
        $id = Auth::id(); // More optimized way to get the authenticated user ID
        $profileData = User::findOrFail($id); // Ensures an error is thrown if user is not found
        return view('admin.admin_profile_view', compact('profileData'));
    }

    public function adminProfileStore(Request $request)
    {
        $id = Auth::id();
        $data = User::findOrFail($id);

        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // Delete the old photo if it exists
            if ($data->photo && file_exists(public_path('upload/admin_images/' . $data->photo))) {
                @unlink(public_path('upload/admin_images/' . $data->photo));
            }

            $fileName = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $fileName);
            $data->photo = $fileName;
        }

        $data->save();

        return redirect()->back()->with([
            'message' => 'Admin updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function adminChangePassword()
    {
        $id = Auth::id();
        $profileData = User::findOrFail($id);
        return view('admin.admin_change_pass', compact('profileData'));
    }

    public function adminUpdatePassword(Request $request)
    {
        // Validate input
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'confirm_password' => 'required|same:new_password',
        ]);

        // Get the currently authenticated user
        $admin = User::find(Auth::id());


        // Check if the old password matches the current password
        if (!Hash::check($request->old_password, $admin->password)) {
            $notification = array(
                'message' => 'Old password is incorrect.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        // Update the password
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        $notify = array(
            'message' => 'Password updated successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notify);
    } // End Method 

    // Agent User All Method 

    public function AllAgent()
    {
        $allagent = User::where('role', 'agent')->get();
        return view('backend.agentuser.all_agent', compact('allagent'));
    } // End Method 

    public function AddAgent()
    {

        return view('backend.agentuser.add_agent');
    } // End Method 


    public function StoreAgent(Request $request)
    {

        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'status' => 'active',
        ]);


        $notification = array(
            'message' => 'Agent Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.agent')->with($notification);
    } // End Method 
    public function EditAgent($id)
    {

        $allagent = User::findOrFail($id);
        return view('backend.agentuser.edit_agent', compact('allagent'));
    } // End Method 


    public function UpdateAgent(Request $request)
    {

        $user_id = $request->id;

        User::findOrFail($user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);


        $notification = array(
            'message' => 'Agent Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.agent')->with($notification);
    } // End Method 


    public function DeleteAgent($id)
    {

        User::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Agent Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 

    public function changeStatus(Request $request)
    {

        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => 'Status Change Successfully']);
    } // End Method 

}
