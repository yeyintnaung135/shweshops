<?php

namespace App\Http\Controllers\traid;

use Illuminate\Support\Facades\Auth;
use App\Models\Shopowner;
use App\Models\ShopRole;

trait ShopTrait
{
    public function getShopId()
    {
        $shopId = Auth::guard('shop_owner')->check()
            ? Shopowner::find(Auth::guard('shop_owner')->id())->id
            : ShopRole::find(Auth::guard('shop_role')->id())->shop_id;

        return $shopId;
    }
}
