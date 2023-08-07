<?php

namespace App\Http\Controllers\message;

use App\Events\Activeusers;
use App\Events\Shopownermessage;
use App\Events\Usermessage;
use App\Events\Shopownersmessage;
use App\Forfirebase;
use App\Http\Controllers\Controller;

use App\Http\Controllers\traid\firebase;
use App\Http\Controllers\traid\forsitesetting;
use App\Http\Controllers\traid\UserRole;
use App\Messages;
use App\Shopowner;
use App\User;
use App\Usersorshopsonlinestatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //
    use forsitesetting, UserRole, firebase;

    public function __construct()
    {
        $this->middleware('chatison');

        $this->middleware('auth:shop_owner,shop_role', ['except' => ['sendmessagetoshopowner']]);

    }

    public function storefirebasetokenforshop(Request $request)
    {
        $shopid = $this->getshopid();
        $input = $request->all();
        if (Forfirebase::updateOrCreate(['shopid' => $shopid], ['token' => $input['token']])) {
            return response()->json('done');
        } else {
            return response()->json('fail');

        }

    }

    public function sendmessagetouser(Request $request)
    {
        $datamsg = Messages::create($request->data);
//        $getmessages = Messages::join('users', 'users.id', '=', 'messages.message_user_id')->where('messages.id', $data->id)->select('*', 'messages.id as message_id', 'messages.created_at as message_created_at')->first();
        $getshopdata=Shopowner::where('id',$this->getshopid())->first();

        $data=['message'=>$datamsg,'shop'=>$getshopdata];

        $checkonline = Usersorshopsonlinestatus::where('users_id', $datamsg->message_user_id)->first();

        if ($data) {
            broadcast(new Usermessage($data));
            event(new Shopownersmessage($data));
        }
        if($datamsg->type != 'text'){
            $message='photo message';

        }else{
            $message=$datamsg->message;
        }
  // Uncommented by Swe
           $test = firebase::sendformessage($datamsg->message_user_id, $getshopdata->shop_name, $message, 'https://test.shweshops.com', 'logo', 'feafeaf');




//        $check = event(new Usermessage($getmessages->toArray()));
        return response()->json(['success' => true, 'msg' => 'success']);


    }

    public function sendmessagetoshopowner(Request $request)
    {

        if (Messages::create($request->data)) {
            event(new Shopownermessage($request->data));

        }


        return response()->json(['success' => true, 'msg' => 'successfully send']);


    }

    public function chatpannel()
    {
        return view('backend.shopowner.chatpannel.chatpannel');
    }

    public function getshopschatslist()
    {
        $getuserid=Messages::where('message_shop_id', intval($this->getshopid()))
            ->orderBy('created_at','desc')
            ->get()->unique('message_user_id')
            ->values()
            ->all();

        foreach ($getuserid as $key=>$value){
            $alldata=User::leftjoin('online_status', 'users.id', 'online_status.users_id')->select('*')->where('users.id',$value->message_user_id)->first();
            if($alldata != NUll){

                $getuserid[$key]['userdata']=$alldata;
            }else{
                unset($getuserid[$key]);
            }


        }
        return response()->json(['success' => true, 'data' => $getuserid]);
    }

    public function gettotalchatcountforshop() {

      $gettotalchatcount = Messages::where('to_id', $this->getshopid())
                          ->where('read_by_user', 'no')->distinct()->count('message_user_id');
      return response()->json(['data' => $gettotalchatcount]);
    }

    public function getspecificchatcountforshop($user_id) {
      $getspecificchatcount = Messages::where('to_id', $this->getshopid())
                              ->where(function($query) use($user_id){
                                $query->where('from_id', (int)$user_id)
                                      ->orWhere('from_id', (string)$user_id);
                              })
                              ->where('read_by_user', 'no')
                              ->count('message_shop_id');
      return response()->json(['data' => $getspecificchatcount]);
    }

    public function getcurrentchatuser(Request $request)
    {
        $start =$request->limit;
        //we take 20 latest messages
        $getmessages=Messages::where(function($query) use ($request){
                        $query->where([['from_id', '=', intval($request->data)], ['to_id', '=', intval($this->getshopid())]])
                              ->orWhere([['from_id', '=', strval($request->data)], ['to_id', '=', intval($this->getshopid())]]);
                      })
                      ->orWhere(function($query) use ($request){
                        $query->where([['from_id', '=',  intval($this->getshopid())], ['to_id', '=', intval($request->data)]])
                              ->orWhere([['from_id', '=',  strval($this->getshopid())], ['to_id', '=', intval($request->data)]]);
                      })
                      ->orderBy('created_at', 'desc')->skip($start)->take(20)->get();

        $getuserdata= User::leftjoin('online_status','users.id','=','online_status.users_id')->where('users.id',$request->data)->first();

        return response()->json(['success' => true, 'data' => ['messages'=>$getmessages,'userdata'=>$getuserdata]]);

    }

    public function sendwhatshopisactive(Request $request)
    {
        $forcheck = Usersorshopsonlinestatus::where([['shops_id', '=', $request->data], ['role', '=', 'shop']]);
        if ($forcheck->count() != 0) {
            $getdata = $forcheck->update(['status' => 'online']);
        } else {
            $getdata = Usersorshopsonlinestatus::create(['shops_id' => $request->data, 'role' => 'shop', 'status' => 'online']);
        }
        event(new Activeusers(['shops_id' => $request->data, 'role' => 'shop', 'status' => 'online']));
        return $request->data;

    }

    public function sendwhatshopisoffline(Request $request)
    {
        $forcheck = Usersorshopsonlinestatus::where([['shops_id', '=', $request->data], ['role', '=', 'shop']]);
        if ($forcheck->count() != 0) {
            $getdata = $forcheck->update(['status' => 'offline']);
        } else {
            $getdata = Usersorshopsonlinestatus::create(['shops_id' => $request->data, 'role' => 'shop', 'status' => 'offline']);
        }
        event(new Activeusers(['shops_id' => $request->data, 'role' => 'shop', 'status' => 'offline']));
        return $request->data;

    }

    public function setreadbyshop(Request $request)
    {
      $getmessages = Messages::where(function($query) use ($request){
        $query->where([['to_id', '=', $this->getshopid()], ['from_id', '=', $request->data], ['read_by_user', '=', 'no']])
              ->orWhere([['to_id', '=', $this->getshopid()], ['from_id', '=', strval($request->data)], ['read_by_user', '=', 'no']]);
      })
      // ->orWhere(function($query) use ($request){
      //   $query->where([['from_id', '=', $this->getshopid()], ['to_id', '=', $request->data], ['read_by_user', '=', 'no']])
      //         ->orWhere([['from_id', '=', strval($this->getshopid())], ['to_id', '=', $request->data], ['read_by_user', '=', 'no']]);
      // })
      ->update(['read_by_user' => 'yes']);
      return response()->json(['success' => true, 'data' => 'set read by user']);
    }

}

