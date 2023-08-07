<?php

namespace App\Http\Controllers;

use App\Models\Catsupport;
use App\Models\Support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupportFrontController extends Controller
{
    //
    public function support(){
        $data=Support::where('for_what','for_user')->limit(6)->get();
        $cats=Catsupport::all();
        return view('front.support.support',['data'=>$data,'cats'=>$cats]);
    }
    public function get_support(Request $request){
        if($request->filtertype['cat_id']==0 or $request->filtertype['cat_id']==1 ){
            $data=Support::where('for_what','for_user')->skip($request->filtertype['limit'])->take('6')->get();

        }else{
            $catid=$request->filtertype['cat_id'];
            $data=Support::where('for_what','for_user')->where('cat_id',$catid)->skip($request->filtertype['limit'])->take('6')->get();

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
            $data=Support::where('for_what','for_user')->skip($request->filtertype['limit'])->take('6')->get();

        }else{
            $catid=$request->filtertype['cat_id'];
            $data=Support::where('for_what','for_user')->where('cat_id',$catid)->skip($request->filtertype['limit'])->take('6')->get();

        }
        if (count($data) < 6) {
            $empty_on_server = 1;
        } else {
            $empty_on_server = 0;
        }
        return response()->json(['shops' => $data, 'count' => count($data), 'empty_on_server' => $empty_on_server]);
    }
}
