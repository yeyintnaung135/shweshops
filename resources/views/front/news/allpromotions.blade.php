@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')
    @include('front.news.news_menu')

    <div class="container-fluid mt-5 p-3">
        <div class="row gx-3 px-2">
            <div class="col-lg-2 col-sm-2 mb-4 d-lg-block d-none">
                <ul class="d-flex flex-column list-unstyled">
                    <li class="text-black mb-2">
                        <a class="btn" href="news">News</a>
                    </li>
                    <li class="text-black mb-2">
                        <a class="btn btn-primary text-white" href="promotions">Promotions</a>
                    </li>
                    <li class="text-black mb-2">
                        <a class="btn" href="events">Events</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-10">
                <div class="row">
                    @forelse ($promotions as $p )
                        <div class="col-md-4 mb-3">
                            <div><img class="w-100" src="{{ asset('images/news_&_events/promotion/'.$p->photo)}}"
                                      alt="Promotion Image" style="height: 200px;">
                            </div>
                            <div>
                                <a href="promotion/detail">
                                    <h5 class="mt-3 text-black">{{ $p->title }}</h5>
                                </a>
                                <p class="mb-3 mt-2 d-none"><span><i class="fa-solid fa-calendar-days"></i></span> 15 July
                                    2022</p>
                                <p>{{ Str::words($p->description, 10)}}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-4 mb-3">
                            <span>No Data found</span>
                        </div>
                    @endforelse
                </div>
                <div class="row">
                    <div class="sn-upcoming-events col-md-auto mx-auto my-3">
                        <a class="sn-news-button">Load More</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('layouts.frontend.allpart.footer')
    @include('layouts.frontend.allpart.mobile_footer')
@endsection
