<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperadminLogActivity extends Model
{
    //
    protected $table = 'superadmin_log_activities';
    protected $fillable = [
        'name','type','type_name','type_id','status','role','role_id',
    ];
}
