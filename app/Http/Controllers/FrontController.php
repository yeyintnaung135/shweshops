<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Ajax;
use App\Models\Item;
use App\Models\News;
use App\Models\Event;
use App\Models\State;
use App\Models\discount;
use App\Models\Township;
use App\Models\Usernoti;
use App\Models\Contactus;
use App\Models\MainPopup;
use App\Models\Shopowner;
use App\Models\UserPoint;
use App\Models\Users_fav;
use Carbon\Carbon;
use App\Models\Collection;
use App\Models\Manager_fav;
use App\Models\foraddtohome;
use App\Models\OpeningTimes;
use App\Facade\Repair;
use App\Models\frontuserlogs;
use App\Models\Guestoruserid;
use App\Models\Shopdirectory;
use App\Models\BuyNowClickLog;
use App\Models\Shop_owners_fav;
use App\Models\WhislistClickLog;
use App\Models\AddToCartClickLog;
use App\Models\VisitorLogActivity;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
use App\Http\Controllers\Trait\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Trait\AllShops;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Trait\Category;
use App\Http\Controllers\Trait\ForYouLogic;
use App\Http\Controllers\Trait\SimilarLogic;
=======
use App\Http\Controllers\Trait\logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Trait\allshops;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Trait\category;
use App\Http\Controllers\Trait\foryoulogic;
use App\Http\Controllers\Trait\similarlogic;
>>>>>>> c127b1566be7122c565719718ac60f06891577f9

class FrontController extends Controller
{
    use ForYouLogic;
    use AllShops;
    use SimilarLogic;
    use Category;
    use Logs;
    public function getstates(){
        $states=State::all();
        return response()->json(['data'=>$states]);
    }

    public function getshopbystate($id) {
      $shops = Shopowner::where('state', $id)->orderBy('shop_name', 'asc')->get();
      return response()->json($shops);
    }

    public function addtohomeupdate()
    {
        foraddtohome::where('user_id', Auth::guard('web')->user()->id)->update(['added' => 'yes']);
        return response()->json(['success' => true]);
    }
    public function directory()
    {
      $data = Shopdirectory::select(
        [
          'shop_directory.id as dir_id', 'shop_directory.shop_id as id',
          'shop_directory.shop_name as dir_shop_name', 'shop_owners.shop_name as shop_name',
          'shop_directory.shop_name_url as dir_shop_name_url', 'shop_owners.shop_name_url as shop_name_url',
          'shop_directory.main_phone as dir_main_phone', 'shop_owners.main_phone as main_phone',
          'shop_directory.shop_logo as dir_shop_logo', 'shop_owners.shop_logo as shop_logo',
          'shop_directory.facebook_link as dir_facebook_link', 'shop_owners.page_link as facebook_link',
          'shop_directory.website_link as website_link',
          'shop_owners.premium as premium'
        ]
      )->leftjoin('shop_owners', 'shop_directory.shop_id', '=', 'shop_owners.id')
      ->where('shop_owners.deleted_at',NULL)
      ->orderBy('shop_directory.created_at', 'DESC')
      ->where('pos_only','no')
      ->limit(20)->get()
      ->map(fn($data) => [
        'shweshops_premium_status' => $data->premium ? $data->premium : null,
        'id' => $data->id ? $data->id : $data->dir_id,
        'shop_name' => $data->dir_shop_name ? $data->dir_shop_name : $data->shop_name,
        'shop_name_url' => $data->dir_shop_name_url ? $data->dir_shop_name_url : $data->shop_name_url,
        'main_phone' => $data->dir_main_phone ? $data->dir_main_phone : $data->main_phone,
        'dir_shop_logo' => $data->dir_shop_logo ? $data->dir_shop_logo : null,
        'shop_logo' => $data->shop_logo ? $data->shop_logo : null,
        'facebook_link' => $data->dir_facebook_link ? $data->dir_facebook_link : $data->facebook_link,
        'website_link' => $data->website_link ? $data->website_link : null
      ]);

      $states = State::get();
      // dd($data);
      return view('front.directory.directory',['data'=>$data, 'states'=>$states]);
    }
    public function directdetail($shopname)
    {
        $escaped_shopname = addslashes($shopname);

        $data = Shopdirectory::whereRaw("REPLACE(shop_name,' ','') = '" . $escaped_shopname . "'")
            ->orWhereRaw("REPLACE(shop_name_url,' ','') = '" . $escaped_shopname . "'")
            ->get();
        if($data->count() == 0){
            return abort(404);
        }
        return view('front.directory.detail',['item'=>$data->first()]);
    }

