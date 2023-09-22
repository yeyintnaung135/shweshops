<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\UserRole;
use App\Models\FacebookMessage;
use App\Models\FacebookTable;
use App\Models\Item;
use App\Models\Shops;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class FacebookDataController extends Controller
{
    use UserRole;
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function list(): View
    {
        return view('backend.super_admin.fbdata.list');
    }

    public function get_all(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $toDate = $request->input('toDate');

        $recordsQuery = FacebookTable::leftJoin('shops', 'facebook.shop_owner_id', '=', 'shops.id')
            ->select('shops.id', 'shops.shop_name', 'facebook.pagename', 'facebook.created_at')
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($toDate, fn($query) => $query->whereDate('created_at', '<=', $toDate));

        return DataTables::of($recordsQuery)
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->make(true);
    }

    public function get_count(Request $request): JsonResponse
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
    public function messenger_log(): View
    {
        return view('backend.super_admin.fbdata.msglog');
    }
    public function messenger_log_detail($shopid)
    {
        return view('backend.super_admin.fbdata.msglogdetail', ['shop_id' => $shopid]);
    }
    public function get_msg_log_detail(Request $request): JsonResponse
    {
        $fromDate = $request->input('fromDate') ?? '0-0-0 00:00:00';
        $toDate = $request->input('toDate') ?? Carbon::now();
        $shop_id = $request->input('shop_id');

        $recordsQuery = FacebookMessage::where('shop_id', $shop_id)
            ->select('id', 'user_fb_id', 'user_id', 'item_id', 'created_at')
            ->when($fromDate, fn($query) => $query->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn($query) => $query->whereDate('created_at', '<=', $toDate));

        return DataTables::of($recordsQuery)
            ->addColumn('user_name', function ($record) {
                return $record->user->username;
            })
            ->addColumn('user_phone', function ($record) {
                return $record->user->phone;
            })
            ->addColumn('item_name', function ($record) {
                return $record->item->name;
            })
            ->addColumn('item_code', function ($record) {
                return $record->item->product_code;
            })
            ->addColumn('item_photo', function ($record) {
                if ($record->item) {
                    return $record->item->check_photo ?? '';
                }
                return '';
            })
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->make(true);
    }

    public function get_msg_log(Request $request): JsonResponse
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $recordsQuery = Shops::select('id', 'shop_name', 'created_at')
            ->withCount('facebook_message_clicks')
            ->when($fromDate, fn($query) => $query->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn($query) => $query->whereDate('created_at', '<=', $toDate));

        return DataTables::of($recordsQuery)
            ->editColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->addColumn('action', function ($record) {
                return $record->id;
            })
            ->make(true);
    }
}
