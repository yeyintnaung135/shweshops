<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Facade\Repair;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\News\StoreNewsRequest;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }
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
        $news_all = News::where('shop_id', 0)->latest()->paginate(5);
        return view('backend.super_admin.news_&_events.news.create', compact('news_all'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsRequest $request)
    {
        $file = $request->file('file_upload');
        $dir = "images/news_&_events/news";
        $news = new News();
        $news->title = $request->title;
        // $news->slug = Str::slug($request->title) . '-' . uniqid();
        $news->description = $request->description;
        $news->image = Repair::fileStore($file, $dir);

        $news->save();

        return redirect()->back()->with('success', 'News Create Successfully');
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
        $news = News::findOrFail($id);
        $news_all = News::where('shop_id', 0)->latest()->paginate(5);
        return view('backend.super_admin.news_&_events.news.edit', compact('news', 'news_all'));
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

        $file = $request->file('file_upload');
        $dir = "images/news_&_events/news";
        $news = News::findOrFail($id);
        $news->title = $request->title;
        // $news->slug = Str::slug($request->title) . '-' . uniqid();
        $news->description = $request->description;
        if ($request->hasFile('file_upload')) {
            $news->image = Repair::fileStore($file, $dir);
        }
        $news->update();

        return redirect()->back()->with('success', 'News Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        News::findOrFail($id)->delete();
        return redirect('backside/super_admin/news/create')->with('success', 'News Delete Successfully');
    }
}
