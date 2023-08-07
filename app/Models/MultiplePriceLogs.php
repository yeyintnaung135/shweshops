<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MultiplePriceLogs extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'shop_id','item_id','user_name','user_role',
        'name','product_code', 'old_price','new_price',
        'min_price','max_price','new_min_price','new_max_price','user_id','deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
