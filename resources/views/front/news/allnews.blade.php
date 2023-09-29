@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')
    @include('front.news.news_menu')

    @push('css')
        <style>
            #mainDiv {
                color: black !important;
                position: relative;
            }
            #borderBottom {
                border-bottom: 2px solid black;
                padding: 2px;
                position: absolute;
                top: 100%;
                right: 35%;
                left: 0;
            }
            .description{
                font-size: 13px;
            }

            .all-news-title{
                font-size: 24px;
            }
            .all-news-title:hover{
                color: #780116;
            }
            .all-news-image{
                cursor: pointer;
                overflow: hidden;
            }
            .all-news-image img{
                transition: 0.5s ease-out;
            }
            .all-news-image img:hover{
                transform: scale(1.2);
            }


        </style>
    @endpush

    <div class="container-fluid mt-5 p-3">
        <div class="row gx-3 px-2">
            <div class="col-lg-2 col-sm-2 mb-2 d-lg-block d-none">
                <ul class="d-flex flex-column list-unstyled">
                    <li class="mb-2 px-5">
                        <a id="mainDiv" href="news">
                            <span id="borderBottom"></span>
                            News
                        </a>
                    </li>
              
                    <li class="mb-2 mt-3 px-5">
                        <a href="events">Events</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-10 mb-4">
                <div class="row">
                    @forelse ($news as $n)
                        <div class="col-md-4 mb-3">
                            <div class="all-news-image">
                                <a href="{{ route('news.detail',$n->id)}}">
                                    @if(dofile_exists('/news_&_events/news/' . $n->image))
                                    <img class="w-100" src="{{ filedopath('/news_&_events/news/' . $n->image)}}" alt=""
                                     style="height: 200px;">
                                     @else
                                     <img class="w-100" src="{{ url('/images/news_&_events/news/' . $n->image)}}" alt=""
                                     style="height: 200px;">
                                     @endif
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('news.detail',$n->id)}}">
                                    <h6 class="mt-3 text-black mb-2 all-news-title">{{ Str::words($n->title ,10) }}</h6>
                                </a>
                                <p class="mb-3 mt-2 d-none"><span><i
                                            class="fa-solid fa-calendar-days"></i></span> {{ $n->created_at->format('d M Y')}}
                                </p>
                                <p class="description text-black-50">{{ Str::words($n->description ,10)}}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-4 mb-3">

                        </div>
                    @endforelse
                </div>
                <br>
                <br>
                <br>

            </div>
        </div>
    </div>
    @include('layouts.frontend.allpart.footer')
    @include('layouts.frontend.allpart.mobile_footer')

@endsection
