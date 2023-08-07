<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Ads;
use App\Ajax;
use App\Item;
use App\State;
use App\discount;
use App\Township;
use App\Usernoti;
use App\Contactus;
use App\Shopowner;
use App\UserPoint;
use App\Users_fav;
use Carbon\Carbon;
use App\Collection;
use App\Manager_fav;
use App\foraddtohome;
use App\Facade\Repair;
use App\frontuserlogs;
use App\Guestoruserid;
use App\Shopdirectory;
use App\BuyNowClickLog;
use App\Shop_owners_fav;
use App\WhislistClickLog;
use App\AddToCartClickLog;
use App\VisitorLogActivity;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\traid\logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\traid\allshops;
use App\Http\Controllers\traid\category;
use App\Http\Controllers\traid\similarlogic;
use App\Http\Controllers\traid\foryoulogic;
use App\sitesettings;


class IndexTest extends Controller
{
    use foryoulogic;

    public function index(){
        //dummy products (Latest 20)
        $dummyProducts = Item::select('items.id as item_id','shop_id','default_photo', 'items.name as item_name', 'min_price', 'max_price', 'shop_owners.shop_name_url')
                            ->orderBy('items.created_at', 'desc')
                            ->leftJoin('shop_owners','items.shop_id','=','shop_owners.id')
                            ->limit(20)
                            ->get();
        //premium shops (dummy for popular shops)
        $premiumshops = Shopowner::orderBy('created_at', 'desc')->where('premium', 'yes')->limit(20)->get();

        //for new item every shop
        //get all distinct shopid from table
        $new_items = DB::table('items')->select('shop_id')->distinct()->orderBy('created_at', 'desc')->get();

        $get_by_shopid = [];
        //loop and retrive data by shop id greater than last 10 day
        $count = 0;
        $current_shop_count = 0;
        foreach ($new_items as $ni) {
            if ($count > 19) {
                break;
            } else {
                $tmpgbsid = Item::where('shop_id', $ni->shop_id)->whereDate('created_at', '>', Carbon::today()->subDay(60))->orderBy('created_at', 'desc')->limit(4)->get();
                foreach ($tmpgbsid as $tmpsid) {
                    array_push($get_by_shopid, $tmpsid);
                }
                $count += count($tmpgbsid);
                $current_shop_count += 1;
            }
        }

        //randomize result
        $get_by_shopid = collect($get_by_shopid)->shuffle()->values();
        //randomize result

        //for all cat count
        //$all = Item::where('id', '!=', 0)->get();


        //values function is beacause filter retrun {{}} but i need [{}]
        $remove_discount_new = collect($get_by_shopid)->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->values();

        //popular shops filter
        $popular_shops = frontuserlogs::leftJoin('shop_owners','front_user_logs.shop_id','=','shop_owners.id')
                                        ->select('shop_owners.id','shop_owners.shop_logo','shop_owners.shop_name','shop_owners.shop_name_url')->selectRaw('count(*) as s_count')
                                        ->where('status','shopdetail')
                                        ->whereDate('front_user_logs.created_at', '>', Carbon::today()->subDay(30))
                                        ->groupBy('shop_id')
                                        ->orderBy('s_count', 'desc')
                                        ->limit(20)
                                        ->get();

        $sitesettings = sitesettings::where('name','foryou')->first();
        if($sitesettings->action == 'on'){
            $foryoudata=$this->caculateforyouforcurrentuser();
        }else{
            $foryoudata=[];
        }
                                


       
        return view('front.index_test', ['recommendedProducts' => $foryoudata, 'premium' => $premiumshops, 'current_shop_count' => $current_shop_count, 'new_items' => $remove_discount_new, 'popular_shops' => $popular_shops]);
    }



}
