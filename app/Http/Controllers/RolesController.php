<?php

namespace App\Http\Controllers;

use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Http\Request;
use DB;
class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('created_at', 'DESC')->get();
		
        return view('roles.index', compact('roles'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255|unique:roles,name|sanitizeScripts'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
		
		
        $role = new Role();
        $role->name = $request->input('name');
		$role->slug = $this->slugify($request->input('name'));		
        //pr($role); die;
        $role->save();
        return redirect('roles')->with('success','Role Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        return view('roles.edit')->with('role',$role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|max:255|sanitizeScripts|unique:roles,name,' .$id,
            'status'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $role = Role::find($id);
        $role->name = $request->input('name');
		$role->slug = $this->slugify($request->input('name'));	
        $role->status = $request->input('status');
        $role->save();
        return redirect('roles')->with('success','Role Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect('roles')->with('success', 'Role Deleted.');
    }
	
	public function slugify($string){
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
    }
}
