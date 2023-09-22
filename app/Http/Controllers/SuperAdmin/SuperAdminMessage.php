<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SuperAdminMessage extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function show_all_expire(): View
    {
        return view('backend.super_admin.message.expire');
    }

    public function delete_by_one(Request $request): RedirectResponse
    {
        Messages::destroy($request->id);
        return redirect()->back();
    }

    public function get_expire(Request $request)
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

        if ($columnName == 'expired_in') {
            $columnName = 'message_created_at';
        }

        $records = Messages::leftjoin('users', 'users.id', '=', 'message_user_id')->leftjoin('shops', 'shops.id', '=', 'message_shop_id')
            ->orderBy($columnName, $columnSortOrder)
            ->where([['users.username', 'like', '%' . $searchValue . '%'], ['messages.created_at', '<', Carbon::now()->subMinute()]])
            ->orWhere([['shops.shop_name', 'like', '%' . $searchValue . '%'], ['messages.created_at', '<', Carbon::now()->subMinute()]])
            ->select('*', 'messages.created_at as message_created_at', 'messages.id as mid')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();
        foreach ($records as $record) {
            if (Str::contains($record->message, 'image')) {
                $checkedstr = $record->message;
            } else {
                $checkedstr = Str::limit($record->message, 50);
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
                "message_created_at" => date('F d, Y ( h:i A )', strtotime($record->message_created_at)),
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

    //INFO Not enough time to implement for MongoDB Model
    // public function get_expire(Request $request): JsonResponse
    // {
    //     $messages = Messages::with(['user:id,name', 'shop:id,shop_name'])
    //         ->select('id', 'message', 'created_at');

    //     return DataTables::of($messages)
    //         ->addColumn('checkbox', function ($record) {
    //             return $record->id;
    //         })
    //         ->addColumn('user_name', function ($record) {
    //             return $record->user ? $record->user->name : '-';
    //         })
    //         ->addColumn('shop_name', function ($record) {
    //             return $record->shop ? $record->shop->shop_name : '-';
    //         })
    //         ->addColumn('message', function ($record) {
    //             if (Str::contains($record->message, 'image')) {
    //                 return $record->message;
    //             } else {
    //                 return Str::limit($record->message, 50);
    //             }
    //         })
    //         ->addColumn('expired_in', function ($record) {
    //             $cd = Carbon::parse($record->message_created_at);
    //             $expiredMonth = Carbon::now()->subMinute();
    //             return $cd->diffForHumans($expiredMonth);
    //         })
    //         ->addColumn('action', function ($record) {
    //             return $record->id;
    //         })
    //         ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
    //         ->toJson();
    // }
}
