<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FacebookMessage;
use App\Models\FacebookTable;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FacebookDataController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }

    public function list() {
        return view('backend.super_admin.fbdata.list');
    }

    public function get_all(Request $request)
    {
        $searchByFromdate = $request->input('fromDate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('toDate') ?? Carbon::now();

        $recordsQuery = FacebookTable::leftJoin('shop_owners', 'facebook.shop_owner_id', '=', 'shop_owners.id')
            ->select('*', 'facebook.created_at as ff')
            ->orderBy('facebook.created_at', 'desc')
            ->whereBetween('facebook.created_at', [$searchByFromdate, $searchByTodate]);

        return DataTables::of($recordsQuery)
            ->addColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->ff));
            })
            ->make(true);
    }

    public function get_count(Request $request)
    {
        $allcount = FacebookTable::all();
        $allcountbydate = FacebookTable::whereBetween('created_at', [$request->from, $request->to])->get();
        return response()->json(['all' => count($allcount), 'alld' => count($allcountbydate)]);
    }
    public function get_msg_log_count(Request $request)
    {
        $allcount = FacebookMessage::all();
        $allcountbydate = FacebookMessage::whereBetween('created_at', [$request->from, $request->to])->get();
        return response()->json(['all' => count($allcount), 'alld' => count($allcountbydate)]);
    }
    public function messenger_log()
    {
        return view('backend.super_admin.fbdata.msglog');
    }
    public function messenger_log_detail($shopid)
    {
        return view('backend.super_admin.fbdata.msglogdetail', ['shop_id' => $shopid]);
    }
    public function get_msg_log_detail(Request $request)
    {
        $searchByFromdate = $request->input('fromDate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('toDate') ?? Carbon::now();

        $recordsQuery = FacebookMessage::leftJoin('shop_owners', 'fb_messenger_click_log.shop_id', '=', 'shop_owners.id')
            ->leftJoin('items', 'fb_messenger_click_log.item_id', '=', 'items.id')
            ->where('fb_messenger_click_log.shop_id', $request->get('shop_id'))
            ->leftJoin('users', 'fb_messenger_click_log.user_id', '=', 'users.id')
            ->orderBy('fb_messenger_click_log.created_at', 'desc')
            ->select('*', 'fb_messenger_click_log.created_at as ff')
            ->whereBetween('fb_messenger_click_log.created_at', [$searchByFromdate, $searchByTodate]);

        return DataTables::of($recordsQuery)
            ->addColumn('item_photo', function ($record) {
                $photo = Item::where('id', $record->item_id)->first();
                return !empty($photo) ? $photo->check_photo : '';
            })
            ->addColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->ff));
            })
            ->make(true);
    }

    public function get_msg_log(Request $request)
    {
        $searchByFromdate = $request->input('fromDate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('toDate') ?? Carbon::now();

        $recordsQuery = FacebookMessage::leftJoin('shop_owners', 'fb_messenger_click_log.shop_id', '=', 'shop_owners.id')
            ->select('*', 'fb_messenger_click_log.created_at as ff', DB::raw('count(*) as total'))
            ->whereBetween('fb_messenger_click_log.created_at', [$searchByFromdate, $searchByTodate])
            ->orderBy('fb_messenger_click_log.created_at', 'desc');

        return DataTables::of($recordsQuery)
            ->addColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->ff));
            })
            ->addColumn('detail', function ($record) {
                return $record->shop_id;
            })
            ->make(true);
    }
}
