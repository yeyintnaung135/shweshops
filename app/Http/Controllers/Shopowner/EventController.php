<?php

namespace App\Http\Controllers\Shopowner;

use App\Services\ImageService;
use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Controllers\traid\ykimage;
use App\Http\Requests\ShopOwner\StoreEventRequest;
use App\Http\Requests\ShopOwner\UpdateEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\traid\ShopTrait;
use Illuminate\Support\Str;

class EventController extends Controller
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
        return view('backend.shopowner.event.index');
    }

    public function create()
    {
        return view('backend.shopowner.event.create');
    }

    public function store(StoreEventRequest $request)
    {
        $baseDirectory = 'shop_owner';
        $subDirectory = 'events';
        if (env('USE_DO') != 'true') {
            $fileName = $this->imageService->saveImage(
                $request->file('photo'),
                "{$baseDirectory}/{$subDirectory}"
            );
            $this->resizeImages($baseDirectory, $subDirectory, $fileName);
        } else {
            $directory = "prod/{$baseDirectory}/{$subDirectory}/";
            $fileName = $this->imageService->saveImageDigitalOcean($request->file('photo'), $directory);
            $this->resizeImagesDigitalOcean($baseDirectory, $subDirectory, $fileName);
        }

        Event::create([
            'shop_id' => $this->getShopId(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'photo' => $fileName,
        ]);

        return redirect()->route('backside.shop_owner.events.index')
            ->with('message', 'Your event was successfully created');
    }

    public function edit(Event $event)
    {
        return view('backend.shopowner.event.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $image = $event->photo;
        $baseDirectory = 'shop_owner';
        $subDirectory = 'events';

        if (env('USE_DO') != 'true' && $request->hasFile('photo')) {
            $newImage = $this->imageService->saveImage(
                $request->file('photo'),
                "{$baseDirectory}/{$subDirectory}"
            );

            if ($newImage !== $event->image) {
                $this->imageService->deleteImage(
                    "{$baseDirectory}/{$subDirectory}/{$event->photo}",
                    "{$baseDirectory}/{$subDirectory}/thumbs/{$event->photo}"
                );
            }

            $this->resizeImages($baseDirectory, $subDirectory, $newImage);
            $image = $newImage;
        } elseif (env('USE_DO') == 'true' && $request->hasFile('photo')) {
            $directory = "prod/{$baseDirectory}/{$subDirectory}/";
            $newImage = $this->imageService->saveImageDigitalOcean($request->file('photo'), $directory);

            if ($newImage !== $event->photo) {
                $this->imageService->deleteImageDigitalOcean(
                    "{$directory}{$event->photo}",
                    "{$directory}thumbs/{$event->photo}"
                );
                $this->resizeImagesDigitalOcean($baseDirectory, $subDirectory, $newImage);
            }

            $image = $newImage;
        }

        $event->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'photo' => $image,
        ]);

        return redirect()->route('backside.shop_owner.events.index')
            ->with('message', 'Your event was successfully updated');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        $baseDirectory = 'shop_owner';
        $subDirectory = 'events';

        if (env('USE_DO') != 'true' && $event->photo) {
            $this->imageService->deleteImage("{$baseDirectory}/{$subDirectory}/{$event->photo}", "{$baseDirectory}/{$subDirectory}/thumbs/{$event->photo}");
        } elseif (env('USE_DO') == 'true' && $event->photo) {
            $directory = "prod/{$baseDirectory}/{$subDirectory}/";

            $this->imageService->deleteImageDigitalOcean(
                "{$directory}{$event->photo}",
                "{$directory}thumbs/{$event->photo}"
            );
        }

        return redirect()->route('backside.shop_owner.events.index')->with('message', 'event deleted successfully.');
    }

    public function getEvents(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $events = Event::where('shop_id', $this->getShopId())
            ->select('id', 'title', 'description', 'photo')
            ->when($fromDate, fn ($query) => $query->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn ($query) => $query->whereDate('created_at', '<=', $toDate));

        return datatables($events)
            ->addColumn('description', function ($news) {
                return Str::limit($news->description, 80, '...');
            })
            ->addColumn('actions', function ($events) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.events.edit', $events->id),
                    'delete_url' => route('backside.shop_owner.events.destroy',  $events->id)
                ];

                return $urls;
            })
            ->toJson();
    }
}
