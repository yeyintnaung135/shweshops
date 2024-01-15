<?php

namespace App\Http\Controllers\forfacebook;

use App\Models\FacebookMessage;
use App\Models\FacebookTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FacebookController extends Controller
{
    use UserRole;
    //

//    public function __construct()
//    {
//
//        $this->middleware('auth:shop_owner,shop_role');
//
//    }
    public function checkwehavetoken(){
//             $shop_id=Auth::guard('shop_owner')->user()->id;
             $shop_id=$this->get_shopid();
             $countrecords=FacebookTable::where('shop_owner_id',$shop_id)->count();
             if($countrecords == 0){
                 return response()->json(['status'=>false]);
             }else{
                 return response()->json(['status'=>true]);

             }
    }
    public function addlog(Request $request){
        if(Auth::guard('web')->check()){
            FacebookMessage::create(['user_fb_id'=>$request->userid,'shop_id'=>$request->shopid,'user_id'=>$request->userid,'item_id'=>$request->itemid]);
            return response()->json(['status'=>'done']);

        }else{
            return response()->json(['status'=>'no']);

        }
    }
    public function dis_fb(Request $request){
        $shop_id=$this->get_shopid();
        $getfbdata=FacebookTable::where('shop_owner_id',$shop_id)->first();

        $response = Http::withHeaders([
            'Content-Type' => "application/json"
        ])->get('https://graph.facebook.com/v13.0/'.$getfbdata->page_id.'/subscribed_apps?access_token='.$getfbdata->longlivepagetoken);
        FacebookTable::where('shop_owner_id',$shop_id)->forceDelete();

        return redirect(url('backside/shop_owner/shop'));
    }

    public function storetoken(Request $request){
//             $shop_id=Auth::guard('shop_owner')->user()->id;
        $shop_id=$this->get_shopid();

        $input=$request->all();
        $input['shop_id']=$shop_id;
        $input['shop_owner_id']=$shop_id;
        $countrecords=FacebookTable::create($input)->count();
        if($countrecords == 0){
            return response()->json(['status'=>false]);
        }else{
            return response()->json(['status'=>true]);

        }
    }
}
