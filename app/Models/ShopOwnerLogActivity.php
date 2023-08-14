<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopOwnerLogActivity extends Model
{

    use SoftDeletes;
    protected $table = "shopowner_log_activities";
    protected $fillable = [
        'shop_id', 'shop_name', 'product_code', 'item_id', 'item_name', 'category', 'user_name', 'action', 'role', 'deleted_at',
    ];
}
