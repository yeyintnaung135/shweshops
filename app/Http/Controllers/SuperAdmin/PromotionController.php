<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Facade\Repair;
use App\Http\Controllers\Controller;
use App\Models\Promotions;
use App\Models\Shops;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PromotionController extends Controller
{
    public function create(): View
    {
        $shopowners = Shops::all();
        $promotions = Promotions::latest()->paginate(5);
        return view('backend.super_admin.news_&_events.promotions.create', compact('shopowners', 'promotions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'file_upload' => 'required|mimes:jpeg,bmp,png,jpg',
        ]);

        $file = $request->file('file_upload');
        $dir = "images/news_&_events/promotion";
        $promotion = new Promotions();
        $promotion->title = $request->title;
        if ($request->slug) {
            $promotion->slug = Str::slug($request->slug);
        } else {
            $promotion->slug = Str::slug($request->title) . "-" . uniqid();
        }
        $promotion->description = $request->description;
        $promotion->photo = Repair::fileStore($file, $dir);
        $promotion->shop_id = $request->shop_id;

        $promotion->save();

        return redirect()->back()->with('success', 'Promotion Create Successfully');
    }

    public function edit($id): View
    {
        $promotion = Promotions::findOrFail($id);
        $shopowners = Shops::all();
        $promotions = Promotions::latest()->paginate(5);
        return view('backend.super_admin.news_&_events.promotions.edit', compact('shopowners', 'promotion', 'promotions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'file_upload' => 'required|mimes:jpeg,bmp,png,jpg',
        ]);

        $file = $request->file('file_upload');
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
        if ($request->hasFile('file_upload')) {
            $promotion->photo = Repair::fileStore($file, $dir);
        }
        $promotion->update();

        return redirect()->back()->with('success', 'Promotion Update Successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Promotions::findOrFail($id)->delete();
        return redirect('backside/super_admin/promotion/create')->with('success', 'Promotion Delete Successfully');
    }
}
