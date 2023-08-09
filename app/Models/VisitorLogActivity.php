<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLogActivity extends Model
{
    //
    protected $fillable = [
        'user_name', 'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
