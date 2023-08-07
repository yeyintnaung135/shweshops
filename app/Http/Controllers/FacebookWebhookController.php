<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\facebookmessage;
use App\Models\facebooktable;
use App\Http\Controllers\traid\UserRole;
use App\Models\Item;
use App\Models\Shopowner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\traid\facebooktraid;


class FacebookWebhookController extends Controller
{
    use facebooktraid;use UserRole;

    //
//    public function webhook()
//    {
//        $verify_token = 'yankee_messenger_is_the_best';
//        if ($verify_token == $_GET['hub_verify_token']) {
//            return $_GET['hub_challenge'];
//
//        } else {
//            return response(403);
//        }
//
//    }
//
//    public function webhook_post()
//    {
//        $raw_post_data = file_get_contents('php://input');
//        file_put_contents(public_path('file.txt'), $raw_post_data);
//        $decodejson = json_decode($raw_post_data, true);
//
//        if (!empty($decodejson['entry'][0]['messaging'][0]['sender']['id']) and !empty($decodejson['entry'][0]['messaging'][0]['postback']['referral']['ref'])){
//            $ref_parm = $decodejson['entry'][0]['messaging'][0]['postback']['referral']['ref'];
//            $psid = $decodejson['entry'][0]['messaging'][0]['sender']['id'];
//            $getitemtocheck=Item::where('id',$ref_parm)->first();
//            $getshop=Shopowner::where('id',$getitemtocheck->shop_id)->first();
//            if($getshop->premium == 'yes'){
//                $resp = $this->sendslidetemplate($psid, $ref_parm);
//
//            }else{
//                $resp = $this->sendimagetemplate($psid, $ref_parm);
//
//            }
//
//            Log::alert($resp);
//            $response = json_decode($resp, true);
//            if ($resp) {
//                return response('EVENT_RECEIVED', 200);
//
//            }
//        }else{
//            if (!empty($decodejson['entry'][0]['messaging'][0]['sender']['id']) and !empty($decodejson['entry'][0]['messaging'][0]['referral']['ref'])) {
//
//                $ref_parm = $decodejson['entry'][0]['messaging'][0]['referral']['ref'];
//                $psid = $decodejson['entry'][0]['messaging'][0]['sender']['id'];
//                $getitemtocheck=Item::where('id',$ref_parm)->first();
//                $getshop=Shopowner::where('id',$getitemtocheck->shop_id)->first();
//                if($getshop->premium == 'yes'){
//                    $resp = $this->sendslidetemplate($psid, $ref_parm);
//
//                }else{
//                    $resp = $this->sendimagetemplate($psid, $ref_parm);
//
//                }
//
//                Log::alert($resp);
//                $response = json_decode($resp, true);
//                if ($resp) {
//                    return response('EVENT_RECEIVED', 200);
//
//                }
//            }else{
////                if (!empty($decodejson['entry'][0]['messaging'][0]['sender']['id'])){
////
////                    $psid = $decodejson['entry'][0]['messaging'][0]['sender']['id'];
////                    $getrandomitemid=Item::where('shop_id',143)->orderByRaw("RAND()")->first();
////
////                        $resp = $this->sendimagetemplate($psid, $getrandomitemid->id);
////
////
////
////
////
////
////                }
//                return response('EVENT_RECEIVED', 200);
//
//            }
//
//        }
//        return response('EVENT_RECEIVED', 200);
//
//    }
//
//    public function forgetstart($postid)
//    {
//        $raw_post_data = file_get_contents('php://input');
//        file_put_contents(public_path('getstart.txt'), $raw_post_data);
//        $get_item=Item::where('id',$postid)->first();
//        $shop_id=$this->getshopid();
//
//        $access_token=facebooktable::where('shop_id',$shop_id)->first()->longlivepagetoken;
//        $response = Http::withHeaders([
//            'Content-Type' => "application/json"
//        ])->post('https://graph.facebook.com/v13.0/me/messenger_profile?access_token='.$access_token,
//            [
//                "get_started" => [
//                    "payload" => 'temp'
//                ]
//            ]);
//        return $response;
//    }


























//for real

    public function webhook()
    {
        $verify_token = 'yankee_messenger_is_the_best';
        if ($verify_token == $_GET['hub_verify_token']) {
            return $_GET['hub_challenge'];

        } else {
            return response(403);
        }

    }

    public function webhook_post()
    {
        $raw_post_data = file_get_contents('php://input');
        file_put_contents(public_path('file.txt'), $raw_post_data);
        $decodejson = json_decode($raw_post_data, true);

        if (!empty($decodejson['entry'][0]['messaging'][0]['postback']['referral']['ref'])){
            $ref_parm = $decodejson['entry'][0]['messaging'][0]['postback']['referral']['ref'];

        }else{
            $ref_parm = $decodejson['entry'][0]['messaging'][0]['referral']['ref'];

        }
        $psid = $decodejson['entry'][0]['messaging'][0]['sender']['id'];

        $getitemtocheck=Item::where('id',$ref_parm)->first();
        $getshop=Shopowner::where('id',$getitemtocheck->shop_id)->first();
        $storetofacebookmessage=facebookmessage::create(['user_fb_id'=>$psid,'shop_id'=>$getitemtocheck->shop_id,'user_id'=>'faefae']);
        if($getshop->premium == 'yes'){
            $resp = $this->sendslidetemplate($psid, $ref_parm);

        }else{
            $resp = $this->sendimagetemplate($psid, $ref_parm);

        }

        Log::alert($resp);
        $response = json_decode($resp, true);
        if ($resp) {
            return response('EVENT_RECEIVED', 200);

        }
    }

    public function forgetstart($postid)
    {
        $raw_post_data = file_get_contents('php://input');
        file_put_contents(public_path('getstart.txt'), $raw_post_data);
        $get_item=Item::where('id',$postid)->first();
        $shop_id=$this->getshopid();

        $access_token=facebooktable::where('shop_id',$shop_id)->first()->longlivepagetoken;
        $response = Http::withHeaders([
            'Content-Type' => "application/json"
        ])->post('https://graph.facebook.com/v13.0/me/messenger_profile?access_token='.$access_token,
            [
                "get_started" => [
                    "payload" => 'temp'
                ]
            ]);
        return $response;
    }
//for real

    //m.me link with messaging event

}

