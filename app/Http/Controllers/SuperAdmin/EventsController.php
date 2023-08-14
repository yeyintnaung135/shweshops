<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Facade\Repair;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Events\StoreEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
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
        $events = Event::where('shop_id', 0)->latest()->paginate(5);
        return view('backend.super_admin.news_&_events.events.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        $file = $request->file('file_upload');
        $dir = "images/news_&_events/event";
        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->photo = Repair::fileStore($file, $dir);

        $event->save();
        // $event->shop_id = $request->shop_id;
        // $event->slug = Str::slug($request->title) . "-" . uniqid();

        return redirect()->back()->with('success', 'Events Create Successfully');
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'file_upload' => 'mimes:jpeg,bmp,png,jpg',
        ]);

        $file = $request->file('file_upload');
        $dir = "images/news_&_events/event";
        $event = Event::findOrFail($id);
        $event->title = $request->title;
        $event->description = $request->description;
        if ($request->hasFile('file_upload')) {
            $event->photo = Repair::fileStore($file, $dir);
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
    public function destroy($id)
    {
        Event::findOrFail($id)->delete();
        return redirect('backside/super_admin/events/create')->with('success', 'Event Delete Successfully');
    }
}
