<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AddToCartClickLog;
use App\Models\BuyNowClickLog;
use App\Models\FrontUserLogs;
use App\Models\GuestOrUserId;
use App\Models\Shops;
use App\Models\User;
use App\Models\WishlistClickLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DangerZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function show_delete_logs()
    {

        //base on day count
        $registered = User::all();
        $alllogscount = FrontUserLogs::select(DB::raw('count(*) as total'))->first()->total;

        $viewer = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->whereBetween('front_user_logs.created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();
        $adsview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'adsclick')->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->groupBy('front_user_logs.visited_link')->whereBetween('front_user_logs.created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();

        $shop = Shops::all();
        $shopview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'shopdetail')->groupBy('front_user_logs.userorguestid')->groupBy(DB::raw('date(front_user_logs.created_at)'))->groupBy('front_user_logs.visited_link')->whereBetween('front_user_logs.created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();

        $buynow = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))->groupBy(DB::raw('date(buy_now_click_logs.created_at)'))->groupBy('buy_now_click_logs.item_id')->whereBetween('buy_now_click_logs.created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();

        $addtocart = AddToCartClickLog::whereBetween('created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();
        $whishlist = WishlistClickLog::whereBetween('created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();
        //base on day count

        $uqviewer = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->groupBy('front_user_logs.userorguestid')->whereBetween('front_user_logs.created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();
        $uqadsview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'adsclick')->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->whereBetween('front_user_logs.created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();

        $shop = Shops::all();
        $uqshopview = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->where('status', 'shopdetail')->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->whereBetween('front_user_logs.created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();
        $uqbuynow = BuyNowClickLog::leftjoin('guestoruserid', 'buy_now_click_logs.userorguestid', '=', 'guestoruserid.id')->select('*', DB::raw("count('*') as total"))
            ->groupBy(DB::raw('case when guestoruserid.user_id = 0 then guestoruserid.guest_id else guestoruserid.user_id end'))->groupBy('buy_now_click_logs.item_id')->whereBetween('buy_now_click_logs.created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();

        //all logs count
        $allviewers = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->whereBetween('front_user_logs.created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();

        $alladsviewers = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->select(DB::raw("count('*') as total"))->where('front_user_logs.status', 'adsclick')->groupBy('guestoruserid.ip')->whereBetween('front_user_logs.created_at', [Carbon::now()->subDays(3), Carbon::now()])->get();
        $allshopviewers = FrontUserLogs::select(DB::raw("count('*') as total"))->where('status', 'shopdetail')->whereBetween('front_user_logs.created_at', [Carbon::now()->subDays(3), Carbon::now()])->first()->total;
        $allbuynow = BuyNowClickLog::select(DB::raw("count('*') as total"))->whereBetween('created_at', [Carbon::now()->subDays(3), Carbon::now()])->first()->total;

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
        return view('backend.super_admin.dangerzone.deletelogs', ['register' => $registered,
            'newusers' => $countnu,
            'alllogscount' => $alllogscount,
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

    public function delete_logs(Request $request)
    {
        $deletelogs = FrontUserLogs::whereBetween('created_at', [$request->from, $request->to])->delete();
        $wdeletelogs = WishlistClickLog::whereBetween('created_at', [$request->from, $request->to])->delete();
        $atcdeletelogs = AddToCartClickLog::whereBetween('created_at', [$request->from, $request->to])->delete();
        $userdeletelogs = GuestOrUserId::whereBetween('created_at', [$request->from, $request->to])->delete();
        $buynowclicklogs = BuyNowClickLog::whereBetween('created_at', [$request->from, $request->to])->delete();
        $deletedcount = $request->currenttotal - FrontUserLogs::select(DB::raw('count(*) as total'))->first()->total;

        return response()->json(['success' => true, 'data' => $request->all(), 'deleted_count' => $deletedcount]);
    }
}
