<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
 public function store(LoginRequest $request): RedirectResponse
{
    // Custom validation inside LoginRequest should still validate 'login' and 'password'
    $request->validate([
        'login' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    // Determine login type: email, phone (numeric), or username
    $loginInput = $request->input('login');

    $login_type = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($loginInput) ? 'phone' : 'username');

    $credentials = [
        $login_type => $loginInput,
        'password' => $request->input('password'),
    ];

    // Attempt login with these credentials
    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
        // Authentication failed: throw validation error
        return back()->withErrors([
            'login' => __('auth.failed'),
        ])->onlyInput('login');
    }

    $request->session()->regenerate();

    $id = Auth::user()->id;
    $adminData = User::find($id);
    $username = $adminData->name;

    // Forget any intended URL to avoid redirection to previous pages you don't want
    session()->forget('url.intended');

    $url = '';

    if ($request->user()->role === 'admin') {
        $url = route('admin.dashboard');
    } elseif ($request->user()->role === 'agent') {
        $url = route('agent.dashboard');
    } else {
        $url = '/dashboard';
    }

    return redirect()->intended($url);
}


    /*
     * Destroy an authenticated session. 
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
