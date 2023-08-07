<?php

namespace App\Http\Controllers\super_admin;


use App\Http\Controllers\Controller;

use App\Messages;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuperadminMessage extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }

    public function showallexpire()
    {
        return view('backend.super_admin.message.expire');
    }

    public function deletebyone(Request $request)
    {
        Messages::destroy($request->id);
        return redirect()->back();
    }

    public function getexpire(Request $request)
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
        $totalRecords = Messages::where('messages.created_at', '<', Carbon::now()->subMinute())->count();
        $totalRecordswithFilter = Messages::where('messages.created_at', '<', Carbon::now()->subMinute())->count();

        if($columnName == 'expired_in'){
            $columnName='message_created_at';
        }

        $records = Messages::leftjoin('users', 'users.id', '=', 'message_user_id')->leftjoin('shop_owners', 'shop_owners.id', '=', 'message_shop_id')
            ->orderBy($columnName, $columnSortOrder)
            ->where([['users.username', 'like', '%' . $searchValue . '%'], ['messages.created_at', '<', Carbon::now()->subMinute()]])
            ->orWhere([['shop_owners.shop_name', 'like', '%' . $searchValue . '%'], ['messages.created_at', '<', Carbon::now()->subMinute()]])
            ->select('*', 'messages.created_at as message_created_at', 'messages.id as mid')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();
        foreach ($records as $record) {
            if(Str::contains($record->message, 'image')){
                $checkedstr=$record->message;
            }else{
                $checkedstr=Str::limit($record->message, 50);
            }
            $cd = Carbon::parse($record->message_created_at);
            $expiredMonth = Carbon::now()->subMinute();
            $diff = $cd->diffForHumans($expiredMonth);
            $data_arr[] = array(
                "checkbox" => $record->mid,
                "mid" => $record->mid,
                "user_name" => $record->username,
                "shop_name" => $record->shop_name ? $record->shop_name : '-',
                "message" => $checkedstr,
                "expired_in" => $diff,
                "action" => $record->mid,
                "message_created_at" =>  date('F d, Y ( h:i A )',strtotime($record->message_created_at))
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        return response()->json($response);

    }

}
