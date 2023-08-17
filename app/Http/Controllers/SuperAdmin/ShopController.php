<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\ShopDelete;
use App\Http\Controllers\Trait\UserRole;
use App\Models\AddToCartClickLog;
use App\Models\BuyNowClickLog;
use App\Models\CountSetting;
use App\Models\FeaturesForShops;
use App\Models\FrontUserLogs;
use App\Models\GuestOrUserId;
use App\Models\Item;
use App\Models\Manager;
use App\Models\Messages;
use App\Models\PremiumTemplate;
use App\Models\ShopBanner;
use App\Models\ShopDirectory;
use App\Models\Shops;
use App\Models\State;
use App\Models\SuperAdminLogActivity;
use App\Models\User;
use App\Models\WishlistClickLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ShopController extends Controller
{
    use ShopDelete;
    use UserRole;

    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }

    /**
     * Chat Lists
     *
     * @var array
     */

    public function show_owner_using_chat(): View
    {

        $shopowner_only_count = Messages::where('from_role', 'shopowner')->groupBy('message_shop_id')->get();
        return view('backend.super_admin.shops.shopowner_chat_using', compact('shopowner_only_count'));
    }

    // NOTE : This method has a model which uses MongoDB
    public function show_owner_using_chat_all(Request $request): mixed
    {
        $searchByFromdate = $request->input('fromDate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('toDate') ?? Carbon::now();

        $recordsQuery = Messages::whereBetween('created_at', [
            Carbon::createFromDate($searchByFromdate),
            Carbon::createFromDate($searchByTodate)->addDays(1),
        ])
            ->get(['message_shop_id', 'created_at']);

        $data_arr = [];

        foreach ($recordsQuery as $record) {
            foreach ($record->ShopName as $shop_name) {
                $owner_chat_count = Messages::where('message_shop_id', (int) $shop_name->id)
                    ->where('from_role', 'shopowner')
                    ->groupBy('message_user_id')
                    ->count();

                $user_chat_count = Messages::where('message_shop_id', (int) $shop_name->id)
                    ->where('from_role', 'user')
                    ->groupBy('message_user_id')
                    ->count();

                $data_arr[] = [
                    "id" => $shop_name->id,
                    "name" => $shop_name->shop_name,
                    "created_at" => $record->created_at,
                    "owner_chat_count" => $owner_chat_count,
                    "user_chat_count" => $user_chat_count,
                    "action" => $shop_name->id,
                ];
            }
        }

        return DataTables::of(collect($data_arr))->make(true);
    }

    public function show_owner_using_chat_detail($id): View
    {
        $get_message_shops = Messages::where('message_shop_id', (int) $id)
            ->groupBy('message_user_id')
            ->get();

        $messages_all_users = $this->paginate($get_message_shops);

        $messages = Messages::where('message_shop_id', (int) $id)->get();
        $shop_owner = Messages::where('message_shop_id', (int) $id)->first();
        $shop_id = Shops::where('id', $id)->first();

        $chat_count = Messages::where('message_shop_id', (int) $id)->groupBy('message_user_id')->get();

        return view('backend.super_admin.shops.shopowner_chat_using_detail', [
            'messages_all_users' => $messages_all_users,
            'messages' => $messages,
            'shop_owner' => $shop_owner,
            'shop_id' => $shop_id,
            'counts' => $chat_count,
        ]);
    }

    public function paginate($messages, $perPage = 10, $page = 1): LengthAwarePaginator
    {

        $page = Paginator::resolveCurrentPage();

        $messages = $messages instanceof Collection ? $messages : Collection::make($messages);

        return new LengthAwarePaginator($messages->forPage($page, $perPage), $messages->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]);
    }

    public function shop_owner_chat_product_code_search(Request $request): View
    {
        // return $request;
        // return Messages::where('message_shop_id',(int)$request->id)->get();
        $messages_all_users = Messages::when(isset(request()->search), function ($q) {
            $search = request()->search;
            $regexQuery = '/.*' . $search . '.*/';
            $q->find([
                '$and' => [

                    ['message' => ['$gt' => $search, '$lt' => $search]],
                ],
            ]);
        })->where('message_shop_id', (int) request()->id)->groupBy('message_user_id')->get();
        return DB::select(DB::raw("SELECT * FROM messages WHERE JSON_EXTRACT(message, '$.product_code') = '123'"));

        // $messages_all_users  = Messages::where('message_shop_id',(int)$request->id)
        // ->whereBetween('created_at',array(
        //          Carbon::createFromDate($request->from),
        //          Carbon::createFromDate($request->to)->addDays(1)
        //      ))
        //      ->groupBy('message_user_id')
        //      ->get();

        $messages = Messages::where('message_shop_id', (int) $request->id)->get();
        $shop_owner = Messages::where('message_shop_id', (int) $request->id)->first();
        $shop_id = Shops::where('id', $request->id)->first();

        return view('backend.super_admin.shops.shop_date_filter', [
            'messages_all_users' => $messages_all_users,
            'messages' => $messages,
            'shop_owner' => $shop_owner,
            'shop_id' => $shop_id,
        ]);
    }

