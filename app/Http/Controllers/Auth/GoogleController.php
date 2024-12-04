<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'profile_picture' => $googleUser->avatar, // Save the Google profile picture URL
                ]);
                
                Auth::login($user);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'profile_picture' => $googleUser->avatar,
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt('hilirisasiupi'),
                    'role' => 'user',
                ]);
                Auth::login($user);
            }

            // Redirect based on role
            if ($user->role == 'admin') {
                return redirect('/dashboard');
            } elseif ($user->role == 'user') {
                return redirect()->route('proposals.index');
            }

            // Default redirect
            return redirect('/dashboard');
        } catch (\Exception $e) {
            // Handle exception
            return redirect('/dashboard')->with('error', 'Failed to login with Google.');
        }
    }

    public function loginData(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to login
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            // Authentication passed, redirect based on role
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect('/dashboard');
            } elseif ($user->role == 'user') {
                return redirect()->route('proposals.index');
            }

            // Default redirect
            return redirect('/dashboard');
        }

        // Authentication failed, redirect back with error
        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/auth/login')->with('status', 'Successfully logged out.');
    }
}
