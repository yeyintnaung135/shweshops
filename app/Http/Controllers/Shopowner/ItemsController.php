<?php

namespace App\Http\Controllers\ShopOwner;

use App\Models\facebooktable;
use App\Models\Gems;
use App\Http\Controllers\Trait\FacebookTraid;
use App\Imports\ItemsImport;
use App\Models\Item;
use App\Models\ItemLogActivity;
use App\Models\MultiplePriceLogs;
use App\Models\MultipleDiscountLogs;
use App\Models\MultipleDamageLogs;
use App\Models\Recap;
use App\Models\discount;
use App\Models\MainCategory;
use App\Models\Shopowner;
use App\Models\Percent_template;
use App\Models\categories;
use App\Models\Collection;
use App\Models\ItemsEditDetailLogs;
use App\Facade\TzGate;
use App\Productdetails;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\ProdcutdetailsForItems;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Trait\TzRule;
use App\Http\Controllers\Trait\YKImage;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Trait\UserRole;
use App\Http\Requests\ItemsRecapRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Trait\MultipleItem;
use App\Http\Requests\ItemsRecapUpdateRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\MultiplePriceUpdateRequest;

class ItemsController extends Controller
{
    use YKImage, UserRole, MultipleItem,FacebookTraid;

    public $err_data = [];

    public function __construct()
    {
        $this->middleware('auth:shop_owners_and_staffs');
    }

    public function index()
    {
      
            $items = Item::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
     

        return view('backend.shopowner.item.list', ['items' => $items, 'shopowner' => $this->current_shop_data()]);
    }

    public function updateexcel()
    {
        return view('backend.shopowner.item.updateexcel');
    }

    public function postupdateexcel(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, [

            'excel' => ['mimes:xlsx', 'required'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Excel::import(new ItemsImport, $request->file('excel'));
        Session::flash('message', 'Your Products are succesfully updated with excel');
        return redirect(url('backside/shop_owner/items'));
    }

    public function item_activity_index()
    {
        if (Auth::guard("shop_role")->check()) {
            $this->role('shop_role');
            $items = Item::where('shop_id', $this->role_shop_id)->orderBy('created_at', 'desc')->get();
        } else {
            $this->role('shop_owner');
            $items = Item::where('shop_id', $this->role)->orderBy('created_at', 'desc')->get();
        }
        return view('backend.shopowner.activity.product.item', ['items' => $items, 'shopowner' => $this->shop_owner]);
    }

    public function multiprice_activity_index()
    {
        if (Auth::guard("shop_role")->check()) {
            $this->role('shop_role');
            $items = Item::where('shop_id', $this->role_shop_id)->orderBy('created_at', 'desc')->get();
        } else {
            $this->role('shop_owner');
            $items = Item::where('shop_id', $this->role)->orderBy('created_at', 'desc')->get();
        }
        return view('backend.shopowner.activity.product.multiprice', ['items' => $items, 'shopowner' => $this->shop_owner]);
    }

    public function multidiscount_activity_index()
    {
        if (Auth::guard("shop_role")->check()) {
            $this->role('shop_role');
            $items = Item::where('shop_id', $this->role_shop_id)->orderBy('created_at', 'desc')->get();
        } else {
            $this->role('shop_owner');
            $items = Item::where('shop_id', $this->role)->orderBy('created_at', 'desc')->get();
        }
        return view('backend.shopowner.activity.product.multidis', ['items' => $items, 'shopowner' => $this->shop_owner]);
    }

    public function multipercent_activity_index()
    {
        if (Auth::guard("shop_role")->check()) {
            $this->role('shop_role');
            $items = Item::where('shop_id', $this->role_shop_id)->orderBy('created_at', 'desc')->get();
        } else {
            $this->role('shop_owner');
            $items = Item::where('shop_id', $this->role)->orderBy('created_at', 'desc')->get();
        }
        return view('backend.shopowner.activity.product.multipercent', ['items' => $items, 'shopowner' => $this->shop_owner]);
    }

    public function getItemActivityLog(Request $request)
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

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');


        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }

        $shop_id = 1;

        if (Auth::guard('shop_owner')->check()) {
            $shop_id = Auth::guard('shop_owner')->user()->id;
        } else {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        }

        $totalRecords = Itemlogactivity::select('count(*) as allcount')
            ->where('shop_id', $shop_id)
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('item_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = ItemLogActivity::orderBy($columnName, $columnSortOrder)
            ->where('shop_id', $shop_id)->orderBy('created_at', 'desc')
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('item_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('item_log_activities.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        //    return $records;
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "item_code" => $record->item_code,
                "name" => $record->name,
                "user_id" => $record->user_id,
                "user_name" => $record->user_name,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->created_at)),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function getMultiplePriceActivityLog(Request $request)
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

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');


        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }

        $shop_id = 1;

        if (Auth::guard('shop_owner')->check()) {
            $shop_id = Auth::guard('shop_owner')->user()->id;
        } else {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        }

