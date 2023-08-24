<?php
namespace App\Http\Controllers\Trait;

use Illuminate\Support\Facades\DB;

trait CalculateCat
{
    public function getallcatcount()
    {
        $catlist = DB::table('categories')->leftjoin('items', 'categories.name', '=', 'items.category_id')->select('categories.*')->where('items.deleted_at', '=', null)->groupBy('categories.name')->orderByRaw("CASE
        WHEN count(items.category_id) = 0 THEN categories.id END ASC,
        case when count(items.category_id) != 0 then count(categories.name) end DESC")->get();
        return $catlist;
    }
}
