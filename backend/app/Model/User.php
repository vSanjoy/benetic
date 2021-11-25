<?php
/*****************************************************/
# Page/Class name   : User
# Purpose           : Table declaration
/*****************************************************/

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*****************************************************/
    # Function name : setPasswordAttribute
    # Params        : $pass
    /*****************************************************/
    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = \Hash::make($pass);
    }

    /*****************************************************/
    # Function name : getFirstNameAttribute
    # Params        : $firstName
    /*****************************************************/
    public function getFirstNameAttribute($firstName)
    {
        return ucfirst($firstName);
    }

    /*****************************************************/
    # Function name : role
    # Params        : 
    /*****************************************************/
    public function role() {
        return $this->belongsTo('App\Model\Role', 'role_id');
    }

    /*****************************************************/
    # Function name : checkRolePermission
    # Params        : 
    /*****************************************************/
    public function checkRolePermission() {
        return $this->belongsTo('App\Model\Role', 'role_id')->where('is_admin','1');
    }

    /*****************************************************/
    # Function name : allRolePermissionForUser
    # Params        : 
    /*****************************************************/
    public function allRolePermissionForUser() {
        return $this->hasMany('App\Model\RolePermission', 'role_id', 'role_id');
    }

    /*****************************************************/
    # Function name : userRoles
    # Params        : 
    /*****************************************************/
    public function userRoles()
    {
        return $this->belongsToMany('App\Model\Role', 'App\Model\UserRole', 'user_id', 'role_id');
    }

}
