<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddToCartClickLog extends Model
{
//    use SoftDeletes;
    protected $fillable = [
        'userorguestid', 'item_id', 'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
