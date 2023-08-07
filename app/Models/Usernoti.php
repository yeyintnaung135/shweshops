<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usernoti extends Model
{
    //
    protected $fillable=['sender_shop_id','receiver_user_id','user_type','item_id','message','read_by_receiver'];
    public $table='user_noti';
    protected $appends = ['WithoutspaceShopname'];

    public function getWithoutspaceShopnameAttribute()
    {
        $shop_name_for_space = Shopowner::where('id', $this->sender_shop_id)->first();
        $shopurl='deleted shop';
        if(!empty($shop_name_for_space)){
            if(!empty($shop_name_for_space->shop_name_url)) {
                $shopurl = $shop_name_for_space->shop_name_url;
            } else {
                $shopurl = str_replace(' ', '', $shop_name_for_space->shop_name);
            }
        }

        return $shopurl;
    }
}
