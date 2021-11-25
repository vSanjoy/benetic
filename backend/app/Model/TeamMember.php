<?php
/*****************************************************/
# Page/Class name   : TeamMember
/*****************************************************/

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use SoftDeletes;
}