        $totalRecords = MultiplePriceLogs::select('count(*) as allcount')
            ->where('shop_id', $shop_id)
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_role', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('min_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('max_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_min_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_max_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = MultiplePriceLogs::orderBy($columnName, $columnSortOrder)
            ->where('shop_id', $shop_id)->orderBy('created_at', 'desc')
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_role', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('min_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('max_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_min_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_max_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('multiple_price_logs.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        //    return $records;
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "product_code" => $record->product_code,
                "name" => $record->name,
                "user_id" => $record->user_id,
                "user_name" => $record->user_name,
                "user_role" => $record->user_role,
                "old_price" => $record->old_price,
                "new_price" => $record->new_price,
                "min_price" => $record->min_price,
                "max_price" => $record->max_price,
                "new_min_price" => $record->new_min_price,
                "new_max_price" => $record->new_max_price,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->created_at)),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function getMultipleDiscountActivityLog(Request $request)
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

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');


        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }

        $shop_id = 1;

        if (Auth::guard('shop_owner')->check()) {
            $shop_id = Auth::guard('shop_owner')->user()->id;
        } else {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        }

        $totalRecords = MultipleDiscountLogs::select('count(*) as allcount')
            ->where('shop_id', $shop_id)
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_role', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_min_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_max_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('percent', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_discount_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_discount_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_discount_min', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_discount_max', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_discount_min', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_discount_max', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = MultipleDiscountLogs::orderBy($columnName, $columnSortOrder)
            ->where('shop_id', $shop_id)->orderBy('created_at', 'desc')
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_role', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_min_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_max_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('percent', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_discount_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_discount_price', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_discount_min', 'like', '%' . $searchValue . '%')
                    ->orWhere('old_discount_max', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_discount_min', 'like', '%' . $searchValue . '%')
                    ->orWhere('new_discount_max', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('multiple_discount_logs.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        //    return $records;
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "product_code" => $record->product_code,
                "name" => $record->name,
                "user_id" => $record->user_id,
                "user_name" => $record->user_name,
                "user_role" => $record->user_role,
                "old_price" => $record->old_price,
                "old_min_price" => $record->old_min_price,
                "old_max_price" => $record->old_max_price,
                "percent" => $record->percent,
                "old_discount_price" => $record->old_discount_price,
                "new_discount_price" => $record->new_discount_price,
                "old_discount_min" => $record->old_discount_min,
                "old_discount_max" => $record->old_discount_max,
                "new_discount_min" => $record->new_discount_min,
                "new_discount_max" => $record->new_discount_max,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->created_at)),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function getMultipleDamageActivityLog(Request $request)
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

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');


        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }

        $shop_id = 1;

        if (Auth::guard('shop_owner')->check()) {
            $shop_id = Auth::guard('shop_owner')->user()->id;
        } else {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        }

        $totalRecords = MultipleDamageLogs::select('count(*) as allcount')->where('shop_id', $shop_id)->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = MultipleDamageLogs::select('count(*) as allcount')->where('shop_id', $shop_id)->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->count();

        $records = MultipleDamageLogs::orderBy($columnName, $columnSortOrder)
            ->where('shop_id', $shop_id)->orderBy('created_at', 'desc')
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('multiple_damage_logs.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        //    return $records;
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "product_code" => $record->product_code,
                "name" => $record->name,
                "user_id" => $record->user_id,
                "user_name" => $record->user_name,
                "user_role" => $record->user_role,
                "name" => $record->name,
                "decrease" => $record->decrease,
                "fee" => $record->fee,
                "undamage" => $record->undamage,
                "damage" => $record->damage,
                "expensive_thing" => $record->expensive_thing,
                "new_decrease" => $record->new_decrease,
                "new_fee" => $record->new_fee,
                "new_undamage" => $record->new_undamage,
                "new_damage" => $record->new_damage,
                "new_expensive_thing" => $record->new_expensive_thing,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->created_at)),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }
    //show create form
    //Process Ajax request
    public function getItems(Request $request)
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

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');


        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }

        $shop_id = $this->get_shopid();

       


        $totalRecords = Item::select('count(*) as allcount')
            ->where('shop_id', $shop_id)
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = Item::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where('shop_id', $shop_id)
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('items.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        //    return $records;
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "checkbox" => $record->id,
                "id" => $record->id,
                "check_discount" => $record->YkGetDiscount,
                "product_code" => $record->product_code,
                "image" => $record->default_photo,
                "name" => $record->name,
                // "description" => strlen($record->description)<=80 ? substr($record->description, 0, 80) :substr($record->description, 0, 80) . ' ...',
                "description" => Str::length($record->description) <= 80 ? Str::substr($record->description, 0, 80) : Str::substr($record->description, 0, 80) . ' ...',
                "price" => [($record->price != 0) ? $record->price : $record->min_price . '-' . $record->max_price, $record->id],
                "action" => $record->id,
                "created_at" => $record->created_at,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);

    }

    public function exportexcel()
    {
        return view('backend.shopowner.item.exportexcel');
    }

    public function postexportexcel(Request $request)
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

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');


        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }

        $shop_id = 1;

        if (Auth::guard('shop_owner')->check()) {
            $shop_id = Auth::guard('shop_owner')->user()->id;

        } else {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        }


        $totalRecords = Item::select('count(*) as allcount')
            ->where('shop_id', $shop_id)
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = Item::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where('shop_id', $shop_id)
            ->where(function ($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('items.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        //    return $records;
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "check_discount" => $record->YkGetDiscount,
                "product_code" => $record->product_code,
                "image" => $record->default_photo,
                "name" => $record->name,
                // "description" => strlen($record->description)<=80 ? substr($record->description, 0, 80) :substr($record->description, 0, 80) . ' ...',
                "description" => Str::length($record->description) <= 80 ? Str::substr($record->description, 0, 80) : Str::substr($record->description, 0, 80) . ' ...',
                "price" => [($record->price != 0) ? $record->price : $record->short_price, $record->id],
                "action" => $record->id,
                "created_at" => $record->created_at,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);

    }

    public function getproductcodebytyping(Request $request)
    {
        $result = Item::orderBy('product_code', 'asc')
            ->where('shop_id', $request->shop_id)
            ->where('product_code', 'like', $request->chatdatabytyping . '%')
            ->select('*')
            ->take(5)
            ->get();
        echo json_encode($result);
    }


    //show create form
    public function create()
    {


        $test_world_gold = 3224903.7151547;
        $product_details = Productdetails::all();
        //tz
        if (isset(Auth::guard('shop_role')->user()->id)) {
            $this->role('shop_role');
            $collection = Collection::where('shop_id', $this->role_shop_id)->get();
            $somedatafromshop = Shopowner::where('id', $this->role_shop_id)->first();
            $recap = Percent_template::where('shop_id', $this->role_shop_id)->get();
        } else {
            $this->role('shop_owner');
            $collection = Collection::where('shop_id', $this->role)->get();
            $somedatafromshop = Shopowner::where('id', $this->role)->first();
            $recap = Percent_template::where('shop_id', $this->role)->get();

        }
        $main_cat = MainCategory::get();
        $cat_list = DB::table('categories')->leftjoin('items', 'categories.name', '=', 'items.category_id')->select('categories.*')->groupBy('categories.name')->orderByRaw("CASE
                        WHEN count(items.category_id) = 0 THEN categories.id END ASC,
            case when count(items.category_id) != 0 then count(categories.name) end DESC")->get();

        return view('backend.shopowner.item.create', ['main_cat' => $main_cat, 'cat_list' => $cat_list, 'shopowner' => $this->shop_owner, 'collection' => $collection, 'product_details' => $product_details, 'somedatafromshop' => $somedatafromshop, 'world_gold_price' => $test_world_gold, 'recap' => $recap]);
    }

    //start storing data
    public function store(Request $request)
    {

        // \ShopownerLogActivity::ShopowneraddToLog($id);
        $input = $request->except('_token');
        if ($input['price'] > 9999999999 or $input['min_price'] > 9999999999 or $input['max_price'] > 9999999999 or ($input['min_price'] > $input['max_price'])) {
            return response()->json(['msg' => 'error', 'error_msg' => 'Wrong Price']);
        }
        $jdmidimage = json_decode($input['formidphotos'], true);
        $jdthumbimage = json_decode($input['forthumbphotos'], true);


        foreach ($request->file('file') as $key => $value) {
            $file = $request->file('file')[$key];
            $imageName[$key] = strtolower($request->file('file')[$key]->getClientOriginalName());

            $get_path = $request->file('file')[$key]->move(public_path('images/items'), $imageName[$key]);
            //for thumbnail

            //            $this->setthumbs($get_path, $imageName[$key]);


        }
        foreach ($jdmidimage as $jdmi) {
            $this->base64_to_image($jdmi['data'], public_path('images/items/mid/' . strtolower($jdmi['name'])));
        }
        foreach ($jdthumbimage as $jdti) {
            $this->base64_to_image($jdti['data'], public_path('images/items/thumbs/' . strtolower($jdti['name'])));
        }
        if (!empty($imageName[0])) {
            $input['photo_one'] = $imageName[0];

        } else {
            $input['photo_one'] = '';

        }
        if (!empty($imageName[1])) {
            $input['photo_two'] = $imageName[1];

        } else {
            $input['photo_two'] = '';

        }
        if (!empty($imageName[2])) {
            $input['photo_three'] = $imageName[2];

        } else {
            $input['photo_three'] = '';

        }
        if (!empty($imageName[3])) {
            $input['photo_four'] = $imageName[3];

        } else {
            $input['photo_four'] = '';

        }
        if (!empty($imageName[4])) {
            $input['photo_five'] = $imageName[4];

        } else {
            $input['photo_five'] = '';

        }
        if (!empty($imageName[5])) {
            $input['photo_six'] = $imageName[5];

        } else {
            $input['photo_six'] = '';

        }
        if (!empty($imageName[6])) {
            $input['photo_seven'] = $imageName[6];

        } else {
            $input['photo_seven'] = '';

        }
        if (!empty($imageName[7])) {
            $input['photo_eight'] = $imageName[7];

        } else {
            $input['photo_eight'] = '';

        }
        if (!empty($imageName[8])) {
            $input['photo_nine'] = $imageName[8];

        } else {
            $input['photo_nine'] = '';

        }
        if (!empty($imageName[9])) {
            $input['photo_ten'] = $imageName[9];

        } else {
            $input['photo_ten'] = '';
        }

        //set id for manager
        if (isset(Auth::guard('shop_role')->user()->id)) {

            $shop_id = Auth::guard('shop_role')->user()->shop_id;
            $user_id = Auth::guard('shop_role')->user()->id;

            $input['shop_id'] = $shop_id;
            $input['user_id'] = $user_id;

        } else {
            //set id for shopowner
            // $user_id = Auth::guard('shop_owner')->user()->id;
            //0 for shop_owner
            $user_id = 0;
            $input['shop_id'] = Auth::guard('shop_owner')->user()->id;
            $input['user_id'] = $user_id;
            $shop_id = "yahoo";

        }

        $input['default_photo'] = strtolower($input['default_photo']);
        $input['view_count'] = 0;
        if ($input['diamond'] == 'No') {
            $input['carat'] = 0;
            $input['yati'] = 0;
            $input['pwint'] = 0;
            $input['d_gram'] = 0;
        }

        $input['weight_unit'] = 0;


        $itemupload = Item::create($input);
        \ShopownerLogActivity::ShopownerCreateLog($itemupload, $shop_id);
        if ($itemupload) {
            Gems::create(['gems' => $input['gems'], 'item_id' => $itemupload->id]);
            $itemupload->tag($request->tags);

        }
        if($input['price'] != 0){
            $toshowprice=$input['price'];

        }else{
            $toshowprice=$input['min_price'].'-'.$input['max_price'];

        }
        $data=$input['name'].' ('.$toshowprice.')'.$input['description'];
        $getfbdata=facebooktable::where('shop_id',$input['shop_id'])->first();
        if(!empty($getfbdata)){
            $this->posttofbpage($input['shop_id'],$data,$itemupload->check_photo);

        }


        Session::flash('message', 'Your item was successfully uploaded');


        return response()->json(['msg' => 'success', 'id' => $itemupload->id]);

    }

    //show edit form
    public function edit($id)
    {

        $item_id = Item::findOrFail($id)->shop_id;
        if (isset(Auth::guard('shop_role')->user()->id)) {
            $this->role('shop_role');
            $collection = Collection::where('shop_id', $this->role_shop_id)->get();
            if (TzGate::allows($this->role_shop_id == $item_id)) {
                $item = Item::where('id', $id)->with('tagged')->first();
                foreach ($item->toArray() as $key => $value) {
                    if ($value === $item->default_photo and $key != 'default_photo') {
                        $item->default_photo = $key;
                    }

                }
                if ($item->weight_unit != '0') {
                    $item->weight = 'temp';
                }
            }
        } else {


            $this->role('shop_owner');

            $collection = Collection::where('shop_id', $this->role)->get();

            $user_id = $this->role;
            if (TzGate::allows($user_id == $item_id)) {
                $item = Item::where('id', $id)->with('tagged')->first();
                foreach ($item->toArray() as $key => $value) {
                    if ($value === $item->default_photo and $key != 'default_photo') {
                        $item->default_photo = $key;
                    }

                }
                if ($item->weight_unit != '0') {
                    $item->weight = 'temp';
                }
            }
        }


        $cat_list = DB::table('categories')->leftjoin('items', 'categories.name', '=', 'items.category_id')->select('categories.*')->groupBy('categories.name')->orderByRaw("CASE
                                WHEN count(items.category_id) = 0 THEN categories.id END ASC,
                    case when count(items.category_id) != 0 then count(categories.name) end DESC")->get();
        $main_cat = MainCategory::get();

        return view('backend.shopowner.item.edit', ['cat_list' => $cat_list, 'main_cat' => $main_cat, 'shopowner' => $this->shop_owner, 'item' => $item, 'collection' => $collection]);

    }

    public function removeimage(Request $request)
    {
        if (!$this->itisowneritem($request->id)) {
            return $this->unauthorize();
        }
        if (dofile_exists(public_path('/images/items/' . $request->name))) {
            File::delete(public_path('/images/items/' . $request->name));
            if (File::exists(public_path('/images/items/thumbs/' . $request->name))) {
                File::delete(public_path('/images/items/thumbs/' . $request->name));

            }
            if (File::exists(public_path('/images/items/mid/' . $request->name))) {
                File::delete(public_path('/images/items/mid/' . $request->name));

            }
            Item::where('id', $request->id)->update(array($request->column_name => ''));
            return response()->json('success');

        } else {
            Item::where('id', $request->id)->update(array($request->column_name => ''));

            return response()->json($request);

        }


    }

    //edit but custom upload not from dropzone
    public function customedit(Request $request)
    {
        // if (!$this->itisowneritem($request->id)) {
        //      return $this->unauthorize();
        //  }
        $all_image_fields = ['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten'];

        $input = $request->except('_token', 'id', 'gems', 'tags', 'file', 'formidphotos', 'forthumbphotos', 'discount', 'unsetdiscount');
        if ($input['price'] > 9999999999 or $input['min_price'] > 9999999999 or $input['max_price'] > 9999999999 or ($input['min_price'] > $input['max_price'])) {
            return response()->json(['msg' => 'error', 'error_msg' => 'Wrong Price']);
        }
        foreach ($all_image_fields as $key => $value) {
            if ($request->default_photo == $value) {
                $ford_photo = Item::where('id', $request->id)->first();
                $input['default_photo'] = strtolower($ford_photo->$value);
            }
        }
        if ($input['diamond'] == 'No') {
            $input['carat'] = 0;
            $input['yati'] = 0;
            $input['pwint'] = 0;
            $input['d_gram'] = 0;
        }
        $input['weight_unit'] = 0;

        $change = Item::where('id', $request->id)->first();
        $old = $change->getOriginal();
        $old_gem = Gems::where('item_id', $request->id)->first();


        if ($change->update($input)) {

            if (isset(Auth::guard('shop_role')->user()->id)) {
                $this->role('shop_role');
                $shop_id = $this->role_shop_id;
            } else {
                $shop_id = Auth::guard('shop_owner')->user()->id;
            }


            $shopownerlogid = \ShopownerLogActivity:: ShopownerEditLog($request, $shop_id);
            $old_tags = DB::table('tagging_tagged')->where('taggable_id', $request->id)->get();
            $item_tag = Item::where('id', $request->id)->first();
            $item_tagarray = explode(',', $item_tag->tags);
            $collection = collect($item_tagarray);
            $output = $collection->implode(',');

            // $item_tagarray = implode(',',$item_tag->tags);


            Item::find($request->id)->retag($request->all()['tags']);


            $checkgcount = Gems::where('item_id', $request->id)->count();
            if ($checkgcount == 0) {
                $n_gems = Gems::create(['gems' => $request->all()['gems'], 'item_id' => $request->id]);


            } else {
                $n_gems = Gems::where('item_id', $request->id);
                $n_gems->update(['gems' => $request->all()['gems']]);

            }
            $tmpdis = json_decode($request->all()['discount'], true);
            if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'false') {
                discount::where('item_id', $request->id)->update(['discount_price' => $tmpdis['newprice'], 'discount_min' => $tmpdis['newmin'], 'discount_max' => $tmpdis['newmax']]);
            } else if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'true') {
                discount::where('item_id', $request->id)->delete();

            } else {

            }
        }

        $new_gem = Gems::where('item_id', $request->id)->first();
        $new_tags = $request->tags;
        $item_newtag = Item::where('id', $request->id)->first();
        $item_newtagarray = explode(',', $item_newtag->tags);
        $newcollection = collect($item_newtagarray);
        $newoutput = $newcollection->implode(',');

        $changes = $change->getChanges();

        $items_edit_detail_logs = new ItemsEditDetailLogs();
        // return dd($item_tag['tags']);


        $items_edit_detail_logs->tags = $output;

        if ($output == $newoutput) {
            $items_edit_detail_logs->new_tags = "-----";
        } else {
            $items_edit_detail_logs->new_tags = $new_tags;

        }

        $items_edit_detail_logs->gems = $old_gem->gems;

        if ($old_gem == $new_gem) {
            $items_edit_detail_logs->new_gems = "-----";
        } else {
            $items_edit_detail_logs->new_gems = $new_gem->gems;
        }

        $items_edit_detail_logs->name = $old['name'];
        if ($old['name'] == $change->name) {
            $items_edit_detail_logs->new_name = "-----";
        } else {
            $items_edit_detail_logs->new_name = $changes['name'];
        }
        $items_edit_detail_logs->price = $old['price'];
        if ($old['price'] == $change->price) {
            $items_edit_detail_logs->new_price = "-----";
        } else {
            $items_edit_detail_logs->new_price = $changes['price'];
        }
        $items_edit_detail_logs->description = $old['description'];
        if ($old['description'] == $change->description) {
            $items_edit_detail_logs->new_description = "-----";
        } else {
            $items_edit_detail_logs->new_description = $changes['description'];
        }
        $items_edit_detail_logs->product_code = $old['product_code'];
        if ($old['product_code'] == $change->product_code) {
            $items_edit_detail_logs->new_product_code = "-----";
        } else {
            $items_edit_detail_logs->new_product_code = $changes['product_code'];
        }
        $items_edit_detail_logs->gold_quality = $old['gold_quality'];
        if ($old['gold_quality'] == $change->gold_quality) {
            $items_edit_detail_logs->new_gold_quality = "-----";
        } else {
            $items_edit_detail_logs->new_gold_quality = $changes['gold_quality'];
        }
        $items_edit_detail_logs->gold_colour = $old['gold_colour'];
        if ($old['gold_colour'] == $change->gold_colour) {
            $items_edit_detail_logs->new_gold_colour = "-----";
        } else {
            $items_edit_detail_logs->new_gold_colour = $changes['gold_colour'];
        }
        //   $items_edit_detail_logs->sizing_guide = $old['sizing_guide'];
        //   if($changes == []){
        //         $items_edit_detail_logs->new_sizing_guide = "-----";
        //   }else{
        //       $items_edit_detail_logs->new_sizing_guide = $changes['sizing_guide'];
        //   }
        $items_edit_detail_logs->undamage = $old['အထည်မပျက်_ပြန်သွင်း'];
        if ($old['အထည်မပျက်_ပြန်သွင်း'] == $change->အထည်မပျက်_ပြန်သွင်း) {
            $items_edit_detail_logs->new_undamage = "-----";
        } else {
            $items_edit_detail_logs->new_undamage = $changes['အထည်မပျက်_ပြန်သွင်း'];
        }
        $items_edit_detail_logs->expensive_thing = $old['တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ'];
        if ($old['တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ'] == $change->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ) {
            $items_edit_detail_logs->new_expensive_thing = "-----";
        } else {
            $items_edit_detail_logs->new_expensive_thing = $changes['တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ'];
        }
        $items_edit_detail_logs->damage = $old['အထည်ပျက်စီးချို့ယွင်း'];
        if ($old['အထည်ပျက်စီးချို့ယွင်း'] == $change->အထည်ပျက်စီးချို့ယွင်း) {
            $items_edit_detail_logs->new_damage = "-----";
        } else {
            $items_edit_detail_logs->new_damage = $changes['အထည်ပျက်စီးချို့ယွင်း'];
        }
        $items_edit_detail_logs->weight = $old['weight'];
        if ($old['weight'] == $change->weight) {
            $items_edit_detail_logs->new_weight = "-----";
        } else {
            $items_edit_detail_logs->new_weight = $changes['weight'];
        }
        //   $items_edit_detail_logs->weight_unit = $old['weight_unit'];
        //   if($changes == []){
        //         $items_edit_detail_logs->new_weight_unit = "-----";
        //   }else{
        //       $items_edit_detail_logs->new_weight_unit = $changes['weight_unit'];
        //   }

        $items_edit_detail_logs->min_price = $old['min_price'];
        if ($old['min_price'] == $change->min_price) {
            $items_edit_detail_logs->new_min_price = "-----";
        } else {
            $items_edit_detail_logs->new_min_price = $changes['min_price'];
        }
        $items_edit_detail_logs->max_price = $old['max_price'];
        if ($old['max_price'] == $change->max_price) {
            $items_edit_detail_logs->new_max_price = "-----";
        } else {
            $items_edit_detail_logs->new_max_price = $changes['max_price'];
        }
        $items_edit_detail_logs->review = $old['review'];
        if ($old['review'] == $change->review) {
            $items_edit_detail_logs->new_review = "-----";
        } else {
            $items_edit_detail_logs->new_review = $changes['review'];
        }
        $items_edit_detail_logs->stock = $old['stock'];
        if ($old['stock'] == $change->stock) {
            $items_edit_detail_logs->new_stock = "-----";
        } else {
            $items_edit_detail_logs->new_stock = $changes['stock'];
        }
        $items_edit_detail_logs->stock_count = $old['stock_count'];
        if ($old['stock_count'] == $change->stock_count) {
            $items_edit_detail_logs->new_stock_count = "-----";
        } else {
            $items_edit_detail_logs->new_stock_count = $changes['stock_count'];
        }
        $items_edit_detail_logs->diamond = $old['diamond'];
        if ($old['diamond'] == $change->diamond) {
            $items_edit_detail_logs->new_diamond = "-----";
        } else {
            $items_edit_detail_logs->new_diamond = $changes['diamond'];
        }
        $items_edit_detail_logs->carat = $old['carat'];
        if ($old['carat'] == $change->carat) {
            $items_edit_detail_logs->new_carat = "-----";
        } else {
            $items_edit_detail_logs->new_carat = $changes['carat'];
        }
        $items_edit_detail_logs->yati = $old['yati'];
        if ($old['yati'] == $change->yati) {
            $items_edit_detail_logs->new_yati = "-----";
        } else {
            $items_edit_detail_logs->new_yati = $changes['yati'];
        }
        $items_edit_detail_logs->gender = $old['gender'];
        if ($old['gender'] == $change->gender) {
            $items_edit_detail_logs->new_gender = "-----";
        } else {
            $items_edit_detail_logs->new_gender = $changes['gender'];
        }
        $items_edit_detail_logs->handmade = $old['handmade'];
        if ($old['handmade'] == $change->handmade) {
            $items_edit_detail_logs->new_handmade = "-----";
        } else {
            $items_edit_detail_logs->new_handmade = $changes['handmade'];
        }
        $items_edit_detail_logs->pwint = $old['pwint'];
        if ($old['pwint'] == $change->pwint) {
            $items_edit_detail_logs->new_pwint = "-----";
        } else {
            $items_edit_detail_logs->new_pwint = $changes['pwint'];
        }
        $items_edit_detail_logs->d_gram = $old['d_gram'];
        if ($old['d_gram'] == $change->d_gram) {
            $items_edit_detail_logs->new_d_gram = "-----";
        } else {
            $items_edit_detail_logs->new_d_gram = $changes['d_gram'];
        }
        $items_edit_detail_logs->category_id = $old['category_id'];
        if ($old['category_id'] == $change->category_id) {
            $items_edit_detail_logs->new_category_id = "-----";
        } else {
            $items_edit_detail_logs->new_category_id = $changes['category_id'];
        }
        $items_edit_detail_logs->view_count = $old['view_count'];
        if ($old['view_count'] == $change->view_count) {
            $items_edit_detail_logs->new_view_count = "-----";
        } else {
            $items_edit_detail_logs->new_view_count = $changes['view_count'];
        }
        $items_edit_detail_logs->charge = $old['charge'];
        if ($old['charge'] == $change->charge) {
            $items_edit_detail_logs->new_charge = "-----";
        } else {
            $items_edit_detail_logs->new_charge = $changes['charge'];
        }
        $items_edit_detail_logs->collection_id = $old['collection_id'];
        if ($old['collection_id'] == $change->collection_id) {
            $items_edit_detail_logs->new_collection_id = "-----";
        } else {
            $items_edit_detail_logs->new_collection_id = $changes['collection_id'];
        }
        $items_edit_detail_logs->user_id = $old ['user_id'];
        $items_edit_detail_logs->shop_id = $old ['shop_id'];
        $items_edit_detail_logs->shopownereditlogs_id = $shopownerlogid->id;
        $items_edit_detail_logs->save();


        Session::flash('message', 'Your item was successfully updated');
        return response()->json(['msg' => 'success', 'id' => $request->id]);


    }

    //edit function
    public function editajax(Request $request)
    {
        //        if (!$this->itisowneritem($request->id)) {
        //            return $this->unauthorize();
        //        }
        $old_tags = DB::table('tagging_tagged')->where('taggable_id', $request->id)->get();
        $item_tag = Item::where('id', $request->id)->first();
        $item_tagarray = explode(',', $item_tag->tags);
        $collection = collect($item_tagarray);
        $output = $collection->implode(',');
        $current_item = Item::where('id', $request->id)->first();
        $old_gem = Gems::where('item_id', $request->id)->first();

        $all_image_fields = ['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten'];
        $input = $request->except('_token', 'id', 'gems', 'tags', 'file', 'formidphotos', 'forthumbphotos', 'discount', 'unsetdiscount');

        if ($input['price'] > 9999999999 or $input['min_price'] > 9999999999 or $input['max_price'] > 9999999999 or ($input['min_price'] > $input['max_price'])) {
            return response()->json(['msg' => 'error', 'error_msg' => 'Wrong Price']);
        }
        $forphotos = $request->except('_token', 'id', 'gems', 'tags', 'file');
        $imageName = [];
        if ($input['diamond'] == 'No') {
            $input['carat'] = 0;
            $input['yati'] = 0;
            $input['pwint'] = 0;
            $input['d_gram'] = 0;
        }
        $input['weight_unit'] = 0;
        $jdmidimage = json_decode($forphotos['formidphotos'], true);
        $jdthumbimage = json_decode($forphotos['forthumbphotos'], true);

        foreach ($request->file('file') as $key => $value) {
            $imageName[$key] = strtolower($request->file('file')[$key]->getClientOriginalName());
            $get_path = $request->file('file')[$key]->move(public_path('images/items'), $imageName[$key]);

            //for thumbnail

            //$this->setthumbs($get_path, $imageName[$key]);
            //for thumbnail


        }
        foreach ($jdmidimage as $jdmi) {
            $this->base64_to_image($jdmi['data'], public_path('images/items/mid/' . strtolower($jdmi['name'])));

        }
        foreach ($jdthumbimage as $jdti) {
            $this->base64_to_image($jdti['data'], public_path('images/items/thumbs/' . strtolower($jdti['name'])));
        }
        foreach ($imageName as &$imn) {
            foreach ($all_image_fields as $af) {
                if (empty($input[$af])) {

                    if ($current_item[$af] == '') {

                        $input[$af] = $imn;

                        break;

                    } else {
                        continue;

                    }
                } else {
                    continue;
                }

            }


        }
        $change = Item::where('id', $request->id)->first();
        // return dd($change);
        if ($change->update($input)) {

            if (isset(Auth::guard('shop_role')->user()->id)) {
                $this->role('shop_role');
                $shop_id = $this->role_shop_id;
            } else {
                $shop_id = Auth::guard('shop_owner')->user()->id;
            }

            $shopownerlogid = \ShopownerLogActivity:: ShopownerEditLog($request, $shop_id);
            Item::find($request->id)->retag($request->all()['tags']);

            $checkgcount = Gems::where('item_id', $request->id)->count();
            if ($checkgcount == 0) {
                Gems::create(['gems' => $request->all()['gems'], 'item_id' => $request->id]);

            } else {
                Gems::where('item_id', $request->id)->update(['gems' => $request->all()['gems']]);

            }

            $tmpdis = json_decode($request->all()['discount'], true);
            if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'false') {
                discount::where('item_id', $request->id)->update(['discount_price' => $tmpdis['newprice'], 'discount_min' => $tmpdis['newmin'], 'discount_max' => $tmpdis['newmax']]);
            } else if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'true') {
                discount::where('item_id', $request->id)->delete();

            } else {

            }
            foreach ($all_image_fields as $key => $value) {
                if ($request->default_photo == $value) {
                    $ford_photo = Item::where('id', $request->id)->first();
                    Item::where('id', $request->id)->update(['default_photo' => $ford_photo->$value]);
                    break 1;
                } else {
                    Item::where('id', $request->id)->update(['default_photo' => $request->default_photo]);

                }


            }


            //            $dis = discount::where('item_id', $request->id)->get();
            //            foreach ($dis as $d) {
            //                $percent = $input['price'] - ($input['price'] * $d->percent / 100);
            //                discount::where('item_id', $request->id)->update(['discount_price' => $percent]);
            //            }


        }
        // else {
        //     return dd($input);

        // }
        $new_gem = Gems::where('item_id', $request->id)->first();
        $changes = $change->getChanges();
        $new_tags = $request->tags;
        $items_edit_detail_logs = new ItemsEditDetailLogs();
        $new_gem = Gems::where('item_id', $request->id)->first();
        $new_tags = $request->tags;
        $item_newtag = Item::where('id', $request->id)->first();
        $item_newtagarray = explode(',', $item_newtag->tags);
        $newcollection = collect($item_newtagarray);
        $newoutput = $newcollection->implode(',');

        $changes = $change->getChanges();

        $items_edit_detail_logs = new ItemsEditDetailLogs();
        // return dd($item_tag['tags']);


        $items_edit_detail_logs->tags = $output;

        if ($output == $newoutput) {
            $items_edit_detail_logs->new_tags = "-----";
        } else {
            $items_edit_detail_logs->new_tags = $new_tags;

        }
        $items_edit_detail_logs->gems = $old_gem->gems;

        if ($old_gem == $new_gem) {
            $items_edit_detail_logs->new_gems = "-----";
        } else {
            $items_edit_detail_logs->new_gems = $new_gem->gems;
        }

        $items_edit_detail_logs->photo_one = $current_item->photo_one;
        if ($current_item->photo_one == $change->photo_one) {
            $items_edit_detail_logs->new_photo_one = "-----";
        } else {
            $items_edit_detail_logs->new_photo_one = "images changes";
        }
        $items_edit_detail_logs->photo_two = $current_item->photo_two;
        if ($current_item->photo_two == $change->photo_two) {
            $items_edit_detail_logs->new_photo_two = "-----";
        } else {
            $items_edit_detail_logs->new_photo_two = "images changes";
        }
        $items_edit_detail_logs->photo_three = $current_item->photo_three;
        if ($current_item->photo_three == $change->photo_three) {
            $items_edit_detail_logs->new_photo_three = "-----";
        } else {
            $items_edit_detail_logs->new_photo_three = "images changes";
        }
        $items_edit_detail_logs->photo_four = $current_item->photo_four;
        if ($current_item->photo_four == $change->photo_four) {
            $items_edit_detail_logs->new_photo_four = "-----";
        } else {
            $items_edit_detail_logs->new_photo_four = "images changes";
        }
        $items_edit_detail_logs->photo_five = $current_item->photo_five;
        if ($current_item->photo_five == $change->photo_five) {
            $items_edit_detail_logs->new_photo_five = "-----";
        } else {
            $items_edit_detail_logs->new_photo_five = "images changes";
        }
        $items_edit_detail_logs->photo_six = $current_item->photo_six;
        if ($current_item->photo_six == $change->photo_six) {
            $items_edit_detail_logs->new_photo_six = "-----";
        } else {
            $items_edit_detail_logs->new_photo_six = "images changes";
        }
        $items_edit_detail_logs->photo_seven = $current_item->photo_seven;
        if ($current_item->photo_seven == $change->photo_seven) {
            $items_edit_detail_logs->new_photo_seven = "-----";
        } else {
            $items_edit_detail_logs->new_photo_seven = "images changes";
        }
        $items_edit_detail_logs->photo_eight = $current_item->photo_eight;
        if ($current_item->photo_eight == $change->photo_eight) {
            $items_edit_detail_logs->new_photo_eight = "-----";
        } else {
            $items_edit_detail_logs->new_photo_eight = "images changes";
        }
        $items_edit_detail_logs->photo_nine = $current_item->photo_nine;
        if ($current_item->photo_nine == $change->photo_nine) {
            $items_edit_detail_logs->new_photo_nine = "-----";
        } else {
            $items_edit_detail_logs->new_photo_nine = "images changes";
        }
        $items_edit_detail_logs->photo_ten = $current_item->photo_ten;
        if ($current_item->photo_ten == $change->photo_ten) {
            $items_edit_detail_logs->new_photo_ten = "-----";
        } else {
            $items_edit_detail_logs->new_photo_ten = "images changes";
        }
        $items_edit_detail_logs->default_photo = $current_item->default_photo;
        if ($current_item->default_photo == $change->default_photo) {
            $items_edit_detail_logs->new_default_photo = "-----";
        } else {
            $items_edit_detail_logs->new_default_photo = "images changes";
        }

        $items_edit_detail_logs->name = $current_item->name;
        if ($current_item->name == $change->name) {
            $items_edit_detail_logs->new_name = "-----";
        } else {
            $items_edit_detail_logs->new_name = $changes['name'];
        }

        $items_edit_detail_logs->price = $current_item->price;
        if ($current_item->price == $change->price) {
            $items_edit_detail_logs->new_price = "-----";
        } else {
            $items_edit_detail_logs->new_price = $changes['price'];
        }
        $items_edit_detail_logs->description = $current_item->description;
        if ($current_item->description == $change->description) {
            $items_edit_detail_logs->new_description = "-----";
        } else {
            $items_edit_detail_logs->new_description = $changes['description'];
        }
        $items_edit_detail_logs->product_code = $current_item->product_code;
        if ($current_item->product_code == $change->product_code) {
            $items_edit_detail_logs->new_product_code = "-----";
        } else {
            $items_edit_detail_logs->new_product_code = $changes['product_code'];
        }
        $items_edit_detail_logs->gold_quality = $current_item->gold_quality;
        if ($current_item->gold_quality == $change->gold_quality) {
            $items_edit_detail_logs->new_gold_quality = "-----";
        } else {
            $items_edit_detail_logs->new_gold_quality = $changes['gold_quality'];
        }
        $items_edit_detail_logs->gold_colour = $current_item->gold_colour;
        if ($current_item->gold_colour == $change->gold_colour) {
            $items_edit_detail_logs->new_gold_colour = "-----";
        } else {
            $items_edit_detail_logs->new_gold_colour = $changes['gold_colour'];
        }
        //   $items_edit_detail_logs->sizing_guide = $old['sizing_guide'];
        //   if($changes == []){
        //         $items_edit_detail_logs->new_sizing_guide = "-----";
        //   }else{
        //       $items_edit_detail_logs->new_sizing_guide = $changes['sizing_guide'];
        //   }
        $items_edit_detail_logs->undamage = $current_item->အထည်မပျက်_ပြန်သွင်း;
        if ($current_item->အထည်မပျက်_ပြန်သွင်း == $change->အထည်မပျက်_ပြန်သွင်း) {
            $items_edit_detail_logs->new_undamage = "-----";
        } else {
            $items_edit_detail_logs->new_undamage = $changes['အထည်မပျက်_ပြန်သွင်း'];
        }
        $items_edit_detail_logs->expensive_thing = $current_item->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ;
        if ($current_item->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ == $change->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ) {
            $items_edit_detail_logs->new_expensive_thing = "-----";
        } else {
            $items_edit_detail_logs->new_expensive_thing = $changes['တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ'];
        }
        $items_edit_detail_logs->damage = $current_item->အထည်ပျက်စီးချို့ယွင်း;
        if ($current_item->အထည်ပျက်စီးချို့ယွင်း == $change->အထည်ပျက်စီးချို့ယွင်း) {
            $items_edit_detail_logs->new_damage = "-----";
        } else {
            $items_edit_detail_logs->new_damage = $changes['အထည်ပျက်စီးချို့ယွင်း'];
        }
        $items_edit_detail_logs->weight = $current_item->weight;
        if ($current_item->weight == $change->weight) {
            $items_edit_detail_logs->new_weight = "-----";
        } else {
            $items_edit_detail_logs->new_weight = $changes['weight'];
        }
        //   $items_edit_detail_logs->weight_unit = $old['weight_unit'];
        //   if($changes == []){
        //         $items_edit_detail_logs->new_weight_unit = "-----";
        //   }else{
        //       $items_edit_detail_logs->new_weight_unit = $changes['weight_unit'];
        //   }

        $items_edit_detail_logs->min_price = $current_item->min_price;
        if ($current_item->min_price == $change->min_price) {
            $items_edit_detail_logs->new_min_price = "-----";
        } else {
            $items_edit_detail_logs->new_min_price = $changes['min_price'];
        }
        $items_edit_detail_logs->max_price = $current_item->max_price;
        if ($current_item->max_price == $change->max_price) {
            $items_edit_detail_logs->new_max_price = "-----";
        } else {
            $items_edit_detail_logs->new_max_price = $changes['max_price'];
        }
        $items_edit_detail_logs->review = $current_item->review;
        if ($current_item->review == $change->review) {
            $items_edit_detail_logs->new_review = "-----";
        } else {
            $items_edit_detail_logs->new_review = $changes['review'];
        }
        $items_edit_detail_logs->stock = $current_item->stock;
        if ($current_item->stock == $change->stock) {
            $items_edit_detail_logs->new_stock = "-----";
        } else {
            $items_edit_detail_logs->new_stock = $changes['stock'];
        }
        $items_edit_detail_logs->stock_count = $current_item->stock_count;
        if ($current_item->stock_count == $change->stock_count) {
            $items_edit_detail_logs->new_stock_count = "-----";
        } else {
            $items_edit_detail_logs->new_stock_count = $changes['stock_count'];
        }
        $items_edit_detail_logs->diamond = $current_item->diamond;
        if ($current_item->diamond == $change->diamond) {
            $items_edit_detail_logs->new_diamond = "-----";
        } else {
            $items_edit_detail_logs->new_diamond = $changes['diamond'];
        }
        $items_edit_detail_logs->carat = $current_item->carat;
        if ($current_item->carat == $change->carat) {
            $items_edit_detail_logs->new_carat = "-----";
        } else {
            $items_edit_detail_logs->new_carat = $changes['carat'];
        }
        $items_edit_detail_logs->yati = $current_item->yati;
        if ($current_item->yati == $change->yati) {
            $items_edit_detail_logs->new_yati = "-----";
        } else {
            $items_edit_detail_logs->new_yati = $changes['yati'];
        }
        $items_edit_detail_logs->gender = $current_item['gender'];
        if ($current_item->gender == $change->gender) {
            $items_edit_detail_logs->new_gender = "-----";
        } else {
            $items_edit_detail_logs->new_gender = $changes['gender'];
        }
        $items_edit_detail_logs->handmade = $current_item->handmade;
        if ($current_item->handmade == $change->handmade) {
            $items_edit_detail_logs->new_handmade = "-----";
        } else {
            $items_edit_detail_logs->new_handmade = $changes['handmade'];
        }
        $items_edit_detail_logs->pwint = $current_item->pwint;
        if ($current_item->pwint == $change->pwint) {
            $items_edit_detail_logs->new_pwint = "-----";
        } else {
            $items_edit_detail_logs->new_pwint = $changes['pwint'];
        }
        $items_edit_detail_logs->d_gram = $current_item->d_gram;
        if ($current_item->d_gram == $change->d_gram) {
            $items_edit_detail_logs->new_d_gram = "-----";
        } else {
            $items_edit_detail_logs->new_d_gram = $changes['d_gram'];
        }
        $items_edit_detail_logs->category_id = $current_item->category_id;
        if ($current_item->category_id == $change->category_id) {
            $items_edit_detail_logs->new_category_id = "-----";
        } else {
            $items_edit_detail_logs->new_category_id = $changes['category_id'];
        }
        $items_edit_detail_logs->view_count = $current_item->view_count;
        if ($current_item->view_count == $change->view_count) {
            $items_edit_detail_logs->new_view_count = "-----";
        } else {
            $items_edit_detail_logs->new_view_count = $changes['view_count'];
        }
        $items_edit_detail_logs->charge = $current_item->charge;
        if ($current_item->charge == $change->charge) {
            $items_edit_detail_logs->new_charge = "-----";
        } else {
            $items_edit_detail_logs->new_charge = $changes['charge'];
        }
        $items_edit_detail_logs->collection_id = $current_item->collection_id;
        if ($current_item->collection_id == $change->collection_id) {
            $items_edit_detail_logs->new_collection_id = "-----";
        } else {
            $items_edit_detail_logs->new_collection_id = $changes['collection_id'];
        }
        $items_edit_detail_logs->user_id = $current_item->user_id;
        $items_edit_detail_logs->shop_id = $current_item->shop_id;
        $items_edit_detail_logs->shopownereditlogs_id = $shopownerlogid->id;
        $items_edit_detail_logs->save();


        Session::flash('message', 'Your item was successfully updated');
        return response()->json(['msg' => 'success', 'id' => $request->id]);

    }

    public function multiple_update_minus(MultiplePriceUpdateRequest $request)
    {
        $plus_price = $request->price;
        foreach ($request->id as $id) {
            $item = Item::findOrfail($id);
            $shop_id = $this->get_shopid();

            \MultiplePriceLogs:: MultipleMinusPriceLogs($item, $plus_price, $shop_id);
            $this->minus($item, $request);
        }
        $items = Item::whereIn('id', $request->id)->get();
        Session::flash('message', 'Your items were successfully edited');

        return response()->json(
            [
                'data' => $this->err_data,
                'items' => $items,
            ]
        );

    }

    public function multiple_update_recap(ItemsRecapUpdateRequest $request)
    {
        $old_percent = $request;
        foreach ($request->id as $id) {
            $item = Item::findOrfail($id);
            $shop_id = $this->get_shopid();

            // return dd($item);
            \MultipleDamageLogs:: MultipleDamageLogs($item, $old_percent, $shop_id);
            // $item->user_id = $user_id;
            $this->get_multiple_recap($item, $old_percent);
        }

        $items = Item::whereIn('id', $request->id)->get();

        Session::flash('message', 'Your items were successfully edited');

        return response()->json(
            [
                'items' => $items,
            ]
        );
    }

    public function multiple_update_plus(MultiplePriceUpdateRequest $request)
    {

        $plus_price = $request->price;
        foreach ($request->id as $id) {
            $item = Item::findOrfail($id);
            $shop_id = $this->get_shopid();

            \MultiplePriceLogs:: MultiplePlusPriceLogs($item, $plus_price, $shop_id);
            $this->plus($item, $request);


        }
        $items = Item::whereIn('id', $request->id)->get();


        Session::flash('message', 'Your items were successfully edited');
        return response()->json(
            [
                'success' => true,
                'data' => $request->data,
                'items' => $items,
            ],

        );

    }

    public function multiple_stock(Request $request)
    {

        if ($request->stock === "In Stock") {

            $request->validate([
                "count" => "required|numeric|min:0",
            ]);

        }


        $change_request_array = explode(",", $request->multipleStockId);

        foreach ($change_request_array as $id) {

            $items = Item::find($id);
            $items->stock = $request->stock;
            if ($request->count) {
                $items->stock_count = $request->count;
            }
            $items->update();
        }
        //  Session::flash('message', 'Your Discount Item was successfully unset');

        return redirect()->back();

    }

    public function validatorformultiupdate($data)
    {
        $message = ['price.min' => 'Price သည် 1 ထပ် မငယ်ရ', 'price.numeric' => 'Price သည် number ဖြစ်ရမည်', 'အလျော့တွက်.min' => 'အလျော့တွက်သည် 0 ထပ် မငယ်ရ',
            'အလျော့တွက်.numeric' => 'အလျော့တွက်သည် number ဖြစ်ရမည်',

            'လက်ခ.min' => 'လက်ခသည် 0 ထပ် မငယ်ရ',
            'လက်ခ.numeric' => 'လက်ခသည် number ဖြစ်ရမည်',

            'အထည်မပျက်ပြန်သွင်း.min' => 'အထည်မပျက်ပြန်သွင်းသည် 0 ထပ် မငယ်ရ',
            'အထည်မပျက်ပြန်သွင်း.numeric' => 'အထည်မပျက်ပြန်သွင်းသည် number ဖြစ်ရမည်',

            'အထည်ပျက်စီးချို့ယွင်း.min' => 'အထည်ပျက်စီးချို့ယွင်းသည် 0 ထပ် မငယ်ရ',
            'အထည်ပျက်စီးချို့ယွင်း.numeric' => 'အထည်ပျက်စီးချို့ယွင်းသည် number ဖြစ်ရမည်',


            'တန်ဖိုးမြင့်.min' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် 0 ထပ် မငယ်ရ',
            'တန်ဖိုးမြင့်.numeric' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် number ဖြစ်ရမည်'];

        return Validator::make($data, [
            'price' => ['numeric', 'min:1'],
            'အလျော့တွက်' => ['numeric', 'min:0', 'max:90'],
            'လက်ခ' => ['numeric', 'min:0', 'max:90'],
            'အထည်မပျက်ပြန်သွင်း' => ['numeric', 'min:0', 'max:90'],
            'အထည်ပျက်စီးချို့ယွင်း' => ['numeric', 'min:0', 'max:90'],
            'တန်ဖိုးမြင့်' => ['numeric', 'min:0', 'max:90'],
        ], $message);
    }

    public function checkpriceafterupdateclick(Request $request)
    {

        // return dd($request);
        $validator = $this->validatorformultiupdate($request->all());
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'data' => $validator->errors()]);
        }

        $willupdatepricelist = [];
        if ($request->price != '') {

            foreach ($request->id as $key => $value) {
                $item = Item::where('id', $value)->first();
                $disitem = 'no';
                $disprice = 0;
                $dismin = 0;
                $dismax = 0;
                $plus_price = 0;
                $minPrice = 0;
                $maxPrice = 0;
                $fromdisprice = '----';

                if ($request->oper == 'plus') {
                    $plus_price = $item->price + $request->price;
                    $minPrice = $item->min_price + $request->price;
                    $maxPrice = $item->max_price + $request->price;
                } else {
                    $plus_price = $item->price - $request->price;
                    $minPrice = $item->min_price - $request->price;
                    $maxPrice = $item->max_price - $request->price;
                }
                if ($item->ykget_discount !== 0) {
                    $disitem = 'yes';
                    if ($item->ykget_discount->base == 'price') {
                        if ($item->ykget_discount->discount_price != 0) {
                            $fromdisprice = $item->ykget_discount->discount_price;

                            $disprice = $plus_price - $item->ykget_discount->dec_price;
                            $dismin = 0;
                            $dismax = 0;
                        } else {
                            $fromdisprice = $item->ykget_discount->discount_min . '--' . $item->ykget_discount->discount_max;

                            $disprice = 0;
                            $dismin = $minPrice - $item->ykget_discount->dec_price;
                            $dismax = $maxPrice - $item->ykget_discount->dec_price;
                        }

                    } else {
                        if ($item->ykget_discount->discount_price != 0) {
                            $fromdisprice = $item->ykget_discount->discount_price;
                            $disprice = round($plus_price - (($plus_price * $item->ykget_discount->percent) / 100));
                            $dismin = 0;
                            $dismax = 0;
                        } else {
                            $fromdisprice = $item->ykget_discount->discount_min . '--' . $item->ykget_discount->discount_max;

                            $disprice = 0;
                            $dismin = round($minPrice - (($minPrice * $item->ykget_discount->percent) / 100));
                            $dismax = round($maxPrice - (($maxPrice * $item->ykget_discount->percent) / 100));
                        }

                    }

                }

                if ($item->price != 0) {
                    $willupdatepricelist[$key] = ['fromdisprice' => $fromdisprice, 'disitem' => $disitem, 'disprice' => $disprice, 'dismin' => $dismin, 'dismax' => $dismax, 'id' => $item->id, 'name' => $item->name, 'product_code' => $item->product_code, 'orgprice' => $item->price, 'orgmin' => 0, 'orgmax' => 0, 'price' => $plus_price, 'min' => 0, 'max' => 0];
                } else {
                    $willupdatepricelist[$key] = ['fromdisprice' => $fromdisprice, 'disitem' => $disitem, 'disprice' => $disprice, 'dismin' => $dismin, 'dismax' => $dismax, 'id' => $item->id, 'name' => $item->name, 'product_code' => $item->product_code, 'price' => 0, 'min' => $minPrice, 'max' => $maxPrice, 'orgprice' => 0, 'orgmin' => $item->min_price, 'orgmax' => $item->max_price,];


                }

            }
            return response()->json(['status' => 'success', 'data' => $willupdatepricelist]);
        } else {
            return response()->json(['status' => 'onlypercent']);

        }


    }

    //for detail of specified item
    public function show($id)
    {
        $slides = Item::select('photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten')->get();
        $photo = Item::where('id', $id)->get(['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten']);
        $photos = $photo;
        $item_id = Item::findOrFail($id)->shop_id;

        //tz
        if (isset(Auth::guard('shop_role')->user()->id)) {
            $this->role('shop_role');
            if (TzGate::allows($this->role_shop_id == $item_id)) {
                $item = Item::where('id', $id)->first();
            }
        } else {
            $this->role('shop_owner');

            if (TzGate::allows($this->role == $item_id)) {
                $item = Item::where('id', $id)->first();
                foreach ($item->tags as $itg) {

                }

            }
        }

        return view('backend.shopowner.item.detail', ['shopowner' => $this->shop_owner, 'item' => $item, 'photos' => $photos, 'slides' => $slides]);

    }

    //for delete function of specified item
    public function destroy($id)
    {

        $item_id = Item::findOrFail($id)->shop_id;
        $item = Item::findOrFail($id);

        $shopowner_log = Item::where('id', $id)->get();

        $item_log = ItemLogActivity::where('item_id', $id);


        if (discount::where('item_id', $id)->count() > 0) {
            discount::where('item_id', $id)->delete();
        }
        if (Auth::guard('shop_role')->check()) {
            $this->role('shop_role');
            if (TzGate::allows($item_id == $this->role_shop_id)) {
                $item->delete();
                $item_log->delete();
            }
            $shop_id = $this->role_shop_id;
        } else {
            $this->role('shop_owner');

            if (TzGate::allows($item_id == $this->role)) {
                $item->delete();
                $item_log->delete();
            }
            $shop_id = "yahoo";
        }
        $shopownerlogid = \ShopownerLogActivity:: ShopownerDeleteLog($shopowner_log, $shop_id);


        return redirect(url('backside/shop_owner/items'))->with(['status' => 'success', 'message' => 'Your Item was successfully Deleted']);
    }

    public function trash()
    {
        if (Auth::guard('shop_role')->check()) {
            $this->role('shop_role');
            $items = Item::onlyTrashed()->where('shop_id', $this->role_shop_id)->get();
        } else {
            $this->role('shop_owner');
            $items = Item::onlyTrashed()->where('shop_id', $this->role)->get();
        }
        return view('backend.shopowner.item.trash', ['items' => $items, 'shopowner' => $this->shop_owner]);
    }

    public function getitemsTrash(Request $request)
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

        $shop_id = 1;

        if (Auth::guard('shop_owner')->check()) {
            $shop_id = Auth::guard('shop_owner')->user()->id;

        } else {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        }


        $totalRecords = Item::onlyTrashed()
            ->select('count(*) as allcount')
            ->where('shop_id', $shop_id)
            ->where('product_code', 'like', '%' . $searchValue . '%')
            ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = Item::onlyTrashed()
            ->orderBy($columnName, $columnSortOrder)
            ->where('shop_id', $shop_id)->orderBy('created_at', 'desc')
            ->where('product_code', 'like', '%' . $searchValue . '%')
            ->select('items.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        //    return $records;
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "product_code" => $record->product_code,
                "image" => $record->default_photo,
                "price" => ($record->price != 0) ? $record->price : $record->short_price,
                "action" => $record->id,
                "deleted_at" => $record->delete_at,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function restore($id)
    {

        $item_id = Item::onlyTrashed()->findOrFail($id)->shop_id;

        if (Auth::guard('shop_role')->check()) {
            $this->role('shop_role');
            if (TzGate::allows($this->role_shop_id == $item_id)) {
                Item::onlyTrashed()->findOrFail($id)->restore();
                discount::onlyTrashed()->where('item_id', $id)->restore();
            }
        } else {
            $this->role('shop_owner');
            if (TzGate::allows($this->role == $item_id)) {
                Item::onlyTrashed()->findOrFail($id)->restore();
                discount::onlyTrashed()->where('item_id', $id)->restore();
            }
        }
        Session::flash('message', 'Your item was successfully restored');

        return redirect('backside/shop_owner/items_trash');
    }

    private function items_photos_delete($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        if (File::exists(public_path('images/items/' . $item->photo_one))) {
            File::delete(public_path('images/items/' . $item->photo_one));
            File::delete(public_path('images/items/mid/' . $item->photo_one));
            File::delete(public_path('images/items/thumbs/' . $item->photo_one));
        }
        if (File::exists(public_path('images/items/' . $item->photo_two))) {
            File::delete(public_path('images/items/' . $item->photo_two));
            File::delete(public_path('images/items/mid/' . $item->photo_two));
            File::delete(public_path('images/items/thumbs/' . $item->photo_two));
        }
        if (File::exists(public_path('images/items/' . $item->photo_three))) {
            File::delete(public_path('images/items/' . $item->photo_three));
            File::delete(public_path('images/items/mid/' . $item->photo_three));
            File::delete(public_path('images/items/thumbs/' . $item->photo_three));
        }
        if (File::exists(public_path('images/items/' . $item->photo_four))) {
            File::delete(public_path('images/items/' . $item->photo_four));
            File::delete(public_path('images/items/mid/' . $item->photo_four));
            File::delete(public_path('images/items/thumbs/' . $item->photo_four));
        }
        if (File::exists(public_path('images/items/' . $item->photo_five))) {
            File::delete(public_path('images/items/' . $item->photo_five));
            File::delete(public_path('images/items/mid/' . $item->photo_five));
            File::delete(public_path('images/items/thumbs/' . $item->photo_five));
        }
        if (File::exists(public_path('images/items/' . $item->photo_six))) {
            File::delete(public_path('images/items/' . $item->photo_six));
            File::delete(public_path('images/items/mid/' . $item->photo_six));
            File::delete(public_path('images/items/thumbs/' . $item->photo_six));
        }
        if (File::exists(public_path('images/items/' . $item->photo_seven))) {
            File::delete(public_path('images/items/' . $item->photo_seven));
            File::delete(public_path('images/items/mid/' . $item->photo_seven));
            File::delete(public_path('images/items/thumbs/' . $item->photo_seven));
        }
        if (File::exists(public_path('images/items/' . $item->photo_eight))) {
            File::delete(public_path('images/items/' . $item->photo_eight));
            File::delete(public_path('images/items/mid/' . $item->photo_eight));
            File::delete(public_path('images/items/thumbs/' . $item->photo_eight));
        }
        if (File::exists(public_path('images/items/' . $item->photo_nine))) {
            File::delete(public_path('images/items/' . $item->photo_nine));
            File::delete(public_path('images/items/mid/' . $item->photo_nine));
            File::delete(public_path('images/items/thumbs/' . $item->photo_nine));
        }
        if (File::exists(public_path('images/items/' . $item->photo_ten))) {
            File::delete(public_path('images/items/' . $item->photo_ten));
            File::delete(public_path('images/items/mid/' . $item->photo_ten));
            File::delete(public_path('images/items/thumbs/' . $item->photo_ten));
        }
    }

    public function forceDelete($id)
    {
        $item_id = Item::onlyTrashed()->findOrFail($id)->shop_id;
        if (Auth::guard('shop_role')->check()) {
            $this->role('shop_role');
            if (discount::where('item_id', $id)->count() > 0) {
                $this->items_photos_delete($id);
                discount::where('item_id', $id)->forceDelete();
            }
            if (TzGate::allows($this->role_shop_id == $item_id)) {
                Item::onlyTrashed()->findOrFail($id)->forceDelete();
            }
        } else {
            $this->role('shop_owner');
            if (TzGate::allows($this->role == $item_id)) {
                $this->items_photos_delete($id);
                Item::onlyTrashed()->findOrFail($id)->forceDelete();
                discount::onlyTrashed()->where('item_id', $id)->forceDelete();

            }
        }
        Session::flash('message', 'Your item was successfully hard deleted ');

        return redirect()->back();
    }

    public function fromDetailEdit(Request $request)
    {
        $input = $request->except('_token', '_method', 'id');
        $id = $request->input('id');
        if (($request->input('price')) != null) {
            $this->validate($request, [
                'product_code' => 'required|gt:0',
                'stock_count' => 'required|numeric|gt:0',
                'price' => 'required|numeric',
            ]);
        } elseif (($request->input('max_price')) != null) {
            $this->validate($request, [
                'product_code' => 'required|gt:0',
                'stock_count' => 'required|numeric|gt:0',
                'min_price' => 'required|numeric',
                'max_price' => 'required|numeric',
            ]);
        }
        $item = DB::table('items')->where('id', $id);
        $query = $item->update($input);
        Session::flash('message', 'Your item was successfully updated');
        return redirect()->back();
    }

    public function only_price_update(Request $request)
    {

        $request->validate([
            'price' => 'required'
        ]);

        $price = explode("-", $request->price);

        $item = Item::find($request->id);
        if(count($price) > 1){
            if($price[0] < $price[1]){
                $item->price = 0;
                $item->min_price = $price[0];
                $item->max_price = $price[1];
                $item->update();
            }else{
               return redirect()->back()->withErrors('wrong_price','In Valid Price');
            }



        }else{
            $item->price = $request->price;
            $item->update();
        }


        return response()->json([
            'success' => true,
            'data' =>  $price
        ]);
    }

}
