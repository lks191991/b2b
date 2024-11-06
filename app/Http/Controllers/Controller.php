<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	protected function checkPermissionMethod($p)
    {
		$user = auth()->user();
		$role = $user->role;
		if($user->role_id == '1'){
			return 1;
		}else { 
		$permission = $user->hasPermission($p, $role);
		if(!empty($permission)){
			return 1;
		} else {
			return abort(403, 'Unauthorized');;
		}
		}
		
		
    }
}
