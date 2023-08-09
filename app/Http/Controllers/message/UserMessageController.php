<?php

namespace App\Http\Controllers\message;

use App\Events\Activeusers;
use App\Events\Shopownermessage;
use App\Events\Usermessage;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Http\Controllers\traid\firebase;
use App\Messages;
use App\Shopowner;
use App\Item;
use App\User;
use App\Usersorshopsonlinestatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class UsermessageController extends Controller
{
    //
    public function __construct()
    {

    }

    public function sendwhatuserisactive(Request $request)
    {
        $forcheck = Usersorshopsonlinestatus::where([['users_id', '=', $request->data], ['role', '=', 'user']]);
        if ($forcheck->count() != 0) {
            $getdata = $forcheck->update(['status' => 'online']);
        } else {
            $getdata = Usersorshopsonlinestatus::create(['users_id' => $request->data, 'role' => 'user', 'status' => 'online']);
        }
        event(new Activeusers(['users_id' => $request->data, 'role' => 'user', 'status' => 'online']));
        return $request->data;

    }

    public function sendwhatuserisoffline(Request $request)
    {
        $forcheck = Usersorshopsonlinestatus::where([['users_id', '=', $request->data], ['role', '=', 'user']]);
        if ($forcheck->count() != 0) {
            $getdata = $forcheck->update(['status' => 'offline']);
        } else {
            $getdata = Usersorshopsonlinestatus::create(['users_id' => $request->data, 'role' => 'user', 'status' => 'offline']);
            // $getdata = Usersorshopsonlinestatus::create(['users_id' => $request->data, 'role' => 'user', 'status' => 'offline']);
        }
        event(new Activeusers(['users_id' => $request->data, 'role' => 'user', 'status' => 'offline']));
        return $request->data;

    }

    public function sendmessagetoshopowner(Request $request)
    {
        $getdata = Messages::create($request->data);
//        $getmessages = Messages::leftjoin('shop_owners','shop_owners.id', '=', 'messages.message_shop_id')->where('messages.id', $getdata->id)->select('*', 'messages.id as message_id', 'messages.created_at as message_created_at')->first();
        $getshop=User::where('id',$getdata->message_user_id)->first();
        $data=['message'=>$getdata,'user'=>$getshop];
        event(new Shopownermessage($data));
        $checkonline = Usersorshopsonlinestatus::where('shops_id', $getdata->message_shop_id)->first();
        if($getdata->type != 'text'){
            $message='photo message';

        }else{
            $message=$getdata->message;
        }



  // Uncommented by Swe
            $test = firebase::sendformessagetoshop($getdata->message_shop_id, Auth::user()->username, $message, 'https://test.shweshops.com', 'logo', 'feafeaf');




        return response()->json(['success' => true, 'msg' => 'successfully send']);


    }

    public function sendimagemessagetoshopowner(Request $request) {
        $request->validate([
          'message' => 'array',
          'message.*' => 'mimes:jpeg,bmp,png,jpg,gif|max:5120'
        ]);

        $images = [];
        foreach ($request->file('message') as $message) {
            $new_name = Carbon::now()->timestamp . '_chat_' . $message->getClientOriginalName();
            $message->move(public_path('images/chat'), $new_name);
            array_push($images, $new_name);
        }

        return response()->json(['success'=>'File uploaded successfully.', 'images'=> $images]);
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
    public function getitemdata(Request $request)
    {

        $itemdata=Item::where('id',$request->itemid)->first();
        return response()->json($itemdata);

    }

    public function getuserchatlistsfromserver()
    {
        $getshopid=Messages::where(function($query){
              $query->where('message_user_id', Auth::guard('web')->user()->id)
                    ->orWhere('message_user_id', (string)Auth::guard('web')->user()->id);
            })
            ->orderBy('created_at','desc')
            ->get()->unique('message_shop_id')
            ->values()
            ->all();
        foreach ($getshopid as $key=>$value){
            $alldata=Shopowner::leftjoin('online_status', 'shop_owners.id', 'online_status.shops_id')->where('shop_owners.id',$value->message_shop_id)->first();
               $getshopid[$key]['shopdata']=$alldata;


        }

        return response()->json(['success' => true, 'data' => $getshopid]);
    }

    public function gettotalchatcountforuser() {
        $gettotalchatcount = Messages::where('to_id', Auth::guard('web')->user()->id)->where('read_by_user', 'no')->distinct()->count('message_shop_id');
        return response()->json(['data' => $gettotalchatcount]);
    }

    public function getspecificchatcountforuser($shop_id) {
        $getspecificchatcount = Messages::where('to_id', Auth::guard('web')->user()->id)->where('from_id', (int)$shop_id)->where('read_by_user', 'no')->count('message_shop_id');
        return response()->json(['data' => $getspecificchatcount]);
    }

    public function setreadbyuser(Request $request)
    {
        // $getmessages = Messages::where('id')->update(['read_by_user' => 'no']);
        $getmessages = Messages::where(function($query) use ($request) {
          $query->where([['to_id', '=', Auth::guard('web')->user()->id], ['from_id', '=', $request->data], ['read_by_user', '=', 'no']])
                ->orWhere([['to_id', '=', Auth::guard('web')->user()->id], ['from_id', '=', strval($request->data)], ['read_by_user', '=', 'no']]);
        })
        // ->orWhere(function($query) use ($request){
        //   $query->where([['from_id', '=', Auth::guard('web')->user()->id], ['to_id', '=', $request->data], ['read_by_user', '=', 'no']])
        //         ->orWhere([['from_id', '=', strval(Auth::guard('web')->user()->id)], ['to_id', '=', $request->data], ['read_by_user', '=', 'no']]);
        // })
        ->update(['read_by_user' => 'yes']);
        return response()->json(['success' => true, 'data' => 'set read by user']);
    }

    public function getcurrentchatshops(Request $request)
    {
        $start =$request->limit;
        //we take 20 latest messages
        $getmessages=Messages::where(function($query) use ($request){
          $query->where([['from_id', '=', intval($request->data)], ['to_id', '=',intval(Auth::guard('web')->user()->id)]])
                ->orWhere([['from_id', '=', strval($request->data)], ['to_id', '=',intval(Auth::guard('web')->user()->id)]]);
        })
        ->orWhere(function($query) use ($request){
          $query->where([['from_id', '=',intval(Auth::guard('web')->user()->id)], ['to_id', '=', intval($request->data)]])
                ->orWhere([['from_id', '=',strval(Auth::guard('web')->user()->id)], ['to_id', '=', intval($request->data)]]);
        })
        ->orderBy('created_at', 'desc')->skip($start)->take(20)->get();

        //take shop data except psw
        $getshopdata= Shopowner::leftjoin('online_status','shop_owners.id','=','online_status.shops_id')->where('shop_owners.id',$request->data)->first();

        return response()->json(['success' => true, 'data' => ['messages'=>$getmessages,'shop_data'=>$getshopdata]]);
    }

    public function getpostbyproductid($item_id) {
        $getpost = Item::select('items.*')
            ->leftjoin('discount', 'items.id', '=', 'discount.item_id')
            ->where("items.id", '=', $item_id)
            ->get();
        return response()->json(['success' => true, 'data' => $getpost]);
    }


}

