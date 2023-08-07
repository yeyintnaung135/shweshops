<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhislistClickLog extends Model
{
    //
    protected $fillable = [
        'userorguestid','item_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
