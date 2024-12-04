<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $roles = null)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Get the authenticated user's role
        $userRole = Auth::user()->role;

        // If the route requires a role, check if the user has it
        if ($roles) {
            // Split the roles into an array and check if the user's role is in the allowed roles
            $allowedRoles = explode('|', $roles);
            if (!in_array($userRole, $allowedRoles)) {
                return redirect()->back()->with('error', "You don't have access to this page.");
            }
        }

        return $next($request);
    }
}
