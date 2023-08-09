<?php

namespace App\Http\Controllers\ShopOwner;

use App\Models\Ads;

use App\Models\FrontUserLogs;
use App\Models\Item;
use App\Models\GoldPoint;
use App\Models\Discount;
use App\Models\Shop;
use App\Models\ShopBanner;
use App\Models\BuyNowClickLog;
use App\Models\ItemLogActivity;
use App\Models\ShopLogActivity;
use App\Models\User;
use App\Models\WishlistClickLog;
use App\Models\AddToCartClickLog;
use App\Models\CountSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\CountSettingCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Trait\YKImage;
use App\Http\Controllers\Trait\UserRole;
use App\Models\ShopOwnerGoldPoint;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Trait\CalculateCat;
use Illuminate\Support\Facades\Cache;

class ShopOwnerController extends Controller
{
    use YKImage;
    use UserRole;
    use CountSettingCheck;
    use CalculateCat;

    public function __construct()
    {
        //tz
        $this->middleware('auth:shop_owners_and_staffs');
    }

    public function index()
    {
        $storecattocache = Cache::put('cat', $this->getallcatcount());

        $items = Item::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        return view('backend.shopowner.list', ['items' => $items]);
    }

    public function detail()
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();

        $items = Item::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $products_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'item')->get();


        $shopview = frontuserlogs::where('shop_id', $this->get_shopid())->where('status', 'shopdetail')->orderBy('created_at', 'desc')->get()->unique('guest_id');
        $shops_view_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'shop_view')->get();


        $productclick = frontuserlogs::leftjoin('items', 'front_user_logs.product_id', '=', 'items.id')->where('front_user_logs.status', 'product_detail')->where('items.shop_id', $this->get_shopid())->orderBy('front_user_logs.created_at', 'desc')->get();
        $items_view_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'items_view')->get();

        $unique_productclick = ItemLogActivity::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->get()->unique('user_id', 'guest_id');
        $unique_product_click_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'item_unique_view')->get();

        $buynowclick = BuyNowClickLog::leftjoin('items', 'items.id', 'buy_now_click_logs.item_id')->where('items.shop_id', $this->get_shopid())->orderBy('buy_now_click_logs.created_at', 'desc')->get();
        $buy_now_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'buyNowClick')->get();

        $addtocartclick = AddToCartClickLog::leftjoin('items', 'items.id', 'add_to_cart_click_logs.item_id')->where('items.shop_id', $this->get_shopid())->orderBy('add_to_cart_click_logs.created_at', 'desc')->get()->unique('guest_id', 'user_id');
        $addtocartclick_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'addToCartClick')->get();

        $whislistclick = WishlistClickLog::leftjoin('items', 'items.id', 'wishlist_click_logs.item_id')->where('items.shop_id', $this->get_shopid())->orderBy('wishlist_click_logs.created_at', 'desc')->get();
        $whislistclick_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'whislistclick')->get();

        $discountview = ItemLogActivity::where('shop_id', $this->get_shopid())->whereIn('item_id', Discount::pluck('item_id'))->get();
        $discountview_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'discountview')->get();

        $adsview = ShopLogActivity::where('shop', $this->get_shopid())->whereIn('shop', Ads::pluck('shop_id'))->get();
        $adsview_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'adsview')->get();

        // if($this->checkUserCount($this->get_shopid())){

        // }
        $users = $this->getuserlistbyrolelevel();
        $users_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'users')->get();


        //  return $buynowclick;

        return view('backend.shopowner.detail', [
            'unique_productclick' => $unique_productclick,
            'unique_product_click_count_setting' => $unique_product_click_count_setting,

            'adsview' => $adsview,
            'adsview_count_setting' => $adsview_count_setting,

            'discountview' => $discountview,
            'discountview_count_setting' => $discountview_count_setting,

            'whislistclick' => $whislistclick,
            'whislistclick_count_setting' => $whislistclick_count_setting,

            'addtocartclick' => $addtocartclick,
            'addtocartclick_count_setting' => $addtocartclick_count_setting,

            'buynowclick' => $buynowclick,
            'buy_now_count_setting' => $buy_now_count_setting,

            'productclick' => $productclick,
            'items_view_count_setting' => $items_view_count_setting,

            'shopview' => $shopview,
            'shops_view_count_setting' => $shops_view_count_setting,

            'shopowner' => $shopowner,

            'items' => $items,
            'products_count_setting' => $products_count_setting,

            'managers' => $users,
            'users_count_setting' => $users_count_setting,

        ]);
    }

    public function shop_view()
    {
        if (count($this->shopViewCheck($this->get_shopid())) != 0) {

            $shopowner = Shop::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.shop_view', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function product_view()
    {

        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        return view('backend.shopowner.count.product_view', ['shopowner' => $shopowner]);
    }

    public function unique_product_view()
    {

        if (count($this->uniqueProductViewCheck($this->get_shopid())) != 0) {
            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.uniqueproduct_view', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function buy_now_click()
    {
        if (count($this->buyNowClickViewCheck($this->get_shopid())) != 0) {
            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.buy_now_click', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function unique_add_to_cart_click()
    {
        if (count($this->uniqueAddToCartViewCheck($this->get_shopid())) != 0) {
            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.unique_add_to_cart_click', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function unique_whishlist_click()
    {
        if (count($this->uniqueWhishlistViewCheck($this->get_shopid())) != 0) {
            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.unique_whishlist_click', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function unique_ads_view()
    {
        if (count($this->uniqueAdsViewCheck($this->get_shopid())) != 0) {
            $shopowner = Shop::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.unique_ads_view', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function discount_product_view()
    {
        if (count($this->uniqueDiscountCheck($this->get_shopid())) != 0) {
            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.discount_product_view', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function get_shop_owner_view(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');


        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }

        $totalRecords = frontuserlogs::select('count(*) as allcount')->where('status', 'shopdetail')->where('shop_id', $this->get_shopid())
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('userorguestid', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;
        if ($columnName == 'created_at') {
            $columnName = 'front_user_logs.' . $columnName;
        }
        if ($columnName == 'user_name') {
            $columnName = 'users.username';
        }
        if ($columnName == 'user_id') {
            $columnName = 'guestoruserid.user_id';
        }
        if ($columnName == 'id') {
            $columnName = 'front_user_logs.id';
        }
        if ($columnName == 'shop') {
            $columnName = 'front_user_logs.shop_id';
        }
        $records = frontuserlogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->leftjoin('shop_owners', 'shop_owners.id', '=', 'front_user_logs.shop_id')->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')->orderBy($columnName, $columnSortOrder)
            ->orderBy('front_user_logs.created_at', 'desc')->where('front_user_logs.status', 'shopdetail')->where('front_user_logs.shop_id', $this->get_shopid())
            ->where(function ($query) use ($searchValue) {
                $query->where('front_user_logs.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('front_user_logs.userorguestid', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('front_user_logs.created_at', [$searchByFromdate, $searchByTodate])
            ->select('*', 'front_user_logs.created_at as fulct', 'front_user_logs.id as fulid')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();


        foreach ($records as $record) {
            if ($record->user_id == 0) {
                $getuser = 'guest';
                $id = $record->guest_id;
            } else {
                $getuser = User::where('id', $record->user_id)->first()->username;
                $id = $record->user_id;
            }
            $data_arr[] = array(
                "id" => $record->fulid,
                "shop" => $record->shop_id,
                "shop_name" => $record->shop_name,
                "user_id" => $id,
                "user_name" => $record->username,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->fulct)),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function get_buy_now_click(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');


        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }
        if ($columnName == 'created_at') {
            $columnName = 'buy_now_click_logs.' . $columnName;
        }
        if ($columnName == 'user_name') {
            $columnName = 'users.username';
        }
        if ($columnName == 'user_id') {
            $columnName = 'guestoruserid.user_id';
        }
        if ($columnName == 'id') {
            $columnName = 'buy_now_click_logs.id';
        }
        if ($columnName == 'shop') {
            $columnName = 'buy_now_click_logs.shop_id';
        }
        $totalRecords = BuyNowClickLog::select('count(*) as allcount')
            ->leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')

            ->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->leftjoin('items', 'items.id', '=', 'buy_now_click_logs.item_id')
            ->leftjoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')->where('items.shop_id', $this->get_shopid())
            ->where(function ($query) use ($searchValue) {
                $query->where('buy_now_click_logs.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.username', 'like', '%' . $searchValue . '%')
                    ->orWhere('guestoruserid.user_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('items.shop_id', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('guestoruserid.created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;
        $records = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')

            ->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->leftjoin('items', 'items.id', '=', 'buy_now_click_logs.item_id')
            ->leftjoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
            ->orderBy($columnName, $columnSortOrder)
            ->orderBy('buy_now_click_logs.created_at', 'desc')
            ->select('*', 'buy_now_click_logs.created_at as fulct', 'buy_now_click_logs.id as fulid', 'guestoruserid.user_id as goruserid')

            ->where(function ($query) use ($searchValue) {
                $query->where('buy_now_click_logs.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.username', 'like', '%' . $searchValue . '%')
                    ->orWhere('guestoruserid.user_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('items.shop_id', 'like', '%' . $searchValue . '%');
            })->where('items.shop_id', $this->get_shopid())
            ->whereBetween('buy_now_click_logs.created_at', [$searchByFromdate, $searchByTodate])
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            if ($record->goruserid == 0) {
                $getuser = 'guest';
                $id = $record->guest_id;
            } else {
                $getuser = User::where('id', $record->goruserid)->first()->username;
                $id = $record->goruserid;
            }
            $data_arr[] = array(
                "id" => $record->fulid,
                "user_name" => $getuser,
                "user_id" => $id,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->fulct)),
                // "deleted_at" => date('F d, Y ( h:i A )',strtotime($record->deleted_at)),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function get_unique_add_to_cart_click(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');


        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }
        if ($columnName == 'created_at') {
            $columnName = 'add_to_cart_click_logs.' . $columnName;
        }
        if ($columnName == 'user_name') {
            $columnName = 'users.username';
        }
        if ($columnName == 'user_id') {
            $columnName = 'guestoruserid.user_id';
        }
        if ($columnName == 'id') {
            $columnName = 'add_to_cart_click_logs.id';
        }
        if ($columnName == 'shop') {
            $columnName = 'items.shop_id';
        }
        $totalRecords = AddToCartClickLog::leftjoin('items', 'items.id', '=', 'add_to_cart_click_logs.item_id')
            ->leftjoin('guestoruserid', 'add_to_cart_click_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftjoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
            ->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')->select('count(*) as allcount')
            ->where(function ($query) use ($searchValue) {
                $query->where('add_to_cart_click_logs.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.username', 'like', '%' . $searchValue . '%')
                    ->orWhere('guestoruserid.user_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('items.shop_id', 'like', '%' . $searchValue . '%');
            })->where('items.shop_id', $this->get_shopid())
            ->whereBetween('add_to_cart_click_logs.created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;
        $records = AddToCartClickLog::leftjoin('items', 'items.id', '=', 'add_to_cart_click_logs.item_id')
            ->leftjoin('guestoruserid', 'add_to_cart_click_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftjoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
            ->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->orderBy($columnName, $columnSortOrder)
            ->orderBy('add_to_cart_click_logs.created_at', 'desc')
            ->where(function ($query) use ($searchValue) {
                $query->where('add_to_cart_click_logs.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.username', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('items.shop_id', 'like', '%' . $searchValue . '%');
            })->where('items.shop_id', $this->get_shopid())
            ->whereBetween('add_to_cart_click_logs.created_at', [$searchByFromdate, $searchByTodate])
            ->select('*', 'add_to_cart_click_logs.created_at as fulct', 'add_to_cart_click_logs.id as fulid')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            if ($record->user_id == 0) {
                $getuser = 'guest';
                $id = $record->guest_id;
            } else {
                $getuser = User::where('id', $record->user_id)->first()->username;
                $id = $record->user_id;
            }
            $data_arr[] = array(
                "id" => $record->fulid,
                "user_name" => $getuser,
                "user_id" => $id,
                "shop_id" => $record->shop_id,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->fulct)),
                // "deleted_at" => date('F d, Y ( h:i A )',strtotime($record->deleted_at)),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function get_unique_whishlist_click(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');


        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }
        if ($columnName == 'created_at') {
            $columnName = 'whislist_click_logs.' . $columnName;
        }
        if ($columnName == 'user_name') {
            $columnName = 'users.username';
        }
        if ($columnName == 'user_id') {
            $columnName = 'guestoruserid.user_id';
        }
        if ($columnName == 'id') {
            $columnName = 'whislist_click_logs.id';
        }
        if ($columnName == 'shop') {
            $columnName = 'items.shop_id';
        }
        $totalRecords = h::leftjoin('items', 'items.id', '=', 'whislist_click_logs.item_id')
            ->leftjoin('guestoruserid', 'whislist_click_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftjoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
            ->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')->select('count(*) as allcount')
            ->where(function ($query) use ($searchValue) {
                $query->where('whislist_click_logs.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.username', 'like', '%' . $searchValue . '%')
                    ->orWhere('guestoruserid.user_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('items.shop_id', 'like', '%' . $searchValue . '%');
            })->where('items.shop_id', $this->get_shopid())
            ->whereBetween('whislist_click_logs.created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;
        $records = h::leftjoin('items', 'items.id', '=', 'whislist_click_logs.item_id')
            ->leftjoin('guestoruserid', 'whislist_click_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftjoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
            ->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->orderBy($columnName, $columnSortOrder)
            ->orderBy('whislist_click_logs.created_at', 'desc')
            ->where(function ($query) use ($searchValue) {
                $query->where('whislist_click_logs.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.username', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('items.shop_id', 'like', '%' . $searchValue . '%');
            })->where('items.shop_id', $this->get_shopid())
            ->whereBetween('whislist_click_logs.created_at', [$searchByFromdate, $searchByTodate])
            ->select('*', 'whislist_click_logs.created_at as fulct', 'whislist_click_logs.id as fulid')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            if ($record->user_id == 0) {
                $getuser = 'guest';
                $id = $record->guest_id;
            } else {
                $getuser = User::where('id', $record->user_id)->first()->username;
                $id = $record->user_id;
            }
            $data_arr[] = array(
                "id" => $record->fulid,
                "user_name" => $getuser,
                "user_id" => $id,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->fulct)),
                // "deleted_at" => date('F d, Y ( h:i A )',strtotime($record->deleted_at)),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function get_unique_ads_view(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');


        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }
        if ($columnName == 'created_at') {
            $columnName = 'front_user_logs.' . $columnName;
        }
        if ($columnName == 'user_name') {
            $columnName = 'users.username';
        }
        if ($columnName == 'user_id') {
            $columnName = 'guestoruserid.user_id';
        }
        if ($columnName == 'id') {
            $columnName = 'front_user_logs.id';
        }
        if ($columnName == 'shop') {
            $columnName = 'front_user_logs.shop_id';
        }
        $totalRecords = frontuserlogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('count(*) as allcount')->leftjoin('ads', 'front_user_logs.ads_id', '=', 'ads.id')
            ->leftjoin('shop_owners', 'shop_owners.id', '=', 'ads.shop_id')

            ->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')->where('status', 'adsclick')
            ->where(function ($query) use ($searchValue) {
                $query->where('front_user_logs.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('front_user_logs.userorguestid', 'like', '%' . $searchValue . '%');
            })->where('ads.shop_id', $this->get_shopid())
            ->whereBetween('front_user_logs.created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;

        $records = frontuserlogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->leftjoin('ads', 'front_user_logs.ads_id', '=', 'ads.id')
            ->leftjoin('shop_owners', 'shop_owners.id', '=', 'ads.shop_id')

            ->orderBy($columnName, $columnSortOrder)
            ->orderBy('front_user_logs.created_at', 'desc')->where('front_user_logs.status', 'adsclick')
            ->where(function ($query) use ($searchValue) {
                $query->where('front_user_logs.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('front_user_logs.userorguestid', 'like', '%' . $searchValue . '%');
            })->where('ads.shop_id', $this->get_shopid())
            ->whereBetween('front_user_logs.created_at', [$searchByFromdate, $searchByTodate])
            ->select('*', 'front_user_logs.created_at as fulct', 'front_user_logs.id as fulid')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();


        foreach ($records as $record) {
            if ($record->user_id == 0) {
                $getuser = 'guest';
                $id = $record->guest_id;
            } else {
                $getuser = User::where('id', $record->user_id)->first()->username;
                $id = $record->user_id;
            }
            $data_arr[] = array(
                "id" => $record->fulid,
                "shop" => $record->shop_id,
                "shop_name" => $record->name,
                "user_id" => $id,
                "user_name" => $record->username,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->fulct)),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function get_discount_product_view(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $totalRecords = ItemLogActivity::select('count(*) as allcount')->where('shop_id', $this->get_shopid())->count();
        $totalRecordswithFilter = ItemLogActivity::select('count(*) as allcount')->where('shop_id', $this->get_shopid())->count();

        $users = ItemLogActivity::orderBy($columnName, $columnSortOrder)
            ->where('shop_id', $this->get_shopid())
            ->whereIn('item_id', Discount::pluck('item_id'))
            ->orderBy('created_at', 'desc')
            ->select('item_log_activities.*')
            ->skip($start)
            ->take($rowperpage)
            ->get()->unique('guest_id', 'user_id');


        $data_arr = array();

        foreach ($users as $user) {
            $data_arr[] = array(
                "id" => $user->id,
                "user_id" => $user->user_id,
                "user_name" => $user->user_name,
                "created_at" => date('F d, Y ( h:i A )', strtotime($user->created_at))
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function unique_get_item_activity_log(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $shop_id = 1;

        if (Auth::guard('shop_owner')->check()) {
            $shop_id = Auth::guard('shop_owner')->user()->id;
        } else {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        }

        $totalRecords = Itemlogactivity::select('count(*) as allcount')->where('shop_id', $shop_id)->count();
        // $totalRecords = ItemLogActivity::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Itemlogactivity::select('count(*) as allcount')->where('shop_id', $shop_id)->count();
        // $totalRecordswithFilter = ItemLogActivity::select('count(*) as allcount')->count();

        $records = ItemLogActivity::orderBy($columnName, $columnSortOrder)
            ->where('shop_id', $shop_id)->orderBy('created_at', 'desc')
            // ->where('product_code', 'like', '%' . $searchValue . '%')
            // ->orWhere('name', 'like', '%' . $searchValue . '%')
            ->select('item_log_activities.*')
            ->skip($start)
            ->take($rowperpage)
            ->get()->unique('user_id', 'guest_id');


        //    return $records;
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "item_code" => $record->item_code,
                "name" => $record->name,
                "user_id" => $record->user_id,
                "user_name" => $record->user_name,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->created_at)),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function shop_detail()
    {

        $users_list = $this->getuserlistbyrolelevel();
        $result = Shops::where('id', $this->get_shopid())->with(['getPhotos'])->orderBy('created_at', 'desc')->get();
        $items = Item::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        return view('backend.shopowner.shop', ['shopowner' => $result, 'items' => $items, 'managers' => $users_list]);
    }

    public function edit()
    {
        if ($this->isstaff()) {
            return $this->unauthorize();
        }
        $shopowner = Shops::where('id', $this->get_shopid())->with(['getPhotos'])->orderBy('created_at', 'desc')->get();
        return view('backend.shopowner.edit', ['shopowner' => $shopowner]);
    }

    public function update(Request $request, $id)
    {
        if ($this->isstaff()) {
            return $this->unauthorize();
        }
        //remove token and method from request
        $input = $request->except('_token', '_method');


        // $input = $request->except('_token', '_method');
        $shopowner = Shop::findOrFail($id);
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'shop_name' => ['required', 'string', 'max:255'], //Rule::unique('shop_owners')->ignore($shopowner->id)
                'shop_name_url' => ['required', 'alpha_num', 'string', 'max:255'],
                'description' => ['string', 'max:1112255'],
                'shop_logo' => 'nullable|mimes:jpeg,bmp,png,jpg',
                'banner.*' => 'mimes:jpeg,bmp,png,jpg',
                // 'main_phone' =>  ['required', 'string', 'max:20','unique:manager,phone','unique:users,phone','unique:shop_owners,main_phone'],
                'main_phone' => [
                    'required',
                    Rule::unique('shop_owners')->ignore($shopowner->id),
                    Rule::unique('manager', 'phone')->ignore($shopowner->id),
                ],
                'messenger_link' => 'max:1130',
            ]
        );
        $add_ph = json_decode($request->additional_phones);
        $add_ph_array = [];

        if (json_decode($request->additional_phones) !== null) {
            foreach ($add_ph as $k => $v) {
                if (count($add_ph) != 0) {
                    $ph = json_decode(json_encode($v), true);
                    foreach ($ph as $k2 => $v2) {
                        array_push($add_ph_array, $v2);
                    }
                }
            }
        }
        // dd($add_ph_array);
        $shopowner->name = $request->name;
        $shopowner->shop_name_url = $request->shop_name_url;
        $shopowner->shop_name = $request->shop_name;
        $shopowner->shop_name_myan = $request->shop_name_myan;
        $shopowner->description = $request->description;
        $shopowner->address = $request->address;
        $shopowner->main_phone = $request->main_phone;
        $shopowner->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ = $request->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ;
        $shopowner->အထည်မပျက်_ပြန်သွင်း = $request->အထည်မပျက်_ပြန်သွင်း;
        $shopowner->အထည်ပျက်စီးချို့ယွင်း = $request->အထည်ပျက်စီးချို့ယွင်း;
        $shopowner->messenger_link = $request->messenger_link;
        $shopowner->page_link = $request->page_link;
        $shopowner->map = $request->map;
        $shopowner->additional_phones = json_encode($add_ph_array);
        $shopowner->other_address = $request->other_address;


        if ($request->file('shop_logo')) {

            if (File::exists(public_path($shopowner->shop_logo))) {
                File::delete(public_path($shopowner->shop_logo));
            }

            $shop_logo = time() . '1.' . $request->file('shop_logo')->getClientOriginalExtension();
            $get_path = $request->file('shop_logo')->move(public_path('images/logo'), $shop_logo);
            $this->setthumbslogo($get_path, $shop_logo);

            $shopowner->shop_logo = $shop_logo;
        }

        $updateSuccess = $shopowner->update();

        if ($request->hasFile('banner')) {
            $shop_banner = ShopBanner::where('shop_owner_id', $id)->get();
            foreach ($shop_banner as $b) {
                if (File::exists(public_path($b->location))) {
                    File::delete(public_path($b->location));
                }
            }
            if (isset($shopowner->getPhotos)) {
                $del = $shopowner->getPhotos->pluck("id");
                ShopBanner::destroy($del);
            }

            $fileNameArr = [];
            foreach ($request->banner as $b) {
                $newFileName = uniqid() . '_banner' . '.' . $b->getClientOriginalExtension();
                array_push($fileNameArr, $newFileName);
                $b->move(public_path('images/banner'), $newFileName);
            }
            foreach ($fileNameArr as $f) {
                $banner = new ShopBanner();
                $banner->shop_owner_id = $id;
                $banner->location = $f;
                $banner->save();
            }
        }


        if ($updateSuccess) {
            return redirect()->route('backside.shop_owner.shop_detail')->with(['status' => 'success', 'message' => 'Your Shop was successfully Edited']);
        } else {
            return dd($input);
        }
    }

    /**
     *
     *  Point System Section
     *
     *
     */

    public function add_price()
    {
        $goldPoint = GoldPoint::latest()->first();
        return view('backend.shopowner.points.add_price', compact('goldPoint'));
    }

    public function add_price_create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'amount' => 'required',
        ]);
        $isUser = User::where('phone', $request->phone)->first();
        if (isset($isUser)) {
            $user_gold_points = new ShopOwnerGoldPoint();
            $user_gold_points->user_id = $isUser->id;
            $user_gold_points->name = $request->name;
            $user_gold_points->phone = $request->phone;
            $user_gold_points->point = $request->point;
            $user_gold_points->amount = $request->amount;
            $user_gold_points->save();
            return redirect()->back()->with('success', 'Point added successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'User does not exit']);
        }
    }

}
