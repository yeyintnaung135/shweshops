<?php
namespace App\Http\Controllers\traid;

use App\Models\discount;
use App\Models\Item;
use App\Models\Shopowner;

trait allshops
{
    public function getallshops()
    {
        $all_shop_id = Shopowner::where('id', '!=', 1)->orderBy('shop_name', 'asc')->get();
        return $all_shop_id;

    }
    public function getshopnamebyid($shop_id){
        $arr=[];
        $shop_name=Shopowner::where('id',$shop_id)->first();
        $arr['mm']=$shop_name->shop_name_myan;
        $arr['en']=$shop_name->shop_name;
        return $arr;

    }
    public function getshopbyid($shop_id){
        $shop=Shopowner::where('id',$shop_id)->first();
        return $shop;

    }
}

?>
