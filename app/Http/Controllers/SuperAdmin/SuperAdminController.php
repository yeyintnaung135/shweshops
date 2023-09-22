<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\CalculateCat;
use App\Http\Requests\SuperAdmin\SuperAdminContactUsUpdateRequest;
use App\Models\AddToCartClickLog;
use App\Models\BuyNowClickLog;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\FrontUserLogs;
use App\Models\GoldPrice;
use App\Models\GuestOrUserId;
use App\Models\Item;
use App\Models\ShopOwnerLogActivity;
use App\Models\Shops;
use App\Models\SuperAdmin;
use App\Models\User;
use App\Models\WishlistClickLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SuperAdminController extends Controller
{
    use CalculateCat;
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function index(): View
    {
        // $storecattocache = Cache::put('cat', $this->getallcatcount());

        $registered = User::count();

        $viewer = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->groupBy('front_user_logs.userorguestid')
            ->groupBy(DB::raw('date(front_user_logs.created_at)'))
            ->get()
            ->count();

        $adsview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->where('status', 'adsclick')
            ->groupBy('front_user_logs.userorguestid')
            ->groupBy(DB::raw('date(front_user_logs.created_at)'))
            ->groupBy('front_user_logs.visited_link')
            ->get()
            ->count();

        $shop = Shops::count();

        $shopview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->where('status', 'shopdetail')
            ->groupBy('front_user_logs.userorguestid')
            ->groupBy(DB::raw('date(front_user_logs.created_at)'))
            ->groupBy('front_user_logs.visited_link')
            ->get()
            ->count();

        $buynow = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')
            ->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))
            ->groupBy(DB::raw('date(buy_now_click_logs.created_at)'))
            ->groupBy('buy_now_click_logs.item_id')
            ->get()
            ->count();

        $addtocart = AddToCartClickLog::count();

        $whishlist = WishlistClickLog::count();

        $uqviewer = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->groupBy('front_user_logs.userorguestid')
            ->get()
            ->count();

        $uqadsview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->where('status', 'adsclick')
            ->groupBy('front_user_logs.userorguestid')
            ->groupBy('front_user_logs.visited_link')
            ->get()
            ->count();

        $shop = Shops::count();

        $uqshopview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->where('status', 'shopdetail')
            ->groupBy('front_user_logs.userorguestid')
            ->groupBy('front_user_logs.visited_link')
            ->get()
            ->count();

        $uqbuynow = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')
            ->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))
            ->groupBy('buy_now_click_logs.item_id')
            ->get()
            ->count();

        //all logs count
        $allviewers = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->count();

        $alladsviewers = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->where('front_user_logs.status', 'adsclick')
            ->groupBy('guestoruserid.ip')
            ->get()
            ->count();

        $allshopviewers = FrontUserLogs::where('status', 'shopdetail')->count();

        $allbuynow = BuyNowClickLog::count();

        $newusers = GuestOrUserId::where('user_agent', '!=', 'bot')->whereDate('created_at', '=', Carbon::today()->toDateString())->groupBy('ip')->get();

        $countnu = 0;
        foreach ($newusers as $nu) {
            $checkhnucount = FrontUserLogs::where('userorguestid', $nu->id)->first();

            $checkhnu = FrontUserLogs::where('userorguestid', $nu->id)->whereDate('created_at', '<', Carbon::now()->toDate())->get();

            if (count($checkhnu) > 0 or empty($checkhnucount)) {
                continue;
            } else {
                $countnu += 1;
            }
        }
        Cache::put('cat', 'value');

        return view('backend.super_admin.dashboard', ['register' => $registered,
            'newusers' => $countnu,
            'allbuynow' => $allbuynow,
            'allshopviewers' => $allshopviewers,
            'alladsviewers' => $alladsviewers,
            'allviewers' => $allviewers,
            'uqbuynow' => $uqbuynow,
            'uqshopview' => $uqshopview,
            'uqadsview' => $uqadsview,
            'uqviewer' => $uqviewer,
            'whishlist' => $whishlist,
            'addtocart' => $addtocart,
            'buynow' => $buynow,
            'shopview' => $shopview,
            'shop' => $shop,
            'adsview' => $adsview,
            'viewer' => $viewer]);

    }
    public function all_counts(Request $request): JsonResponse
    {
        //base on day count

        $registered = User::whereBetween('created_at', [$request->from, $request->to])->count();

        $viewer = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->whereBetween('front_user_logs.created_at', [$request->from, $request->to])
            ->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->count();
        $adsview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'adsclick')->whereBetween('front_user_logs.created_at', [$request->from, $request->to])->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->count();

        $shop = Shops::count();
        $shopview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'shopdetail')->whereBetween('front_user_logs.created_at', [$request->from, $request->to])->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->groupBy('front_user_logs.visited_link')->count();

        $buynow = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->whereBetween('buy_now_click_logs.created_at', [$request->from, $request->to])->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))->groupBy(DB::raw('date(buy_now_click_logs.created_at)'))->groupBy('buy_now_click_logs.item_id')->count();

        $addtocart = AddToCartClickLog::whereBetween('created_at', [$request->from, $request->to])->count();
        $whishlist = WishlistClickLog::whereBetween('created_at', [$request->from, $request->to])->count();
        //base on day count

        $uqviewer = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->whereBetween('front_user_logs.created_at', [$request->from, $request->to])->groupBy('front_user_logs.userorguestid')->count();
        $uqadsview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'adsclick')->whereBetween('front_user_logs.created_at', [$request->from, $request->to])->groupBy('front_user_logs.userorguestid')->count();

        $shop = Shops::whereBetween('created_at', [$request->from, $request->to])->count();
        $uqshopview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'shopdetail')->whereBetween('front_user_logs.created_at', [$request->from, $request->to])->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->count();
        $uqbuynow = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->whereBetween('buy_now_click_logs.created_at', [$request->from, $request->to])->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))->groupBy('buy_now_click_logs.item_id')->count();

        //all logs count
        $allviewers = FrontUserLogs::select(DB::raw("count('*') as total"))->whereBetween('created_at', [$request->from, $request->to])->first()->total;
        $alladsviewers = FrontUserLogs::select(DB::raw("count('*') as total"))->whereBetween('created_at', [$request->from, $request->to])->where('status', 'adsclick')->first()->total;
        $allshopviewers = FrontUserLogs::select(DB::raw("count('*') as total"))->whereBetween('created_at', [$request->from, $request->to])->where('status', 'shopdetail')->first()->total;
        $allbuynow = BuyNowClickLog::select(DB::raw("count('*') as total"))->whereBetween('created_at', [$request->from, $request->to])->first()->total;

        $newusers = GuestOrUserId::where('user_agent', '!=', 'bot')->whereBetween('created_at', [Carbon::createFromDate($request->from), Carbon::createFromDate($request->to)])->groupBy('ip')->get();

        $countnu = 0;
        foreach ($newusers as $nu) {
            $checkhnucount = FrontUserLogs::where('userorguestid', $nu->id)->first();

            $checkhnu = FrontUserLogs::where('userorguestid', $nu->id)->whereDate('created_at', '<', Carbon::createFromDate($request->from))->count();

            if ($checkhnu > 0 or empty($checkhnucount)) {
                continue;
            } else {
                $countnu += 1;
            }

        }
        return response()->json(['register' => $registered, 'newusers' => $countnu, 'allbuynow' => $allbuynow, 'allshopviewers' => $allshopviewers, 'alladsviewers' => $alladsviewers, 'allviewers' => $allviewers, 'uqbuynow' => $uqbuynow, 'uqshopview' => $uqshopview, 'uqadsview' => $uqadsview, 'uqviewer' => $uqviewer, 'whishlist' => $whishlist, 'addtocart' => $addtocart, 'buynow' => $buynow, 'shopview' => $shopview, 'shop' => $shop, 'adsview' => $adsview, 'viewer' => $viewer]);
    }

    public function visitor_count(): View
    {
        return view('backend.super_admin.activity_logs.customer');
    }

    public function get_all_visitor(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $records = DB::table('front_user_logs')
            ->leftJoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftJoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->leftJoin('items', 'front_user_logs.product_id', '=', 'items.id')
            ->select(
                'front_user_logs.product_id',
                'front_user_logs.shop_id',
                'front_user_logs.status',
                'front_user_logs.created_at',
                'front_user_logs.id',
                'guestoruserid.user_id as guest_or_user_id',
                'items.name as item_name',
                'items.product_code as product_code'
            )->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($records)
            ->editColumn('user_name', function ($record) {
                if ($record->guest_or_user_id == 0) {
                    return 'Guest';
                } else {
                    return User::where('id', $record->guest_or_user_id)->value('username');
                }
            })
            ->editColumn('status', function ($record) {
                if ($record->product_id != 0) {
                    return $record->item_name . ' (P)';
                } else {
                    if ($record->shop_id != 0) {
                        return Shops::where('id', $record->shop_id)->value('shop_name') . ' (S)';
                    } else {
                        return strtoupper($record->status);
                    }
                }
            })
            ->editColumn('product_code', function ($record) {
                return $record->product_code ?? 0;
            })
            ->editColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->toJson();
    }

    public function ads_count(): View
    {
        return view('backend.super_admin.count_detail_list.adscountlist');
    }

    public function get_all_ads_count(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $searchByFromdate = $request->get('searchByFromdate') ?? '0-0-0 00:00:00';
            $searchByTodate = $request->get('searchByTodate') ?? Carbon::now();

            $recordsQuery = FrontUserLogs::leftJoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
                ->leftJoin('shop_owners', 'shop_owners.id', '=', 'front_user_logs.shop_id')
                ->leftJoin('ads', 'front_user_logs.ads_id', '=', 'ads.id')
                ->leftJoin('users', 'users.id', '=', 'guestoruserid.user_id')
                ->where('front_user_logs.status', 'adsclick')
                ->whereBetween('front_user_logs.created_at', [$searchByFromdate, $searchByTodate])
                ->selectRaw("front_user_logs.id as fulid, COALESCE(guestoruserid.user_id, 0) as user_id,
                shop_owners.id as shop_id, shop_owners.name, users.username,
                front_user_logs.created_at as fulct")
                ->orderBy($request->input('columns')[$request->input('order')[0]['column']]['data'],
                    $request->input('order')[0]['dir'])
                ->orderBy('front_user_logs.created_at', 'desc');

            return DataTables::of($recordsQuery)
                ->addColumn('user_name', function ($record) {
                    return ($record->user_id == 0) ? 'guest' : $record->username;
                })
                ->addColumn('shop_name', function ($record) {
                    return $record->name;
                })
                ->addColumn('created_at_formatted', function ($record) {
                    return date('F d, Y ( h:i A )', strtotime($record->fulct));
                })
                ->rawColumns(['created_at_formatted'])
                ->toJson();
        }
    }

    public function shop_viewer_count(): View
    {
        return view('backend.super_admin.count_detail_list.shopviewercountlist');
    }

    public function get_all_shop_viewer_count(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $searchByFromdate = $request->get('searchByFromdate') ?? '0-0-0 00:00:00';
            $searchByTodate = $request->get('searchByTodate') ?? Carbon::now();

            $recordsQuery = FrontUserLogs::leftJoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
                ->leftJoin('shop_owners', 'shop_owners.id', '=', 'front_user_logs.shop_id')
                ->leftJoin('users', 'users.id', '=', 'guestoruserid.user_id')
                ->where('front_user_logs.status', 'shopdetail')
                ->whereBetween('front_user_logs.created_at', [$searchByFromdate, $searchByTodate])
                ->selectRaw("front_user_logs.id as fulid, COALESCE(guestoruserid.user_id, 0) as user_id,
                shop_owners.id as shop_id, shop_owners.name as shop_name, users.username,
                front_user_logs.created_at as fulct")
                ->orderBy($request->input('columns')[$request->input('order')[0]['column']]['data'],
                    $request->input('order')[0]['dir'])
                ->orderBy('front_user_logs.created_at', 'desc');

            return DataTables::of($recordsQuery)
                ->addColumn('user_name', function ($record) {
                    return ($record->user_id == 0) ? 'guest' : $record->username;
                })
                ->addColumn('created_at_formatted', function ($record) {
                    return date('F d, Y ( h:i A )', strtotime($record->fulct));
                })
                ->rawColumns(['created_at_formatted'])
                ->toJson();
        }
    }

    public function buy_now_count(): View
    {
        return view('backend.super_admin.count_detail_list.buynowcountlist');
    }

    public function get_all_buy_now_count(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $searchByFromdate = $request->get('searchByFromdate') ?? '0-0-0 00:00:00';
            $searchByTodate = $request->get('searchByTodate') ?? Carbon::now();

            $recordsQuery = BuyNowClickLog::leftJoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')
                ->leftJoin('users', 'users.id', '=', 'guestoruserid.user_id')
                ->leftJoin('items', 'items.id', '=', 'buy_now_click_logs.item_id')
                ->leftJoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
                ->whereBetween('buy_now_click_logs.created_at', [$searchByFromdate, $searchByTodate])
                ->selectRaw("buy_now_click_logs.id as fulid, COALESCE(guestoruserid.user_id, 0) as user_id,
                items.shop_id, users.username, buy_now_click_logs.created_at as fulct")
                ->orderBy($request->input('columns')[$request->input('order')[0]['column']]['data'],
                    $request->input('order')[0]['dir'])
                ->orderBy('buy_now_click_logs.created_at', 'desc');

            return DataTables::of($recordsQuery)
                ->addColumn('user_name', function ($record) {
                    return ($record->user_id == 0) ? 'guest' : User::find($record->user_id)->username;
                })
                ->addColumn('created_at_formatted', function ($record) {
                    return date('F d, Y ( h:i A )', strtotime($record->fulct));
                })
                ->rawColumns(['created_at_formatted'])
                ->toJson();
        }
    }

    public function add_to_cart_count(): View
    {
        return view('backend.super_admin.count_detail_list.addtocartcountlist');
    }

    public function get_all_add_to_cart_count(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $searchByFromdate = $request->get('searchByFromdate') ?? '0-0-0 00:00:00';
            $searchByTodate = $request->get('searchByTodate') ?? Carbon::now();

            $recordsQuery = AddToCartClickLog::leftJoin('items', 'items.id', '=', 'add_to_cart_click_logs.item_id')
                ->leftJoin('guestoruserid', 'add_to_cart_click_logs.userorguestid', '=', 'guestoruserid.id')
                ->leftJoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
                ->leftJoin('users', 'users.id', '=', 'guestoruserid.user_id')
                ->whereBetween('add_to_cart_click_logs.created_at', [$searchByFromdate, $searchByTodate])
                ->selectRaw("add_to_cart_click_logs.id as fulid, COALESCE(guestoruserid.user_id, 0) as user_id,
                items.shop_id, users.username, add_to_cart_click_logs.created_at as fulct")
                ->orderBy($request->input('columns')[$request->input('order')[0]['column']]['data'],
                    $request->input('order')[0]['dir'])
                ->orderBy('add_to_cart_click_logs.created_at', 'desc');

            return DataTables::of($recordsQuery)
                ->addColumn('user_name', function ($record) {
                    return ($record->user_id == 0) ? 'guest' : User::find($record->user_id)->username;
                })
                ->addColumn('created_at_formatted', function ($record) {
                    return date('F d, Y ( h:i A )', strtotime($record->fulct));
                })
                ->rawColumns(['created_at_formatted'])
                ->toJson();
        }
    }

    public function wishlist_count(): View
    {
        return view('backend.super_admin.count_detail_list.wishlistcountlist');
    }

    public function get_all_wishlist_count(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $searchByFromdate = $request->get('searchByFromdate') ?? '0-0-0 00:00:00';
            $searchByTodate = $request->get('searchByTodate') ?? Carbon::now();

            $recordsQuery = WishlistClickLog::leftJoin('items', 'items.id', '=', 'whislist_click_logs.item_id')
                ->leftJoin('guestoruserid', 'whislist_click_logs.userorguestid', '=', 'guestoruserid.id')
                ->leftJoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
                ->leftJoin('users', 'users.id', '=', 'guestoruserid.user_id')
                ->whereBetween('whislist_click_logs.created_at', [$searchByFromdate, $searchByTodate])
                ->selectRaw("whislist_click_logs.id as fulid, COALESCE(guestoruserid.user_id, 0) as user_id,
                items.shop_id, users.username, whislist_click_logs.created_at as fulct")
                ->orderBy($request->input('columns')[$request->input('order')[0]['column']]['data'],
                    $request->input('order')[0]['dir'])
                ->orderBy('whislist_click_logs.created_at', 'desc');

            return DataTables::of($recordsQuery)
                ->addColumn('user_name', function ($record) {
                    return ($record->user_id == 0) ? 'guest' : User::find($record->user_id)->username;
                })
                ->addColumn('created_at_formatted', function ($record) {
                    return date('F d, Y ( h:i A )', strtotime($record->fulct));
                })
                ->rawColumns(['created_at_formatted'])
                ->toJson();
        }
    }

    public function product_daily_count(): View
    {

        $itemlog = ShopOwnerLogActivity::where(['action' => 'create'])->count();
        $item = Item::count();
        $itemdate = $itemlog
            ->groupBy([function ($date) {
                return Carbon::parse($date->created_at)->format('M d Y');
            }, function ($category) {
                return $category->category;
            }])
            ->sortBy('created_at');

        $itemcategory = $itemlog
            ->groupBy([function ($category) {
                return $category->category;
            }, function ($date) {
                return Carbon::parse($date->created_at)->format('M d Y');
            }])
            ->sortBy('created_at');

        $itemtotal = $itemlog
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('M d Y');
            })
            ->sortBy('created_at');

        return view('backend.super_admin.dailycount.productdailycount', ['itemcategory' => $itemcategory, 'item' => $item, 'itemlog' => $itemlog, 'itemtotal' => $itemtotal, 'itemdate' => $itemdate]);
    }

    public function shop_daily_count(): View
    {

        $itemlog = ShopOwnerLogActivity::where(['action' => 'create'])->count();
        $itemdate = $itemlog
            ->groupBy([function ($date) {
                return Carbon::parse($date->created_at)->format('M d Y');
            }, function ($category) {
                return $category->shop_name;
            }])
            ->sortBy('created_at');

        $itemtotal = $itemlog
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('M d Y');
            })
            ->sortBy('created_at');

        return view('backend.super_admin.dailycount.shopdailycount', ['itemlog' => $itemlog, 'itemtotal' => $itemtotal, 'itemdate' => $itemdate]);
    }

    public function product_daily_count_clear(): RedirectResponse
    {
        //
        ShopOwnerLogActivity::where(['action' => 'create'])->forceDelete();
        return redirect('backside/super_admin/productdailycount/all');
    }

    public function shop_daily_count_clear(): RedirectResponse
    {
        //
        ShopOwnerLogActivity::where(['action' => 'create'])->forceDelete();
        return redirect('backside/super_admin/shopdailycount/all');
    }

    public function approve($id): RedirectResponse
    {
        $admin = SuperAdmin::findOrFail($id);
        $admin->role = '1';
        $admin->update();
        return redirect()->back();
    }

    public function is_banned($id): RedirectResponse
    {
        $admin = SuperAdmin::findOrFail($id);
        $admin->role = '3';
        $admin->update();
        return redirect()->back();
    }

    public function delete(Request $request): RedirectResponse
    {
        SuperAdmin::where('id', $request->id)->delete();
        return redirect()->back();
    }

    public function contact_us_get(): View
    {
        $contact = ContactUs::where('active', 1)->first();
        return view('backend.super_admin.contactus.edit', ['contact' => $contact]);
    }

    public function contact_us_update(SuperAdminContactUsUpdateRequest $request): RedirectResponse
    {
        $folderPath = 'images/contactus/';
        $contact = ContactUs::where('active', 1)->first();

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path($folderPath), $filename);
            $input['image'] = $filename;
        } else {
            $input['image'] = $contact->image;
        }
        $contact = ContactUs::where('active', 1)->update(['active' => 0]);

        if (ContactUs::create($input)) {

            return redirect()->route('superAdmin.contactus_get')->with(['status' => 'success', 'message' => 'Your Shop was successfully Edited']);
        }
    }

    public function gold_price_get(): View
    {
        $gold_price = GoldPrice::first();
        return view('backend.super_admin.gold_price.edit', ['gold_price' => $gold_price]);
    }

    public function gold_price_update(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'sell_price' => ['required', 'max:30'],
            'buy_price' => ['required', 'max:30'],
        ]);

        $gold_price = GoldPrice::first();
        if ($gold_price) {
            $result = GoldPrice::find($gold_price['id'])->update($validatedData);
        } else {
            $result = GoldPrice::create($validatedData);
        }

        if ($result) {

            return redirect()->route('backside.super_admin.superAdmin.gold_price_get')->with(['status' => 'success', 'message' => 'Gold price was successfully Edited']);
        }
    }

}

