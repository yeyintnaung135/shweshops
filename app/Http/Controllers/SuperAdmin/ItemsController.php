<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ShopBanner;
use App\Models\Shops;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function total_create_count(Request $request): JsonResponse
    {
        $allcount = Item::count();
        $allcountbydate = Item::leftjoin('shops', 'items.shop_id', '=', 'shops.id')->where('items.deleted_at', null)->where('shops.deleted_at', null)->whereBetween('items.created_at', [Carbon::createFromDate($request->from), Carbon::createFromDate($request->to)])->count();
        return response()->json(['all' => $allcount, 'alld' => $allcountbydate]);
    }

    public function all(): View
    {
        return view('backend.super_admin.items.all');
    }

    public function get_items_ajax(Request $request)
    {
        $searchByFromdate = Carbon::createFromDate($request->input('searchByFromdate'));
        $searchByTodate = Carbon::createFromDate($request->input('searchByTodate'))->addDay();

        $shopsQuery = Item::leftjoin('shops', 'items.shop_id', '=', 'shops.id')->select(array('shops.*', DB::raw('COUNT(items.shop_id) as items_count')))
            ->groupBy('items.shop_id')
            ->whereBetween('items.created_at', [$searchByFromdate, $searchByTodate]);
        return DataTables::eloquent($shopsQuery)
            ->editColumn('shop_banner', function ($shop) {
                $checkbanner = ShopBanner::where('shop_owner_id', $shop->id)->first();
                return empty($checkbanner) ? '' : $checkbanner->location;
            })
            ->editColumn('created_at', function ($shop) {
                return date('F d, Y ( h:i A )', strtotime($shop->created_at));
            })
            ->addColumn('items', function ($shop) {
                return $shop->items_count;
            })
            ->make(true);
    }

    private function calculate_item_counts($shops): array
    {
        $itemCounts = [];

        foreach ($shops as $shop) {
            $itemCount = Item::where('shop_id', $shop->id)->count();
            $itemCounts[$shop->id] = $itemCount;
        }

        return $itemCounts;
    }
}
