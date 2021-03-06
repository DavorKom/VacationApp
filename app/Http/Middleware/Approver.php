<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;

class Approver
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
        $user = auth()->user();

        if ($user->role->slug === Role::ADMIN) {
            return $next($request);
        }

        if ($user->role->slug === Role::APPROVER) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
