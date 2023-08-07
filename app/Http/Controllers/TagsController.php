<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Shopowner;
use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\traid\allshops;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    use allshops;

    //
    public function index($name)
    {
        $data = Item::withAnyTag([$name])->limit(20)->get();

         // for account
         if(isset(Auth::guard('shop_owner')->user()->id)){
            $shopowner_acc = Shopowner::where('id', Auth::guard('shop_owner')->user()->id)->orderBy('created_at', 'desc')->get();
            }else if(isset(Auth::guard('shop_role')->user()->id)){
                $manager = Manager::where('id', Auth::guard('shop_role')->user()->id)->pluck('shop_id');
                $shopowner_acc = Shopowner::where('id',$manager)->orderBy('created_at', 'desc')->get();
            }

        if(isset(Auth::guard('shop_owner')->user()->id)){
        return view('front.tags', ['shopowner_acc' => $shopowner_acc,'data' => $data, 'shop_ids' => $this->getallshops(), 'title_prop' => $name]);
        }elseif(isset(Auth::guard('shop_role')->user()->id)){
        return view('front.tags', ['shopowner_acc' => $shopowner_acc,'data' => $data, 'shop_ids' => $this->getallshops(), 'title_prop' => $name]);
        }else{
        return view('front.tags', ['data' => $data, 'shop_ids' => $this->getallshops(), 'title_prop' => $name]);
        }
    }

    public function get_tags_items(Request $request)
    {
        $data = Item::withAnyTag($request->filtertype['tags'])->skip($request->filtertype['start'])->take($request->filtertype['end'])->orderBy('view_count', 'desc')->get();
        return response()->json($data);
    }
}
