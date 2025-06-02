<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\Schedule;
use App\Models\PreferenceNotification;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaction;


class UserController extends Controller
{
    public function Index()
    {
        return view('frontend.index');
    }

    public function UserProfile()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('frontend.dashboard.edit_profile', compact('userData'));
    }

    public function UserProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function UserChangePassword()
    {
        return view('frontend.dashboard.change_password');
    }

    public function UserPasswordUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function recommendations()
    {
        $user = Auth::user();
        $notifications = PreferenceNotification::where('user_id', $user->id)
            ->with(['property.type']) // So we can access $notify->property->type->name in the Blade file
            ->latest()->get();
        return view('frontend.dashboard.recommendation', compact('notifications'));
    }
    public function UserScheduleRequest()
    {

        $id = Auth::user()->id;
        $userData = User::find($id);

        $srequest = Schedule::where('user_id', $id)->get();
        return view('frontend.message.schedule_request', compact('userData', 'srequest'));
    } // End Method 


    public function dashboard()
    {
        $userId = Auth::id(); // if you want user-specific stats

        // If for a specific user:
        $approved = Transaction::where('user_id', $userId)->where('status', 'approved')->count();
        $pending = Transaction::where('user_id', $userId)->where('status', 'pending')->count();
        $rejected = Transaction::where('user_id', $userId)->where('status', 'rejected')->count();

        // If for ALL transactions (e.g., admin dashboard), remove ->where('user_id', $userId)

        return view('dashboard', compact('approved', 'pending', 'rejected'));
    }
}
