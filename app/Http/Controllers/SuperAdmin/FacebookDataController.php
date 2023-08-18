<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FacebookMessage;
use App\Models\FacebookTable;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class FacebookDataController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function list(): View {
        return view('backend.super_admin.fbdata.list');
    }

    public function get_all(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $recordsQuery = FacebookTable::leftJoin('shops', 'facebook.shop_owner_id', '=', 'shops.id')
            ->select('shops.id','shops.shop_name','facebook.pagename','facebook.created_at')
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($recordsQuery)
            ->editColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
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

    public function get_msg_log(Request $request): JsonResponse
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
