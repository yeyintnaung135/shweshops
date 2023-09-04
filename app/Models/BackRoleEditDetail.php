<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackRoleEditDetail extends Model
{
    protected $table = 'backrole_editdetails';

    protected $fillable = [
        'old_name', 'new_name', 'old_phone', 'new_phone', 'old_role_id', 'new_role_id', 'role_id', 'backrole_log_activities_id',
    ];
}
