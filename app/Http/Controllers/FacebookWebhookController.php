<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\FacebookTrait;
use App\Http\Controllers\Trait\UserRole;
use App\Models\FacebookMessage;
use App\Models\FacebookTable;
use App\Models\Item;
use App\Models\Shops;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookWebhookController extends Controller
{
    use FacebookTrait, UserRole;

  
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
        $getshop=Shops::where('id',$getitemtocheck->shop_id)->first();
        $storetofacebookmessage=FacebookMessage::create(['user_fb_id'=>$psid,'shop_id'=>$getitemtocheck->shop_id,'user_id'=>'faefae']);
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
        file_put_contents(public_path('getstart.txt'), 'get start effect');
        $get_item=Item::where('id',$postid)->first();
        $shop_id=$this->get_shopid();

        $access_token=FacebookTable::where('shop_id',$shop_id)->first()->longlivepagetoken;
        $response = Http::withHeaders([
            'Content-Type' => "application/json"
        ])->post('https://graph.facebook.com/v14.0/me/messenger_profile?access_token='.$access_token,
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
