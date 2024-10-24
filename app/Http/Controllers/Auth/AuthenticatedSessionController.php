<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        $request->authenticate();

        $request->session()->regenerate();

        $loggedInUser = $request->user()->role;
        // dd($request->all(), $request->user());
        
        if($loggedInUser != 'student'){
            // user.dashboard
            return redirect()->intended(route($loggedInUser.'.dashboard', absolute: false));
        }
        // if($loggedInUser == 'admin'){
        //     // admin.dashboard
        //     return redirect()->intended(route('admin.dashboard', absolute: false));
        // }elseif ($loggedInUser == 'guardian'){
        //     // guardian.dashboard
        //     return redirect()->intended(route('guardian.dashboard', absolute: false));
        // }elseif ($loggedInUser == 'driver'){
        //     // driver.dashboard
        //     return redirect()->intended(route('driver.dashboard', absolute: false));
        // }

        return redirect()->intended(route($loggedInUser.'.dashboard', absolute: false));
    }

    /**
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
