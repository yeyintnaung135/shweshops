<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Item;
use App\Models\Shopowner;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopCollectionController extends Controller
{
    public function collection_for_shop($shopname, $col_id){
        $id = DB::table('shop_owners')->where('shop_name_url', $shopname)->value('id');

        $collection = Collection::leftJoin('items','collection.id','=','items.collection_id')
        ->select('collection.id','collection.name', 'items.default_photo')
        ->where('collection.shop_id', $id)
        ->where('collection.id', $col_id)
        ->orderBy('collection.created_at', 'desc')
        ->groupBy('collection.id')
        ->get();

        $other_collections = Collection::leftJoin('items','collection.id','=','items.collection_id')
        ->select('collection.id','collection.name', 'items.default_photo')
        ->where('collection.shop_id', $id)
        ->whereNotIn('collection.id', [$col_id])
        ->groupBy('collection.id')
        ->get();

        $allcollection = Collection::leftJoin('items','collection.id','=','items.collection_id')
        ->select('collection.id','collection.name', 'items.default_photo')
        ->where('collection.shop_id', $id)
        ->orderBy('collection.created_at', 'desc')
        ->groupBy('collection.id')
        ->get();

        $allother_collections = Collection::leftJoin('items','collection.id','=','items.collection_id')
        ->select('collection.id','collection.name', 'items.default_photo')
        ->where('collection.shop_id', $id)
        ->whereNotIn('collection.id', [$allcollection[0]->id])
        ->groupBy('collection.id')
        ->get();

        // dd($other_collections);
        
        $col_items = Item::select('photo_one','name','price','view_count','id')
                    ->where('shop_id',$id)
                    ->where('collection_id', $col_id)
                    ->get();

        // dd($col_items);
        if($col_id == 'all'){
            return view('front.collection_for_shop', ['collection' => $allcollection, 'items' => $col_items, 'other_collections' => $allother_collections, 'shop_name' => $shopname]);
        } else {
            return view('front.collection_for_shop', ['collection' => $collection, 'items' => $col_items, 'other_collections' => $other_collections, 'shop_name' => $shopname]);
        }
    }
}
