<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackRoleLogActivity extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'shop_id', 'user_name', 'user_role', 'action', 'name', 'role', 'old_name', 'new_name', 'deleted_at',
    ];

}
