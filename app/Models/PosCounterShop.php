<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class PosCounterShop extends Model
{
    use SoftDeletes;
    //
    protected $fillable = ['date', 'shop_name', 'shop_owner_id', 'counter_name', 'staff_no', 'address', 'remark', 'state_id', 'terms', 'offdays', 'phno', 'otherno', 'deleted_at'];
    protected $table = 'pos_counter_shops';
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
