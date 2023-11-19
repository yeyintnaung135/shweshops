<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    //
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index($id){
        $productdata=Item::where('id',$id)->first();
        
        return view('front.orderform',['product_data'=>$productdata]);
    }
    public function create(Request $request){
        $input=$request->except('_token');
        $input['user_id']=Auth::guard('web')->user()->id;
        $input['status']='prepare';

        $productdata=Item::where('id',$request->product_id)->first();
        $check=Orders::where('product_id',$input['product_id'])->where('user_id',$input['user_id']);
        if(!empty($check->first())){
         $check->delete();
        }
        Orders::create($input);
        return view('front.revieworder',['product_data'=>$productdata]);
    }
}
