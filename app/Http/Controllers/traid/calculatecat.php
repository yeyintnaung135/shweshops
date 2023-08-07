<?php
namespace App\Http\Controllers\traid;
use Illuminate\Support\Facades\Cache;
use DB;

trait calculatecat{
    public function getallcatcount(){
        $catlist = DB::table('categories')->leftjoin('items', 'categories.name', '=', 'items.category_id')->select('categories.*')->where('items.deleted_at', '=', NULL)->groupBy('categories.name')->orderByRaw("CASE
        WHEN count(items.category_id) = 0 THEN categories.id END ASC,
        case when count(items.category_id) != 0 then count(categories.name) end DESC")->get();
        return $catlist;
    }
}