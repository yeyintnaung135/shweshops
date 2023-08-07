<?php

namespace App\Http\Controllers\Shopowner;

use App\Services\ImageService;
use App\News;
use App\Http\Controllers\Controller;
use App\Http\Controllers\traid\ykimage;
use App\Http\Requests\ShopOwner\StoreNewsRequest;
use App\Http\Requests\ShopOwner\UpdateNewsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\traid\ShopTrait;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    use ykimage;
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

    public function index()
    {
        return view('backend.shopowner.news.index');
    }

    public function create()
    {
        return view('backend.shopowner.news.create');
    }

    public function store(StoreNewsRequest $request)
    {
        $baseDirectory = 'shop_owner';
        $subDirectory = 'news';
        if (env('USE_DO') != 'true') {
            $fileName = $this->imageService->saveImage(
                $request->file('image'),
                "{$baseDirectory}/{$subDirectory}"
            );
            $this->resizeImages($baseDirectory, $subDirectory, $fileName);
        } else {
            $directory = "prod/{$baseDirectory}/{$subDirectory}/";
            $fileName = $this->imageService->saveImageDigitalOcean($request->file('image'), $directory);
            $this->resizeImagesDigitalOcean($baseDirectory, $subDirectory, $fileName);
        }

        News::create([
            'shop_id' => $this->getShopId(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $fileName,
        ]);

        return redirect()->route('backside.shop_owner.news.index')
            ->with('message', 'Your news was successfully created');
    }

    public function edit(News $news)
    {
        return view('backend.shopowner.news.edit', compact('news'));
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $image = $news->image;
        $baseDirectory = 'shop_owner';
        $subDirectory = 'news';

        if (env('USE_DO') != 'true' && $request->hasFile('image')) {
            $newImage = $this->imageService->saveImage(
                $request->file('image'),
                "{$baseDirectory}/{$subDirectory}"
            );

            if ($newImage !== $news->image) {
                $this->imageService->deleteImage(
                    "{$baseDirectory}/{$subDirectory}/{$news->image}",
                    "{$baseDirectory}/{$subDirectory}/thumbs/{$news->image}"
                );
            }

            $this->resizeImages($baseDirectory, $subDirectory, $newImage);
            $image = $newImage;
        } elseif (env('USE_DO') == 'true' && $request->hasFile('image')) {
            $directory = "prod/{$baseDirectory}/{$subDirectory}/";
            $newImage = $this->imageService->saveImageDigitalOcean($request->file('image'), $directory);

            if ($newImage !== $news->image) {
                $this->imageService->deleteImageDigitalOcean(
                    "{$directory}{$news->image}",
                    "{$directory}thumbs/{$news->image}"
                );
                $this->resizeImagesDigitalOcean($baseDirectory, $subDirectory, $newImage);
            }

            $image = $newImage;
        }

        $news->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $image,
        ]);

        return redirect()->route('backside.shop_owner.news.index')
            ->with('message', 'Your news was successfully updated');
    }

    public function destroy(News $news)
    {
        $news->delete();
        $baseDirectory = 'shop_owner';
        $subDirectory = 'news';
        if (env('USE_DO') != 'true' && $news->image) {
            $this->imageService->deleteImage("{$baseDirectory}/{$subDirectory}/{$news->image}", "{$baseDirectory}/{$subDirectory}/thumbs/{$news->image}");
        } elseif (env('USE_DO') == 'true' && $news->image) {
            $directory = "prod/{$baseDirectory}/{$subDirectory}/";

            $this->imageService->deleteImageDigitalOcean(
                "{$directory}{$news->image}",
                "{$directory}thumbs/{$news->image}"
            );
        }

        return redirect()->route('backside.shop_owner.news.index')->with('message', 'News deleted successfully.');
    }

    public function getAllNews(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $allNews = News::where('shop_id', $this->getShopId())
            ->select('id', 'title', 'description', 'image')
            ->when($fromDate, fn ($query) => $query->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn ($query) => $query->whereDate('created_at', '<=', $toDate));

        return datatables($allNews)
            ->addColumn('description', function ($news) {
                return Str::limit($news->description, 80, '...');
            })
            ->addColumn('actions', function ($news) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.news.edit', $news->id),
                    'delete_url' => route('backside.shop_owner.news.destroy',  $news->id)
                ];

                return $urls;
            })
            ->toJson();
    }
}
