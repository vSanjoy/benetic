<?php
/*****************************************************/
# Page/Class name   : RolePermission
# Purpose           : Table declaration, get role page details
/*****************************************************/

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
  	public $timestamps = false;

  	/*****************************************************/
  	# Function name : page
  	# Params        : 
  	/*****************************************************/
  	public function page() {
		return $this->belongsTo('App\Model\RolePage', 'page_id');
	}
}