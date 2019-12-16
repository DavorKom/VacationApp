<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;

class IsAdmin
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

        if(!$user_role->slug === Role::ADMIN){
            return redirect('home');
        };

        return $next($request);
    }
}
