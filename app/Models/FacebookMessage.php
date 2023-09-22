<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookMessage extends Model
{
    //
    protected $table = 'fb_messenger_click_log';
    protected $fillable = ['user_fb_id', 'shop_id', 'user_id', 'item_id'];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
