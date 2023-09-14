<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\FavouriteItem;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FavouriteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->except(['see_all','get_fav_items_data']);
    }
 

    public function see_all(){
        return view('front.AllFavourite');
    }
    public function get_fav_items_data_authuser(Request $request):JsonResponse
    {
        $useridandtypearry = $this->get_usertype_and_id();
        $type=$useridandtypearry['type'];
        $id=$useridandtypearry['id'];
        $getfavdata = FavouriteItem::select('fav_id')->where('user_id', $id)->where('type',$type)->get();

        if (!empty($getfavdata) ) {
            $lettmpfav_ids=[];
            foreach ($getfavdata as $je) {
             array_push($lettmpfav_ids,$je->fav_id);    
                
            }
            $get_item_data=Item::whereIn('id',$lettmpfav_ids)->get();
            return response()->json(['success' => true, 'data' => $get_item_data]);
        }else{
            return response()->json(['success' => true, 'data' => []]);

        }
      

    }

    public function get_fav_items_data(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'fav_ids' => ['required', 'array']
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()]);
        }  

        if ($request->fav_ids != "null" and !empty($request->fav_ids) ) {
            $lettmpfav_ids=[];
            foreach ($request->fav_ids as $je) {
             array_push($lettmpfav_ids,$je['fav_id']);    
                
            }
            $get_item_data=Item::whereIn('id',$lettmpfav_ids)->get();
            return response()->json(['success' => true, 'data' => $get_item_data]);
        }else{
            return response()->json(['success' => true, 'data' => []]);

        }
      

    }


    public function action_favourite(Request $request)
    {
        $input = $request->except(['action']);
        $validator = Validator::make($request->all(), [
            'fav_id' => ['required', 'numeric'], 'action' => [Rule::in(['add', 'remove'])]
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()]);
        }
        if ($request->action == 'add') {
             $this->store_fav_item_to_db($input);
             
        }
        if ($request->action == 'remove') {
             $this->remove_fav_item_to_db($input);
        }
        $useridandtypearry = $this->get_usertype_and_id();

        $getfavdata = FavouriteItem::select('fav_id')->where('user_id', $useridandtypearry['id'])->where('type',$useridandtypearry['type'])->get();

        return response()->json(['success' => true, 'data' => $getfavdata]);
    }



    public function upload_after_logined(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => ['required', 'string', 'max:2000'],
            'rm_ids' => ['string', 'max:2000']

        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()]);
        }
        $useridandtypearry = $this->get_usertype_and_id();
        $type=$useridandtypearry['type'];
        $id=$useridandtypearry['id'];

        if ($request->ids != "null" and !empty($request->fav_ids) ) {
            $json_encoded = json_decode($request->fav_ids, true);
            foreach ($json_encoded as $je) {
               
    
                $this->store_fav_item_to_db($je);
            }
        }
        if ($request->rm_ids != "null" and !empty($request->fav_rm_ids)) {
            $json_encoded_rm = json_decode($request->fav_rm_ids, true);
            foreach ($json_encoded_rm as $jerm) {
             
    
                $this->remove_fav_item_to_db($jerm);
            }
        }
       
       
        $getfavdata = FavouriteItem::select('fav_id')->where('user_id', $id)->where('type',$type)->get();


        return response()->json(['success' => true, 'data' => $getfavdata]);
    }
    public function remove_fav_item_to_db($data): string
    {


        $useridandtypearry = $this->get_usertype_and_id();
        $data['user_id'] = $useridandtypearry['id'];
        $data['type'] = $useridandtypearry['type'];


        $deletefav = FavouriteItem::where([['user_id', '=', $data['user_id']], ['type', '=', $data['type']], ['fav_id', '=', $data['fav_id']]])->delete();

        return 'done';
    }
    public function get_usertype_and_id(): array
    {
        if (Auth::guard('shop_owners_and_staffs')->check()) {
            $type = 'shop_owners';
            $id = Auth::guard('shop_owners_and_staffs')->user()->id;
        } else {
            $type = 'user';
            $id = Auth::guard('web')->user()->id;
        }
        return ['type' => $type, 'id' => $id];
    }
    public function store_fav_item_to_db($data): string
    {
        $useridandtypearry = $this->get_usertype_and_id();
        $data['user_id'] = $useridandtypearry['id'];
        $data['type'] = $useridandtypearry['type'];



        $updateorcreate = FavouriteItem::updateOrCreate($data);
        return 'done';
   
    }
    public function check(Request $request): JsonResponse
    {
        $data = $request->all();


        if (Auth::guard('shop_owners_and_staffs')->check()) {
            $data['type'] = 'shop_owners';
            $data['user_id'] = Auth::guard('shop_owners_and_staffs')->user()->id;
        } else {
            $data['type'] = 'user';
            $data['user_id'] = Auth::guard('web')->user()->id;
        }

        $check = FavouriteItem::where([['user_id', '=', $data['user_id']], ['type', '=', $data['type']], ['fav_id', '=', $data['fav_id']]])->first();
        if (!empty($check)) {
            return response()->json(['success' => true, 'data' => true]);
        } else {
            return response()->json(['success' => false, 'data' => false]);
        }
    }
}
