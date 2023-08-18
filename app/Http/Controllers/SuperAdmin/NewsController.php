<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Facade\Repair;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\News\StoreNewsRequest;
use App\Http\Requests\SuperAdmin\News\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function create(): View
    {
        $news_all = News::where('shop_id', 0)->latest()->paginate(5);
        return view('backend.super_admin.news_&_events.news.create', compact('news_all'));
    }

    public function store(StoreNewsRequest $request): RedirectResponse
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

    public function edit($id): View
    {
        $news = News::findOrFail($id);
        $news_all = News::where('shop_id', 0)->latest()->paginate(5);
        return view('backend.super_admin.news_&_events.news.edit', compact('news', 'news_all'));
    }

    public function update(UpdateNewsRequest $request, $id): RedirectResponse
    {
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
    public function destroy($id): RedirectResponse
    {
        News::findOrFail($id)->delete();
        return redirect('backside/super_admin/news/create')->with('success', 'News Delete Successfully');
    }
}
