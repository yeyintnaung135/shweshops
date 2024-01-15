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
use Yajra\DataTables\Facades\DataTables;

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
        $searchByTodate = $request->input('searchByTodate');

        $recordsQuery = FacebookTable::with('shop')
            ->select('id', 'pagename', 'shop_id', 'created_at')
            ->when($searchByFromdate, fn ($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn ($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::eloquent($recordsQuery)
            ->addColumn('shop_name', function ($record) {
                return $record->shop->shop_name;
            })
            ->editColumn('created_at', fn ($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
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
            ->when($fromDate, fn ($query) => $query->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn ($query) => $query->whereDate('created_at', '<=', $toDate));

        return DataTables::of($recordsQuery)
            ->addColumn('user_name', function ($record) {
                if (!empty($record->user->username)) {
                    return $record->user->username;
                } else {
                    return 'Deleted User';
                }
            })
            ->addColumn('user_phone', function ($record) {
                if (!empty($record->user->phone)) {
                    return $record->user->phone;
                } else {
                    return 'Deleted User';
                }
            })
            ->addColumn('item_name', function ($record) {
                if (!empty($record->item->name)) {
                    return $record->item->name;
                } else {
                    return 'Deleted Item';
                }
            })
            ->addColumn('item_code', function ($record) {
                if (!empty($record->item->product_code)) {
                    return $record->item->product_code;
                } else {
                    return 'Deleted Item';
                }
            })
            ->addColumn('item_photo', function ($record) {
                if ($record->item) {
                    return $record->item->check_photo ?? '';
                }
                return '';
            })
            ->editColumn('created_at', fn ($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->make(true);
    }

    public function get_msg_log(Request $request): JsonResponse
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $recordsQuery = Shops::select('id', 'shop_name', 'created_at')
            ->withCount('facebook_message_clicks')
            ->when($fromDate, fn ($query) => $query->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn ($query) => $query->whereDate('created_at', '<=', $toDate));

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
