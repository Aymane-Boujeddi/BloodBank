<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        return $this->redirectBasedOnRole($user->role);
    }

    /**
     * Redirect the user based on their role.
     * 
     * @param string $role
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole($role)
    {
        $message = 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.';
        
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('error', $message);
            
            case 'donor':
                return redirect()->route('donor.dashboard')->with('error', $message);
            
            case 'donation_centre':
                return redirect()->route('donationCenter.dashboard')->with('error', $message);
                
            default:
                return redirect('/')->with('error', $message);
        }
    }
}


