<?php

namespace App\Http\Controllers\super_admin;


use App\Http\Controllers\Controller;
use App\ShopBanner;
use App\Shopdirectory;
use App\State;
use App\Township;
use App\Shopowner;
use App\Superadmin;
use App\Tooltips;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class DirectoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }
    public function alltable(){
        return view('backend.super_admin.directory.list');
    }
    public function alldirectory(Request $request) {
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

        $totalRecords = Shopdirectory::select('count(*) as allcount')
            ->where('shop_name','!=', '')
            ->where(function ($query) use($searchValue) {
                $query->orWhere('shop_name', 'like', '%' . $searchValue . '%')
                ->orWhere('main_phone', 'like', '%' . $searchValue . '%')
                ->orWhere('address', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;

        $records = Shopdirectory::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where('shop_id', '=' ,'0')
            ->where(function ($query) use($searchValue) {
                $query->orWhere('shop_name', 'like', '%' . $searchValue . '%')
                      ->orWhere('main_phone', 'like', '%' . $searchValue . '%')
                      ->orWhere('address', 'like', '%' . $searchValue . '%');
            })

            ->select('shop_directory.*')
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "id" => $record->id,
                "shop_name" => $record->shop_name,

                "shop_logo" => $record->shop_logo,

                "main_phone" => $record->main_phone,
                "action" => $record->id,
                "created_at" => date('F d, Y ( h:i A )',strtotime($record->created_at)),
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

    public function gettownship(Request $request) {
      if(is_array($request->id)) {
        $townships = Township::select('id', 'name', 'myan_name')->whereIn('state_id', $request->id)->get();
      } else {
        $townships = Township::select('id', 'name', 'myan_name')->where('state_id', $request->id)->get();
      }
      return response()->json($townships);
    }

    public function check_shop_directory_name(Request $request) {
      if (Shopdirectory::where('shop_name', '=', $request->shopName)->exists()) {
        $isExit = true;
      } else {
        $isExit = false;
      }
      return response()->json([
        'isExit' => $isExit
      ]);
    }

    public function createform()
    {
      $states = State::get();
      return view('backend.super_admin.directory.create',['states' => $states]);
    }
    public function validator(array $data)
    {
        return Validator::make($data, [

            'shop_logo' => ['mimes:jpeg,bmp,png,jpg'],
            'shop_name' =>  ['required', 'string', 'max:50'],
            'shop_name_url' =>  ['required', 'string', 'max:50','unique:shop_directory,shop_name_url'],
            'main_phone' =>  ['string', 'max:11','unique:shop_directory,main_phone'],
            'address' => ['required','string'],
            'state' => ['required','string','min:3'],
            'township' => ['required','string','min:3']

        ],
        [
          'state.min' => 'State field is required',
          'township.min' => 'Township field is required'
        ]);
    }
    public function evalidator(array $data)
    {
        return Validator::make($data, [

            'shop_logo' => ['mimes:jpeg,bmp,png,jpg'],
            'shop_name' =>  ['required', 'string', 'max:50'],
            'shop_name_url' =>  ['required', 'string', 'max:50'],
            'main_phone' =>  ['string', 'max:11'],
            'address' => ['required','string'],
            'state' => ['required','string','min:3'],
            'township' => ['required','string','min:3']

        ],
        [
          'state.array' => 'State field is required',
          'township.array' => 'Township field is required'
        ]);
    }
    public function store(Request $request)
    {
      // dd($request);
        $data = $request->except("_token");
        $valid=$this->validator($data);

        if( $valid->fails())
        {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        if($request->hasFile('shop_logo')) {
          $shop_logo = $data['shop_logo'];

          //file upload
          $imageNameone = time().'logo'.'.'.$shop_logo->getClientOriginalExtension();

          $lpath=$shop_logo->move(public_path('images/directory/'),$imageNameone);
          $data['shop_logo']=$imageNameone;
        }
        $add_ph = json_decode($request->additional_phones);
        $add_ph_array = [];

        if(json_decode($request->additional_phones)!== null){
            foreach($add_ph as $k=>$v){
                if(count($add_ph) != 0){
                    $ph = json_decode(json_encode($v), true);
                    foreach ($ph as $k2=>$v2) {
                    array_push($add_ph_array,$v2 );
                    }
                }
            }
        }
        // $state = json_decode($request->state);
        // $state_array = [];
        // if(json_decode($request->state)!== null){
        //   foreach($state as $k=>$v){
        //     if(count($state) != 0){
        //       $st = json_decode(json_encode($v), true);
        //       foreach ($st as $k2=>$v2) {
        //         array_push($state_array,$v2);
        //       }
        //     }
        //   }
        // }

        $data['additional_phones']=json_encode($add_ph_array);
        Shopdirectory::create($data);
        Session::flash('message', 'Your Shop Directory was successfully Created');

       return redirect('backside/super_admin/directory/all');
    }
    public function detail($id)
    {
        $ttdata=Shopdirectory::where('id',$id)->first();
        return view('backend.super_admin.directory.detail',['ttdata'=>$ttdata]);

    }
    public function editform($id)
    {
      $states = State::get();
      $ttdata=Shopdirectory::where('id',$id)->first();
      return view('backend.super_admin.directory.edit',['ttdata'=>$ttdata, 'states'=>$states]);

    }
    public function update(Request $request)
    {
        $sd = Shopdirectory::where('id',$request->id)->first();
        $data = $request->except("_token");
        $valid=$this->evalidator($data);

        if( $valid->fails())
        {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if ($request->file('shop_logo')) {

            if (File::exists(public_path('image/directory/'.$sd->shop_logo))) {
                File::delete(public_path('image/directory/'.$sd->shop_logo));
            }

            $shop_logo = time() . '1.' . $request->file('shop_logo')->getClientOriginalExtension();
            $get_path = $request->file('shop_logo')->move(public_path('images/directory'), $shop_logo);

            $data['shop_logo'] = $shop_logo;

        }
        $add_ph = json_decode($request->additional_phones);
        $add_ph_array = [];

        if(json_decode($request->additional_phones)!== null){
            foreach($add_ph as $k=>$v){
                if(count($add_ph) != 0){
                    $ph = json_decode(json_encode($v), true);
                    foreach ($ph as $k2=>$v2) {
                    array_push($add_ph_array,$v2 );
                    }
                }
            }
        }
        $data['additional_phones']=json_encode($add_ph_array);
        Shopdirectory::where('id',$request->id)->update($data);


        Session::flash('message', 'Your Shop Directory was successfully Edited');

        return redirect('backside/super_admin/directory/all');

    }
    public function delete(Request $request)
    {
       $sd= Shopdirectory::where('id',$request->id)->first();


            if (File::exists(public_path('image/directory/'.$sd->shop_logo))) {
                File::delete(public_path('image/directory/'.$sd->shop_logo));
            }



        Shopdirectory::where('id',$request->id)->delete();
        Session::flash('message', 'Your Tooltips was successfully deleted');

        return redirect('backside/super_admin/directory/all');

    }
    public function list(){
        $alltt=Tooltips::all();
        return view('backend.super_admin.tooltips.list',['alltt'=>$alltt]);
    }

    public function all(Request $request)
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

        $totalRecords = Tooltips::select('count(*) as allcount')
            ->where('endpoint', 'like', '%' . $searchValue . '%')
            ->orWhere('info', 'like', '%' . $searchValue . '%')
            ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = Tooltips::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where('endpoint', 'like', '%' . $searchValue . '%')
            ->orWhere('info', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "url" => $record->name,
                "info" => $record->email,
                "id" => $record->id,
                "created_at" => $record->created_at
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
}
