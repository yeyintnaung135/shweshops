<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
        $productdata=Item::where('id',$id)->first();
        $check=Orders::where('product_id',$id)->where('status','prepare')->where('user_id',Auth::guard('web')->user()->id)->first();

        return view('front.orderform',['product_data'=>$productdata,'order_data'=>$check]);
    }
    public function create(Request $request){
        $input=$request->except('_token');
        $input['user_id']=Auth::guard('web')->user()->id;
        $input['status']='prepare';

        $productdata=Item::where('id',$request->product_id)->first();
        $check=Orders::where('product_id',$input['product_id'])->where('status','prepare')->where('user_id',$input['user_id']);
        if(!empty($check->first())){
         $check->delete();
        }
        Orders::create($input);
        return view('front.reviewform',['product_data'=>$productdata,'order_data'=>$check->first()]);
    }
    public function confirm(Request $request){
        Orders::where('id',$request->order_id)->where('status','prepare')->where('user_id',Auth::guard('web')->user()->id)->update(['status'=>'pending']);
        return view('front.successform');
    }
}
