<?php

namespace App\Http\Controllers\super_admin;

use App\Ads;
use App\SuperadminLogActivity;
use App\Shopowner;
use App\Facade\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\AdsImageRequest;
use DataTables;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Session;

class AdsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin','admin']);
    }

    public function index()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s A');
        Ads::where('end','<=',$now)->delete();
        $ads = Ads::withTrashed()->get();
        // $ads_role = SuperadminLogActivity::where('type',['ads'])->orderBy('created_at', 'desc')->get();
        return view('backend.super_admin.ad.all',['ads'=>$ads]);
    }
    public function activity_index()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s A');
        Ads::where('end','<=',$now)->delete();
        $ads = Ads::withTrashed()->get();
        $ads_role = SuperadminLogActivity::where('type','ads')->orderBy('created_at', 'desc')->get();
        return view('backend.super_admin.activity_logs.ads',['ads'=>$ads,'ads_role'=>$ads_role]);
    }

    // datable for ads log activity
    public function getAdsActivity(Request $request) {
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


        if($searchByFromdate == null) {
          $searchByFromdate = '0-0-0 00:00:00';
        }
        if($searchByTodate == null) {
          $searchByTodate = Carbon::now();
        }

        $totalRecords = SuperadminLogActivity::select('count(*) as allcount')
        ->where('type','ads')
                      ->where(function ($query) use($searchValue) {
                        $query->where('name', 'like', '%' . $searchValue . '%')
                              ->orWhere('type', 'like', '%' . $searchValue . '%')
                              ->orWhere('type_id', 'like', '%' . $searchValue . '%')
                              ->orWhere('type_name', 'like', '%' . $searchValue . '%')
                              ->orWhere('role', 'like', '%' . $searchValue . '%')
                              ->orWhere('status', 'like', '%' . $searchValue . '%');
                      })
                      ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
                      ->count();
        $totalRecordswithFilter = $totalRecords;
        $ads = SuperadminLogActivity::where('type','ads')->orderBy('created_at', 'desc')->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->get();
        $records = SuperadminLogActivity::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            // ->where('type',['ads'])
            ->where(function ($query) use($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%')
                  ->orWhere('type', 'like', '%' . $searchValue . '%')
                  ->orWhere('type_id', 'like', '%' . $searchValue . '%')
                  ->orWhere('type_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('role', 'like', '%' . $searchValue . '%')
                  ->orWhere('status', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('superadmin_log_activities.*')
            ->where('type','ads')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = array();

        foreach ($records as $record) {
          $data_arr[] = array(
              "id" => $record->id,
              "name" => $record->name,
              "type" => $record->type,
              "type_name" => $record->type_name,
              "status" => $record->status,
              "role" => $record->role,
              "created_at" => date('F d, Y ( h:i A )',strtotime($record->created_at)),
              // "created_at" => $record->created_at,
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

    public function getAllAds(Request $request) {

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


      if($searchByFromdate == null) {
        $searchByFromdate = '0-0-0 00:00:00';
      }
      if($searchByTodate == null) {
        $searchByTodate = Carbon::now();
      }

      $totalRecords = Ads::select('count(*) as allcount')
                      ->where(function ($query) use($searchValue) {
                        $query->where('name', 'like', '%' . $searchValue . '%')
                              ->orWhere('created_at', 'like', '%' . $searchValue . '%')
                              ->orWhere('end', 'like', '%' . $searchValue . '%');
                      })
                      ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->count();
      $totalRecordswithFilter = $totalRecords;

      $records = Ads::orderBy($columnName, $columnSortOrder)
          ->orderBy('created_at', 'desc')
          ->where(function ($query) use($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%')
                  ->orWhere('created_at', 'like', '%' . $searchValue . '%')
                  ->orWhere('end', 'like', '%' . $searchValue . '%');
          })
          ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
          ->select('ads.*')
          ->withTrashed()
          ->skip($start)
          ->take($rowperpage)
          ->get();

      $data_arr = array();

      foreach ($records as $record) {
        $data_arr[] = array(
            "name" => $record->name,
            "image" => $record->image,
            "video" => $record->video,
            "start" => date('F d, Y ( h:i A )',strtotime($record->start)),
            "end" => date('F d, Y ( h:i A )',strtotime($record->end)),
            "deleted_at" => $record->deleted_at ? '<span class="text-danger">' . $record->deleted_at->diffForHumans() . '</span>' : '',
            "id" => $record->id,
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = Shopowner::all();
        return view('backend.super_admin.ad.create',['shops'=> $shops]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdsImageRequest $request)
    {

        $folderPath = 'images/banner/';
        $mobileimgfolder='images/banner/thumbs/';
        $shop_name = Shopowner::where('id',$request->shop_id)->first();
        $start =  Carbon::parse($request->start,'UTC')->format('Y-m-d H:i:s A');
        $end =  Carbon::parse($request->end,'UTC')->format('Y-m-d H:i:s A');
        $ads = new Ads();
        if(!empty($shop_name)){
            $ads->name = $shop_name->shop_name;

        }else{
            $ads->name='No Shop';
        }
        $ads->shop_id = $request->shop_id;
        $ads->image = Repair::fileStore($request->file('photo'),$folderPath);
        $ads->image_for_mobile = Repair::fileStore($request->file('image_for_mobile'),$mobileimgfolder);

        $ads->start =$start;
        $ads->links =$request->links;

        $ads->end = $end;
        $ads->save();

        \SuperadminLogActivity::SuperadminAdsCreateLog($ads);


        return response()->json([
            'success' => true,
            'message' =>  "Ads Created Successfully"
        ]);

    }

    public function store_video(Request $request)
    {
        $request->validate([
          "video" => "required|mimes:gif,jpg,bmp,png,jpeg",
          "image_for_mobile" => "required|mimes:gif,jpg,bmp,png,jpeg",

          "start" => "required",
          "end" => "required",

        ],[
           "start.required" => 'Start Date ထည့်ပေးရန်',
           "end.required" => 'End Date ထည့်ပေးရန်',
           "video.required" => 'Video ထည့်ပေးရန်',
           "video.mimes" => 'Image'
           ]);
        $folderPath = 'images/banner';
        $mobileimgfolder='images/banner/thumbs/';

        $shop_name = Shopowner::where('id',$request->shop_id)->first();

        $start =  Carbon::parse($request->start,'UTC')->format('Y-m-d H:i:s A');
        $end =  Carbon::parse($request->end,'UTC')->format('Y-m-d H:i:s A');
        $ads = new Ads();
        if(!empty($shop_name)){
            $ads->name = $shop_name->shop_name;

        }else{
            $ads->name='No Shop';
        }
        $ads->shop_id = $request->shop_id;
        $ads->image = Repair::fileStore($request->file('video'),$folderPath);
        $ads->image_for_mobile = Repair::fileStore($request->file('image_for_mobile'),$mobileimgfolder);

        $ads->start =$start;
        $ads->links =$request->links;
        $ads->end = $end;
        $ads->save();

        \SuperadminLogActivity::SuperadminAdsCreateLog($ads);

        Session::flash('message', 'Your ads was successfully created');

        return redirect('/backside/super_admin/ads');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ad = Ads::withTrashed()->findOrFail($id);
        $shop = Shopowner::where('shop_name',$ad->name)->first();
        if(empty($shop)){
            $shop_name_myan='No Shop';
        }else{
            $shop_name_myan=$shop->shop_name_myan;

        }

        return view('backend.super_admin.ad.detail',['ad' => $ad, 'shop_name_myan'=> $shop_name_myan,'id' => $id]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
        $ad = Ads::withTrashed()->findOrFail($id);
        $shops = Shopowner::all();
        return view('backend.super_admin.ad.edit',['shops'=> $shops,'ad'=> $ad]);
     }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        return $request->shop_id;
        $shop_name = Shopowner::where('id',$request->shop_id)->first();
        $folderPath = 'images/banner/';
        $ads = Ads::withTrashed()->findOrfail($id);
        if(!empty($shop_name)){
            $ads->name = $shop_name->shop_name;

        }else{
            $ads->name='No Shop';
        }        $ads->shop_id = $request->shop_id;
        if($request->start){
           $ads->start = Carbon::createFromFormat('d-m-Y h:i A',$request->start)->format('Y-m-d H:i:s A');
        }
        if($request->end){
           $ads->end = Carbon::createFromFormat('d-m-Y h:i A',$request->end)->format('Y-m-d H:i:s A');
        }
       if($request->image){
         $ads->image = Repair::fileStore($request->file('image'),$folderPath);
        }
        if($request->image_for_mobile){
            $mobileimgfolder='images/banner/thumbs/';

            $ads->image_for_mobile = Repair::fileStore($request->file('image_for_mobile'),$mobileimgfolder);
           }
       $ads->links=$request->links;

        $ads->save();
        \SuperadminLogActivity::SuperadminAdsEditLog($ads);

        $ads = Ads::withTrashed()->findOrfail($id)->restore();
        Session::flash('message', 'Your ads was successfully updated');
        return redirect('/backside/super_admin/ads');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $ad = Ads::withTrashed()->findOrFail($id);
        \SuperadminLogActivity::SuperadminAdsDeleteLog($ad);

        if(File::exists(public_path('images/banner/' . $ad->image))){
            File::delete(public_path('/images/banner/' . $ad->name));
        }

        if($ad->deleted_at){
           Ads::onlyTrashed()->findOrFail($id)->forceDelete();
        }else{
           $ad->delete();
        }
        Session::flash('message', 'Your ads was successfully deleted');

        return redirect()->route('backside.super_admin.ads.index');
    }
}
