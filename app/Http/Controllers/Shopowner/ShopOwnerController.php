<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\CalculateCat;
use App\Http\Controllers\Trait\CountSettingCheck;
use App\Http\Controllers\Trait\UserRole;
use App\Http\Controllers\Trait\YKImage;
use App\Models\AddToCartClickLog;
use App\Models\Ads;
use App\Models\BuyNowClickLog;
use App\Models\CountSetting;
use App\Models\Discount;
use App\Models\FrontUserLogs;
use App\Models\GoldPoint;
use App\Models\Item;
use App\Models\ItemLogActivity;
use App\Models\ShopBanner;
use App\Models\ShopLogActivity;
use App\Models\ShopOwnerGoldPoint;
use App\Models\Shops;
use App\Models\SiteSettings;
use App\Models\User;
use App\Models\WishlistClickLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Models\Orders;
use App\Models\ShopOwnersAndStaffs;

class ShopOwnerController extends Controller
{
    use YKImage, UserRole, CountSettingCheck, CalculateCat;

    public function __construct()
    {
        //
        $this->middleware('auth:shop_owners_and_staffs');
    }

    public function index(): View
    {
        $storecattocache = Cache::put('cat', $this->getallcatcount());
        $items = Item::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        return view('backend.shopowner.list', ['items' => $items]);
    }
    
    //order list for shop owner
    public function orderList()
    {
        return view('backend.shopowner.orders.index');
    }

    public function get_orders(Request $request)
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        // $searchByFromdate = empty($searchByFromdate)
        //     ? Carbon::now()->startOfDay()
        //     : Carbon::parse($searchByFromdate)->startOfDay();

        // $searchByTodate = empty($searchByTodate)
        //     ? Carbon::now()->endOfDay()
        //     : Carbon::parse($searchByTodate)->endOfDay();

        $shopOwner = Auth::guard('shop_owners_and_staffs')->user();
        $shop_id = $shopOwner->shop_id;
        
        if(empty($searchByFromdate) && empty($searchByTodate)){
            $recordsQuery = Orders::with('items')
            ->whereHas('items', function($query) use ($shop_id){
                $query->where('shop_id', $shop_id);
            })
            ->latest()->take(30)->get();
        }else{
            $recordsQuery = Orders::with('items')
            ->whereHas('items', function ($query) use ($shop_id) {
                $query->where('shop_id', $shop_id);
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->get();
        }

        // $recordsQuery = Orders::with('items')
        //     ->whereHas('items', function ($query) use ($shop_id) {
        //         $query->where('shop_id', $shop_id);
        //     })
        //     ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
        //     ->get();
        $tmpcount = 0;

        foreach ($recordsQuery as $key => $value) {
            $tmpcount=$tmpcount+1;
            $recordsQuery[$key]['dtid'] = $tmpcount;
        }

        return DataTables::of($recordsQuery)
            ->editColumn('created_at', fn ($record) => $record->created_at->format('F d, Y (h:i A)'))
            ->editColumn('product_name', function ($record) {
                return $record->items->name ?? '';
            })
            ->editColumn('action', fn ($record) => $record->id)
            ->editColumn('id', fn ($record) => $record->dtid)

            ->editColumn('product_code', function ($record) {
                return $record->items->product_code ?? '';
            })
            ->editColumn('shop_name', function ($record) use ($shop_id) {
                $shop = Shops::find($shop_id);
                return $shop ? $shop->shop_name : '';
            })
            ->make(true);
    }

    public function orderDetail($id)
    {
        $order= Orders::with('items')->where('id',$id)->first();
        return view('backend.shopowner.orders.detail',['order'=>$order]);
    }
    //order list for shop owner

    public function detail(): View
    {

        $shop = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->first();

        $items = Item::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->limit(6)->get();

        $products_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'item')->count();
        if ($products_count_setting != 0) {
            $items_count = Item::where('shop_id', $this->get_shopid())->count();
        } else {
            $items_count = null;
            $shopview = null;
        }

        $shops_view_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'shop_view')->count();
        if ($shops_view_count_setting != 0) {
            $shopview = frontuserlogs::where('shop_id', $this->get_shopid())->where('status', 'shopdetail')->orderBy('created_at', 'desc')->get()->unique('guest_id')->count();
        } else {
            $shopview = null;
        }

