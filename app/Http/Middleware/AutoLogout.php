<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

         // Check if the user is logged in as a customer
         if (Auth::guard('customer')->check()) {
            $lastActivity = session('last_activity');

            // If last activity time is more than 5 minutes (300 seconds) ago, log out
            if ($lastActivity && now()->diffInSeconds($lastActivity) > 3600) {
                // Log out the user
                Auth::guard('customer')->logout();

                // Forget the customer and last activity session
                session()->forget(['customer', 'last_activity']);

                // Redirect to login page with a timeout message
                return redirect()->route('customer.login')->withErrors(['message' => 'You have been logged out due to inactivity.']);
            }

            // Update last activity time
            session(['last_activity' => now()]);
        }
        return $next($request);
    }
}
