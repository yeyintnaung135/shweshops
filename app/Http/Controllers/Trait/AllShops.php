<?php
namespace App\Http\Controllers\Trait;

use App\Models\Shops;

trait AllShops
{
    public function getallshops()
    {
        $all_shop_id = Shops::where('id', '!=', 1)->orderBy('shop_name', 'asc')->get();
        return $all_shop_id;

    }
    public function getshopnamebyid($shop_id)
    {
        $arr = [];
        $shop_name = Shops::where('id', $shop_id)->first();
        $arr['mm'] = $shop_name->shop_name_myan;
        $arr['en'] = $shop_name->shop_name;
        return $arr;

    }
    public function getshopbyid($shop_id)
    {
        $shop = Shops::where('id', $shop_id)->first();
        return $shop;

    }
}
