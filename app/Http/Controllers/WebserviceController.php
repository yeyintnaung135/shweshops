<?php

namespace App\Http\Controllers;

use App\Models\Forfirebase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WebserviceController extends Controller
{
    //
    public function storewspushapi(Request $request){
        $user = User::find(Auth::user()->id);
        $input=$request->all();
        $jsd =json_decode($input['data'],true);
        $endpoint = $jsd['endpoint'];
        $token = $jsd['keys']['auth'];
        $key =  $jsd['keys']['p256dh'];
        if($user->updatePushSubscription($endpoint,$key,$token,$contentEncoding = null)){
            return response()->json('done');
        }else{
            return response()->json('fail');

        }

    }
    public function storefirebasetoken(Request $request){
        $userid = Auth::user()->id;
        $input=$request->all();
       if( Forfirebase::updateOrCreate(['userid'=>$userid],['token'=>$input['token']])){
            return response()->json('done');
        }else{
            return response()->json('fail');

        }

    }
    public function storefirebasetokenfromandroid(Request $request) {
      $data = $request->all();
      if($data['userid']['type'] == 'shopid') {
        if( Forfirebase::updateOrCreate(['shopid'=>$data['userid']['id']],['androidtoken'=>$request['token']])){
            return response()->json('done');
        }else{
            return response()->json('fail');
        }
      } else {
        if( Forfirebase::updateOrCreate(['userid'=>$data['userid']['id']],['androidtoken'=>$request['token']])){
            return response()->json('done');
        }else{
            return response()->json('fail');
        }
      }
    }
    public function checkhavefromserver(){
       if(Auth::check()){
           return response()->json('none');

       }else{
           return response()->json('unauthorize ');

       }

    }
    public function checkhavefromserverfirebase(){
        if(Auth::check()){
            return response()->json('none');

        }else{
            return response()->json('unauthorize ');

        }

    }
}