/**
 * For shops
 *
 * @var array
 */

    public function all(): View
    {
        $shopowner = Shops::all();
        return view('backend.super_admin.shops.all', ['shopowner' => $shopowner]);
    }

    /**
     * super_admin\shops\trash.blade.php
     */
    public function get_all_trash_shop(Request $request): mixed
    {
        $recordsQuery = Shops::where('deleted_at', '!=', null)->onlyTrashed()->orderBy('created_at', 'desc');

        return DataTables::of($recordsQuery)
            ->addColumn('checkbox', function ($record) {
                return $record->id;
            })
            ->addColumn('expired', function ($record) {
                $deleteDate = Carbon::parse($record->deleted_at);
                $expiredMonth = Carbon::now()->subMonths(3);
                $diff = $expiredMonth->diffInDays($deleteDate);
                return $record->deleted_at < Carbon::now()->subMonths(3) ? 'expired' : $diff;
            })
            ->addColumn('shop_name', function ($record) {
                return $record->shop_name ?: '-';
            })
            ->addColumn('shop_name_myan', function ($record) {
                return $record->shop_name_myan ?: '-';
            })
            ->addColumn('action', function ($record) {
                return $record->id;
            })
            ->addColumn('created_at_formatted', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->rawColumns(['expired', 'shop_name', 'shop_name_myan', 'created_at_formatted'])
            ->make(true);
    }
    public function get_all_shops(Request $request)
    {
        $searchByFromdate = $request->input('fromDate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('toDate') ?? Carbon::now();

        $recordsQuery = Shops::select('shops.*')
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->orderBy('created_at', 'desc');

        return DataTables::of($recordsQuery)
            ->addColumn('shop_banner', function ($record) {
                $checkbanner = ShopBanner::where('shop_owner_id', $record->id)->first();
                return empty($checkbanner) ? '' : $checkbanner->location;
            })
            ->addColumn('description', function ($record) {
                return Str::limit($record->description, 50, ' ...');
            })
            ->addColumn('shop_name_myan', function ($record) {
                return $record->shop_name_myan ?: '-';
            })
            ->addColumn('state', function ($record) {
                $state = State::where('id', $record->state)->value('name');
                return $state;
            })
            ->addColumn('action', function ($record) {
                return $record->id;
            })
            ->addColumn('created_at_formatted', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->rawColumns(['shop_banner', 'description', 'shop_name_myan', 'state', 'created_at_formatted'])
            ->make(true);
    }

// datable for shop log activity
    public function get_shop_activity(Request $request): mixed
    {
        $searchByFromdate = $request->input('fromDate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('toDate') ?? Carbon::now();

        $recordsQuery = SuperAdminLogActivity::select('superadmin_log_activities.*')
            ->where('type', 'shop')
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->orderBy('created_at', 'desc');

        return DataTables::of($recordsQuery)
            ->addColumn('created_at_formatted', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->rawColumns(['created_at_formatted'])
            ->make(true);
    }

    public function show($id): View
    {
        $shop = Shops::findOrFail($id);
        $all = CountSetting::where('shop_id', $shop->id)->where('name', 'all')->get();
        $products_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'item')->get();
        $users_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'users')->get();
        $users_inquiry_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'inquiry')->get();
        $shops_view_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'shop_view')->get();
        $items_view_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'items_view')->get();
        $unique_product_click_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'item_unique_view')->get();
        $buy_now_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'buyNowClick')->get();
        $addtocartclick_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'addToCartClick')->get();
        $whislistclick_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'whislistclick')->get();
        $discountview_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'discountview')->get();
        $adsview_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'adsview')->get();
        $poson = FeaturesForShops::where([['shop_id', '=', $shop->id], ['feature', '=', 'pos']])->get();

        $premium_template = PremiumTemplate::where('id', $shop->premium_template_id)->first();
        return view('backend.super_admin.shops.detail', [
            'all' => $all,
            'shop' => $shop,
            'products_count_setting' => $products_count_setting,
            'users_count_setting' => $users_count_setting,
            'users_inquiry_setting' => $users_inquiry_setting,
            'shops_view_count_setting' => $shops_view_count_setting,
            'items_view_count_setting' => $items_view_count_setting,
            'unique_product_click_count_setting' => $unique_product_click_count_setting,
            'buy_now_count_setting' => $buy_now_count_setting,
            'addtocartclick_count_setting' => $addtocartclick_count_setting,
            'whislistclick_count_setting' => $whislistclick_count_setting,
            'discountview_count_setting' => $discountview_count_setting,
            'adsview_count_setting' => $adsview_count_setting,
            'poson' => $poson,
            'premium_template' => $premium_template,
        ]);
    }

    public function counts_setting(Request $request): JsonResponse
    {
        if ($request->setting == 0) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'item')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "item";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 1) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'users')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "users";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 2) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'shop_view')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "shop_view";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 3) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'items_view')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "items_view";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 4) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'item_unique_view')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "item_unique_view";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 5) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'buyNowClick')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "buyNowClick";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 6) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'addToCartClick')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "addToCartClick";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 7) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'whislistclick')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "whislistclick";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 8) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'discountview')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "discountview";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 9) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'adsview')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "adsview";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 10) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'inquiry')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "inquiry";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 111) {
            if ($request->action == 0) {
                FeaturesForShops::where([['shop_id', '=', $request->id], ['feature', '=', 'pos']])->forceDelete();
            } else {
                $count_setting = new FeaturesForShops();
                $count_setting->shop_id = $request->id;
                $count_setting->feature = "pos";

                $count_setting->save();
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function all_counts_setting(Request $request): JsonResponse
    {

        $array = ["item", "users", "shop_view", "items_view", "item_unique_view", "buyNowClick", "addToCartClick", "whislistclick", "discountview", "adsview", "inquiry", "pos"];
        if ($request->action == 0) {
            CountSetting::where('shop_id', $request->id)->forceDelete();
            FeaturesForShops::where([['shop_id', '=', $request->id], ['feature', '=', 'pos']])->forceDelete();
        } else {
            $count_setting = new CountSetting();
            $count_setting->name = "all";
            $count_setting->setting = "on";
            $count_setting->shop_id = $request->id;
            $count_setting->save();

            foreach ($array as $value) {
                if ($value == 'pos') {
                    $count_setting = new FeaturesForShops();
                    $count_setting->shop_id = $request->id;
                    $count_setting->feature = "pos";

                    $count_setting->save();
                } else {
                    $count_setting = new CountSetting();
                    $count_setting->name = $value;
                    $count_setting->setting = "on";
                    $count_setting->shop_id = $request->id;
                    $count_setting->save();
                }
            }
        }
        return response()->json(['status' => $request->action]);
    }

//Shop Owner Monthly Report

    public function report($id): View
    {
        $start_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now()->lastOfMonth();
        $shopowner = Shops::findOrFail($id);

        $off_counts = CountSetting::where('shop_id', $id)->get();
        $shop_counts = Shops::all();

        $items = Item::where('shop_id', $id)->orderBy('created_at', 'desc')->get();
        $products_count_setting = CountSetting::where('shop_id', $id)->where('name', 'item')->get();

        $shopview = FrontUserLogs::join('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->where('guestoruserid.user_agent', '!=', 'bot')->where('front_user_logs.shop_id', $id)->where('front_user_logs.status', 'shopdetail')->get();
        $shops_view_count_setting = CountSetting::where('shop_id', $id)->where('name', 'shop_view')->get();

        $user_inquiry = Messages::where('message_shop_id', (int) $id)->where('from_role', 'user')->get();
        $user_inquiry_count_setting = CountSetting::where('shop_id', $id)->where('name', 'inquiry')->get();

        $productclick = FrontUserLogs::leftjoin('items', 'front_user_logs.product_id', '=', 'items.id')->where('front_user_logs.status', 'product_detail')->where('items.shop_id', $id)->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
        $items_view_count_setting = CountSetting::where('shop_id', $id)->where('name', 'items_view')->get();

        $unique_productclick = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->where('guestoruserid.user_agent', '!=', 'bot')->where('front_user_logs.status', 'product_detail')->where('front_user_logs.shop_id', $id)->where('front_user_logs.product_id', '!=', 0)->whereBetween('guestoruserid.created_at', [$start_date, $last_date])->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
        $unique_product_click_count_setting = CountSetting::where('shop_id', $id)->where('name', 'item_unique_view')->get();

        $buynowclick = BuyNowClickLog::leftjoin('items', 'items.id', '=', 'buy_now_click_logs.item_id')->where('items.shop_id', $id)->orderBy('buy_now_click_logs.created_at', 'desc')->get();
        $buy_now_count_setting = CountSetting::where('shop_id', $id)->where('name', 'buyNowClick')->get();

        $addtocartclick = AddToCartClickLog::leftjoin('items', 'items.id', '=', 'add_to_cart_click_logs.item_id')->where('items.shop_id', $id)->orderBy('add_to_cart_click_logs.created_at', 'desc')->get()->unique('guest_id', 'user_id');
        $addtocartclick_count_setting = CountSetting::where('shop_id', $id)->where('name', 'addToCartClick')->get();

        $whislistclick = WishlistClickLog::leftjoin('items', 'items.id', '=', 'whislist_click_logs.item_id')->where('items.shop_id', $id)->orderBy('whislist_click_logs.created_at', 'desc')->get();
        $whislistclick_count_setting = CountSetting::where('shop_id', $id)->where('name', 'whislistclick')->get();
        $discountview = FrontUserLogs::join('discount', 'discount.item_id', '=', 'front_user_logs.product_id')->where('front_user_logs.shop_id', $id)->where('front_user_logs.product_id', '!=', 0)->where('front_user_logs.product_id', '!=', null)->where('front_user_logs.status', 'product_detail')->groupBy('front_user_logs.product_id')->get();

        $discountview_count_setting = CountSetting::where('shop_id', $id)->where('name', 'discountview')->get();

        $adsview = FrontUserLogs::join('guestoruserid', 'guestoruserid.id', '=', 'front_user_logs.userorguestid')->where('front_user_logs.status', 'homepage')->where('guestoruserid.user_agent', '!=', 'bot')->groupBy('front_user_logs.userorguestid')->get();
        $adsview_count_setting = CountSetting::where('shop_id', $id)->where('name', 'adsview')->get();

        $users = Manager::where('shop_id', $id)->get();
        $users_count_setting = CountSetting::where('shop_id', $id)->where('name', 'users')->get();

        $total_products = Item::all();

        //New Users

        // $newusers=Guestoruserid::whereBetween('created_at', [Carbon::createFromDate($start_date), Carbon::createFromDate($last_date)])->get();

        $newusers = GuestOrUserId::whereBetween('created_at', [$start_date, $last_date])->where('user_agent', '!=', 'bot')->groupBy('ip')->get();

        $total_users = GuestOrUserId::where('user_agent', '!=', 'bot')->groupBy('ip')->get();
        if (count($items) == 0) {
            $user_inquiry = [];
            $unique_productclick = [];
            $whislistclick = [];
            $addtocartclick = [];
            $buynowclick = [];
            $productclick = [];
        }

        return view('backend.super_admin.shops.report', [
            'off_count' => count($off_counts),
            'total_products_count' => count($total_products),
            'total_user_count' => count($total_users),
            'new_users' => count($newusers),

            'shop_counts' => count($shop_counts),

            'inquiry' => count($user_inquiry),
            'inquiry_count_setting' => $user_inquiry_count_setting,

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

            'shopid' => $shopowner,

            'items' => $items,
            'products_count_setting' => $products_count_setting,

            'managers' => $users,
            'users_count_setting' => $users_count_setting,

        ]);
    }

    public function count_date_filter(Request $request): JsonResponse
    {

        $id = $request->id;
        $from = $request->from;
        $to = $request->to;

        $total_users = User::whereBetween('created_at', [$from, $to])->get();
        $total_products = Item::whereBetween('created_at', [$from, $to])->get();
        $total_items_all_time = Item::where('shop_id', $id)->get();

        $items = Item::where('shop_id', $id)->whereBetween('created_at', [$from, $to])->get();

        $users = Manager::where('shop_id', $id)->get();

        $productview = FrontUserLogs::where('shop_id', $id)->whereBetween('created_at', [$from, $to])->groupBy('userorguestid')->groupBy('visited_link')->get();
        $user_inquiry = Messages::where('message_shop_id', (int) $id)->where('from_role', 'user')->whereBetween('created_at', array(
            Carbon::createFromDate($from),
            Carbon::createFromDate($to)->addDays(1),
        ))->get();

        // $productview = FrontUserLogs::leftjoin('items','front_user_logs.product_id','=','items.id')->where('front_user_logs.status','product_detail')->where('items.shop_id',$id)->get();

        $shopview = FrontUserLogs::join('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->where('guestoruserid.user_agent', '!=', 'bot')->where('front_user_logs.shop_id', $id)->where('front_user_logs.status', 'shopdetail')->whereBetween('front_user_logs.created_at', [$from, $to])->get();
        $unique_product_view = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->where('guestoruserid.user_agent', '!=', 'bot')->where('front_user_logs.status', 'product_detail')->where('front_user_logs.shop_id', $id)->where('front_user_logs.product_id', '!=', 0)->whereBetween('guestoruserid.created_at', [$from, $to])->whereBetween('front_user_logs.created_at', [$from, $to])->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();

        // $unique_product_view = ItemLogActivity::where('shop_id',$id)->whereBetween('created_at', [$from, $to])->get()->unique('user_id','guest_id');

        $buynowclick = BuyNowClickLog::leftjoin('items', 'items.id', '=', 'buy_now_click_logs.item_id')->where('items.shop_id', $id)->whereBetween('buy_now_click_logs.created_at', [$from, $to])->get();

        $addtocartclick = AddToCartClickLog::leftjoin('items', 'items.id', '=', 'add_to_cart_click_logs.item_id')->where('items.shop_id', $id)->whereBetween('add_to_cart_click_logs.created_at', [$from, $to])->get()->unique('guest_id', 'user_id');

        $whislistclick = WishlistClickLog::leftjoin('items', 'items.id', '=', 'whislist_click_logs.item_id')->where('items.shop_id', $id)->whereBetween('whislist_click_logs.created_at', [$from, $to])->get();
        $adsview = FrontUserLogs::join('guestoruserid', 'guestoruserid.id', '=', 'front_user_logs.userorguestid')->where('front_user_logs.status', 'homepage')->where('guestoruserid.user_agent', '!=', 'bot')->groupBy('front_user_logs.userorguestid')->whereBetween('front_user_logs.created_at', [$from, $to])->get();

        $discountview = FrontUserLogs::join('discount', 'discount.item_id', '=', 'front_user_logs.product_id')->where('front_user_logs.shop_id', $id)->where('front_user_logs.product_id', '!=', 0)->where('front_user_logs.product_id', '!=', null)->where('front_user_logs.status', 'product_detail')->whereBetween('front_user_logs.created_at', [$from, $to])->groupBy('front_user_logs.product_id')->get();

        $newusers = GuestOrUserId::whereBetween('created_at', [$from, $to])->where('user_agent', '!=', 'bot')->groupBy('ip')->get();

        $countnu = 0;
        // $countnu = GuestOrUserId::select( DB::raw("count('*') as total"))->whereBetween('created_at', [Carbon::createFromDate($request->from), Carbon::createFromDate($request->to)])->total;

        if (count($total_items_all_time) == 0) {
            $user_inquiry = [];
            $unique_product_view = [];
            $whislistclick = [];
            $addtocartclick = [];
            $buynowclick = [];
            $productview = [];
        }
        return response()->json([
            'totalusers' => count($total_users),
            'totalproducts' => count($total_products),
            'newusers' => count($newusers),
            'totalitemsalltime' => count($total_items_all_time),

            //Shop Owner
            'itemscount' => count($items),
            'usercounts' => count($users),
            'productviews' => count($productview),
            'shopviewuser' => count($shopview),
            'uniqueproductviews' => count($unique_product_view),
            'buynow' => count($buynowclick),

            'addtocard' => count($addtocartclick),

            'whislistcount' => count($whislistclick),

            'ads' => count($adsview),

            'discount' => count($discountview),
            'inquiry' => count($user_inquiry),
            'for_date_shop' => Carbon::createFromDate($from)->isoFormat('MMM') . ' ' . Carbon::createFromDate($from)->isoFormat('D') . ' မှ ' .
            Carbon::createFromDate($to)->isoFormat('MMM') . ' ' . Carbon::createFromDate($to)->isoFormat('D') . ' အတွင်း ',

        ]);
    }

//    public function report($id){
//        $start_date = Carbon::now()->firstOfMonth();
//        $last_date = Carbon::now()->lastOfMonth();
//
//        $shopowner = Shops::findOrFail($id);
//
//        $off_counts =CountSetting::where('shop_id',$id)->get();
//        $shop_counts = Shops::all();
//
//
//        $items = Item::where('shop_id', $id)->orderBy('created_at', 'desc')->get();
//        $products_count_setting = CountSetting::where('shop_id',$id)->where('name','item')->get();
//
//
//        $shopview = FrontUserLogs::where('shop_id',$id)->where('status','shopdetail')->orderBy('created_at', 'desc')->get()->unique('guest_id');
//        $shops_view_count_setting = CountSetting::where('shop_id', $id)->where('name','shop_view')->get();
//
//        $user_inquiry = Messages::where('message_shop_id',(int)$id)->where('from_role','user')->groupBy('message_user_id')->get();
//        $user_inquiry_count_setting = CountSetting::where('shop_id', $id)->where('name','inquiry')->get();
//
//
//        $productclick = FrontUserLogs::leftjoin('items','front_user_logs.product_id','=','items.id')->where('front_user_logs.status','product_detail')->where('items.shop_id',$id)->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
//        $items_view_count_setting = CountSetting::where('shop_id', $id)->where('name','items_view')->get();
//
//        $unique_productclick = FrontUserLogs::leftjoin('guestoruserid','front_user_logs.userorguestid','=','guestoruserid.id')->where('guestoruserid.user_agent','!=','bot')->where('front_user_logs.status','product_detail')->where('front_user_logs.shop_id',$id)->where('front_user_logs.product_id','!=',0)->whereBetween('guestoruserid.created_at', [$start_date, $last_date])->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
//        $unique_product_click_count_setting = CountSetting::where('shop_id', $id)->where('name','item_unique_view')->get();
//
//        $buynowclick = BuyNowClickLog::leftjoin('items','items.id','=','buy_now_click_logs.item_id')->where('items.shop_id',$id)->orderBy('buy_now_click_logs.created_at', 'desc')->get();
//        $buy_now_count_setting = CountSetting::where('shop_id',$id)->where('name','buyNowClick')->get();
//
//        $addtocartclick = AddToCartClickLog::leftjoin('items','items.id','=','add_to_cart_click_logs.item_id')->where('items.shop_id',$id)->orderBy('add_to_cart_click_logs.created_at', 'desc')->get()->unique('guest_id','user_id');
//        $addtocartclick_count_setting = CountSetting::where('shop_id',$id)->where('name','addToCartClick')->get();
//
//        $whislistclick = WishlistClickLog::leftjoin('items','items.id','=','whislist_click_logs.item_id')->where('items.shop_id',$id)->orderBy('whislist_click_logs.created_at', 'desc')->get();
//        $whislistclick_count_setting = CountSetting::where('shop_id',$id)->where('name','whislistclick')->get();
//        $discountview = FrontUserLogs::join('discount','discount.item_id','=','front_user_logs.product_id')->where('front_user_logs.shop_id',$id)->where('front_user_logs.product_id','!=',0)->where('front_user_logs.product_id','!=',null)->where('front_user_logs.status','product_detail')->groupBy('front_user_logs.product_id')->get();
//
//// return $discountview;
//        $discountview_count_setting = CountSetting::where('shop_id',$id)->where('name','discountview')->get();
//
//        $adsview = FrontUserLogs::join('guestoruserid','guestoruserid.id','=','front_user_logs.userorguestid')->where('front_user_logs.status','homepage')->where('guestoruserid.user_agent','!=','bot')->groupBy('front_user_logs.userorguestid')->get();
//        $adsview_count_setting = CountSetting::where('shop_id',$id)->where('name','adsview')->get();
//
//        $users = Manager::where('shop_id',$id)->get();
//        $users_count_setting = CountSetting::where('shop_id', $id)->where('name','users')->get();
//
//        $total_products = Item::all();
//
//        //New Users
//
//
////        $newusers=GuestOrUserId::whereBetween('created_at', [Carbon::createFromDate($start_date), Carbon::createFromDate($last_date)])->get();
//
//        $newusers=GuestOrUserId::whereBetween('created_at', [$start_date, $last_date])->where('user_agent','!=','bot')->groupBy('ip')->get();
//
//
//        $total_users = GuestOrUserId::where('user_agent','!=','bot')->groupBy('ip')->get();
//
//
//        return view('backend.super_admin.shops.report', [
//            'off_count' => count($off_counts),
//            'total_products_count' => count($total_products),
//            'total_user_count' => count($total_users),
//            'new_users'=>count($newusers),
//            'shop_counts' => count($shop_counts),
//
//            'inquiry' => count($user_inquiry),
//            'inquiry_count_setting' => $user_inquiry_count_setting,
//
//            'unique_productclick' => $unique_productclick,
//            'unique_product_click_count_setting' => $unique_product_click_count_setting,
//
//            'adsview' => $adsview,
//            'adsview_count_setting' => $adsview_count_setting,
//
//            'discountview' => $discountview,
//            'discountview_count_setting' => $discountview_count_setting,
//
//            'whislistclick' => $whislistclick,
//            'whislistclick_count_setting' => $whislistclick_count_setting,
//
//            'addtocartclick' => $addtocartclick,
//            'addtocartclick_count_setting' => $addtocartclick_count_setting,
//
//            'buynowclick' => $buynowclick,
//            'buy_now_count_setting' => $buy_now_count_setting,
//
//            'productclick' => $productclick,
//            'items_view_count_setting' => $items_view_count_setting,
//
//            'shopview' => $shopview,
//            'shops_view_count_setting' => $shops_view_count_setting,
//
//            'shopid' => $shopowner,
//
//            'items' => $items,
//            'products_count_setting'=>$products_count_setting,
//
//            'managers' => $users,
//            'users_count_setting'=>$users_count_setting,
//
//        ]);
//
//    }
//
//    public function count_date_filter(Request $request){
//
//        $id = $request->id;
//        $from = $request->from;
//        $to = $request->to;
//
//        $total_users= User::whereBetween('created_at', [$from,  $to])->get();
//        $total_products = Item::whereBetween('created_at', [$from,  $to])->get();
//
//        $items = Item::where('shop_id', $id)->whereBetween('created_at', [$from, $to])->get();
//
//        $users = Manager::where('shop_id',$id)->whereBetween('created_at', [$from, $to])->get();
//
//        $productview = FrontUserLogs::where('shop_id',$id)->whereBetween('created_at', [$from,  $to])->groupBy('userorguestid')->groupBy('visited_link')->get();
//        $user_inquiry = Messages::where('message_shop_id',(int)$id)->where('from_role','user')->groupBy('message_user_id')->get();
//
//
//        // $productview = FrontUserLogs::leftjoin('items','front_user_logs.product_id','=','items.id')->where('front_user_logs.status','product_detail')->where('items.shop_id',$id)->get();
//
//        $shopview = FrontUserLogs::where('shop_id',$id)->where('status','shopdetail')->whereBetween('created_at', [$from, $to])->get()->unique('guest_id');
//        $unique_product_view = FrontUserLogs::leftjoin('guestoruserid','front_user_logs.userorguestid','=','guestoruserid.id')->where('guestoruserid.user_agent','!=','bot')->where('front_user_logs.status','product_detail')->where('front_user_logs.shop_id',$id)->where('front_user_logs.product_id','!=',0)->whereBetween('guestoruserid.created_at', [$from, $to])->whereBetween('front_user_logs.created_at', [$from, $to])->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
//
//        // $unique_product_view = ItemLogActivity::where('shop_id',$id)->whereBetween('created_at', [$from, $to])->get()->unique('user_id','guest_id');
//
//        $buynowclick = BuyNowClickLog::leftjoin('items','items.id','=','buy_now_click_logs.item_id')->where('items.shop_id',$id)->whereBetween('buy_now_click_logs.created_at', [$from, $to])->get();
//
//        $addtocartclick = AddToCartClickLog::leftjoin('items','items.id','=','add_to_cart_click_logs.item_id')->where('items.shop_id',$id)->whereBetween('add_to_cart_click_logs.created_at', [$from, $to])->get()->unique('guest_id','user_id');
//
//        $whislistclick = WishlistClickLog::leftjoin('items','items.id','=','whislist_click_logs.item_id')->where('items.shop_id',$id)->whereBetween('whislist_click_logs.created_at', [$from, $to])->get();
//        $adsview = FrontUserLogs::join('guestoruserid','guestoruserid.id','=','front_user_logs.userorguestid')->where('front_user_logs.status','homepage')->where('guestoruserid.user_agent','!=','bot')->groupBy('front_user_logs.userorguestid')->whereBetween('front_user_logs.created_at', [$from, $to])->get();
//
//        $discountview = FrontUserLogs::join('discount','discount.item_id','=','front_user_logs.product_id')->where('front_user_logs.shop_id',$id)->where('front_user_logs.product_id','!=',0)->where('front_user_logs.product_id','!=',null)->where('front_user_logs.status','product_detail')->whereBetween('front_user_logs.created_at', [$from,  $to])->groupBy('front_user_logs.product_id')->get();
//
//        $newusers=GuestOrUserId::whereBetween('created_at', [$from, $to])->where('user_agent','!=','bot')->groupBy('ip')->get();
//
//        $countnu=0;
//        // $countnu = GuestOrUserId::select( DB::raw("count('*') as total"))->whereBetween('created_at', [Carbon::createFromDate($request->from), Carbon::createFromDate($request->to)])->total;
//
//        return response()->json([
//            'totalusers' => count($total_users),
//            'totalproducts' => count($total_products),
//            'newusers'=>count($newusers),
//
//            //Shop Owner
//            'itemscount' => count($items),
//            'usercounts' => count($users),
//            'productviews' => count($productview),
//            'shopviewuser' => count($shopview),
//            'uniqueproductviews' => count($unique_product_view),
//            'buynow'=> count($buynowclick),
//
//            'addtocard' => count($addtocartclick),
//
//            'whislistcount' => count( $whislistclick),
//
//            'ads'=> count($adsview),
//
//            'discount' => count($discountview)
//
//
//        ]);
//
//    }

/** shop delete section */

    public function trash($id): RedirectResponse
    {

        $shop_owner = Shops::findOrFail($id);
        if (isset($shop_owner->getPhotos)) {
            $del = $shop_owner->getPhotos->pluck("id");
            ShopBanner::destroy($del);
        }
        \SuperAdminLogActivity::SuperAdminShopDeleteLog($shop_owner);
        $shop_owner->delete();

        $this->shop_relevant_destroy($id);
        ShopDirectory::where('shop_id', $id)->delete();
        return redirect()->route('shops.all')->with(['status' => 'success', 'message' => 'Your Shop was successfully Deleted']);
    }

    public function get_trash(): View
    {
        $shops = Shops::onlyTrashed()->get();
        return view('backend.super_admin.shops.trash', compact('shops'));
    }

    public function restore($id): RedirectResponse
    {
        $shop_owner = ShopBanner::where('shop_owner_id', $id)->withTrashed()->pluck("id");
        Shops::onlyTrashed()->where('id', $id)->restore();

        if ($shop_owner) {
            foreach ($shop_owner as $i) {
                ShopBanner::withTrashed()->find($i)->restore();
            }
        }
        $this->shop_relevant_restore($id);

        $shop_dir['shop_id'] = $id;
        ShopDirectory::updateOrCreate($shop_dir);

        return redirect()->route('shops.all')->with(['status' => 'success', 'message' => 'Your SHOP was restore']);
    }

    public function force_delete($id): RedirectResponse
    {
        $shop_owner = Shops::onlyTrashed()->with('getPhotos')->findOrFail($id);

        if (File::exists('images/logo/' . $shop_owner->shop_logo)) {
            File::delete(public_path('images/logo/' . $shop_owner->shop_logo));
        }
        if (isset($shop_owner->getPhotos)) {
            $re_id = ShopBanner::where('shop_owner_id', $id)->onlyTrashed()->get();

            foreach ($re_id as $i) {
                if (File::exists('images/banner/' . $i->location)) {
                    File::delete(public_path('images/banner/' . $i->location));
                }
                ShopBanner::onlyTrashed()->findOrFail($i->id)->forceDelete();
            }
        }

        $this->shop_relevant_force_delete($id);

        Shops::onlyTrashed()->findOrFail($id)->forceDelete();
        ShopDirectory::where('shop_id', $id)->delete();
        return redirect()->route('shops.all_trash')->with(['status' => 'success', 'message' => 'Your SHOP was Delete']);
    }

    public function shops_multiple_delete(Request $request): RedirectResponse
    {

        $change_request_array = explode(",", $request->deleted_shops);
        foreach ($change_request_array as $id) {
            $shop_owner = Shops::onlyTrashed()->with('getPhotos')->findOrFail($id);
            if (File::exists('images/logo/' . $shop_owner->shop_logo)) {
                File::delete(public_path('images/logo/' . $shop_owner->shop_logo));
            }
            if (isset($shop_owner->getPhotos)) {
                $re_id = ShopBanner::where('shop_owner_id', $id)->onlyTrashed()->get();

                foreach ($re_id as $i) {
                    if (File::exists('images/banner/' . $i->location)) {
                        File::delete(public_path('images/banner/' . $i->location));
                    }
                    ShopBanner::onlyTrashed()->findOrFail($i->id)->forceDelete();
                }
            }
            $this->shop_relevant_force_delete($id);

            Shops::onlyTrashed()->findOrFail($id)->forceDelete();
        }
        return redirect()->route('shops.all_trash')->with(['status' => 'success', 'message' => 'Your SHOP was Delete']);
    }
}