    public function get_shop_directory(Request $request) {

      if($request->filtertype['state'] == 0) {
        $dir_state = 'shop_directory.state >= 0';
        $state = 'shop_owners.state >= 0';
      } else {
        // $dir_state = "shop_directory.state = " . $request->filtertype['state'];
        $dir_state = "shop_directory.state REGEXP '\"" . $request->filtertype['state'] . "\"'";
        $state = "shop_owners.state = " . $request->filtertype['state'];
      }

      if($request->filtertype['township'] == 0) {
        $dir_township = 'shop_directory.township >= 0';
        $township = 'shop_owners.township >= 0';
      } else {
        // $dir_township = "shop_directory.township = " . $request->filtertype['township'];
        $dir_township = "shop_directory.township REGEXP '\"" . $request->filtertype['township'] . "\"'";
        $township = "shop_owners.township = " . $request->filtertype['township'];
      }

      if($request->filtertype['shopname'] == '') {
        $shopname = '%';
        $dir_shopname = '%';
      } else {
        $shopname = '%' . $request->filtertype['shopname'] . '%';
      }

      $shops = Shopdirectory::select(
        [
          'shop_directory.id as dir_id', 'shop_directory.shop_id as id',
          'shop_directory.shop_name as dir_shop_name', 'shop_owners.shop_name as shop_name',
          'shop_directory.shop_name_url as dir_shop_name_url', 'shop_owners.shop_name_url as shop_name_url',
          'shop_directory.main_phone as dir_main_phone', 'shop_owners.main_phone as main_phone',
          'shop_directory.shop_logo as dir_shop_logo', 'shop_owners.shop_logo as shop_logo',
          'shop_directory.facebook_link as dir_facebook_link', 'shop_owners.page_link as facebook_link',
          'shop_directory.website_link as website_link',
          'shop_owners.premium as premium'
        ]
      )->leftjoin('shop_owners', 'shop_directory.shop_id', '=', 'shop_owners.id')
      ->where('shop_owners.deleted_at',NULL)
      ->orderBy('shop_directory.created_at', 'DESC')
      ->where(function($query) use ($state, $dir_state) {
          $query->whereRaw($state)
              ->orWhereRaw($dir_state);
      })
      ->where(function($query) use ($township, $dir_township) {
        $query->whereRaw($township)
              ->orWhereRaw($dir_township);
      })
      ->where(function($query) use ($shopname,) {
        $query->where('shop_directory.shop_name', 'like', $shopname)
              ->orWhere('shop_directory.shop_name_myan', 'like', $shopname)
              ->orWhere('shop_owners.shop_name', 'like', $shopname)
              ->orWhere('shop_owners.shop_name_myan', 'like', $shopname);
      })
      ->skip($request->filtertype['shoplimit'])->take('20')->get()
      ->map(fn($data) => [
        'shweshops_premium_status' => $data->premium ? $data->premium : null,
        'id' => $data->id ? $data->id : $data->dir_id,
        'shop_name' => $data->dir_shop_name ? $data->dir_shop_name : $data->shop_name,
        'shop_name_url' => $data->dir_shop_name_url ? $data->dir_shop_name_url : $data->shop_name_url,
        'main_phone' => $data->dir_main_phone ? $data->dir_main_phone : $data->main_phone,
        'dir_shop_logo' => $data->dir_shop_logo ? $data->dir_shop_logo : null,
        'shop_logo' => $data->shop_logo ? $data->shop_logo : null,
        'facebook_link' => $data->dir_facebook_link ? $data->dir_facebook_link : $data->facebook_link,
        'website_link' => $data->website_link ? $data->website_link : null
      ]);

      if (count($shops) < 20) {
        $empty_on_server = 1;
      } else {
        $empty_on_server = 0;
      }

      return response()->json(['shops' => $shops, 'count' => count($shops), 'empty_on_server' => $empty_on_server]);
    }

    public function getTownshipbyState($id) {
      $townships = Township::select('id', 'name', 'myan_name')->where('state_id', $id)->get();
      return response()->json($townships);
    }

    public function index()
    {

        //Ads
        Ads::where('end', '<=', Carbon::now()->format('Y-m-d H:i:s A'))->delete();
        $collection = Ads::where('start', '<=', Carbon::now()->format('Y-m-d H:i:s A'))->get();
        $ads = $collection->shuffle()->all();
        //Ads end

        //for new item every shop
        //get all distinct shopid from table
        $new_items = DB::table('items')->select('shop_id')->distinct()->orderBy('created_at', 'desc')->get();

        $get_by_shopid = [];
        //        loop and retrive data by shop id greater than last 10 day
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
//        $all = Item::where('id', '!=', 0)->get();


        //values function is beacause filter retrun {{}} but i need [{}]
        $remove_discount_new = collect($get_by_shopid)->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->values();




//        //for all cat count
//        $all = Item::where('id', '!=', 0)->get();


        //        return $allcatcount;
        $catlist = Cache::get('cat');
        //
        //  foreach ($catlist as $c) {
        //      if (empty($allcatcount[$c->name])) {
        //            $allcatcount[$c->name] = 0;
        //         }
        //
        //
        //    }

//        $col_count = Collection::where('id', '!=', 0)->get();
//        $collection_item = Item::orderBy('name', 'desc')->where('collection_id', '!=', 0)->groupBy('collection_id')->limit(20)->get();

        //for all cat count

//        $shops = Shopowner::orderBy('created_at', 'desc')->limit(20)->get();
//        $shops = $shops->shuffle()->values();
        $premiumshops = Shopowner::orderBy('created_at', 'desc')->where('premium', 'yes')->where('pos_only','no')->limit(20)->get();


//        //for discount slide and promotion pannel
//        $discount = discount::orderBy('percent', 'desc')->get();
//        //for discount slide and promotion pannel

        // for account
        //forlogs
        $this->addlog(url()->current(), 'all', 'all', 'homepage', '0');

        //forlogs



        $popular_shops = frontuserlogs::leftJoin('shop_owners','front_user_logs.shop_id','=','shop_owners.id')
                                        ->select('shop_owners.id','shop_owners.shop_logo','shop_owners.shop_name','shop_owners.shop_name_url')->selectRaw('count(*) as s_count')
                                        ->where('status','shopdetail')
                                        ->whereDate('front_user_logs.created_at', '>', Carbon::today()->subDay(30))
                                        ->groupBy('shop_id')
                                        ->orderBy('s_count', 'desc')
                                        ->limit(20)
                                        ->get();


        return view('front.index', ['ads' => $ads,'catlist' => $catlist, 'new_items' => $remove_discount_new, 'current_shop_count' => $current_shop_count, 'premium' => $premiumshops, 'popular_shops' => $popular_shops, 'recommendedProducts' => $this->caculateforyouforcurrentuser()[0]]);


    }
    public function initial_pop_items(Request $request){
        $pop = Item::whereDate('created_at', '>', Carbon::today()->subDay(60))->orderBy('view_count', 'DESC')->limit(10)->get();

//        $remove_discount_pop = collect($pop)->filter(function ($value, $key) {
//            return $value->check_discount == 0;
//        })->values();
        return response()->json([$pop]);

    }


