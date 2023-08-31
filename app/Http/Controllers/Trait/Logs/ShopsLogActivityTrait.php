<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\LogActivity;
use App\Models\ShopOwnerLogActivity;
use App\Models\Shops;
use Illuminate\Support\Facades\Auth;

trait ShopsLogActivityTrait
{

    public static function ShopsDeleteLog($action, $shop_id)
    {
        $log = [];
        $log['shop_id'] = $shop_id;
        $log['shop_name'] = Shops::where('id', $log['shop_id'])->value('name');
        $log['item_id'] = $action->id;
        $log['product_code'] = $action->product_code;
        $log['item_name'] = $action->name;
        $log['category'] = $action->category_id;

        $log['user_name'] = Auth::guard('shop_owners_and_staffs')->user()->name;

        $log['action'] = 'Delete';

        $role = Auth::guard('shop_owners_and_staffs')->user()->role_id;
        $roles = [1 => 'admin', 2 => 'manager', 3 => 'staff', 4 => 'shopowner'];
        $log['role'] = $roles[$role] ?? 'unknown';

        ShopOwnerLogActivity::create($log);
    }

    public static function ShopsCreateLog($action, $shop_id)
    {

        $log = [];
        $log['shop_id'] = $shop_id;
        $log['shop_name'] = Shops::where('id', $log['shop_id'])->value('name');
        $log['item_id'] = $action->id;
        $log['product_code'] = $action->product_code;
        $log['item_name'] = $action->name;
        $log['category'] = $action->category_id;
        $log['user_name'] = Auth::guard('shop_owners_and_staffs')->user()->name;
        $log['action'] = 'Create';

        $role = Auth::guard('shop_owners_and_staffs')->user()->role_id;
        $roles = [1 => 'admin', 2 => 'manager', 3 => 'staff', 4 => 'shopowner'];
        $log['role'] = $roles[$role] ?? 'unknown';

        ShopOwnerLogActivity::create($log);
    }

    public static function ShopsEditLog($action, $shop_id)
    {
        $log = [];
        $log['shop_id'] = $shop_id;
        $log['shop_name'] = Shops::where('id', $log['shop_id'])->value('name');
        $log['item_id'] = $action->id;
        $log['product_code'] = $action->product_code;
        $log['item_name'] = $action->name;
        $log['category'] = $action->category_id;
        $log['user_name'] = Auth::guard('shop_owners_and_staffs')->user()->name;
        $log['action'] = 'Edit';

        $role = Auth::guard('shop_owners_and_staffs')->user()->role_id;
        $roles = [1 => 'admin', 2 => 'manager', 3 => 'staff', 4 => 'shopowner'];
        $log['role'] = $roles[$role] ?? 'unknown';

        $shopownerlogid = ShopOwnerLogActivity::create($log);
        return $shopownerlogid;
    }

    public static function ShopsForceDeleteLog($action, $shop_id)
    {
        $log = [];
        $log['shop_id'] = $shop_id;
        $log['shop_name'] = Shops::where('id', $log['shop_id'])->value('name');
        $log['item_id'] = $action->id;
        $log['product_code'] = $action->product_code;
        $log['item_name'] = $action->name;
        $log['category'] = $action->category_id;
        $log['user_name'] = Auth::guard('shop_owners_and_staffs')->user()->name;
        $log['action'] = 'ForceDelete';

        $role = Auth::guard('shop_owners_and_staffs')->user()->role_id;
        $roles = [1 => 'admin', 2 => 'manager', 3 => 'staff', 4 => 'shopowner'];
        $log['role'] = $roles[$role] ?? 'unknown';

        $shopownerlogid = ShopOwnerLogActivity::create($log);
        return $shopownerlogid;
    }

    public static function ShopsLogActivityLists()
    {
        return LogActivity::latest()->get();
    }

}
