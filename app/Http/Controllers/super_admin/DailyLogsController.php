<?php

namespace App\Http\Controllers\super_admin;


use App\Http\Controllers\Controller;
use App\ShopownerLogActivity;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class DailyLogsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }

    public function daily_shop_create_log()
    {
        return view('backend.super_admin.dailycount.productdailycount');

    }

    public function getalldailyshopcreatecounts(Request $request)
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
            $searchByFromdate = Carbon::now();
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }


        $totalRecords = DB::table('shopowner_log_activities')
                        ->where('action', 'Create')
                        ->where(function ($query) use ($searchValue) {
                            $query->where('shop_name', 'like', '%' . $searchValue . '%')
                                ->orWhere('user_name', 'like', '%' . $searchValue . '%');
                        })
                        ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
                        ->groupBy('shop_id')->get();
        $totalRecordswithFilter = $totalRecords;

        $getshopcreatecountbydateraw = DB::table('shopowner_log_activities')
            //if u want to use both count use this query ex (create count and edit count and delete count)
      //            ->select(['*',DB::raw("COUNT(CASE action WHEN 'Create' THEN 1 ELSE NULL END) as ctotal"),DB::raw("COUNT(CASE action WHEN 'Edit' THEN 1 ELSE NULL END) as etotal")])
            //end
            ->select('*', DB::raw("count('*') as total"))
            ->where(function ($query) use ($searchValue) {
                $query->where('shop_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->where('action', 'Create')
            ->groupBy('shop_id')
            ->orderBy($columnName, $columnSortOrder);


        $getshopcreatecountbydate = $getshopcreatecountbydateraw->skip($start)->take($rowperpage)->get();


        $data_arr_for_datatable = array();

        foreach ($getshopcreatecountbydate as $d) {
            $data_arr_for_datatable[] = array(
                "checkbox" => $d->shop_id,
                "id" => $d->id,
                "shop_name" => empty($d->shop_name) ? $d->user_name : $d->shop_name,
                "product_count" => $d->total,
                "created_at" => date('F d, Y ( h:i A )', strtotime($d->created_at)),
            );
        }
        $response = array(
            "draw" => $draw,
            "iTotalRecords" => count($totalRecords),
            "iTotalDisplayRecords" => count($totalRecords),
            "aaData" => $data_arr_for_datatable,
        );
        return json_encode($response);
    }

    function daily_shop_create_delselected(Request $request)
    {
        $shopids = explode(',', $request->delshopids);

        DB::table('shopowner_log_activities')->where('action', 'Create')->whereIn('shop_id', $shopids)->whereBetween('created_at', [$request->fromdate, $request->todate])->delete();
        Session::flash('message', 'Shop Create Logs was successfully deleted');

        return redirect()->back();
    }

    function daily_shop_create_delall(Request $request)
    {


       $checkcount=DB::table('shopowner_log_activities')->where('action', 'Create')->whereBetween('created_at', [$request->cafromdate, $request->catodate]);
       if(count($checkcount->get()) == 0){
           Session::flash('message', 'Empty lOGS');
           return redirect()->back();
       }else{
           $checkcount->delete();
           Session::flash('message', 'Shop Create Logs was successfully deleted');
           return redirect()->back();
       }


    }
    function total_create_count(Request $request)
    {


        $checkcount=DB::table('shopowner_log_activities')->where('action', 'Create')->whereBetween('created_at', [$request->from, $request->to]);
        return json_encode($checkcount->count());


    }
}
