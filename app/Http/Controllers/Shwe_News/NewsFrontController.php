<?php

namespace App\Http\Controllers\Shwe_News;

use App\Models\News;
use App\Models\Event;
use App\Models\Promotions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class NewsFrontController extends Controller
{
    public function index()
    {

        $latest_news = News::latest()->first();
        if (!empty($latest_news)) {
            $news = News::where('id', '<>', $latest_news->id)->latest()->paginate(3);
        } else {
            $news = News::get();
        }
        $promotions = Promotions::orderBy('id', 'DESC')->paginate(4);
        $events = Event::latest()->paginate(3);
        return view('front.news.news', [
            'latestNews' => $latest_news,
            'promotions' => $promotions,
            'events' => $events,
            'news' => $news
        ]);
    }

    public function allNews()
    {
        $news = News::orderBy('id', 'desc')->get();
        return view('front.news.allnews', compact('news'));
    }
    public function pAllNews($shopid)
    {
        $news = News::where('shop_id', $shopid)->orderBy('id', 'desc')->get();
        return view('front.news.allnews', compact('news'));
    }

    public function allPromotions()
    {
        $promotions = Promotions::all();
        return view('front.news.allpromotions', compact('promotions'));
    }
    public function allEvents()
    {
        $events = Event::orderBy('id', 'desc')->get();
        return view('front.news.allevents', compact('events'));
    }

    public function pAllEvents($shopid)
    {
        $events = Event::where('shop_id', $shopid)->orderBy('id', 'desc')->get();
        return view('front.news.allevents', compact('events'));
    }

    public function NewsDetail($id){
        $news = News::where('id', $id)->first();
        if (empty($news)) {
            return abort(404);
        }
        $other_news = News::where('shop_id', 0)->where('id', '<>', $news->id)->latest()->paginate(2);
        $premium = "No";
        return view('front.news.news-details', compact('news', 'other_news', 'premium'));
    }

    public function pNewsDetail($id, $shopid){
        $news = News::where('shop_id', $shopid)->where('id', $id)->first();
        if (empty($news)) {
            return abort(404);
        }
        $other_news = News::where('shop_id', $shopid)->where('id', '<>', $news->id)->latest()->paginate(2);
        $premium = "Yes";
        return view('front.news.news-details', compact('news', 'other_news', 'premium'));
    }

    public function EventDetail($id)
    {
        $event = Event::where('id', $id)->first();
        if (empty($event)) {
            return abort(404);
        }
        $other_events = Event::where('shop_id', 0)->where('id', '<>', $event->id)->latest()->paginate(2);
        $premium = "No";
        return view('front.news.event-details', compact('event', 'other_events', 'premium'));
    }

    public function pEventDetail($id, $shopid)
    {
        $event = Event::where('shop_id', $shopid)->where('id', $id)->first();
        if (empty($event)) {
            return abort(404);
        }
        $other_events = Event::where('shop_id', $shopid)->where('id', '<>', $event->id)->latest()->paginate(2);
        $premium = "Yes";
        return view('front.news.event_details', compact('event', 'other_events', 'premium'));
    }

    public function PromotionDetail($id)
    {
        $promotion = Promotions::where('id', $id)->first();
        if (empty($promotion)) {
            return abort(404);
        }
        $other_promotions = Promotions::whereNotIn('id', [$promotion->id])->latest()->paginate(2);
        return view('front.news.promo-details', compact('promotion', 'other_promotions'));
    }
}
