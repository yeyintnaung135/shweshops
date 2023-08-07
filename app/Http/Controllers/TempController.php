<?php

namespace App\Http\Controllers;

use App\Models\discount;
use App\Models\Item;
use App\Models\Shopowner;
use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TempController extends Controller
{
    //
    public function see_all_cato(){
        //for new item every shop
        //get all distinct shopid from table
        $new_items = DB::table('items')->select('shop_id')->distinct()->get();

        $get_by_shopid = [];
//        loop and retrive data by shop id greater than last 10 day
        $count = 0;
        foreach ($new_items as $ni) {
            if ($count > 19) {
                break;
            } else {
                $tmpgbsid = Item::where('shop_id', $ni->shop_id)->whereDate('created_at', '>', Carbon::today()->subDay(20))->limit(4)->get();
                foreach ($tmpgbsid as $tmpsid) {
                    array_push($get_by_shopid, $tmpsid);
                }
                $count += count($tmpgbsid);
            }

        }
        //randomize result
        $get_by_shopid = collect($get_by_shopid)->shuffle()->values();
        //randomize result

        //for all cat count
        $all = Item::where('id', '!=', 0)->get();

        $allcatcount = collect($all)->countBy('category_id')->all();
        $catlist = ['hair_clip', 'comb', 'hair_pin', 'headband', 'necklace', 'bayat', 'pendant', 'earring', 'nrrswel', 'brooch', 'ring', 'braceket', 'hand_chain', 'pixiu', 'footchain'];

        foreach ($catlist as $c) {
            if (empty($allcatcount[$c])) {
                $allcatcount[$c] = 0;
            }
        }
        //for all cat count

        //values function is beacause filter retrun {{}} but i need [{}]
        $remove_discount_new = collect($get_by_shopid)->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->values();

        $pop = Item::whereDate('created_at', '>', Carbon::today()->subDay(30))->orderBy('view_count', 'desc')->limit(20)->get();

        $remove_discount_pop = collect($pop)->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->values();

        //for all cat count
        $all = Item::where('id', '!=', 0)->get();
        $allcatcount = collect($all)->countBy('category_id')->all();
        $catlist = ['hair_clip', 'comb', 'hair_pin', 'headband', 'necklace', 'bayat', 'pendant', 'earring', 'nrrswel', 'brooch', 'ring', 'braceket', 'hand_chain', 'pixiu', 'footchain'];

        foreach ($catlist as $c) {
            if (empty($allcatcount[$c])) {
                $allcatcount[$c] = 0;
            }
        }
        $col_count = Collection::where('id', '!=', 0)->get();
        $collection_item = Item::orderBy('name', 'desc')->where('collection_id','!=',0)->groupBy('collection_id')->limit(20)->get();
        //for all cat count
        $shops = Shopowner::orderBy('created_at', 'desc')->limit(20)->get();
        $discount = discount::orderBy('created_at', 'desc')->limit(20)->get();

        return view('front.temp.see_all_cato', ['collection_items'=>$collection_item,'col_count' => $col_count,'allcatcount' => $allcatcount, 'catlist' => $catlist, 'new_items' => $remove_discount_new, 'pop_items' => $remove_discount_pop, 'shops' => $shops, 'discount' => $discount]);

    }
    

}
