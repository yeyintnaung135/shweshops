<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\ShopTrait;
use App\Http\Controllers\Trait\YKImage;
use App\Http\Requests\ShopOwner\StoreEventRequest;
use App\Http\Requests\ShopOwner\UpdateEventRequest;
use App\Models\Event;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class EventController extends Controller
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
        return view('backend.shopowner.event.index');
    }

    public function create(): View
    {
        return view('backend.shopowner.event.create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {

        $file = $request->file('photo');
        $dir = "news_&_events/event/";

        $statictimestamp = Carbon::now()->timestamp;

        // $news->slug = Str::slug($request->title) . '-' . uniqid();
        $imageName = strtolower($statictimestamp . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension());
        $this->save_image($file, $imageName, $dir);

        Event::create([
            'shop_id' => $this->get_shop_id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'photo' => $imageName,
        ]);

        return redirect()->route('backside.shop_owner.events.index')
            ->with('message', 'Your event was successfully created');
    }

    public function edit(Event $event): View
    {
        return view('backend.shopowner.event.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $image = $event->photo;

        $dir = "news_&_events/event/";

        $file = $request->file('photo');

        if ($request->hasFile('photo')) {
            $this->delete_image($dir . $event->photo);

            $statictimestamp = Carbon::now()->timestamp;

            // $news->slug = Str::slug($request->title) . '-' . uniqid();
            $imageName = strtolower($statictimestamp . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension());

            $this->save_image($request->file('photo'), $imageName, $dir);
            $event->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'photo' => $imageName,
            ]);
        } else {
            $event->update([
                'title' => $request->input('title'),
                'description' => $request->input('description')
            ]);
        }


        return redirect()->route('backside.shop_owner.events.index')
            ->with('message', 'Your event was successfully updated');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();
        $dir = "news_&_events/event/";
        $this->delete_image($dir . $event->photo);
        return redirect()->route('backside.shop_owner.events.index')->with('message', 'event deleted successfully.');
    }

    public function get_events(Request $request): JsonResponse
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $events = Event::where('shop_id', $this->get_shop_id())
            ->select('id', 'title', 'description', 'photo', 'created_at')
            ->when($fromDate, fn ($query) => $query->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn ($query) => $query->whereDate('created_at', '<=', $toDate));

        return datatables($events)
            ->addColumn('description', function ($news) {
                return Str::limit($news->description, 80, '...');
            })
            ->addColumn('actions', function ($events) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.events.edit', $events->id),
                    'delete_url' => route('backside.shop_owner.events.destroy', $events->id),
                ];

                return $urls;
            })
            ->editColumn('created_at', fn ($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }
}
