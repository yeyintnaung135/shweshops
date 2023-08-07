<?php

namespace App\Http\Controllers\Shopowner;
use App\Catsupport;
use App\Http\Controllers\Controller;
use App\Support;
use Illuminate\Http\Request;

class ShopownersupportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:shop_owner,shop_role');
    }
    public function index()
    {
        $data=Support::where('for_what','for_so')->limit(6)->get();
        $cats=Catsupport::all();
        return view('backend.shopowner.support.all',['data'=>$data,'cats'=>$cats]);
    }
    public function get_support(Request $request){
        if($request->filtertype['cat_id']==0 or $request->filtertype['cat_id']==1 ){
            $data=Support::where('for_what','for_so')->skip($request->filtertype['limit'])->take('6')->get();

        }else{
            $catid=$request->filtertype['cat_id'];
            $data=Support::where('for_what','for_so')->where('cat_id',$catid)->skip($request->filtertype['limit'])->take('6')->get();

        }

        if (count($data) < 6) {
            $empty_on_server = 1;
        } else {
            $empty_on_server = 0;
        }
        return response()->json(['shops' => $data, 'count' => count($data), 'empty_on_server' => $empty_on_server]);
    }
    public function get_support_by_cat(Request $request){
        if($request->filtertype['cat_id']==0 or $request->filtertype['cat_id']==1 ){
            $data=Support::where('for_what','for_so')->skip($request->filtertype['limit'])->take('6')->get();

        }else{
            $catid=$request->filtertype['cat_id'];
            $data=Support::where('for_what','for_so')->where('cat_id',$catid)->skip($request->filtertype['limit'])->take('6')->get();

        }
        if (count($data) < 6) {
            $empty_on_server = 1;
        } else {
            $empty_on_server = 0;
        }
        return response()->json(['shops' => $data, 'count' => count($data), 'empty_on_server' => $empty_on_server]);
    }
}
