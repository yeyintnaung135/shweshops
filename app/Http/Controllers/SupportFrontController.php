<?php

namespace App\Http\Controllers;

use App\Models\CatSupport;
use App\Models\Support;
use App\Models\Shops;
use App\Models\ShopOwnersAndStaffs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupportFrontController extends Controller
{
    //move datas from shops to shopownerandstaff
    public function movedatas(){
       // Retrieve data from the source table
        $sourceData = Shops::all();
        // Insert data into the destination table
        try{
            foreach ($sourceData as $data) {
                if($data->name && $data->main_phone && $data->id && $data->password){
                    ShopOwnersAndStaffs::create([
                        'name'=>$data->name,
                        'phone'=>$data->main_phone,
                        'role_id'=>4,
                        'shop_id'=>$data->id,
                        'password'=>$data->password
                    ]);
                }
             }
             return 'moved datas from shops to shop_owners_and_staffs successfully!';
        } catch (\Exception $e) {
            dd($e);
        }
        
    }
    //
    public function support(){
        $data=Support::where('for_what','for_user')->limit(6)->get();
        $cats=CatSupport::all();
        return view('front.support.support',['data'=>$data,'cats'=>$cats]);
    }
    public function get_support(Request $request){
        if($request->filtertype['cat_id']==0 or $request->filtertype['cat_id']==1 ){
            $data=Support::where('for_what','for_user')->skip($request->filtertype['limit'])->take('6')->get();

        }else{
            $catid=$request->filtertype['cat_id'];
            $data=Support::where('for_what','for_user')->where('cat_id',$catid)->skip($request->filtertype['limit'])->take('6')->get();

        }

        if (count($data) < 6) {
            $empty_on_server = 1;
        } else {
            $empty_on_server = 0;
        }
        return response()->json(['shops' => $data, 'count' => count($data), 'empty_on_server' => $empty_on_server]);
    }
    public function get_support_by_cat(Request $request){
        if($request->filtertype['cat_id']==0 or $request->filtertype['cat_id']==1 ){
            $data=Support::where('for_what','for_user')->skip($request->filtertype['limit'])->take('6')->get();

        }else{
            $catid=$request->filtertype['cat_id'];
            $data=Support::where('for_what','for_user')->where('cat_id',$catid)->skip($request->filtertype['limit'])->take('6')->get();

        }
        if (count($data) < 6) {
            $empty_on_server = 1;
        } else {
            $empty_on_server = 0;
        }
        return response()->json(['shops' => $data, 'count' => count($data), 'empty_on_server' => $empty_on_server]);
    }
}
