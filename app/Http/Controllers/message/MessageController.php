<?php

namespace App\Http\Controllers\message;

use App\Events\ActiveShops;
use App\Events\Shopownermessage;
use App\Events\Shopownersmessage;
use App\Events\Usermessage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\Firebase;
use App\Http\Controllers\Trait\ForSiteSetting;
use App\Http\Controllers\Trait\UserRole;
use App\Models\ForFirebase;
use App\Models\Messages;
use App\Models\Shops;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //
    use ForSiteSetting, UserRole, Firebase;

    public function __construct()
    {
        $this->middleware('chatison');

        $this->middleware('auth:shop_owners_and_staffs', ['except' => ['sendmessagetoshopowner']]);

    }

    public function storefirebasetokenforshop(Request $request)
    {
        $shopid = $this->get_shopid();
        $input = $request->all();
        if (ForFirebase::updateOrCreate(['shopid' => $shopid], ['token' => $input['token']])) {
            return response()->json('done');
        } else {
            return response()->json('fail');

        }

    }

    public function sendmessagetouser(Request $request)
    {
        $datamsg = Messages::create($request->data);
//        $getmessages = Messages::join('users', 'users.id', '=', 'messages.message_user_id')->where('messages.id', $data->id)->select('*', 'messages.id as message_id', 'messages.created_at as message_created_at')->first();
        $getshopdata = Shops::where('id', $this->get_shopid())->first();

        $data = ['message' => $datamsg, 'shop' => $getshopdata];

        if ($data) {
            event(new Usermessage($data));
            event(new Shopownersmessage($data));
        }
        if ($datamsg->type != 'text') {
            $message = 'photo message';

        } else {
            $message = $datamsg->message;
        }
        // Uncommented by Swe
        // $test = firebase::sendformessage($datamsg->message_user_id, $getshopdata->shop_name, $message, 'https://test.shweshops.com', 'logo', 'feafeaf');

//        $check = event(new Usermessage($getmessages->toArray()));
        return response()->json(['success' => true, 'msg' => 'success']);

    }

    public function sendmessagetoshopowner(Request $request)
    {
        return response()->json(['success' => true, 'msg' => 'successfully send']);

        if (Messages::create($request->data)) {
            event(new Shopownermessage($request->data));

        }

        return response()->json(['success' => true, 'msg' => 'successfully send']);

    }

    public function chatpannel()
    {
        $current_shop = Shops::where('id', Auth::guard('shop_owners_and_staffs')->user()->shop_id)->first();

        return view('backend.shopowner.chatpannel.chatpannel', ['currentShop' => $current_shop]);
    }

    public function getshopschatslist()
    {
        $getuserid = Messages::where('message_shop_id', intval($this->get_shopid()))
            ->orderBy('created_at', 'desc')
            ->get()->unique('message_user_id')
            ->values()
            ->all();

        foreach ($getuserid as $key => $value) {
            $alldata = User::where('id', $value->message_user_id)->first();

            $getuserid[$key]['userdata'] = $alldata;
            $getuserid[$key]['userdata']['status'] = 'offline';

        }
        return response()->json(['success' => true, 'data' => $getuserid]);
    }

    public function gettotalchatcountforshop()
    {

        $gettotalchatcount = Messages::where('to_id', $this->get_shopid())
            ->where('read_by_user', 'no')->distinct()->count('message_user_id');
        return response()->json(['data' => $gettotalchatcount]);
    }

    public function getspecificchatcountforshop($user_id)
    {
        $getspecificchatcount = Messages::where('to_id', $this->get_shopid())
            ->where(function ($query) use ($user_id) {
                $query->where('from_id', (int) $user_id)
                    ->orWhere('from_id', (string) $user_id);
            })
            ->where('read_by_user', 'no')
            ->count('message_shop_id');
        return response()->json(['data' => $getspecificchatcount]);
    }
    public function sendimagemessagetouser(Request $request)
    {
        $request->validate([
            'message' => 'array',
            'message.*' => 'mimes:jpeg,bmp,png,jpg,gif|max:5120',
        ]);

        $images = [];
        foreach ($request->file('message') as $message) {
            $new_name = Carbon::now()->timestamp . '_chat_' . $message->getClientOriginalName();
            $message->move(public_path('images/chat'), $new_name);
            array_push($images, $new_name);
        }

        return response()->json(['success' => 'File uploaded successfully.', 'images' => $images]);
    }
    public function getcurrentchatuser(Request $request)
    {
        $start = $request->limit;
        //we take 20 latest messages
        $getmessages = Messages::where(function ($query) use ($request) {
            $query->where([['from_id', '=', intval($request->data)], ['to_id', '=', intval($this->get_shopid())]])
                ->orWhere([['from_id', '=', strval($request->data)], ['to_id', '=', intval($this->get_shopid())]]);
        })
            ->orWhere(function ($query) use ($request) {
                $query->where([['from_id', '=', intval($this->get_shopid())], ['to_id', '=', intval($request->data)]])
                    ->orWhere([['from_id', '=', strval($this->get_shopid())], ['to_id', '=', intval($request->data)]]);
            })
            ->orderBy('created_at', 'desc')->skip($start)->take(20)->get();

        $getuserdata = User::where('id', $request->data)->first();

        return response()->json(['success' => true, 'data' => ['messages' => $getmessages, 'userdata' => $getuserdata]]);

    }

    public function sendwhatshopisactive(Request $request)
    {

        event(new ActiveShops(['shops_id' => $request->data, 'role' => 'shop', 'status' => 'online']));
        return $request->data;

    }

    public function sendwhatshopisoffline(Request $request)
    {

        event(new ActiveShops(['shops_id' => $request->data, 'role' => 'shop', 'status' => 'offline']));
        return $request->data;

    }

    public function setreadbyshop(Request $request)
    {
        $getmessages = Messages::where(function ($query) use ($request) {
            $query->where([['to_id', '=', $this->get_shopid()], ['from_id', '=', $request->data], ['read_by_user', '=', 'no']])
                ->orWhere([['to_id', '=', $this->get_shopid()], ['from_id', '=', strval($request->data)], ['read_by_user', '=', 'no']]);
        })
        // ->orWhere(function($query) use ($request){
        //   $query->where([['from_id', '=', $this->get_shopid()], ['to_id', '=', $request->data], ['read_by_user', '=', 'no']])
        //         ->orWhere([['from_id', '=', strval($this->get_shopid())], ['to_id', '=', $request->data], ['read_by_user', '=', 'no']]);
        // })
            ->update(['read_by_user' => 'yes']);
        return response()->json(['success' => true, 'data' => 'set read by user']);
    }

}
