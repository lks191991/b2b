<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permission_role';

    /**
     * Get the role.
     */
    public function role()
    {
        return $this->belongsTo('jeremykenedy\LaravelRoles\Models\Role', 'role_id', 'id');
    }

    /**
     * Get the permission.
     */
    public function permission()
    {
        return $this->belongsTo('jeremykenedy\LaravelRoles\Models\Permission', 'permission_id', 'id');
    }
}
