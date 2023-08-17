<?php

namespace App\Http\Controllers\Trait;

use Illuminate\Support\Facades\Auth;
use App\Models\Shopowner;
use App\Models\ShopRole;

trait ShopTrait
{
    public function get_current_auth_data()
    {
        return Auth::guard('shop_owners_and_staffs')->user();
    }
    public function get_shop_id()
    {
        $shop_id = $this->get_current_auth_data()->shop_id;

        return $shop_id;
    }
}
