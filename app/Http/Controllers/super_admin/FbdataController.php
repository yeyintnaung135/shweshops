<?php

namespace App\Http\Controllers\super_admin;

use App\Event;
use App\facebookmessage;
use App\facebooktable;
use App\Item;
use App\Shopowner;
use App\Facade\Repair;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FbdataController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }

    public function list()
    {
        return view('backend.super_admin.fbdata.list');
    }
    public function getall(Request $request)
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



        $totalRecords = facebooktable::leftjoin('shop_owners','facebook.shop_owner_id','=','shop_owners.id')->select('count(facebook.*) as allcount')
            ->orWhere(function ($query) use ($searchValue) {
                $query->where('shop_owners.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.shop_name_myan', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.address', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.main_phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('facebook.pagename', 'like', '%' . $searchValue . '%')->orWhere('facebook.shop_id', 'like', '%' . $searchValue . '%');
                ;
            })
            ->whereBetween('facebook.created_at', [$searchByFromdate, $searchByTodate])->count();

        $totalRecordswithFilter = $totalRecords;
        if($columnName == 'shop_name'){
            $columnName='shop_owners.name';
        }
        if($columnName == 'created_at'){
            $columnName='facebook.created_at';
        }
        if($columnName == 'page_name'){
            $columnName='facebook.pagename';
        }
        if($columnName == 'id'){
            $columnName='facebook.id';
        }
        $records = facebooktable::leftjoin('shop_owners','facebook.shop_owner_id','=','shop_owners.id')->select('*','facebook.created_at as ff')->orderBy($columnName, $columnSortOrder)
            ->orderBy('facebook.created_at', 'desc')
            ->orWhere(function ($query) use ($searchValue) {
                $query->where('shop_owners.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.shop_name_myan', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.address', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.main_phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('facebook.pagename', 'like', '%' . $searchValue . '%')
                    ->orWhere('facebook.shop_id', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('facebook.created_at', [$searchByFromdate, $searchByTodate])
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(

                "id" => $record->id,
                "shop_name" => $record->shop_name,
                "page_name" => $record->pagename,
                "created_at" => date('F d, Y ( h:i A )',strtotime($record->ff)),

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

    public function getcount(Request $request){
        $allcount=facebooktable::all();
        $allcountbydate=facebooktable::whereBetween('created_at',[$request->from,$request->to])->get();
        return response()->json(['all'=>count($allcount),'alld'=>count($allcountbydate)]);
    }
    public function getmsglogcount(Request $request){
        $allcount=facebookmessage::all();
        $allcountbydate=facebookmessage::whereBetween('created_at',[$request->from,$request->to])->get();
        return response()->json(['all'=>count($allcount),'alld'=>count($allcountbydate)]);
    }
    public function messengerlog(){
        return view('backend.super_admin.fbdata.msglog');
    }
    public function messengerlogdetail($shopid){
        return view('backend.super_admin.fbdata.msglogdetail',['shop_id'=>$shopid]);
    }
    public function getmsglogdetail(Request $request){
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



        $totalRecords = facebookmessage::leftjoin('shop_owners','fb_messenger_click_log.shop_id','=','shop_owners.id')

        ->select('*','fb_messenger_click_log.created_at as ff')
            ->Where(function ($query) use ($searchValue) {
                $query->where('shop_owners.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.shop_name_myan', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.address', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.main_phone', 'like', '%' . $searchValue . '%');

            })->where('fb_messenger_click_log.shop_id',$request->get('shop_id'))
            ->whereBetween('fb_messenger_click_log.created_at', [$searchByFromdate, $searchByTodate])
            ->get();
        $totalRecordswithFilter = count($totalRecords);
        if($columnName == 'shop_name'){
            $columnName='shop_owners.name';
        }
        if($columnName == 'created_at'){
            $columnName='fb_messenger_click_log.created_at';
        }
        if($columnName == 'id'){
            $columnName='fb_messenger_click_log.id';
        }
        if($columnName == 'user_name'){
            $columnName='users.username';
        } if($columnName == 'user_phone'){
            $columnName='users.phone';
        }

        $records = facebookmessage::leftjoin('shop_owners','fb_messenger_click_log.shop_id','=','shop_owners.id')->leftjoin('items','fb_messenger_click_log.item_id','=','items.id')->leftjoin('users','fb_messenger_click_log.user_id','=','users.id')->orderBy($columnName, $columnSortOrder)
            ->orderBy('fb_messenger_click_log.created_at', 'desc')
            ->select('*','fb_messenger_click_log.created_at as ff')

            ->Where(function ($query) use ($searchValue) {
                $query->where('users.username', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.address', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.main_phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('fb_messenger_click_log.shop_id', 'like', '%' . $searchValue . '%');
            })->where('fb_messenger_click_log.shop_id',$request->get('shop_id'))
            ->whereBetween('fb_messenger_click_log.created_at', [$searchByFromdate, $searchByTodate])
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $photo=Item::where('id',$record->item_id)->first();
            if(!empty($photo)){
                $itemphoto=$photo->check_photo;
            }else{
                $itemphoto='';
            }

            $data_arr[] = array(
                "id" => $record->id,
                "user_name" => $record->username,
                "user_phone" => $record->phone,
                "item_name" => $record->name,
                "item_code" => $record->product_code,
                "item_photo"=>$itemphoto,
                "created_at" => date('F d, Y ( h:i A )',strtotime($record->ff)),

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordswithFilter,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function getmsglog(Request $request){
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

        if($columnName == 'id'){
            $columnName='fb_messenger_click_log.id';
        }
        if($columnName == 'click_count'){
            $columnName='total';
        }
        $totalRecords = facebookmessage::leftjoin('shop_owners','fb_messenger_click_log.shop_id','=','shop_owners.id')
            ->select('*','fb_messenger_click_log.created_at as ff')


            ->orWhere(function ($query) use ($searchValue) {
                $query->where('shop_owners.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.shop_name_myan', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.address', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.main_phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('fb_messenger_click_log.shop_id', 'like', '%' . $searchValue . '%');

            })
            ->whereBetween('fb_messenger_click_log.created_at', [$searchByFromdate, $searchByTodate])->groupBy('fb_messenger_click_log.shop_id')
            ->get();
        $totalRecordswithFilter = count($totalRecords);
        if($columnName == 'shop_name'){
            $columnName='shop_owners.name';
        }
        if($columnName == 'created_at'){
            $columnName='fb_messenger_click_log.created_at';    
        }

        $records = facebookmessage::leftjoin('shop_owners','fb_messenger_click_log.shop_id','=','shop_owners.id')
        ->select('*','fb_messenger_click_log.created_at as ff', DB::raw('count(*) as total'))

            ->orWhere(function ($query) use ($searchValue) {
                $query->where('shop_owners.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.shop_name_myan', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.address', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_owners.main_phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('fb_messenger_click_log.shop_id', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('fb_messenger_click_log.created_at', [$searchByFromdate, $searchByTodate])
            ->skip($start)
            ->take($rowperpage)
            ->groupBy('fb_messenger_click_log.shop_id')
            ->orderBy($columnName, $columnSortOrder)

            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "id" => $record->id,
                "shop_name" => $record->shop_name,
                "click_count" => $record->total,
                "created_at" => date('F d, Y ( h:i A )',strtotime($record->ff)),
                "detail" => $record->shop_id,

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordswithFilter,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

}
