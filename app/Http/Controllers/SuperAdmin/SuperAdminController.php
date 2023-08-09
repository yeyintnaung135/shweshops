<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\trait\CalculateCat;
use App\Models\AddToCartClickLog;
use App\Models\BuyNowClickLog;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\FrontUserLogs;
use App\Models\GoldPrice;
use App\Models\GuestOrUserId;
use App\Models\Item;
use App\Models\ShopOwner;
use App\Models\ShopOwnerLogActivity;
use App\Models\SuperAdmin;
use App\Models\User;
use App\Models\WishlistClickLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    use CalculateCat;
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        //base on day count
//        $registered = User::all();
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
//        $shop = Shopowner::all();
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
//        $addtocart = AddToCartClickLog::all();
//        $whishlist = WishlistClickLog::all();
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
//        $shop = Shopowner::all();
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
    public function index()
    {

        $storecattocache = Cache::put('cat', $this->getallcatcount());

        // return redirect(url('backside/super_admin/customers'));
        //base on day count
        $registered = User::all();

        $viewer = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->get();
        $adsview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'adsclick')->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->groupBy('front_user_logs.visited_link')->get();

        $shop = ShopOwner::all();
        $shopview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'shopdetail')->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->groupBy('front_user_logs.visited_link')->get();

        $buynow = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))->groupBy(DB::raw('date(buy_now_click_logs.created_at)'))->groupBy('buy_now_click_logs.item_id')->get();

        $addtocart = AddToCartClickLog::all();
        $whishlist = WishlistClickLog::all();
        //base on day count

        $uqviewer = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->groupBy('front_user_logs.userorguestid')->get();
        $uqadsview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'adsclick')->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();

        $shop = ShopOwner::all();
        $uqshopview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'shopdetail')->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
        $uqbuynow = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))->groupBy('buy_now_click_logs.item_id')->get();

        //all logs count
        $allviewers = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->get();

        $alladsviewers = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select(DB::raw("count('*') as total"))->where('front_user_logs.status', 'adsclick')->groupBy('guestoruserid.ip')->get();
        $allshopviewers = FrontUserLogs::select(DB::raw("count('*') as total"))->where('status', 'shopdetail')->first()->total;
        $allbuynow = BuyNowClickLog::select(DB::raw("count('*') as total"))->first()->total;

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
            'alladsviewers' => count($alladsviewers),
            'allviewers' => count($allviewers),
            'uqbuynow' => $uqbuynow,
            'uqshopview' => $uqshopview,
            'uqadsview' => $uqadsview,
            'uqviewer' => $uqviewer,
            'whishlist' => $whishlist,
            'addtocart' => $addtocart, 'buynow' => $buynow, 'shopview' => $shopview, 'shop' => $shop, 'adsview' => $adsview, 'viewer' => $viewer]);

    }
    public function all_counts(Request $request)
    {
        //base on day count

        $registered = User::whereBetween('created_at', [$request->from, $request->to])->get();

        $viewer = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->whereBetween('front_user_logs.created_at', [$request->from, $request->to])
            ->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->get();
        $adsview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'adsclick')->whereBetween('front_user_logs.created_at', [$request->from, $request->to])->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->get();

        $shop = ShopOwner::all();
        $shopview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'shopdetail')->whereBetween('front_user_logs.created_at', [$request->from, $request->to])->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->groupBy('front_user_logs.visited_link')->get();

        $buynow = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->whereBetween('buy_now_click_logs.created_at', [$request->from, $request->to])->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))->groupBy(DB::raw('date(buy_now_click_logs.created_at)'))->groupBy('buy_now_click_logs.item_id')->get();

        $addtocart = AddToCartClickLog::whereBetween('created_at', [$request->from, $request->to])->get();
        $whishlist = WishlistClickLog::whereBetween('created_at', [$request->from, $request->to])->get();
        //base on day count

        $uqviewer = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->whereBetween('front_user_logs.created_at', [$request->from, $request->to])->groupBy('front_user_logs.userorguestid')->get();
        $uqadsview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'adsclick')->whereBetween('front_user_logs.created_at', [$request->from, $request->to])->groupBy('front_user_logs.userorguestid')->get();

        $shop = ShopOwner::whereBetween('created_at', [$request->from, $request->to])->get();
        $uqshopview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'shopdetail')->whereBetween('front_user_logs.created_at', [$request->from, $request->to])->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
        $uqbuynow = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->whereBetween('buy_now_click_logs.created_at', [$request->from, $request->to])->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))->groupBy('buy_now_click_logs.item_id')->get();

        //all logs count
        $allviewers = FrontUserLogs::select(DB::raw("count('*') as total"))->whereBetween('created_at', [$request->from, $request->to])->first()->total;
        $alladsviewers = FrontUserLogs::select(DB::raw("count('*') as total"))->whereBetween('created_at', [$request->from, $request->to])->where('status', 'adsclick')->first()->total;
        $allshopviewers = FrontUserLogs::select(DB::raw("count('*') as total"))->whereBetween('created_at', [$request->from, $request->to])->where('status', 'shopdetail')->first()->total;
        $allbuynow = BuyNowClickLog::select(DB::raw("count('*') as total"))->whereBetween('created_at', [$request->from, $request->to])->first()->total;

        $newusers = GuestOrUserId::where('user_agent', '!=', 'bot')->whereBetween('created_at', [Carbon::createFromDate($request->from), Carbon::createFromDate($request->to)])->groupBy('ip')->get();

        $countnu = 0;
        foreach ($newusers as $nu) {
            $checkhnucount = FrontUserLogs::where('userorguestid', $nu->id)->first();

            $checkhnu = FrontUserLogs::where('userorguestid', $nu->id)->whereDate('created_at', '<', Carbon::createFromDate($request->from))->get();

            if (count($checkhnu) > 0 or empty($checkhnucount)) {
                continue;
            } else {
                $countnu += 1;
            }

        }
        return response()->json(['register' => count($registered), 'newusers' => $countnu, 'allbuynow' => $allbuynow, 'allshopviewers' => $allshopviewers, 'alladsviewers' => $alladsviewers, 'allviewers' => $allviewers, 'uqbuynow' => count($uqbuynow), 'uqshopview' => count($uqshopview), 'uqadsview' => count($uqadsview), 'uqviewer' => count($uqviewer), 'whishlist' => count($whishlist), 'addtocart' => count($addtocart), 'buynow' => count($buynow), 'shopview' => count($shopview), 'shop' => count($shop), 'adsview' => count($adsview), 'viewer' => count($viewer)]);
    }

    public function visitor_count()
    {
        return view('backend.super_admin.activity_logs.customer');
    }

    public function get_all_visitor(Request $request)
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

        $totalRecords = FrontUserLogs::select('count(*) as allcount')->where('status', 'homepage')
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
        if ($columnName == 'status') {
            $columnName = 'front_user_logs.status';
        }
        $records = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')
            ->leftjoin('items', 'front_user_logs.product_id', '=', 'items.id')

            ->orderBy($columnName, $columnSortOrder)
            ->orderBy('front_user_logs.created_at', 'desc')
            ->where(function ($query) use ($searchValue) {
                $query->where('front_user_logs.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('front_user_logs.userorguestid', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.username', 'like', '%' . $searchValue . '%')
                    ->orWhere('items.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('items.product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('front_user_logs.status', 'like', '%' . $searchValue . '%')
                ;
            })
            ->whereBetween('front_user_logs.created_at', [$searchByFromdate, $searchByTodate])
            ->select('*', 'front_user_logs.created_at as fulct', 'front_user_logs.id as fulid', 'guestoruserid.user_id as gouid')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            if ($record->gouid == 0) {
                $getuser = 'Guest';
                $id = $record->guest_id;
            } else {
                $getuser = User::where('id', $record->gouid)->first()->username;
                $id = $record->gouid;

            }
            $togetproductdata = Item::where('id', $record->product_id)->first();
            if ($record->product_id != 0) {
                $productname = $togetproductdata->name . ' (P)';
                $productcode = $togetproductdata->product_code;

            } else {
                $productcode = 0;
                if ($record->shop_id != 0) {
                    $getshopdata = ShopOwner::where('id', $record->shop_id)->first();
                    $productname = $getshopdata->shop_name . ' (S)';

                } else {
                    $productname = strtoupper($record->status);

                }

            }

            $data_arr[] = array(
                "id" => $record->fulid,
                'status' => $productname,
                'product_code' => $productcode,
                "user_name" => $getuser,
                "user_id" => $id,
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

    public function ads_count()
    {
        return view('backend.super_admin.count_detail_list.adscountlist');
    }

    public function get_all_ads_count(Request $request)
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

        $totalRecords = FrontUserLogs::select('count(*) as allcount')->where('status', 'adsclick')
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
        $records = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftjoin('shop_owners', 'shop_owners.id', '=', 'front_user_logs.shop_id')
            ->leftjoin('ads', 'front_user_logs.ads_id', '=', 'ads.id')
            ->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')->orderBy($columnName, $columnSortOrder)
            ->orderBy('front_user_logs.created_at', 'desc')->where('front_user_logs.status', 'adsclick')
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

    public function shop_viewer_count()
    {
        return view('backend.super_admin.count_detail_list.shopviewercountlist');
    }

    public function get_all_shop_viewer_count(Request $request)
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

        $totalRecords = FrontUserLogs::select('count(*) as allcount')->where('status', 'shopdetail')
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
        $records = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->leftjoin('shop_owners', 'shop_owners.id', '=', 'front_user_logs.shop_id')->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')->orderBy($columnName, $columnSortOrder)
            ->orderBy('front_user_logs.created_at', 'desc')->where('front_user_logs.status', 'shopdetail')
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

    public function buy_now_count()
    {
        return view('backend.super_admin.count_detail_list.buynowcountlist');
    }

    public function get_all_buy_now_count(Request $request)
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
            ->leftjoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
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
            })
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

    public function add_to_cart_count()
    {
        return view('backend.super_admin.count_detail_list.addtocartcountlist');
    }

    public function get_all_add_to_cart_count(Request $request)
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
            })
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
            })
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

    public function wishlist_count()
    {
        return view('backend.super_admin.count_detail_list.wishlistcountlist');
    }

    public function get_all_wishlist_count(Request $request)
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
        $totalRecords = WishlistClickLog::leftjoin('items', 'items.id', '=', 'whislist_click_logs.item_id')
            ->leftjoin('guestoruserid', 'whislist_click_logs.userorguestid', '=', 'guestoruserid.id')
            ->leftjoin('shop_owners', 'shop_owners.id', '=', 'items.shop_id')
            ->leftjoin('users', 'users.id', '=', 'guestoruserid.user_id')->select('count(*) as allcount')
            ->where(function ($query) use ($searchValue) {
                $query->where('whislist_click_logs.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.username', 'like', '%' . $searchValue . '%')
                    ->orWhere('guestoruserid.user_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('items.shop_id', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('whislist_click_logs.created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;
        $records = WishlistClickLog::leftjoin('items', 'items.id', '=', 'whislist_click_logs.item_id')
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
            })
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

    public function product_daily_count()
    {

        $itemlog = ShopOwnerLogActivity::where(['action' => 'create'])->get();
        $item = Item::all();
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

    public function shop_daily_count()
    {

        $itemlog = ShopOwnerLogActivity::where(['action' => 'create'])->get();
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

    public function product_daily_count_clear()
    {
        //
        ShopOwnerLogActivity::where(['action' => 'create'])->forceDelete();
        return redirect('backside/super_admin/productdailycount/all');
    }

    public function shop_daily_count_clear()
    {
        //
        ShopOwnerLogActivity::where(['action' => 'create'])->forceDelete();
        return redirect('backside/super_admin/shopdailycount/all');
    }

    public function approve($id)
    {
        $admin = SuperAdmin::findOrFail($id);
        $admin->role = '1';
        $admin->update();
        return redirect()->back();
    }

    public function is_banned($id)
    {
        $admin = SuperAdmin::findOrFail($id);
        $admin->role = '3';
        $admin->update();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        SuperAdmin::where('id', $request->id)->delete();
        return redirect()->back();
    }

    public function contact_us_get()
    {
        $contact = ContactUs::where('active', 1)->first();
        return view('backend.super_admin.contactus.edit', ['contact' => $contact]);
    }

    public function contact_us_update(Request $request)
    {
        $input = $request->except('_token', '_method');
        $folderPath = 'images/contactus/';
        $contact = ContactUs::where('active', 1)->first();
        $rules = [
            'top_text' => ['required', 'max:1000'],
            'phone' => ['required', 'max:30'],
            'email' => ['required', 'max:30'],
            'mid_text' => ['required', 'max:1000'],
            'address' => ['required', 'max:1000'],
            'map' => ['required', 'max:1000'],
            // 'image' => 'required|mimes:jpeg,png,jpg,gif'
        ];
        if (isset($contact->image) || !empty($contact->image)) {
            $rules['image'] = 'image';
        } else {
            $rules['image'] = 'required|mimes:jpeg,png,jpg,gif';
        }
        $validate = Validator::make($input, $rules);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
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

    public function gold_price_get()
    {
        $gold_price = GoldPrice::first();
        return view('backend.super_admin.gold_price.edit', ['gold_price' => $gold_price]);
    }

    public function gold_price_update(Request $request)
    {
        $input = $request->except('_token', '_method');
        $gold_price = GoldPrice::first();
        $rules = [
            'sell_price' => ['required', 'max:30'],
            'buy_price' => ['required', 'max:30'],
        ];
        $validate = Validator::make($input, $rules);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if ($gold_price) {
            $result = GoldPrice::find($gold_price['id'])->update($input);
        } else {
            $result = GoldPrice::create($input);
        }

        if ($result) {

            return redirect()->route('superAdmin.gold_price_get')->with(['status' => 'success', 'message' => 'Gold price was successfully Edited']);
        }
    }

}
