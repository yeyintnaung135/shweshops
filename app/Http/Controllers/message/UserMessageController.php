<?php

namespace App\Http\Controllers\message;

use App\Events\Activeusers;
use App\Events\Shopownermessage;
use App\Models\Events\Usermessage;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Models\Http\Controllers\traid\firebase;
use App\Models\Messages;
use App\Models\Shops;
use App\Models\Item;
use App\Models\User;
use App\Models\Usersorshopsonlinestatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsermessageController extends Controller
{
    //
    public function __construct()
    {
    }

    public function sendwhatuserisactive(Request $request)
    {
   
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
        $input = $request->all()['data'];

        $getdata = Messages::create($input);
        $getuser = User::where('id', $getdata->message_user_id)->first();
        $data = ['message' => $getdata, 'user' => $getuser];
        event(new Shopownermessage($data));
        if ($getdata->type != 'text') {
            $message = 'photo message';
        } else {
            $message = $getdata->message;
        }



        // Uncommented by Swe
        // $test = firebase::sendformessagetoshop($getdata->message_shop_id, Auth::user()->username, $message, 'https://test.shweshops.com', 'logo', 'feafeaf');




        return response()->json(['success' => true, 'msg' => 'successfully send']);
    }

    public function sendimagemessagetoshopowner(Request $request)
    {
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

        return response()->json(['success' => 'File uploaded successfully.', 'images' => $images]);
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

        $itemdata = Item::where('id', $request->itemid)->first();
        return response()->json($itemdata);
    }

    public function getuserchatlistsfromserver()
    {
        $getshopid = Messages::where(function ($query) {
            $query->where('message_user_id', Auth::guard('web')->user()->id)
                ->orWhere('message_user_id', (string)Auth::guard('web')->user()->id);
        })
            ->orderBy('created_at', 'desc')
            ->get()->unique('message_shop_id')
            ->values()
            ->all();
        foreach ($getshopid as $key => $value) {
            $alldata = Shops::select('shop_logo','id','shop_name')->where('id', $value->message_shop_id)->first();
            $getshopid[$key]['shopdata'] = $alldata;
            $getshopid[$key]['shopdata']['status']='offline';
        }

        return response()->json(['success' => true, 'data' => $getshopid]);
    }

    public function gettotalchatcountforuser()
    {
        $gettotalchatcount = Messages::where('to_id', Auth::guard('web')->user()->id)->where('read_by_user', 'no')->distinct()->count('message_shop_id');
        return response()->json(['data' => $gettotalchatcount]);
    }

    public function getspecificchatcountforuser($shop_id)
    {
        $getspecificchatcount = Messages::where('to_id', Auth::guard('web')->user()->id)->where('from_id', (int)$shop_id)->where('read_by_user', 'no')->count('message_shop_id');
        return response()->json(['data' => $getspecificchatcount]);
    }

    public function setreadbyuser(Request $request)
    {
        // $getmessages = Messages::where('id')->update(['read_by_user' => 'no']);
        $getmessages = Messages::where(function ($query) use ($request) {
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
        $start = $request->limit;
        //we take 20 latest messages
        $getmessages = Messages::where(function ($query) use ($request) {
            $query->where([['from_id', '=', intval($request->data)], ['to_id', '=', intval(Auth::guard('web')->user()->id)]])
                ->orWhere([['from_id', '=', strval($request->data)], ['to_id', '=', intval(Auth::guard('web')->user()->id)]]);
        })
            ->orWhere(function ($query) use ($request) {
                $query->where([['from_id', '=', intval(Auth::guard('web')->user()->id)], ['to_id', '=', intval($request->data)]])
                    ->orWhere([['from_id', '=', strval(Auth::guard('web')->user()->id)], ['to_id', '=', intval($request->data)]]);
            })
            ->orderBy('created_at', 'desc')->skip($start)->take(20)->get();

        //take shop data except psw
        $getshopdata =Shops::select('shop_logo','id','shop_name','shop_name_url')->where('id', $request->data)->first();
        $getshopid['status']='offline';

        return response()->json(['success' => true, 'data' => ['messages' => $getmessages, 'shop_data' => $getshopdata]]);
    }

    public function getpostbyproductid($item_id)
    {
        $getpost = Item::select('items.*')
            ->leftjoin('discount', 'items.id', '=', 'discount.item_id')
            ->where("items.id", '=', $item_id)
            ->get();
        return response()->json(['success' => true, 'data' => $getpost]);
    }
}
