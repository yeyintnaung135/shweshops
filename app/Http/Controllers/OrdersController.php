<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

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
}
