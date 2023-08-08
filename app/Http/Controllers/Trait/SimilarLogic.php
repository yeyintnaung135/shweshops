<?php
namespace App\Http\Controllers\Trait;

use App\Models\discount;
use App\Models\Item;

trait SimilarLogic{
  public function getsimilarsqlcode($item_id){
      $item=Item::where('id',$item_id)->first();
      $to_check_dis=discount::where('item_id',$item_id);
      if($to_check_dis->count() == 0){
          if($item->price == 0){
              $min=$item->min_price - (($item->min_price * 20)/100);
              $max=$item->max_price + (($item->min_price * 20)/100);
          }else{
              $min=$item->price - (($item->price * 20)/100);
              $max=$item->price + (($item->price * 20)/100);

          }

      }else{
          if($to_check_dis->first()->discount_price == 0){
              $min=$to_check_dis->first()->discount_min - (($to_check_dis->first()->discount_min * 20)/100);
              $max=$to_check_dis->first()->discount_max + (($to_check_dis->first()->discount_max * 20)/100);
          }else{
              $min=$to_check_dis->first()->discount_price - (($to_check_dis->first()->discount_price * 20)/100);
              $max=$to_check_dis->first()->discount_price + (($to_check_dis->first()->discount_price * 20)/100);
          }
      }

      return "IF (discount.discount_price = 0 ,(discount.discount_min >= ".$min." AND discount.discount_min <= ".$max.") OR (discount.discount_max >= ".$min." AND discount.discount_max <= ".$max.")  ,discount.discount_price >= ".$min." AND discount.discount_price <= ".$max.") AND items.id <>".$item_id." OR IF (items.price = 0 AND discount.discount_price IS NULL,(items.min_price >= ".$min." AND items.min_price <= ".$max.") OR (items.max_price >= ".$min." AND items.max_price <= ".$max."),items.price >= ".$min." AND items.price <= ".$max.") AND items.id <> ".$item_id;

  }
}
?>