    public function get_newitems_ajax(Request $request)
    {
        //return $request->data;
        $total_count = DB::table('items')->select('shop_id')->distinct()->orderBy('created_at', 'desc')->get()->count();
        $limit = $total_count - $request->filtertype['shop_limit'];
        $shop_ids = DB::table('items')->select('shop_id')->distinct()->orderBy('created_at', 'desc')->skip($request->filtertype['shop_limit'])->take($limit)->get();

        //return $request[0]['id'];
        $get_by_shopid = [];

        if ($request->filtertype["latest"] === true) {
            $date = '>';
        } else {
            $date = '<';
        }

        $count = 0;
        $current_shop_count = 0;

        foreach ($shop_ids as $ni) {
            if ($count > 19) {
                break;
            } else {
                $tmpgbsid = Item::where('shop_id', $ni->shop_id)->whereDate('created_at', $date, Carbon::today()->subDay(60))->orderBy('created_at', 'desc')->skip($request->filtertype["item_limit"])->limit(4)->get();
                foreach ($tmpgbsid as $tmpsid) {
                    array_push($get_by_shopid, $tmpsid);
                }
                $count += count($tmpgbsid);
                $current_shop_count += 1;
            }

        }

        //randomize result
        $get_by_shopid = collect($get_by_shopid)->values();

        $remove_discount_new = collect($get_by_shopid)->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->shuffle()->values();


        //product empty check
        if ($count == 0 && $current_shop_count + $request->filtertype['shop_limit'] == $total_count) {
            $itemsemptyonserver = 1;
        } else {
            $itemsemptyonserver = 0;
        }

        //shop list empty check
        if (($count == 0) || ($current_shop_count == 0) || ($current_shop_count + $request->filtertype['shop_limit'] == $total_count)) {
            $shopsempty = 1;
        } else {
            $shopsempty = 0;
        }

        return response()->json(['newitems' => $remove_discount_new, "shopsempty" => $shopsempty, "itemsemptyonserver" => $itemsemptyonserver, "current_shop_limit" => $current_shop_count]);
    }


    public function get_popitems_ajax($latest, $limit)
    {

//        $latestviewcount = Item::where('id', $latestid)->first()->view_count;
//
//        $pop_items = Item::where('view_count', '=', $latestviewcount)->limit(20)->get();
//        if (count($pop_items) != 0) {
//            $pop_items = Item::Where([['view_count', '=', $latestviewcount], ['id', '>', $latestid]])->orWhere([['view_count', '<', $latestviewcount], ['id', '!=', $latestid]])->orderBy('view_count', 'desc')->limit(20)->get();
//
//        } else {
//            $pop_items = Item::Where([['view_count', '<', $latestviewcount], ['id', '!=', $latestid]])->orderBy('view_count', 'desc')->limit(20)->get();
//
//        }
        if ($latest === "true") {
            $date = '>';
        } else {
            $date = '<';
        }

        $pop_items = Item::whereDate('created_at', $date, Carbon::today()->subDay(60))->orderBy('view_count', 'DESC')->skip($limit)->take(20)->get();

        $remove_discount_pop = collect($pop_items)->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->values();

        // if($latest !== "true") {
        //   $remove_discount_pop = collect($remove_discount_pop)->shuffle()->values();
        // }

        //        for seeall button check if data has in database
        if (count($pop_items) < 20) {
            $emptyonserver = 1;
        } else {
            $emptyonserver = 0;
        }
        //  for seeall button

        return response()->json([$remove_discount_pop, 20, $emptyonserver]);

    }

    public function search()
    {
        $categories = Item::select('category_id')->groupBy('category_id')->get();
        $shops = Shopowner::all();
        $priceFrom = Item::select('price')->orderBy('price', 'asc')->get();
        $priceTo = Item::select('price')->orderBy('price', 'desc')->get();
        $gold_quality = Item::select('gold_quality')->groupBy('gold_quality')->get();
        $gold_color = Item::select('gold_colour')->groupBy('gold_colour')->get();

        return view('front.search', ['gold_quality' => $gold_quality, 'gold_color' => $gold_color, 'categories' => $categories, 'shops' => $shops, 'priceFrom' => $priceFrom, 'priceTo' => $priceTo]);
    }

