<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\AllShops;
use App\Models\Item;
use App\Models\ShopOwnersAndStaffs;
use App\Models\Shops;
use Illuminate\Support\Facades\Auth;

class FrontShopController extends Controller
{
    use AllShops;

    //
//see all for cat by shop
    public function see_all($shop_name, $cat_name, $shop_id)
    {

        $data = Item::where([['shop_id', '=', $shop_id], ['category_id', '=', $cat_name]])->limit('20')->get();
        if (count($data) == 0) {
            abort(404);
        }

        $all_shop_id = Shops::where('id', '!=', 1)->orderBy('shop_name', 'asc')->get();
        // $all_shop_id = Shops::where('id', '!=', 1)->orderBy('created_at', 'desc')->get();

        // for account
        if (isset(Auth::guard('shop_owners_and_staffs')->user()->id)) {
            $shop_user = ShopOwnersAndStaffs::where('id', Auth::guard('shop_owners_and_staffs')->user()->id)->pluck('shop_id');
            $shop = Shops::where('id', $shop_user)->orderBy('created_at', 'desc')->get();
        }

        return view('front.forcat_shop', ['data' => $data, 'cat_id' => $cat_name, 'shop_data' => $this->getshopbyid($shop_id), 'shop_ids' => $all_shop_id]);

        // return $get_by_shopid;

    }
//see all for cat by shop

    public function view_more_ajax($limit)
    {
        $shop = Shops::orderBy('id', 'desc')->skip($limit)->take(20)->get();
        if (count($shop) < 20) {
            $emptyonserver = 1;
        } else {
            $emptyonserver = 0;
        }
        return response()->json([$shop->shuffle()->values(), count($shop), $emptyonserver]);

    }
    public function get_popitems_forshop_ajax($latest, $shop_id)
    {

        $latestviewcount = Item::where('id', $latest)->first()->view_count;

        $pop_items = Item::where([['view_count', '=', $latestviewcount], ['shop_id', '=', $shop_id]])->limit(20)->get();
        if (count($pop_items) != 0) {
            $pop_items = Item::Where([['view_count', '=', $latestviewcount], ['shop_id', '=', $shop_id], ['shop_id', '=', $shop_id], ['id', '>', $latest]])->orWhere([['view_count', '<', $latestviewcount], ['shop_id', '=', $shop_id], ['id', '!=', $latest]])->orderBy('view_count', 'desc')->limit(20)->get();

        } else {
            $pop_items = Item::Where([['view_count', '<', $latestviewcount], ['shop_id', '=', $shop_id], ['id', '!=', $latest]])->orderBy('view_count', 'desc')->limit(20)->get();

        }

        $remove_discount_pop = collect($pop_items)->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->values();

        //        for seeall button check if data has in database
        $checkhas_item = Item::Where([['view_count', '=', collect($remove_discount_pop)->last()->view_count], ['id', '>', collect($remove_discount_pop)->last()->id]])->orWhere([['view_count', '<', collect($remove_discount_pop)->last()->view_count], ['id', '!=', collect($remove_discount_pop)->last()->id]])->get();
        $remove_discount_checkhas_item = collect($checkhas_item)->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->values();
        //        for seeall button

        return response()->json([$remove_discount_pop, count($remove_discount_checkhas_item)]);

    }
    public function get_newitems_forshop_ajax($limit, $shop_id)
    {

        $getitems = Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')->where('items.shop_id', $shop_id)->where('discount.item_id', '=', null)->orderBy('items.id', 'desc')->skip($limit)->take(20)->get();

        return response()->json($getitems);

    }

}
