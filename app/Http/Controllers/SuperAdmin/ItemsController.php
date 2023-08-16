<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ShopBanner;
use App\Models\Shops;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }

    public function total_create_count(Request $request): RedirectResponse
    {
        $allcount = Item::all();
        $allcountbydate = Item::whereBetween('created_at', [$request->from, $request->to])->get();
        return response()->json(['all' => count($allcount), 'alld' => count($allcountbydate)]);
    }

    public function all(): View
    {
        //TODO $shopOwner is not needed. Thus, we should remove this
        $shopOwner = Shops::all();
        return view('backend.super_admin.items.all', ['shopOwner' => $shopOwner]);
    }

    public function get_items_ajax(Request $request): mixed
    {
        $searchByFromdate = $request->input('fromDate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('toDate') ?? Carbon::now();

        $recordsQuery = Item::leftJoin('shop_owners', 'items.shop_id', '=', 'shop_owners.id')
            ->select('shop_owners.*', DB::raw('count(*) as total'), 'items.created_at as ica')
            ->whereBetween('items.created_at', [$searchByFromdate, $searchByTodate])
            ->orderBy('created_at', 'desc');

        return DataTables::of($recordsQuery)
            ->addColumn('name', function ($record) {
                return Shops::where('id', $record->id)->first()->shop_name;
            })
            ->addColumn('shop_name_myan', function ($record) {
                return $record->shop_name_myan ? $record->shop_name_myan : '-';
            })
            ->addColumn('shop_logo', function ($record) {
                return $record->shop_logo;
            })
            ->addColumn('shop_banner', function ($record) {
                $checkbanner = ShopBanner::where('shop_owner_id', $record->id)->first();
                return empty($checkbanner) ? '' : $checkbanner->location;
            })
            ->addColumn('premium', function ($record) {
                return $record->premium;
            })
            ->addColumn('description', function ($record) {
                return Str::limit($record->description, 50, ' ...');
            })
            ->addColumn('email', function ($record) {
                return $record->total;
            })
            ->addColumn('undamaged_product', function ($record) {
                return $record->undamaged_product;
            })
            ->addColumn('valuable_product', function ($record) {
                return $record->valuable_product;
            })
            ->addColumn('damaged_product', function ($record) {
                return $record->damaged_product;
            })
            ->addColumn('messenger_link', function ($record) {
                return $record->messenger_link;
            })
            ->addColumn('page_link', function ($record) {
                return $record->page_link;
            })
            ->addColumn('address', function ($record) {
                return $record->address;
            })
            ->addColumn('main_phone', function ($record) {
                return $record->main_phone;
            })
            ->addColumn('action', function ($record) {
                return $record->id;
            })
            ->addColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->ica));
            })
            ->make(true);
    }
}
