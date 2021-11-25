<?php
/*****************************************************/
# Page/Class name   : Benefit
/*****************************************************/

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Benefit extends Model
{
    use SoftDeletes;

    /*****************************************************/
  	# Function name : pageDetails
  	# Params        : 
  	/*****************************************************/
  	public function pageDetails() {
		return $this->belongsTo('App\Model\Cms', 'cms_page_id');
	}
}
