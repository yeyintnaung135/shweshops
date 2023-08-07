<?php

namespace App\Http\Controllers;

use App\Models\discount;
use App\Models\Item;
use App\Models\Shopowner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontDiscountController extends Controller
{
    //
    public function see_all($shop_id){
      if($shop_id != 'all'){
          $temp_shop_name = Shopowner::where('id', $shop_id)->first()->id;

          $shop_id = $temp_shop_name;
          $discount_items=Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')->where('discount.shop_id','=',$shop_id)->whereNotNull('discount.id')->orderBy('discount.percent','DESC')->take('20')->get();

      }else{
          $discount_items=Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')->whereNotNull('discount.id')->orderBy('discount.percent','DESC')->take('20')->get();

      }
      return view('front.discount.see_all',['new_items'=>$discount_items,'shopid'=>$shop_id]);
    }
    public function get_discount_ajax($limit,$shop_id){


        if($shop_id != 'all'){
            $discount_items=Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')->where('discount.shop_id','=',$shop_id)->whereNotNull('discount.id')->orderBy('discount.percent','DESC')->where('discount.deleted_at',NULL)->skip($limit)->take('20')->get();

        }else{
            $discount_items=Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')->whereNotNull('discount.id')->orderBy('discount.percent','DESC')->where('discount.deleted_at',NULL)->skip($limit)->take('20')->get();
        }

        if(count($discount_items) < 20){
          $emptyonserver = 1;
          $tmp_count=0;
        }else{
          $emptyonserver = 0;
          $tmp_count=1;
        }
        return response()->json([$discount_items, count($discount_items), $emptyonserver, $tmp_count ]);

    }

}
