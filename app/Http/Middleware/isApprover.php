<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;

class isApprover
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_role = Role::find(auth()->user()->role_id);

        if (!($user_role->slug === Role::APPROVER)) {
            return redirect()->route('home');
        };

        return $next($request);
    }
}