    public function search_by_type(Request $request)
    {
        // if(empty($request['data'])){
        //     return response()->json(['resultdataitems' => [], 'resultdatashops' => []]);

        // }
        if (empty($request['data'])) {
            return response()->json(['resultdatashops' => []]);

        }

        // $checkcat = \App\Category::whereRaw("mm_name REGEXP '(" . $request['data'] . ")'");
        // if ($checkcat->count() > 0) {
        //     $request['data'] = $checkcat->first()->name;
        // }

        // $search_result = Item::select('items.*')->leftjoin('tagging_tagged', 'items.id', '=', 'tagging_tagged.taggable_id')->orWhere(function ($query) use ($request) {
        //     $query->orwhereRaw("items.name REGEXP '" . $request['data'] . "'");

        // })->orwhereRaw("tagging_tagged.tag_name REGEXP '(" . $request['data'] . ")'")->orWhere('items.category_id', 'like', $request['data'])->orWhere('items.product_code', 'like', '%' . $request['data'] . '%')->skip($request['limit'])->take('20')->get();

        $search_result_shops = Shopowner::where(function ($query) use ($request) {
            //remove space from incoming str
            $remove_space = str_replace(' ', '', $request['data']);
            $query->whereRaw("REPLACE(shop_name,' ','')  REGEXP '(" . $remove_space . ")'");
        })->skip($request['limit'])->take('20')->get();


        // return response()->json(['resultdataitems' => $search_result, 'resultdatashops' => $search_result_shops]);
        return response()->json(['resultdatashops' => $search_result_shops]);

    }

