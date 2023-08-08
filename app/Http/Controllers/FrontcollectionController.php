<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class FrontcollectionController extends Controller
{
    //
    public function see_all()
    {
        $collection = Item::orderBy('name', 'desc')->where('collection_id', '!=', 0)->groupBy('collection_id')->get();

        return view('front.collections.seeall', ['collection' => $collection]);
    }
    public function get_collection(Request $request)
    {
        $all_id = [];
        foreach ($request->all()['data'] as $rd) {
            array_push($all_id, $rd['id']);
        }
        $tmpgbsid = Item::select("*")->whereNotIn('id', $all_id)->where('shop_id', $ni->shop_id)->where('category_id', $id)->limit(4)->get();

    }

}
