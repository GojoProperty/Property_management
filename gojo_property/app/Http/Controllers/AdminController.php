<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.adminIndex');
    } // End method

    public function AdminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function AdminLogin()
    {
        return view('admin.admin_login');
    }

    public function AdminProfile()
    {
        $id = Auth::id(); // More optimized way to get the authenticated user ID
        $profileData = User::findOrFail($id); // Ensures an error is thrown if user is not found
        return view('admin.admin_profile_view', compact('profileData'));
    }

    public function AdminProfileStore(Request $request)
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

    public function AdminChangePass()
    {
        $id = Auth::id();
        $profileData = User::findOrFail($id);
        return view('admin.admin_change_pass', compact('profileData'));
    }

    public function AdminUpdatePassword(Request $request)
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
    }
}