//    public function index()
//    {
//        //base on day count
//        $registered = User::count();
//        $getguestorus=DB::table('guestoruserid')->where('user_agent','!=','bot')->groupBy('ip');
//
//
//        $viewer = FrontUserLogs::joinSub($getguestorus,'guestoruserid',function($join){
//            $join->on('front_user_logs.userorguestid','=','guestoruserid.id');
//        })->select('*', DB::raw("count('*') as total"))->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->get();
//
//        $adsview = FrontUserLogs::joinSub($getguestorus,'guestoruserid',function($join){
//            $join->on('front_user_logs.userorguestid','=','guestoruserid.id');
//        })->select('*', DB::raw("count('*') as total"))
//            ->where('front_user_logs.status', 'adsclick')->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->groupBy('front_user_logs.visited_link')->get();
//
//
//        $shop = Shopowner::count();
//        $shopview = FrontUserLogs::joinSub($getguestorus,'guestoruserid',function($join){
//            $join->on('front_user_logs.userorguestid','=','guestoruserid.id');
//        })->select('*', DB::raw("count('*') as total"))
//            ->where('front_user_logs.status', 'shopdetail')->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->groupBy('front_user_logs.visited_link')->get();
//
//        $buynow = BuyNowClickLog::joinSub($getguestorus,'guestoruserid',function($join){
//            $join->on('buy_now_click_logs.userorguestid','=','guestoruserid.id');
//        })->select('*', DB::raw("count('*') as total"))->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))->groupBy(DB::raw('date(buy_now_click_logs.created_at)'))->groupBy('buy_now_click_logs.item_id')->get();
//
//
//        $addtocart = AddToCartClickLog::count();
//        $whishlist = WishlistClickLog::count();
//        //base on day count
//
//
//        $uqviewer=DB::table('front_user_logs')->select('front_user_logs.*')->joinSub($getguestorus,'guestoruserid',function($join){
//            $join->on('front_user_logs.userorguestid','=','guestoruserid.id');
//        })->groupBy('front_user_logs.userorguestid')->get();
//
//        $uqadsview = FrontUserLogs::joinSub($getguestorus,'guestoruserid',function($join){
//            $join->on('front_user_logs.userorguestid','=','guestoruserid.id');
//        })->where('front_user_logs.status', 'adsclick')->groupBy('front_user_logs.userorguestid')->get();
//
//        $shop = Shopowner::count();
//
//        $uqshopview =  FrontUserLogs::joinSub($getguestorus,'guestoruserid',function($join){
//            $join->on('front_user_logs.userorguestid','=','guestoruserid.id');
//        })->where('front_user_logs.status','shopdetail')->groupBy('front_user_logs.userorguestid')->get();
//
//        $uqbuynow = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))->where('guestoruserid.user_agent','!=','bot')
//            ->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))->groupBy('buy_now_click_logs.item_id')->get();
//
//        //all logs count
//        $allviewers=DB::table('front_user_logs')->select('front_user_logs.*')->joinSub($getguestorus,'guestoruserid',function($join){
//            $join->on('front_user_logs.userorguestid','=','guestoruserid.id');
//        })->get();
//
//        $alladsviewers = FrontUserLogs::joinSub($getguestorus,'guestoruserid',function($join){
//            $join->on('front_user_logs.userorguestid','=','guestoruserid.id');
//        })->select(DB::raw("count('*') as total"))->where('front_user_logs.status', 'adsclick')->first()->total;
//        $allbuynow = BuyNowClickLog::select(DB::raw("count('*') as total"))->first()->total;
//
//        $allshopviewers = FrontUserLogs::joinSub($getguestorus,'guestoruserid',function($join){
//            $join->on('front_user_logs.userorguestid','=','guestoruserid.id');
//        })->where('front_user_logs.status','shopdetail')->get();
//
//
//        $newusers = Guestoruserid::where('user_agent','!=','bot')->whereDate('created_at', '=', Carbon::today()->toDateString())->groupBy('ip')->get();
//
//        $countnu = 0;
//        foreach ($newusers as $nu) {
//            $checkhnucount=FrontUserLogs::where('userorguestid', $nu->id)->first();
//
//            $checkhnu = FrontUserLogs::where('userorguestid', $nu->id)->whereDate('created_at', '<', Carbon::now()->toDate())->get();
//
//            if (count($checkhnu) > 0 or empty($checkhnucount)) {
//                continue;
//            } else {
//                $countnu += 1;
//            }
//
//        }
//        return view('backend.super_admin.dashboard', ['register' => $registered, 'newusers' => $countnu, 'allbuynow' => $allbuynow, 'allshopviewers' =>count($allshopviewers), 'alladsviewers' => $alladsviewers, 'allviewers' => count($allviewers), 'uqbuynow' => $uqbuynow, 'uqshopview' => $uqshopview, 'uqadsview' => $uqadsview, 'uqviewer' => $uqviewer, 'whishlist' => $whishlist, 'addtocart' => $addtocart, 'buynow' => $buynow, 'shopview' => $shopview, 'shop' => $shop, 'adsview' => $adsview, 'viewer' => $viewer]);
//    }
