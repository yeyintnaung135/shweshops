<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MultipleDamageLogs extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'shop_id', 'item_id', 'user_name', 'product_code', 'user_role', 'name',
        'decrease', 'fee', 'undamage', 'damage', 'expensive_thing', 'new_decrease',
        'new_fee', 'new_undamage', 'new_damage', 'new_expensive_thing', 'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
