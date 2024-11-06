<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisableBackBtn
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
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role_id == '3') {
              
                if ($user->profile_update == 0) {
                    if (!$request->routeIs('profile-edit') && !$request->isMethod('post')) {
                        return redirect()->route('profile-edit', [$user->id]);
                    }
                }
            }
        }

        $response = $next($request);

        // Prevent browser from caching pages
        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2020 00:00:00 GMT');

        return $response;
    }
}
