<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopLogActivity extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'shop', 'shop_name', 'user_id', 'user_name', 'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
