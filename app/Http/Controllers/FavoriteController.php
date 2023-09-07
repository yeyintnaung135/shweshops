<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\FavoriteItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FavoriteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function action_favorite(Request $request)
    {
        $input=$request->except(['action']);
        $validator = Validator::make($request->all(), [
            'fav_id' => ['required', 'numeric'],'action'=>[Rule::in(['add','remove'])]
        ]);
        if($validator->fails()){
            return response()->json(['success'=>false,'data'=>$validator->errors()]);
        }
        if($request->action == 'add'){
           return $this->store_fav_item_to_db($input);
        }
        if($request->action == 'remove'){
            return $this->remove_fav_item_to_db($input);
         }
         
    }
    public function remove_fav_item_to_db($data):JsonResponse
    {
      
       
        if(Auth::guard('shop_owners_and_staffs')->check()){
          $data['type']='shop_owners';
          $data['user_id']=Auth::guard('shop_owners_and_staffs')->user()->id;
        }else{
            $data['type']='user';
            $data['user_id']=Auth::guard('web')->user()->id;
        }

        $deletefav=FavoriteItems::where([['user_id','=',$data['user_id']],['type','=',$data['type']],['fav_id','=',$data['fav_id']]])->delete();
        $getfavdata=FavoriteItems::select('fav_id')->where('user_id',$data['user_id'])->get();

        return response()->json(['success'=>true,'data'=>$getfavdata]);
    }
    public function store_fav_item_to_db($data):JsonResponse
    {
      
       
        if(Auth::guard('shop_owners_and_staffs')->check()){
          $data['type']='shop_owners';
          $data['user_id']=Auth::guard('shop_owners_and_staffs')->user()->id;
        }else{
            $data['type']='user';
            $data['user_id']=Auth::guard('web')->user()->id;
        }

        $updateorcreate=FavoriteItems::updateOrCreate($data);
        $getfavdata=FavoriteItems::select('fav_id')->where('user_id',$data['user_id'])->get();

        return response()->json(['success'=>true,'data'=>$getfavdata]);
    }
    public function check(Request $request):JsonResponse
    {
        $data=$request->all();
      
       
        if(Auth::guard('shop_owners_and_staffs')->check()){
          $data['type']='shop_owners';
          $data['user_id']=Auth::guard('shop_owners_and_staffs')->user()->id;
        }else{
            $data['type']='user';
            $data['user_id']=Auth::guard('web')->user()->id;
        }

        $check=FavoriteItems::where([['user_id','=',$data['user_id']],['type','=',$data['type']],['fav_id','=',$data['fav_id']]])->first();
        if(!empty($check)){
            return response()->json(['success'=>true,'data'=>true]);

        }else{
            return response()->json(['success'=>false,'data'=>false]);

        }


    }
}
