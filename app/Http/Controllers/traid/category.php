<?php
namespace App\Http\Controllers\traid;

use App\Models\discount;
use App\Models\Item;
use App\Models\Shopowner;
use Illuminate\Support\Facades\DB;

trait category
{
public function getallcatlistbycount(){
    $all_cat=DB::table('categories')->leftjoin('items', 'categories.name', '=', 'items.category_id')->select('items.category_id','categories.mm_name',DB::raw('count(items.category_id) as catcount'))->where('items.deleted_at','=',NULL)->groupBy('categories.name')->orderByRaw("CASE
                        WHEN count(items.category_id) = 0 THEN categories.id END ASC,
            case when count(items.category_id) != 0 then count(categories.name) end DESC")->get();
    return $all_cat;

}
}
