<?php

namespace App\Http\Controllers\super_admin;

use App\Shopowner;
use App\Promotions;
use App\Facade\Repair;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Promise;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shopowners = Shopowner::all();
        $promotions = Promotions::latest()->paginate(5);
        return view('backend.super_admin.news_&_events.promotions.create',compact('shopowners','promotions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'file_upload' => 'required|mimes:jpeg,bmp,png,jpg',
        ]);

        $file =  $request->file('file_upload');
        $dir = "images/news_&_events/promotion";
        $promotion = new Promotions();
        $promotion->title = $request->title;
        if($request->slug){
            $promotion->slug = Str::slug($request->slug);
        }else{
            $promotion->slug = Str::slug($request->title) . "-" . uniqid();
        }
        $promotion->description = $request->description;
        $promotion->photo = Repair::fileStore($file,$dir);
        $promotion->shop_id = $request->shop_id;

        $promotion->save();

       return redirect()->back()->with('success','Promotion Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
        $promotion = Promotions::findOrFail($id);
        $shopowners = Shopowner::all();
        $promotions = Promotions::latest()->paginate(5);
        return view('backend.super_admin.news_&_events.promotions.edit',compact('shopowners','promotion','promotions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'file_upload' => 'mimes:jpeg,bmp,png,jpg',
        ]);

        $file =  $request->file('file_upload');
        $dir = "images/news_&_events/promotion";
        $promotion = Promotions::findOrFail($id);
        $promotion->shop_id = $request->shop_id;
        $promotion->title = $request->title;
        // if($request->slug != $promotion->slug){
        //     $promotion->slug = Str::slug($request->slug);
        // }else{
        //     $promotion->slug = Str::slug($request->title) . "-" . uniqid();
        // }
        $promotion->description = $request->description;
        if($request->hasFile('file_upload')){
            $promotion->photo = Repair::fileStore($file,$dir);
        }
        $promotion->update();

       return redirect()->back()->with('success','Promotion Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Promotions::findOrFail($id)->delete();
        return redirect('backside/super_admin/promotion/create')->with('success','Promotion Delete Successfully');
    }
}
