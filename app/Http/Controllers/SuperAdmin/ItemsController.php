<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ShopBanner;
use App\Models\Shops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }

    public function total_create_count(Request $request)
    {
        $allcount = Item::all();
        $allcountbydate = Item::whereBetween('created_at', [$request->from, $request->to])->get();
        return response()->json(['all' => count($allcount), 'alld' => count($allcountbydate)]);
    }

    public function all()
    {
        //TODO $shopOwner is not needed. Thus, we should remove this
        $shopOwner = Shops::all();
        return view('backend.super_admin.items.all', ['shopOwner' => $shopOwner]);
    }

    public function get_items_ajax(Request $request)
    {
        //
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

        $totalRecords = Item::leftjoin('shop_owners', 'items.shop_id', '=', 'shop_owners.id')
            ->where(function ($query) use ($searchValue) {
                if (strtolower($searchValue) == "premium") {
                    $premium = '%' . "yes" . '%';
                } elseif (strtolower($searchValue) == "normal") {
                    $premium = '%' . "no" . '%';
                } else {
                    $premium = $searchValue;
                }
                $query->where('shop_owners.premium', 'like', $premium)->orWhere('shop_owners.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.shop_name_myan', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.address', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.main_phone', 'like', '%' . $searchValue . '%');
            })

            ->groupBy('items.shop_id')

            ->whereBetween('items.created_at', [$searchByFromdate, $searchByTodate])->get();
        $totalRecordswithFilter = $totalRecords;
        if ($columnName == 'name') {
            $columnName = 'shop_owners.shop_name';
        }
        if ($columnName == 'created_at') {
            $columnName = 'items.created_at';
        }
        $records = Item::leftjoin('shop_owners', 'items.shop_id', '=', 'shop_owners.id')->select('shop_owners.*', DB::raw("count('*') as total"), 'items.created_at as ica')
            ->orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                if (strtolower($searchValue) == "premium") {
                    $premium = '%' . "yes" . '%';
                } elseif (strtolower($searchValue) == "normal") {
                    $premium = '%' . "no" . '%';
                } else {
                    $premium = $searchValue;
                }
                $query->where('shop_owners.premium', 'like', $premium)->orWhere('shop_owners.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.shop_name_myan', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.address', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.main_phone', 'like', '%' . $searchValue . '%');
            })

            ->whereBetween('items.created_at', [$searchByFromdate, $searchByTodate])
            ->groupBy('items.shop_id')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $checkbanner = ShopBanner::where('shop_owner_id', $record->id)->first();
            if (empty($checkbanner)) {
            } else {
                $record->shop_banner = ShopBanner::where('shop_owner_id', $record->id)->first()->location;
            }
            $shopname = Shops::where('id', $record->id)->first()->shop_name;
            $data_arr[] = array(
                "id" => $record->id,
                "name" => $shopname,
                "shop_name_myan" => $record->shop_name_myan ? $record->shop_name_myan : '-',
                "shop_logo" => $record->shop_logo,
                "shop_banner" => $record->shop_banner,
                "premium" => $record->premium,
                "description" => Str::limit($record->description, 50, ' ...'),
                "email" => $record->total,
                "undamaged_product" => $record->undamaged_product,
                "valuable_product" => $record->valuable_product,
                "damaged_product" => $record->damaged_product,
                "messenger_link" => $record->messenger_link,
                "page_link" => $record->page_link,
                "address" => $record->address,
                "main_phone" => $record->main_phone,
                "action" => $record->id,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->ica)),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => count($totalRecords),
            "iTotalDisplayRecords" => count($totalRecordswithFilter),
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }
}
