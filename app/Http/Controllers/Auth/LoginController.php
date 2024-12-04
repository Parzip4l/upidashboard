<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login request
    public function login(Request $request)
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

    public function register(Request $request)
    {
        // Validate the registration request
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Create the user with default role 'user'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to the default route for users
        return redirect()->route('proposals.index');
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect('/auth/login')->with('status', 'Successfully logged out.');
    }
}
