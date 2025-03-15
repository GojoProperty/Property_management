<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;

class AgentController extends Controller
{
    public function AgentDashboard(){
        return view('agent.agent_dashboard');
    } //end method

    public function AgentLogin(){
 
        return view('agent.agent_login');

    } // End Method 


    public function AgentRegister(Request $request){
 
 
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

    }// End Method 
}
