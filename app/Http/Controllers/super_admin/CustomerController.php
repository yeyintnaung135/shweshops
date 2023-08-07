<?php

namespace App\Http\Controllers\super_admin;

use App\User;
use App\Point;
use App\UserPoint;
use App\GoldPoint;
use App\ItemLogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function index()
    {
        $itemlogs = ItemLogActivity::whereBetween('created_at',[Carbon::now()->submonth(),Carbon::now()]);
        return view('backend.super_admin.customer.list', ['itemlogs' => $itemlogs]);
    }


    public function activity_index()
    {
        $itemlogs = ItemLogActivity::whereBetween('created_at',[Carbon::now()->submonth(),Carbon::now()]);
        return view('backend.super_admin.activity_logs.customer', ['itemlogs' => $itemlogs]);
    }




    public function getCustomers(Request $request)
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

        $totalRecords = User::select('count(*) as allcount')
                        ->where(function ($query) use ($searchValue) {
                          $query->where('username', 'like', '%' . $searchValue . '%')
                              ->orWhere('phone', 'like', '%' . $searchValue . '%')
                              ->orWhere('gender', 'like', '%' . $searchValue . '%');
                        })
                        ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;

        $records = User::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where(function ($query) use ($searchValue) {
                $query->where('username', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('gender', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('users.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "username" => $record->username,
                "phone" => $record->phone,
                "gender" => $record->gender,
                "birthday" => $record->birthday,
                "active" => $record->active,
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

    public function getCustomerActivity(Request $request)
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

        $totalRecords = ItemLogActivity::select('count(*) as allcount')
                        ->where(function ($query) use ($searchValue) {
                          $query->where('item_code', 'like', '%' . $searchValue . '%')
                              ->orWhere('name', 'like', '%' . $searchValue . '%')
                              ->orWhere('user_id', 'like', '%' . $searchValue . '%')
                              ->orWhere('user_name', 'like', '%' . $searchValue . '%');
                        })
                        ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;

        $records = ItemLogActivity::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where(function ($query) use ($searchValue) {
                $query->where('item_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('item_log_activities.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

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
    
    public function point()
    {
        $register_points = Point::where('status','Register')->first();
        $whislist_points = Point::where('status','Whislist')->first();
        $add_to_cart_points = Point::where('status','AddToCart')->first();
        $buynow_points = Point::where('status','Buynow')->first();
        $daily_points = Point::where('status','Daily Login')->first();
        $profile_edit = Point::where('status','Profile Edit')->first();
        $phone_number = Point::where('status','Phone Number Edit')->first();
        $birthdate = Point::where('status','Birth Date Edit')->first();
        $address = Point::where('status','Address Edit')->first();
        $username = Point::where('status','User Name Edit')->first();
        
        return view('backend.super_admin.point',[
            "register" => $register_points,
            "whislist" => $whislist_points,
            'addtocart' =>  $add_to_cart_points,
            "buynow" => $buynow_points,
            "daily" => $daily_points,
            "profile" => $profile_edit,
            "phone" => $phone_number,
            "birthdate" => $birthdate,
            "address" => $address,
            "username" => $username,
        ]);
    }
    public function point_update(Request $request)
    {
        
        $message = [
             'count1.required' => 'The register point count field is required.',
             'count1.numeric' => 'The register point count must be a number.',
             'count2.required' => 'The Daily Login count field is required.',
             'count2.numeric' => 'The Daily Login count must be a number.',
             'count3.required' => 'The Whislist point count field is required.',
             'count3.numeric' => 'The Whislist point count must be a number.',
             'count4.required' => 'The Buynow point count field is required.',
             'count4.numeric' => 'The Buynow point count must be a number.',
             'count5.required' => 'The AddToCart point count field is required.',
             'count5.numeric' => 'The AddTocArt point count must be a number.',
             'count10.required' => 'The Profile Edit point count field is required.',
             'count10.numeric' => 'The Profile Edit point count must be a number.',
             'count6.required' => 'The Phone Number point count field is required.',
             'count6.numeric' => 'The Phone Number point count must be a number.',
             'count7.required' => 'The Birth Date Edit point count field is required.',
             'count7.numeric' => 'The Birth Date Edit point count must be a number.',
             'count8.required' => 'The Address Edit point count field is required.',
             'count8.numeric' => 'The Address Edit point count must be a number.',
             'count9.required' => 'The Username Edit point count field is required.',
             'count9.numeric' => 'The Username Edit point count must be a number.',
            ];
           $request->validate([
            'count1' => 'required|numeric',
            'count2' => 'required|numeric',
            'count3' => 'required|numeric',
            'count4' => 'required|numeric',
            'count5' => 'required|numeric',
            'count10' => 'required|numeric',
            'count6' => 'required|numeric',
            'count7' => 'required|numeric',
            'count8' => 'required|numeric',
            'count9' => 'required|numeric',
        ],$message);
        
        Point::where('status',$request->register)->update([
            'count' => $request->count1,   
        ]);
        Point::where('status',$request->daily)->update([
            'count' => $request->count2,   
        ]);
        Point::where('status',$request->whislist)->update([
            'count' => $request->count3,   
        ]);
        Point::where('status',$request->buynow)->update([
            'count' => $request->count4,   
        ]);
        Point::where('status',$request->addtocart)->update([
         'count' => $request->count5,   
        ]);
        Point::where('status',$request->profile)->update([
         'count' => $request->count10,   
        ]);
        Point::where('status',$request->username)->update([
         'count' => $request->count9,   
        ]);
        Point::where('status',$request->phone)->update([
         'count' => $request->count6,   
        ]);
        Point::where('status',$request->birthdate)->update([
         'count' => $request->count7,   
        ]);
        Point::where('status',$request->address)->update([
         'count' => $request->count8,   
        ]);
        
        return redirect()->back();
    }


    /** Gold Point */

    public function gold_point()
    {
        return view('backend.super_admin.point_system.gold_points_create');
    }

    public function gold_point_store(Request $request)
    {
        $request->validate([
            'status'=> 'required|numeric|unique:gold_points,status',
            'counts'=> 'required|numeric',
        ]);
        $gold_points = new GoldPoint();
        $gold_points->status = $request->status;
        $gold_points->counts = $request->counts;

        return redirect()->back();
    }
    
    public function gold_point_edit($id)
    {   
        $gold_point = GoldPoint::findOrFail($id);
        $gold_points= GoldPoint::latest()->paginate(5);
        return view('backend.super_admin.point_system.gold_points_edit',compact('gold_point','gold_points'));
    }
    
    public function gold_point_update(Request $request , $id)
    {
        $gold_point = GoldPoint::findOrFail($id);
        $gold_point->status =$request->status;
        $gold_point->counts = $gold_point->counts;
        $gold_point->save();
        return redirect()->route('gold_point'); 
    }
}
