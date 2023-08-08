<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopDirectory extends Model
{
    //
    protected $table = 'shop_directory';
    protected $fillable = ['shop_name', 'shop_name_url', 'shop_name_myan', 'main_phone', 'additional_phones', 'state', 'township', 'address', 'shop_logo', 'facebook_link', 'website_link', 'shop_id'];
    public function getWithoutspaceShopnameAttribute()
    {

        $shopurl = str_replace(' ', '', $this->shop_name);

        return $shopurl;
    }
}
