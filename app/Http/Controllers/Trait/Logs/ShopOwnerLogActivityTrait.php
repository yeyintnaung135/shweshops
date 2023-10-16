<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\Gems;
use App\Models\Item;
use App\Models\ItemsEditDetailLogs;
use App\Models\LogActivity;
use App\Models\ShopOwnerLogActivity;
use App\Models\Shops;
use Illuminate\Support\Facades\Auth;

trait ShopOwnerLogActivityTrait
{

    public static function shop_owner_item_delete_log($action, $shop_id)
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

    public static function shop_owner_item_create_log($action, $shop_id)
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

    public static function shop_owner_item_edit_log($action, $shop_id)
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

    public function save_items_edit_detail_logs($current_item, $change, $shopownerlogid, $old_gem, $id, $tags)
    {
        $new_gem = Gems::where('item_id', $id)->first();
        $new_tags = $tags;
        $item_newtag = Item::where('id', $id)->first();
        $item_newtagarray = explode(',', $item_newtag->tags);

        $item_newtag_collection = collect($item_newtagarray);
        $new_output = $item_newtag_collection->implode(',');

        $changes = $change->getChanges();

        $items_edit_detail_logs = new ItemsEditDetailLogs();
        $items_edit_detail_logs->tags = $new_output;
        $items_edit_detail_logs->new_tags = $new_tags !== $new_output ? $new_tags : null;
        $items_edit_detail_logs->gems = $old_gem->gems;
        $items_edit_detail_logs->new_gems = $old_gem !== $new_gem ? $new_gem->gems : null;

        $itemPhotos = [
            'photo_one', 'photo_two', 'photo_three', 'photo_four',
            'photo_five', 'photo_six', 'photo_seven', 'photo_eight',
            'photo_nine', 'photo_ten', 'default_photo',
        ];

        foreach ($itemPhotos as $photo) {
            $items_edit_detail_logs->{$photo} = $current_item->{$photo};
            $items_edit_detail_logs->{'new_' . $photo} = $current_item->{$photo} === $change->{$photo} ? '-----' : 'images changes';
        }

        $itemFields = [
            'name', 'price', 'description', 'product_code', 'gold_quality', 'gold_colour',
            'min_price', 'max_price', 'review', 'stock', 'stock_count', 'diamond',
            'carat', 'yati', 'gender', 'handmade', 'pwint', 'd_gram',
            'category_id', 'view_count', 'charge', 'collection_id',
        ];

        foreach ($itemFields as $field) {
            if (isset($changes[$field])) {
                $items_edit_detail_logs->{$field} = $current_item->{$field};
                $items_edit_detail_logs->{'new_' . $field} = $current_item->{$field} === $change->{$field} ? '-----' : $changes[$field];
            }
        }

        // $items_edit_detail_logs->sizing_guide = $old['sizing_guide'];
        // $items_edit_detail_logs->new_sizing_guide = $changes ? $changes['sizing_guide'] : '-----';
        // $items_edit_detail_logs->weight_unit = $old['weight_unit'];
        // $items_edit_detail_logs->new_weight_unit = $changes ? $changes['weight_unit'] : '-----';

        $itemFieldsForLoss = [
            'undamage' => 'undamaged_product',
            'expensive_thing' => 'valuable_product',
            'damage' => 'damaged_product',
            'weight' => 'weight',
        ];

        foreach ($itemFieldsForLoss as $field => $oldField) {
            $items_edit_detail_logs->{$field} = $current_item->{$oldField};
            $items_edit_detail_logs->{'new_' . $field} = $current_item->{$oldField} === $change->{$oldField} ? '-----' : $changes[$oldField];
        }

        $items_edit_detail_logs->user_id = $current_item->user_id;
        $items_edit_detail_logs->shop_id = $current_item->shop_id;
        $items_edit_detail_logs->shopownereditlogs_id = $shopownerlogid->id;
        $items_edit_detail_logs->save();
    }

    public static function shop_owner_item_force_delete_log($action, $shop_id)
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
