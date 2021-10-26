<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureStaffHasAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $staff = $request->user('staff');

        if($staff && $staff->isAdmin()) {
            return $next($request);
        }

        return back()->with([
            'status' => 'You do not have permission to continue with the request'
        ]);
    }
}
