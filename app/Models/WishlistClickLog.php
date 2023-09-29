<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistClickLog extends Model
{
    //
    protected $table="wishlist_click_logs";
    protected $fillable = [
        'userorguestid', 'item_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
