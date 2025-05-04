<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class profileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Make sure we have a user
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Determine role based on user type
        $role = '';
        if ($user->role == 'donor') {
            $role = 'donor';
        } else if ($user->role == 'donation_centre') {
            $role = 'donationCenter';
        } else if ($user->role == 'admin') {
            $role = 'admin';
        }
        
        if($user->profile_status == 'complete') {
            return redirect()->route($role . '.dashboard')->with('message', 'Please complete your profile before proceeding.');
        }
        
        return $next($request);
    }
}
