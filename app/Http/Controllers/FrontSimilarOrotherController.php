<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Shopowner;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\traid\similarlogic;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class FrontSimilarOrotherController extends Controller
{
    //
    use similarlogic;

    function similar_by_cat($shop_name, $cat,$itemid,$shop_id)
    {

        if($shop_name == 'other_shops'){
            $other_or_no='empty';
        }else{
            $other_or_no=$shop_id;
        }
       ;

       // for account
       if(isset(Auth::guard('shop_owner')->user()->id)){
        $shopowner_acc = Shopowner::where('id', Auth::guard('shop_owner')->user()->id)->orderBy('created_at', 'desc')->get();
        }else if(isset(Auth::guard('shop_role')->user()->id)){
            $manager = Manager::where('id', Auth::guard('shop_role')->user()->id)->pluck('shop_id');
            $shopowner_acc = Shopowner::where('id',$manager)->orderBy('created_at', 'desc')->get();
        }

        if ($other_or_no == 'empty') {
            $forselected = 'all';
            $additional = $shop_id;
            $all_shop_id = Shopowner::where('id', '!=', $shop_id)->orderBy('shop_name', 'asc')->get();
            $items = Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')->where(function ($query) use ($itemid){$query->whereRaw($this->getsimilarsqlcode($itemid));})->where('items.shop_id', '!=', $shop_id)->where('items.category_id', $cat)->orderByRaw("CASE
                        WHEN discount.discount_price = 0 THEN discount.discount_min
            WHEN discount.discount_price !=  0 THEN discount.discount_price
            WHEN items.price=0 THEN min_price
            WHEN items.price!=0 THEN price
            END
            ASC")->limit(40)->get();

            if(isset(Auth::guard('shop_owner')->user()->id)){
            return view('front.similar_items.bycat_other_shop', ['shopowner_acc' => $shopowner_acc,'additional' => $additional, 'data' => $items, 'cat_id' => $cat, 'shop_ids' => $all_shop_id, 'selected_shop' => $forselected,'item_id'=>$itemid]);
             }elseif(isset(Auth::guard('shop_role')->user()->id)){
            return view('front.similar_items.bycat_other_shop', ['shopowner_acc' => $shopowner_acc,'additional' => $additional, 'data' => $items, 'cat_id' => $cat, 'shop_ids' => $all_shop_id, 'selected_shop' => $forselected,'item_id'=>$itemid]);
            }else{
            return view('front.similar_items.bycat_other_shop', ['additional' => $additional, 'data' => $items, 'cat_id' => $cat, 'shop_ids' => $all_shop_id, 'selected_shop' => $forselected,'item_id'=>$itemid]);
            }
        } else {
            $additional = 'no';
            $temp_shop_name=Shopowner::where('id',$shop_id)->first()->id;

            $forselected = $temp_shop_name;
            $all_shop_id = Shopowner::where('id', '!=', 1)->orderBy('shop_name', 'asc')->get();
            // $all_shop_id = Shopowner::where('id', '!=', 1)->orderBy('created_at', 'desc')->get();

            $items = Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')->where(function ($query) use ($itemid){$query->whereRaw($this->getsimilarsqlcode($itemid));})->where([['items.category_id','=', $cat],['items.shop_id','=', $shop_id]])->orderByRaw("CASE
                        WHEN discount.discount_price = 0 THEN discount.discount_min
            WHEN discount.discount_price !=  0 THEN discount.discount_price
            WHEN items.price=0 THEN min_price
            WHEN items.price!=0 THEN price
            END
            ASC")->limit(40)->get();

            if(isset(Auth::guard('shop_owner')->user()->id)){
                return view('front.similar_items.bycat_other_shop', ['shopowner_acc' => $shopowner_acc,'additional' => $additional, 'data' => $items, 'cat_id' => $cat, 'shop_ids' => $all_shop_id, 'selected_shop' => $forselected,'item_id'=>$itemid]);
                 }elseif(isset(Auth::guard('shop_role')->user()->id)){
                return view('front.similar_items.bycat_other_shop', ['shopowner_acc' => $shopowner_acc,'additional' => $additional, 'data' => $items, 'cat_id' => $cat, 'shop_ids' => $all_shop_id, 'selected_shop' => $forselected,'item_id'=>$itemid]);
                }else{
                return view('front.similar_items.bycat_other_shop', ['additional' => $additional, 'data' => $items, 'cat_id' => $cat, 'shop_ids' => $all_shop_id, 'selected_shop' => $forselected,'item_id'=>$itemid]);
                }

        }


    }

}
