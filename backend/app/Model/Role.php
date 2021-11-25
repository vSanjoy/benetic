<?php
/*****************************************************/
# Page/Class name   : Role
# Purpose           : Table declaration
/*****************************************************/

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

	/*****************************************************/
    # Function name : permissions
    # Params        : 
    /*****************************************************/
	public function permissions() {
		return $this->hasMany('App\Model\RolePermission', 'role_id');
	}

	/*****************************************************/
    # Function name : rolePermissionToRolePage
    # Params        : 
    /*****************************************************/
    public function rolePermissionToRolePage()
    {
        return $this->belongsToMany('App\Model\RolePage', 'role_permissions', 'role_id', 'page_id');
    }

}