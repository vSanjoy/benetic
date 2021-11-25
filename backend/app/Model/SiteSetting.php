<?php
/*****************************************************/
# Page/Class name   : SiteSetting
# Purpose           : Table declaration
/*****************************************************/

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public $timestamps = false;
    
    protected $hidden = ['id'];

}