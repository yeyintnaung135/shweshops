<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrontUserLogs extends Model
{
    //
    protected $table = 'front_user_logs';
    protected $fillable = ['userorguestid', 'visited_link', 'product_id', 'shop_id', 'status', 'ads_id'];

    public function shop()
    {
        return $this->belongsTo(Shops::class, 'shop_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'product_id');
    }

    public function guest_or_user()
    {
        return $this->belongsTo(GuestOrUserId::class, 'userorguestid');
    }
}
