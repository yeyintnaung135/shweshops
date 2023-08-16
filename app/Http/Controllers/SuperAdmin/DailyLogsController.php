<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class DailyLogsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function daily_shop_create_log()
    {
        return view('backend.super_admin.dailycount.productdailycount');

    }

    public function get_all_daily_shop_create_counts(Request $request)
    {
        $searchByFromdate = $request->input('fromDate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('toDate') ?? Carbon::now();

        $totalRecordsQuery = DB::table('shopowner_log_activities')
            ->select('*', DB::raw('count(*) as total'))
            ->where('action', 'Create')
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->groupBy('shop_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($totalRecordsQuery)
            ->addColumn('shop_name', function ($record) {
                return empty($record->shop_name) ? $record->user_name : $record->shop_name;
            })
            ->addColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->make(true);
    }

    public function daily_shop_create_del_selected(Request $request)
    {
        $shopids = explode(',', $request->delshopids);

        DB::table('shopowner_log_activities')->where('action', 'Create')->whereIn('shop_id', $shopids)->whereBetween('created_at', [$request->fromdate, $request->todate])->delete();
        Session::flash('message', 'Shop Create Logs was successfully deleted');

        return redirect()->back();
    }

    public function daily_shop_create_del_all(Request $request)
    {

        $checkcount = DB::table('shopowner_log_activities')->where('action', 'Create')->whereBetween('created_at', [$request->cafromdate, $request->catodate]);
        if (count($checkcount->get()) == 0) {
            Session::flash('message', 'Empty lOGS');
            return redirect()->back();
        } else {
            $checkcount->delete();
            Session::flash('message', 'Shop Create Logs was successfully deleted');
            return redirect()->back();
        }

    }
    public function total_create_count(Request $request)
    {

        $checkcount = DB::table('shopowner_log_activities')->where('action', 'Create')->whereBetween('created_at', [$request->from, $request->to]);
        return json_encode($checkcount->count());

    }
}
