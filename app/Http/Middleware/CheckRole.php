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
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string   $roles  Comma-separated list of allowed roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $roles)
    {
        $user = Auth::user();
        if (! $user) {
            abort(403, 'Not authenticated');
        }

        $allowed = explode(',', $roles);
        // Assuming your User model has a 'role' attribute
        if (! in_array($user->role, $allowed)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}