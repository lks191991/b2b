<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\PermissionRole;
use Auth;

class PermissionRoleController extends Controller
{

    private $roleModel;

    private $permissionModel;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $permissions = Permission::get();
        $counts = $permissions->count();

        //$roles = Role::where('slug', '!=', 'admin')->get();
		$roles = Role::get();
        $role_perm = PermissionRole::orderBy('created_at', 'asc')->get();

        $active_perm = array();
        foreach ($role_perm as $rp) {
            $active_perm[$rp->role_id][$rp->permission_id] = 1;
        }

        $perms = array();
        foreach ($permissions as $p) {
            $slug = explode('.', $p->slug);
            $sub_module = $slug[0];
            $action = $slug[1];
            $perms[$p->model][$p->slug] = $p;
        }


        return view('permission.index', compact('perms', 'counts', 'active_perm', 'roles'));
    }

    /**
     * Store/update permissions for roles in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request)
    {

        $inputs = $request->all();

        PermissionRole::truncate();

        if (isset($inputs['perm'])) {
            $permissions = $inputs['perm'];

            foreach ($permissions as $roleId => $perm) {
                foreach ($perm as $perm_id => $perm_slug) {
                    /* permission attached to a role */
                    $role = Role::find($roleId);
                    $role->attachPermission($perm_id);
                }
            }
        }

        return redirect('/permissions')->with('success', "Permissions has been saved successfully.");
    }
}