    public function ajax_search_result($searchtext = null)
    {
        $catlist = DB::table('categories')->leftjoin('items', 'categories.name', '=', 'items.category_id')->select('categories.*')->where('items.deleted_at', '=', NULL)->groupBy('categories.name')->orderByRaw("CASE
                        WHEN count(items.category_id) = 0 THEN categories.id END ASC,
            case when count(items.category_id) != 0 then count(categories.name) end DESC")->get();
        $all_shop_id = Shopowner::where('id', '!=', 1)->orderBy('shop_name', 'asc')->get();
        // $all_shop_id = Shopowner::where('id', '!=', 1)->orderBy('created_at', 'desc')->get();


        return view('front.searchresult', ['searchtext' => $searchtext, 'catlist' => $catlist, 'shop_ids' => $all_shop_id]);


    }


    public function product_detail($shop_name, $product_id)
    {


        $itemc = Item::where('id', $product_id);
        if($itemc->count() == 0){
            return abort(404);
        }
        $item = Item::where('id', $product_id)->first();

        // return dd($item->id);

        // zh item-log
        //forlogs
        $this->addlog(url()->current(), $product_id, $item->shop_id, 'product_detail', '0');
        //forlogs

        //***************************similar and related items logic***************************
        $similar_minimum_products = Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')->where(function ($query) use ($product_id) {
            $query->whereRaw($this->getsimilarsqlcode($product_id));
        })->where('items.shop_id', '=', $item->shop_id)->where('items.category_id', $item->category_id)->orderByRaw("CASE
                        WHEN discount.discount_price = 0 THEN discount.discount_min
            WHEN discount.discount_price !=  0 THEN discount.discount_price
            WHEN items.price=0 THEN min_price
            WHEN items.price!=0 THEN price
            END
            ASC")->limit(20)->get();
        $similar_minimum_products_other_shops = Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')->where(function ($query) use ($product_id) {
            $query->whereRaw($this->getsimilarsqlcode($product_id));
        })->where('items.shop_id', '!=', $item->shop_id)->where('items.category_id', $item->category_id)->orderByRaw("CASE
                        WHEN discount.discount_price = 0 THEN discount.discount_min
            WHEN discount.discount_price !=  0 THEN discount.discount_price
            WHEN items.price=0 THEN min_price
            WHEN items.price!=0 THEN price
            END
            ASC")->limit(20)->get();


        $add_view_count = $item->view_count + 1;
        $view_count = Item::where('id', $product_id)->update(['view_count' => $add_view_count]);

        // for account

        $checkShopOwnerFav = Shop_owners_fav::where('fav_id', $product_id)->pluck('user_id');
        $checkManagerFav = Manager_fav::where('fav_id', $product_id)->pluck('user_id');
        $checkUserFav = Users_fav::where('fav_id', $product_id)->pluck('user_id');

        $fav_total_count = count($checkShopOwnerFav) + count($checkManagerFav) + count($checkUserFav);


        return view('front.product_detail', ['item' => $item, 'category' => $item->category_id, 'sim_items' => $similar_minimum_products, 'sim_items_othershops' => $similar_minimum_products_other_shops, 'fav_total_count' => $fav_total_count]);

    }

    public function buynow(Request $request)
    {
        $item = Item::where('id', $request->id)->first();

        $getuserorguestid = $this->getidoftable_userorguestid();

        BuyNowClickLog::create(['item_id' => $request->id, 'userorguestid' => $getuserorguestid]);

        echo json_encode($item);
    }

    public function addtocartclick(Request $request)
    {
        $item = Item::where('id', $request->id)->first();
        $getuserorguestid = $this->getidoftable_userorguestid();
        $check_atc_logs_exit = AddToCartClickLog::where([['item_id', '=', $request->id], ['userorguestid', '=', $getuserorguestid]]);
        if ($check_atc_logs_exit->count() != 0) {
            AddToCartClickLog::where([['item_id', '=', $request->id], ['userorguestid', '=', $getuserorguestid]])->delete();
        } else {
            AddToCartClickLog::create(['item_id' => $request->id, 'userorguestid' => $getuserorguestid]);

        }


        echo json_encode($item);
    }

    public function whislistclick(Request $request)
    {
        $item = Item::where('id', $request->id)->first();

        $getuserorguestid = $this->getidoftable_userorguestid();
        $check_atc_logs_exit = WhislistClickLog::where([['item_id', '=', $request->id], ['userorguestid', '=', $getuserorguestid]]);
        if ($check_atc_logs_exit->count() != 0) {
            WhislistClickLog::where([['item_id', '=', $request->id], ['userorguestid', '=', $getuserorguestid]])->delete();
        } else {
            WhislistClickLog::create(['item_id' => $request->id, 'userorguestid' => $getuserorguestid]);

        }
        echo json_encode($item);
    }


    public function shop_detail($shopname)
    {
        $id = DB::table('shop_owners')->where('name', $shopname)->value('id');

        $shop = Shopowner::whereRaw("REPLACE(shop_name,' ','') = '" . $shopname . "'")
            ->orWhere('shop_name_url', $shopname)
            ->with(['getPhotos'])
            ->first();
        if(empty($shop)){
            return abort(404);
        }
        // \ShopLogActivity::shopaddToLog($shop->name);
        $id = $shop->id;

        //for log
        if (!Str::contains(url()->previous(), 'adsclick')) {
            $this->addlog(url()->current(), 'all', $id, 'shopdetail', '0');

        }
        //for log

        $premiumshops = Shopowner::orderBy('created_at', 'desc')->where('premium', 'yes')->limit(20)->get();

        $othersellers = Shopowner::orderBy('created_at', 'desc')->where('premium', '!=', 'yes')->orWhereNull('premium')->limit(20)->get();

        $allitems = Item::where('shop_id', $id)->orderBy('created_at', 'desc');
        //for load more button
        $remove_discount_item_for_count = collect($allitems->get())->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->values();

        $forcheck_count = $remove_discount_item_for_count->count();

        if ($forcheck_count < 21) {
            $forcheck_count = 0;
        } else {
            $forcheck_count = 1;
        }
        //
        $get_pop_items = Item::where('shop_id', $id)->orderBy('view_count', 'desc')->limit(12)->get();
        $items = Item::where('shop_id', $id)->orderBy('created_at', 'desc')->limit(20)->get();
        $remove_discount_item = collect($items)->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->values();
        $remove_discount_pop_item = collect($get_pop_items)->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->values();
        $shops = Shopowner::where('id', '!=', $id)->orderBy('created_at', 'desc')->limit(20)->get();
        // $discount = discount::where('shop_id', $id)->orderBy('created_at', 'desc')->limit(20)->get();
        $discount = Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')->where('discount.shop_id', $id)->whereNotNull('discount.id')->orderBy('discount.percent', 'DESC')->where('discount.deleted_at',NULL)->limit('12')->get();
        $allcatcount = DB::table('categories')->leftjoin('items', 'categories.name', '=', 'items.category_id')->select('items.category_id', 'categories.mm_name', DB::raw('count(items.category_id) as catcount'))->where('items.deleted_at', '=', NULL)->groupBy('categories.name')->orderByRaw("CASE
                        WHEN count(items.category_id) = 0 THEN categories.id END ASC,
            case when count(items.category_id) != 0 then count(categories.name) end DESC")->where('shop_id', $id)->get();

        $visitor_view_count = frontuserlogs::where('front_user_logs.shop_id', '=', $id)->count();
        $fav_count=Users_fav::leftjoin('items','items.id','=','users_fav.fav_id')->leftjoin('shop_owners','shop_owners.id','=','items.shop_id')->where('items.shop_id',$id)->count();
        // return count($fav_count);

        $popup = MainPopup::select('video_name','ad_title')->where('shop_id',$id)->first();
        $openingTime = OpeningTimes::select('opening_time')->where('shop_id',$id)->first();

        $news = News::where('shop_id',$id)->get();
        $news->map(function ($n) {
            $n['type'] = 'news';
            return $n;
        });

        $events = Event::where('shop_id',$id)->get();
        $events->map(function ($e) {
            $e['type'] = 'events';
            return $e;
        });

        $news_and_events = $news->merge($events)->sortByDesc('updated_at');
        $collections = Collection::leftJoin('items','collection.id','=','items.collection_id')->select('collection.id','collection.name', 'items.default_photo')->where('collection.shop_id', $id)->groupBy('collection.id')->orderBy('collection.created_at', 'desc')->get();
        //dd($collections . "!");

        $premium_type = Shopowner::leftjoin('premium_templates','shop_owners.premium_template_id','=','premium_templates.id')
                            ->select('premium_templates.id')
                            ->where('shop_owners.id', $id)
                            ->first();
        // dd($premium_status->name);
        // dd($popup);
        if($shop->premium == "no"){
        return view('front.shop_detail', ['premium' => $premiumshops, 'othersellers' => $othersellers, 'shop_data' => $shop, 'forcheck_count' => $forcheck_count, 'get_pop_items' => $get_pop_items, 'items' => $remove_discount_item, 'shops' => $shops, 'allcatcount' => $allcatcount, 'discount' => $discount]);
        }
        else if($shop->premium == "yes"){
            if($premium_type->id == '1'){
                return view('front.shop_detail_gold', ['premium' => $premiumshops, 'premium_type' => $premium_type->id, 'othersellers' => $othersellers, 'shop_data' => $shop, 'favcount'=>$fav_count,'forcheck_count' => $forcheck_count, 'get_pop_items' => $get_pop_items, 'items' => $remove_discount_item, 'shops' => $shops, 'allcatcount' => $allcatcount, 'discount' => $discount, 'view_count' => $visitor_view_count, 'popup' => $popup, 'opening' => $openingTime, 'newsNevents' => $news_and_events, 'collections' => $collections]);
            }

            if($premium_type->id == '2'){
                return view('front.shop_detail_diamond', ['premium' => $premiumshops, 'premium_type' => $premium_type->id, 'othersellers' => $othersellers, 'shop_data' => $shop, 'favcount'=>$fav_count,'forcheck_count' => $forcheck_count, 'get_pop_items' => $get_pop_items, 'items' => $remove_discount_item, 'shops' => $shops, 'allcatcount' => $allcatcount, 'discount' => $discount, 'view_count' => $visitor_view_count, 'popup' => $popup, 'opening' => $openingTime, 'newsNevents' => $news_and_events, 'collections' => $collections]);
            }

            if($premium_type->id == '3'){
                return view('front.shop_detail_platinum', ['premium' => $premiumshops, 'premium_type' => $premium_type->id, 'othersellers' => $othersellers, 'shop_data' => $shop, 'favcount'=>$fav_count,'forcheck_count' => $forcheck_count, 'get_pop_items' => $get_pop_items, 'items' => $remove_discount_item, 'shops' => $shops, 'allcatcount' => $allcatcount, 'discount' => $discount, 'view_count' => $visitor_view_count, 'popup' => $popup, 'opening' => $openingTime, 'newsNevents' => $news_and_events, 'collections' => $collections]);
            }
            if($premium_type->id == ''){
                return view('front.shop_detail_gold', ['premium' => $premiumshops, 'premium_type' => $premium_type->id, 'othersellers' => $othersellers, 'shop_data' => $shop, 'favcount'=>$fav_count,'forcheck_count' => $forcheck_count, 'get_pop_items' => $get_pop_items, 'items' => $remove_discount_item, 'shops' => $shops, 'allcatcount' => $allcatcount, 'discount' => $discount, 'view_count' => $visitor_view_count, 'popup' => $popup, 'opening' => $openingTime, 'newsNevents' => $news_and_events, 'collections' => $collections]);
            }
        }
    }

    public function search_result(Request $request)
    {
        $input = $request->except('_token');
        if (empty($request->category_id)) {
            //'%' mean any brand name
            $input['category_id'] = '%';
        }
        if (empty($request->gold_color)) {
            //'%' mean any brand name
            $input['gold_color'] = '%';
        }
        if (empty($request->gold_quality)) {
            //'%' mean any brand name
            $input['gold_quality'] = '%';
        }

        if (empty($request->price_range)) {
            //'%' mean any brand name
            $input['price_from'] = 0;
            $input['price_to'] = 10000000000000;

        } else {

            $str_toarray = explode(" ", str_replace("-", ' ', $request->price_range));
            $input['price_from'] = intval($str_toarray[0]);
            if ($input['price_from'] == 0) {
                $input['price_from'] = 1;
            }
            $input['price_to'] = intval($str_toarray[1]);
        }

        if (empty($request->shops)) {

        } else {
            foreach ($request->shops as $shop) {


            }
        }

        if (empty($request->shops)) {
            $search_result = Item::where([['gold_quality', 'like', $input['gold_quality']], ['category_id', 'like', $input['category_id']], ['gold_colour', 'like', $input['gold_color']]])->where(function ($query) use ($input) {

                $query->whereBetween('price', [$input['price_from'], $input['price_to']])->orWhere(function ($query) use ($input) {
                    $query->where([['min_price', '>', intval($input['price_from'])], ['max_price', '<', intval($input['price_to'])]]);
                });
            })->get();

        } else {
            $search_result = [];
            foreach ($request->shops as $shop) {
                $result_byshop = Item::where([['shop_id', '=', $shop], ['gold_quality', 'like', $input['gold_quality']], ['category_id', 'like', $input['category_id']], ['gold_colour', 'like', $input['gold_color']]])->where(function ($query) use ($input) {

                    $query->whereBetween('price', [$input['price_from'], $input['price_to']])->orWhere(function ($query) use ($input) {
                        $query->where([['min_price', '>', intval($input['price_from'])], ['max_price', '<', intval($input['price_to'])]]);
                    });
                })->get();
                foreach ($result_byshop as $rbs) {
                    array_push($search_result, $rbs);
                }
            }
        }

//        return $search_result;
        return view('front.searchresult', ['search_result' => $search_result]);
    }

    public function getitem_fromshop_bycat($shopid, $cat)
    {
        $items = Item::where([['shop_id', '=', $shopid], ['category_id', '=', $cat]])->orderBy('created_at', 'desc')->limit(30)->get();
        if (count($items) == 0) {
            $catname = '';
        } else {
            $catname = Item::where([['shop_id', '=', $shopid], ['category_id', '=', $cat]])->first()->ykbeauty_cat;

        }


        $allitems = Item::where('shop_id', $shopid)->orderBy('created_at', 'desc');
        //for load more button
        $remove_discount_item_for_count = collect($allitems->get())->filter(function ($value, $key) {
            return $value->check_discount == 0;
        })->values();
        $forcheck_count = $remove_discount_item_for_count->count();

        if ($forcheck_count < 21) {
            $forcheck_count = 0;
        } else {
            $forcheck_count = 1;
        }
        //
        $discount = discount::where('shop_id', $shopid)->orderBy('created_at', 'desc')->limit(20)->get();
        $shops = Shopowner::where('id', '!=', $shopid)->orderBy('created_at', 'desc')->limit(30)->get();
        $shop = Shopowner::where('id', $shopid)->first();
        $allcatcount = collect($allitems->get())->countBy('category_id')->all();

        return view('front.getitembyshocat', ['forcheck_count' => $forcheck_count, 'discount' => $discount, 'items' => $items, 'shops' => $shops, 'shop_data' => $shop, 'catname' => $catname, 'allcatcount' => $allcatcount]);

    }


    public function gold_calculator()
    {
        return view('front.goldcalculator');
    }


    public function see_all_new()
    {


        $shop_ids = DB::table('items')->select('shop_id')->distinct()->get();
        $get_by_shopid = [];
//loop and retrive data by shop id greater than last 10 day
        $count = 0;
        foreach ($shop_ids as $ni) {
            if ($count > 19) {
                break;
            } else {
                $tmpgbsid = Item::where('shop_id', $ni->shop_id)->orderBy('id', 'desc')->limit(10)->get();
                foreach ($tmpgbsid as $tmpsid) {
                    array_push($get_by_shopid, $tmpsid);
                }
                $count += count($tmpgbsid);
            }

        }


        //randomize result
        $get_by_shopid = collect($get_by_shopid)->shuffle()->values();
        //randomize result

        //


//        Cache::remember($tmp_key, now()->addMinutes(60),function () use ($tmp_cache_data,$get_by_shopid){
//            return ['ini_data'=>[$get_by_shopid,0]];
//        });


//        return Cache::get($tmp_key);


        $all_shop_id = Shopowner::where('id', '!=', 1)->orderBy('shop_name', 'asc')->get();
        // $all_shop_id = Shopowner::where('id', '!=', 1)->orderBy('created_at', 'desc')->get();

        return view('front.see_all', ['new_items' => $get_by_shopid, 'shop_ids' => $all_shop_id]);

        // return $get_by_shopid;

    }

    public function see_all_for_shop($neworpop, $shop_id)
    {
        if ($neworpop == 'latest') {
            $new_items = Item::where('shop_id', $shop_id)->orderBy('created_at', 'desc')->limit(20)->get();

        } else {
            $new_items = Item::where('shop_id', $shop_id)->orderBy('view_count', 'desc')->limit(20)->get();

        }

        $temp_shop_name = Shopowner::where('id', $shop_id)->first()->id;

        $forselected = $temp_shop_name;
        //values function is beacause filter retrun {{}} but i need [{}]

        return view('front.seeall_for_shop', ['neworpop' => $neworpop, 'shop_ids' => $this->getallshops(), 'selected_shop' => $forselected, 'new_items' => $new_items, 'shop_id' => $shop_id]);

    }

    public function see_all_pop()
    {

        $pop = Item::orderBy('view_count', 'desc')->limit(20)->get();
        //values function is beacause filter retrun {{}} but i need [{}]
//        $remove_discount_pop = collect($pop)->filter(function ($value, $key) {
//            return $value->check_discount == 0;
//        })->values();
        $all_shop_id = Shopowner::where('id', '!=', 1)->orderBy('shop_name', 'asc')->get();
        // $all_shop_id = Shopowner::where('id', '!=', 1)->orderBy('created_at', 'desc')->get();

        return view('front.seeall_pop', ['pop_items' => $pop, 'shop_ids' => $all_shop_id]);


    }

    public function contact_us()
    {
        $contact = Contactus::where('active', 1)->first();
        return view('front.ContactUs.contactus', ['contact' => $contact]);
    }

    //sync add to cart and fav
    public function fav_search(Request $request)
    {

        $search_result = Item::wherein('id', $request['data'])->get();
        return response()->json(collect($search_result)->values());
    }

    public function addtocart_search(Request $request)
    {
        $search_result = Item::wherein('id', $request['data'])->get();
        return response()->json(collect($search_result)->values());
    }

    public function addtocart_update(Request $request)

    {
        $modelName = "App\\" . ($request['users'] . "_selection");
        $cleanup = $modelName::where('user_id', $request['id'])->delete();
        if ($request['newSelection'] != null) {
            $id_value = array_values($request['newSelection']);
            for ($i = 0; $i < count($id_value); $i++) {
                $user = $modelName::where('user_id', $request['id'])->where('selection_id', $id_value[$i]);
                $query = $user->updateOrInsert(['user_id' => $request['id']], ['selection_id' => $id_value[$i]]);
            }
            return response('Selection update success');
        } else {
            return response('Selection update is null');
        }
    }

    public function fav_update(Request $request)
    {
        $modelName = "App\\" . $request['users'] . "_fav";
        $cleanup = $modelName::where('user_id', $request['id'])->delete();
        if ($request['newFav'] != null) {
            $id_value = array_values($request['newFav']);
            for ($i = 0; $i < count($id_value); $i++) {
                $user = $modelName::where('user_id', $request['id'])->where('fav_id', $id_value[$i]);
                $query = $user->updateOrInsert(['user_id' => $request['id']], ['fav_id' => $id_value[$i]]);
            }
            return response('Fav update success');
        } else {
            return response('Fav update is null');
        }

    }

    public function getNoti()
    {
        if (isset(Auth::guard('shop_owner')->user()->id) || isset(Auth::guard('web')->user()->id) || isset(Auth::guard('shop_role')->user()->id)) {
            return ('noti');
        } else {
            abort(404);
        }
    }

    public function readNoti(Request $request)
    {
        $readNoti = Usernoti::where('sender_shop_id', $request['sender'])->where('receiver_user_id', $request['receiver'])->where('user_type', $request['user'])->where('item_id', $request['item']);
        $query = $readNoti->update(['read_by_receiver' => $request['read_by_receiver']]);
        return redirect()->back();
    }

    public function getShops()
    {
        $shops = Shopowner::orderBy('created_at', 'desc')->where('pos_only','no')->limit(20)->get();
        return view('front.shops', ['shops' => $shops, 'active' => 'all']);
    }

    public function getPremiumShops()
    {
      $shops = Shopowner::orderBy('created_at', 'desc')->where('premium', 'yes')->limit(20)->get();
      return view('front.shops', ['shops' => $shops, 'active' => 'premium']);
    }

    public function getPopularShops()
    {
        $dateS = Carbon::now()->subMonths(6);
        $dateE = Carbon::now();
        $shops = frontuserlogs::join('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
                                ->join('shop_owners', 'front_user_logs.shop_id', '=', 'shop_owners.id')
                                ->where('guestoruserid.user_agent', '!=', 'bot')
                                ->where('front_user_logs.status', 'shopdetail')
                                ->whereBetween('front_user_logs.created_at',[$dateS,$dateE])
                                ->select('front_user_logs.shop_id', 'shop_owners.*', DB::raw('count(*) as total'))
                                ->groupBy('front_user_logs.shop_id')
                                ->orderBy('total', 'DESC')
                                ->take('20')
                                ->get();
        return view('front.shops', ['shops' => $shops, 'active' => 'popular']);
    }

    public function get_shops_byfilter(Request $request) {
      if($request->filtertype['shopname'] == '') {
        $shopname = '%';
      } else {
        $shopname = '%' . $request->filtertype['shopname'] . '%';
      }
      if($request->filtertype['premium'] == '') {
        $premium = '%';
      } else {
        $premium = '%' . $request->filtertype['premium'] . '%';
      }
      if($request->filtertype['isPopular'] == 'yes') {
        $dateS = Carbon::now()->subMonths(6);
        $dateE = Carbon::now();
        $shops = frontuserlogs::join('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
                                ->join('shop_owners', 'front_user_logs.shop_id', '=', 'shop_owners.id')
                                ->where('guestoruserid.user_agent', '!=', 'bot')
                                ->where('front_user_logs.status', 'shopdetail')
                                ->where(function($query) use ($shopname) {
                                  $query->where('shop_owners.shop_name', 'like', $shopname)
                                        ->orWhere('shop_owners.shop_name_myan', 'like', $shopname);
                                })
                                ->whereBetween('front_user_logs.created_at',[$dateS,$dateE])
                                ->select('front_user_logs.shop_id', 'shop_owners.*', DB::raw('count(*) as total'))
                                ->groupBy('front_user_logs.shop_id')
                                ->orderBy('total', 'DESC')
                                ->skip($request->filtertype['shoplimit'])->take('20')
                                ->get();

      } else {
        $shops = Shopowner::orderBy('created_at', 'desc')
                          ->where(function($query) use ($shopname) {
                            $query->where('shop_name', 'like', $shopname)
                                  ->orWhere('shop_name_myan', 'like', $shopname);
                          })
                          ->where('premium', 'like', $premium)
                          ->skip($request->filtertype['shoplimit'])->take('20')->get();
      }

      if (count($shops) < 20) {
        $empty_on_server = 1;
      } else {
        $empty_on_server = 0;
      }

      return response()->json(['shops' => $shops, 'count' => count($shops), 'empty_on_server' => $empty_on_server]);
    }

    // public function getNewsandEvents() {
    //   return view('font.newsandevents');
    // }

    public function baydins(){
        return view('front.baydins.baydin');
    }

}
