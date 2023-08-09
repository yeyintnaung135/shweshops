<?php

namespace App\Models;

use App\Models\Shopowner;
use Jenssegers\Mongodb\Eloquent\Model;

class Messages extends Model
{
    protected $collection = 'messages';
    protected $connection = 'mongodb';
    //
//    protected $dates = ['created_at'];

    protected $fillable = ['from_id', 'to_id', 'type', 'from_role', 'to_role', 'message', 'from_name', 'read_by_user', 'message_user_id', 'message_shop_id', 'shop_role'];
    protected $appends = ['ShopName', 'UserName'];

    public function getShopNameAttribute()
    {
        $shop_owner = Shopowner::where('id', $this->message_shop_id)->get();
        return $shop_owner;
    }

    public function getUserNameAttribute()
    {
        $shop_owner = User::where('id', $this->message_user_id)->get();
        return $shop_owner;
    }

}
