<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;
use App\Models\Property;
use Carbon\Carbon;


class AgentController extends Controller
{
    public function AgentDashboard()
    {

        return view('agent.index');
    } //end method

    public function AgentRegisterForm()
    {

        return view('agent.agent_register');
    } // End Method 


    public function AgentRegister(Request $request)
    {


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'status' => 'inactive',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(Config::get('constants.AGENT'));
    } // End Method 


    public function AgentLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    } // End Method 



    public function AgentProfile()
    {

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('agent.agent_profile_view', compact('profileData'));
    } // End Method 


    public function AgentProfileStore(Request $request)
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
            @unlink(public_path('upload/agent_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/agent_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Agent Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 


    public function AgentChangePassword()
    {

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('agent.agent_change_password', compact('profileData'));
    } // End Method 


    public function AgentUpdatePassword(Request $request)
    {

        // Validation 
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'

        ]);

        /// Match The Old Password

        if (!Hash::check($request->old_password, auth::user()->password)) {

            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        }

        /// Update The New Password 

        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)

        ]);

        $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    } // End Method 

    public function Dashboard()
    {
        $now = Carbon::now();

        // Define time periods
        $lastMonth = $now->copy()->subMonth();
        $twoMonthsAgo = $now->copy()->subMonths(2);

        // Count new properties added in the last month
        $newPropertiesCount = Property::where('created_at', '>=', $lastMonth)->count();

        // Count properties added in the previous month (for comparison)
        $previousPropertiesCount = Property::whereBetween('created_at', [$twoMonthsAgo, $lastMonth])->count();

        // Calculate percentage change safely
        if ($previousPropertiesCount > 0) {
            $percentChange = (($newPropertiesCount - $previousPropertiesCount) / $previousPropertiesCount) * 100;
        } else {
            $percentChange = 100; // Default to 100% increase if no previous data
        }

        // Prepare weekly data for graph: count of new properties per week for last 4 weeks
        $weeklyData = Property::selectRaw('YEARWEEK(created_at, 1) as yearweek, COUNT(*) as count')
            ->where('created_at', '>=', $now->copy()->subWeeks(4))
            ->groupBy('yearweek')
            ->orderBy('yearweek')
            ->get()
            ->pluck('count')
            ->toArray();

        // Pad the weekly data array with zeros if less than 4 weeks
        while (count($weeklyData) < 4) {
            array_unshift($weeklyData, 0);
        }

        // Pass data to the dashboard view
        return view('agent.index', compact('newPropertiesCount', 'percentChange', 'weeklyData'));
    }
}
