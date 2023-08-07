<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MultipleDiscountLogs extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'shop_id','item_id','user_name','user_role','name',
        'product_code', 'old_price','old_min_price','old_max_price','percent',
        'old_discount_price','old_discount_min','old_discount_max','new_discount_price','
        new_discount_min','new_discount_max','deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
