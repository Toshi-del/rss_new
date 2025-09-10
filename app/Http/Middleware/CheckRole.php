<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Support composite "staff" role and multi-role syntax like "role:a|b|c" or "role:a,b,c"
        $allowedRoles = [];

        if ($role === 'staff') {
            $allowedRoles = ['admin', 'doctor', 'nurse', 'radtech', 'radiologist', 'ecgtech', 'plebo', 'pathologist'];
        } elseif (str_contains($role, '|')) {
            $allowedRoles = explode('|', $role);
        } elseif (str_contains($role, ',')) {
            $allowedRoles = array_map('trim', explode(',', $role));
        } else {
            $allowedRoles = [$role];
        }

        $isAuthorized = in_array($user->role, $allowedRoles, true);

        if (!$isAuthorized) {
            abort(403, 'Unauthorized access. You do not have permission to access this page.');
        }

        return $next($request);
    }
}
