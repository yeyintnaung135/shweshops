<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Facade\Repair;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Event\StoreEventRequest;
use App\Http\Requests\SuperAdmin\Event\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Trait\YKImage;
class EventsController extends Controller
{
    use YKImage;
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $events = Event::latest()->paginate(5);
        return view('backend.super_admin.news_&_events.events.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $file = $request->file('file_upload');
        $dir = "news_&_events/event/";
        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $statictimestamp = Carbon::now()->timestamp;

        $imageName = strtolower($statictimestamp . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension());

        $this->save_image($file, $imageName,$dir);
        $event->photo=$imageName;
        $event->save();
        // $event->shop_id = $request->shop_id;
        // $event->slug = Str::slug($request->title) . "-" . uniqid();

        return redirect()->back()->with('success', 'Events Create Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $events = Event::where('shop_id', 0)->latest()->paginate(5);
        $event = Event::findOrFail($id);
        return view('backend.super_admin.news_&_events.events.edit', compact('event', 'events'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, $id): RedirectResponse
    {
        $file = $request->file('file_upload');
        $dir = "news_&_events/event/";
        $event = Event::findOrFail($id);
        $event->title = $request->title;
        $event->description = $request->description;
        if ($request->hasFile('file_upload')) {
            $this->delete_image($dir . $event->photo);

            $statictimestamp = Carbon::now()->timestamp;

            // $news->slug = Str::slug($request->title) . '-' . uniqid();
            $imageName = strtolower($statictimestamp . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension());
    
            $this->save_image($request->file('file_upload'), $imageName,$dir);
            $event->photo = $imageName;
        }
        $event->update();

        // $event->shop_id = $request->shop_id;

        return redirect()->back()->with('success', 'Events Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $dir = "news_&_events/event/";

        $event=Event::findOrFail($id);

        $this->delete_image($dir . $event->photo);
        $event->delete();
        return redirect('backside/super_admin/events/create')->with('success', 'Event Delete Successfully');
    }
}