        $items_view_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'items_view')->count();
        if ($items_view_count_setting != 0) {
            $productclick = frontuserlogs::leftjoin('items', 'front_user_logs.product_id', '=', 'items.id')->where('front_user_logs.status', 'product_detail')->where('items.shop_id', $this->get_shopid())->orderBy('front_user_logs.created_at', 'desc')->get()->count();
        } else {
            $productclick = null;
        }

        $unique_product_click_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'item_unique_view')->count();
        if ($unique_product_click_count_setting != 0) {
            $unique_productclick = ItemLogActivity::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->get()->unique('user_id', 'guest_id')->count();
        } else {
            $unique_productclick = null;
        }

        $buy_now_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'buyNowClick')->count();
        if ($buy_now_count_setting != 0) {
            $buynowclick = BuyNowClickLog::leftjoin('items', 'items.id', 'buy_now_click_logs.item_id')->where('items.shop_id', $this->get_shopid())->orderBy('buy_now_click_logs.created_at', 'desc')->get()->count();
        } else {
            $buynowclick = null;
        }

        $addtocartclick_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'addToCartClick')->count();
        if ($addtocartclick_count_setting != 0) {
            $addtocartclick = AddToCartClickLog::leftjoin('items', 'items.id', 'add_to_cart_click_logs.item_id')->where('items.shop_id', $this->get_shopid())->orderBy('add_to_cart_click_logs.created_at', 'desc')->get()->unique('guest_id', 'user_id')->count();
        } else {
            $addtocartclick = null;
        }

        $whislistclick_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'whislistclick')->count();
        if ($whislistclick_count_setting != 0) {
            $whislistclick = WishlistClickLog::leftjoin('items', 'items.id', 'wishlist_click_logs.item_id')->where('items.shop_id', $this->get_shopid())->orderBy('wishlist_click_logs.created_at', 'desc')->get()->count();
        } else {
            $whislistclick = null;
        }

        $discountview_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'discountview')->count();
        if ($discountview_count_setting != 0) {
            $discountview = ItemLogActivity::where('shop_id', $this->get_shopid())->whereIn('item_id', Discount::pluck('item_id'))->get()->count();
        } else {
            $discountview = null;
        }

        $adsview_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'adsview')->count();
        if ($adsview_count_setting != 0) {
            $adsview = ShopLogActivity::where('shop', $this->get_shopid())->whereIn('shop', Ads::pluck('shop_id'))->get()->count();
        } else {
            $adsview = null;
        }

        $users = $this->get_user_list_by_role_level_select()->limit(6)->get();

        $users_count_setting = CountSetting::where('shop_id', $this->get_shopid())->where('name', 'users')->count();
        if ($users_count_setting != 0) {
            $users_count = $this->get_user_list_by_role_level_count();
        } else {
            $users_count = null;
        }

        $banner = ShopBanner::where('shop_owner_id', $this->get_shopid())->first();

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

            'shop' => $shop,

            'items' => $items,
            'items_count' => $items_count,
            'products_count_setting' => $products_count_setting,

            'users_count' => $users_count,
            'users' => $users,
            'users_count_setting' => $users_count_setting,

            'banner' => $banner,

        ]);
    }

    public function shop_view(): mixed
    {
        if (count($this->shopViewCheck($this->get_shopid())) != 0) {

            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.shop_view', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function product_view(): View
    {

        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        return view('backend.shopowner.count.product_view', ['shopowner' => $shopowner]);
    }

    public function unique_product_view(): View
    {

        if (count($this->uniqueProductViewCheck($this->get_shopid())) != 0) {
            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.uniqueproduct_view', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function buy_now_click(): View
    {
        if (count($this->buyNowClickViewCheck($this->get_shopid())) != 0) {
            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.buy_now_click', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function unique_add_to_cart_click(): View
    {
        if (count($this->uniqueAddToCartViewCheck($this->get_shopid())) != 0) {
            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.unique_add_to_cart_click', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function unique_whishlist_click(): View
    {
        if (count($this->uniqueWhishlistViewCheck($this->get_shopid())) != 0) {
            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.unique_whishlist_click', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function unique_ads_view(): View
    {
        if (count($this->uniqueAdsViewCheck($this->get_shopid())) != 0) {
            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.unique_ads_view', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function discount_product_view(): View
    {
        if (count($this->uniqueDiscountCheck($this->get_shopid())) != 0) {
            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            return view('backend.shopowner.count.product_view', ['shopowner' => $shopowner]);
        } else {
            return abort(404);
        }
    }

    public function get_shop_owner_view(Request $request): JsonResponse
    {

        $searchByFromdate = $request->input('searchByFromdate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('searchByTodate') ?? Carbon::now();

        $shop_id = $this->get_shopid();

        $query = FrontUserLogs::leftJoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftJoin('shop_owners', 'shop_owners.id', '=', 'front_user_logs.shop_id')
            ->leftJoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->orderBy('front_user_logs.created_at', 'desc')
            ->where('front_user_logs.status', 'shopdetail')
            ->where('front_user_logs.shop_id', $shop_id)
            ->whereBetween('front_user_logs.created_at', [$searchByFromdate, $searchByTodate])
            ->select('*', 'front_user_logs.created_at as fulct', 'front_user_logs.id as fulid');

        return DataTables::of($query)
            ->addColumn('user_id', function ($record) {
                return $record->user_id == 0 ? $record->guest_id : $record->user_id;
            })
            ->addColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->fulct));
            })
            ->toJson();
    }

    public function get_buy_now_click(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('searchByTodate') ?? Carbon::now();

        $shop_id = $this->get_shopid();

        $query = BuyNowClickLog::leftJoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftJoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->leftJoin('items', 'items.id', '=', 'buy_now_click_logs.item_id')
            ->leftJoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
            ->orderBy('buy_now_click_logs.created_at', 'desc')
            ->select('*', 'buy_now_click_logs.created_at as fulct', 'buy_now_click_logs.id as fulid', 'guestoruserid.user_id as goruserid')
            ->where('items.shop_id', $shop_id)
            ->whereBetween('buy_now_click_logs.created_at', [$searchByFromdate, $searchByTodate]);

        return DataTables::of($query)
            ->addColumn('user_name', function ($record) {
                if ($record->goruserid == 0) {
                    return 'guest';
                } else {
                    return User::where('id', $record->goruserid)->value('username');
                }
            })
            ->addColumn('user_id', function ($record) {
                return $record->goruserid == 0 ? $record->guest_id : $record->goruserid;
            })
            ->addColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->fulct));
            })
            ->toJson();
    }

    public function get_unique_add_to_cart_click(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('searchByTodate') ?? Carbon::now();

        $shop_id = $this->get_shopid();

        $query = AddToCartClickLog::leftJoin('items', 'items.id', '=', 'add_to_cart_click_logs.item_id')
            ->leftJoin('guestoruserid', 'add_to_cart_click_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftJoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
            ->leftJoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->orderBy('add_to_cart_click_logs.created_at', 'desc')
            ->where('items.shop_id', $shop_id)
            ->whereBetween('add_to_cart_click_logs.created_at', [$searchByFromdate, $searchByTodate])
            ->select('*', 'add_to_cart_click_logs.created_at as fulct', 'add_to_cart_click_logs.id as fulid');

        return DataTables::of($query)
            ->addColumn('user_name', function ($record) {
                if ($record->user_id == 0) {
                    return 'guest';
                } else {
                    return User::where('id', $record->user_id)->value('username');
                }
            })
            ->addColumn('user_id', function ($record) {
                return $record->user_id == 0 ? $record->guest_id : $record->user_id;
            })
            ->addColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->fulct));
            })
            ->toJson();
    }

    public function get_unique_wishlist_click(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('searchByTodate') ?? Carbon::now();

        $shop_id = $this->get_shopid();

        $query = WishlistClickLog::leftJoin('items', 'items.id', '=', 'whislist_click_logs.item_id')
            ->leftJoin('guestoruserid', 'whislist_click_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftJoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
            ->leftJoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->orderBy('whislist_click_logs.created_at', 'desc')
            ->where('items.shop_id', $shop_id)
            ->whereBetween('whislist_click_logs.created_at', [$searchByFromdate, $searchByTodate])
            ->select('*', 'whislist_click_logs.created_at as fulct', 'whislist_click_logs.id as fulid');

        return DataTables::of($query)
            ->addColumn('user_name', function ($record) {
                if ($record->user_id == 0) {
                    return 'guest';
                } else {
                    return User::where('id', $record->user_id)->value('username');
                }
            })
            ->addColumn('user_id', function ($record) {
                return $record->user_id == 0 ? $record->guest_id : $record->user_id;
            })
            ->addColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->fulct));
            })
            ->toJson();
    }

    public function get_unique_ads_view(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('searchByTodate') ?? Carbon::now();

        $shop_id = $this->get_shopid();

        $query = FrontUserLogs::leftJoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftJoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->leftJoin('ads', 'front_user_logs.ads_id', '=', 'ads.id')
            ->leftJoin('shop_owners', 'shop_owners.id', '=', 'ads.shop_id')
            ->orderBy('front_user_logs.created_at', 'desc')
            ->where('front_user_logs.status', 'adsclick')
            ->where('ads.shop_id', $shop_id)
            ->whereBetween('front_user_logs.created_at', [$searchByFromdate, $searchByTodate])
            ->select('*', 'front_user_logs.created_at as fulct', 'front_user_logs.id as fulid');

        return DataTables::of($query)
            ->addColumn('user_name', function ($record) {
                if ($record->user_id == 0) {
                    return 'guest';
                } else {
                    return User::where('id', $record->user_id)->value('username');
                }
            })
            ->addColumn('user_id', function ($record) {
                return $record->user_id == 0 ? $record->guest_id : $record->user_id;
            })
            ->addColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->fulct));
            })
            ->toJson();
    }

    public function get_discount_product_view(Request $request): JsonResponse
    {
        $users = ItemLogActivity::where('shop_id', $this->get_shopid())
            ->whereIn('item_id', Discount::pluck('item_id'))
            ->orderBy('created_at', 'desc')
            ->select('item_log_activities.*')
            ->get()
            ->unique('guest_id', 'user_id');

        return DataTables::of($users)
            ->addColumn('user_id', function ($user) {
                return $user->user_id;
            })
            ->addColumn('user_name', function ($user) {
                return $user->user_name;
            })
            ->addColumn('created_at', function ($user) {
                return date('F d, Y ( h:i A )', strtotime($user->created_at));
            })
            ->toJson();
    }

    public function unique_get_item_activity_log(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();

        $query = ItemLogActivity::query()
            ->where('shop_id', $shop_id);

        $records = $query->select('item_log_activities.*')
            ->get()
            ->unique(function ($item) {
                return $item['user_id'] . '-' . $item['guest_id'];
            });

        $data_arr = [];

        foreach ($records as $record) {
            $data_arr[] = [
                "id" => $record->id,
                "item_code" => $record->item_code,
                "name" => $record->name,
                "user_id" => $record->user_id,
                "user_name" => $record->user_name,
                "created_at" => $record->created_at->format('F d, Y ( h:i A )'),
            ];
        }

        return DataTables::of($data_arr)
            ->addColumn('DT_RowId', function ($record) {
                return $record['id'];
            })
            ->rawColumns(['DT_RowId'])
            ->make(true);
    }

    public function shop_detail(): View
    {

        $users_list = $this->getuserlistbyrolelevel();
        $result = Shops::where('id', $this->get_shopid())->with(['getPhotos'])->orderBy('created_at', 'desc')->get();
        $items = Item::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $banner = ShopBanner::where('shop_owner_id', $this->get_shopid())->first();
        $siteSettingAction = SiteSettings::where('id', 1)->first()->action;
        return view('backend.shopowner.shop', ['shopowner' => $result, 'items' => $items, 'managers' => $users_list, 'banner' => $banner, 'siteSettingAction' => $siteSettingAction]);
    }

    public function edit()
    {
        if ($this->is_staff()) {
            return $this->unauthorize();
        }
        $shopowner = Shops::where('id', $this->get_shopid())->with(['getPhotos'])->orderBy('created_at', 'desc')->get();
        return view('backend.shopowner.edit', ['shopowner' => $shopowner]);
    }
    public function delete_all_banner_images($imagename)
    {
        if (dofile_exists('/shop_owner/banner/' . $imagename)) {
            $this->delete_image('shop_owner/banner/' . $imagename);
        }

    }

    public function update(Request $request, $id)
    {
        if ($this->is_staff()) {
            return $this->unauthorize();
        }
        //remove token and method from request
        $input = $request->except('_token', '_method');

        // $input = $request->except('_token', '_method');
        $shopowner = Shops::findOrFail($id);
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
                    Rule::unique('shops')->ignore($shopowner->id),
                    Rule::unique('shop_owners_and_staffs', 'phone')->where('shop_id', '<>', $shopowner->id),
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
        $shopowner->valuable_product = $request->valuable_product;
        $shopowner->undamaged_product = $request->undamaged_product;
        $shopowner->damaged_product = $request->damaged_product;
        $shopowner->messenger_link = $request->messenger_link;
        $shopowner->page_link = $request->page_link;
        $shopowner->map = $request->map;
        $shopowner->additional_phones = json_encode($add_ph_array);
        $shopowner->other_address = $request->other_address;

        if ($request->file('shop_logo')) {
            $this->delete_all_logo_images($shopowner->shop_logo);

            $shop_logo = time() . '1.' . $request->file('shop_logo')->getClientOriginalExtension();
            $this->save_image_shop_logo($request->file('shop_logo'), $shop_logo, 'shop_owner/logo/');
            // $this->setthumbslogo($get_path, $shop_logo);

            $shopowner->shop_logo = $shop_logo;
        }

        $updateSuccess = $shopowner->update();
        $shopownerandstaff = ShopOwnersAndStaffs::where('shop_id',$id)->where('role_id','4')->update(['phone'=>$request->main_phone]);

        if ($request->hasFile('banner')) {
            $shop_banner = ShopBanner::where('shop_owner_id', $id)->get();
            foreach ($shop_banner as $b) {
                $this->delete_all_banner_images($b->location);
            }
            if (isset($shopowner->getPhotos)) {
                $del = $shopowner->getPhotos->pluck("id");
                ShopBanner::destroy($del);
            }

            $fileNameArr = [];
            foreach ($request->banner as $b) {
                $newFileName = uniqid() . '_banner' . '.' . $b->getClientOriginalExtension();
                array_push($fileNameArr, $newFileName);
                $this->save_image($b, $newFileName, 'shop_owner/banner/');
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
    public function delete_all_logo_images($imagename)
    {
        if (dofile_exists('/shop_owner/logo/' . $imagename)) {
            $this->delete_image('shop_owner/logo/' . $imagename);
        }
        if (dofile_exists('/shop_owner/logo/mid/' . $imagename)) {
            $this->delete_image('shop_owner/logo/mid/' . $imagename);
        }
        if (dofile_exists('/shop_owner/logo/thumbs/' . $imagename)) {
            $this->delete_image('shop_owner/logo/thumbs/' . $imagename);
        }
    }

    /**
     *
     *  Point System Section
     *
     *
     */

    public function add_price(): View
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
