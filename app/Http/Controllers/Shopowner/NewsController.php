<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\ShopTrait;
use App\Http\Controllers\Trait\YKImage;
use App\Http\Requests\ShopOwner\StoreNewsRequest;
use App\Http\Requests\ShopOwner\UpdateNewsRequest;
use App\Models\News;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class NewsController extends Controller
{
    use YKImage;
    use ShopTrait;
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->middleware(function ($request, $next) {
            abort_if(Gate::none(['access-shop-owner-premium', 'access-shop-role-premium']), 403);
            return $next($request);
        });
    }

    public function index(): View
    {
        return view('backend.shopowner.news.index');
    }

    public function create(): View
    {
        return view('backend.shopowner.news.create');
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
     


        $file = $request->file('image');
        $dir = "news_&_events/news/";
        $news = new News();
        $news->title = $request->title;
        $statictimestamp = Carbon::now()->timestamp;

        // $news->slug = Str::slug($request->title) . '-' . uniqid();
        $news->description = $request->description;
        $imageName = strtolower($statictimestamp . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension());
        $this->save_image($file, $imageName,$dir);


        News::create([
            'shop_id' => $this->get_shop_id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imageName,
        ]);

        return redirect()->route('backside.shop_owner.news.index')
            ->with('message', 'Your news was successfully created');
    }

    public function edit(News $news): View
    {
        return view('backend.shopowner.news.edit', compact('news'));
    }

    public function update(UpdateNewsRequest $request, News $news): RedirectResponse
    {
        $dir = "news_&_events/news/";

        $file = $request->file('image');
     
        if ($request->hasFile('image')) {
            $this->delete_image($dir . $news->image);

            $statictimestamp = Carbon::now()->timestamp;

            // $news->slug = Str::slug($request->title) . '-' . uniqid();
            $imageName = strtolower($statictimestamp . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension());
    
            $this->save_image($request->file('image'), $imageName,$dir);
            $news->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imageName,
            ]);
        }else{
            $news->update([
                'title' => $request->input('title'),
                'description' => $request->input('description')
            ]); 
        }
       

        return redirect()->route('backside.shop_owner.news.index')
            ->with('message', 'Your news was successfully updated');
    }

    public function destroy(News $news): RedirectResponse
    {
        $news->delete();
        $dir = "news_&_events/news/";
        $this->delete_image($dir . $news->image);


        return redirect()->route('backside.shop_owner.news.index')->with('message', 'News deleted successfully.');
    }

    public function get_all_news(Request $request): JsonResponse
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $allNews = News::where('shop_id', $this->get_shop_id())
            ->select('id', 'title', 'description', 'image', 'created_at')
            ->when($fromDate, fn($query) => $query->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn($query) => $query->whereDate('created_at', '<=', $toDate));

        return datatables($allNews)
            ->addColumn('description', function ($news) {
                return Str::limit($news->description, 80, '...');
            })
            ->addColumn('actions', function ($news) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.news.edit', $news->id),
                    'delete_url' => route('backside.shop_owner.news.destroy', $news->id),
                ];

                return $urls;
            })
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }
}
