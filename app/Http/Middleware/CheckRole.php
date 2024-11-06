<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
	public function handle($request, Closure $next, $role)
	{
		if (!auth()->check()) {
			return redirect('login');
		}

		$userRole = auth()->user()->role_id;

		// Assuming role_id 1 is for admin and role_id 2 is for user
		if ($userRole != $role) {
			// Customize the redirect based on the role
			if ($userRole == 1) {
				return redirect('/dashboard');
			} elseif ($userRole == 2) {
				return redirect('/user/dashboard');
			} else {
				// If none of the specified roles match, you can redirect to a default page or abort
				abort(403, 'Unauthorized action.');
			}
		}

		return $next($request);
	}

}
