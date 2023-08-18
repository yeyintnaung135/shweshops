<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ShopBanner;
use App\Models\Shops;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function total_create_count(Request $request): JsonResponse
    {
        $allcount = Item::count();
        $allcountbydate = Item::whereBetween('created_at', [$request->from, $request->to])->count();
        return response()->json(['all' => $allcount, 'alld' => $allcountbydate]);
    }

    public function all(): View
    {
        //TODO $shopOwner is not needed. Thus, we should remove this
        $shopOwner = Shops::all();
        return view('backend.super_admin.items.all', ['shopOwner' => $shopOwner]);
    }

    public function get_items_ajax(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');
        $shopsQuery = Shops::select('id','shop_name','shop_logo', 'shop_banner', 'premium', 'main_phone', 'created_at')
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));
        $shops = $shopsQuery->get();
        $itemCounts = $this->calculate_item_counts($shops);

        return DataTables::of($shopsQuery)
            ->editColumn('shop_banner', function ($record) {
                $checkbanner = ShopBanner::where('shop_owner_id', $record->id)->first();
                return empty($checkbanner) ? '' : $checkbanner->location;
            })
            ->editColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->addColumn('items_count', function ($shop) use ($itemCounts) {
                return $itemCounts[$shop->id];
            })
            ->make(true);
    }

    private function calculate_item_counts($shops): array
    {
        $itemCounts = [];

        foreach ($shops as $shop) {
            $itemCount = Item::where('shop_id', $shop->id)
                ->count();
            $itemCounts[$shop->id] = $itemCount;
        }

        return $itemCounts;
    }
}
