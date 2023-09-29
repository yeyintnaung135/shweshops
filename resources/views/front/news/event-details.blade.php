@extends('layouts.frontend.frontend')
@section('content')
@push('css')
<style>

    .more-events-title{
        font-size: 20px;
    }
    .more-events-title:hover{
        color: #780116;
    }
</style>

@endpush

    @include('layouts.frontend.allpart.for_mobile')
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')

    <div id="page" class="site my-0 py-0">


        {{--Loading Wrapper--}}
        {{--        @include('layouts.frontend.allpart.loading_wrapper')--}}

        {{-- Loading--}}

        <div class="container-fluid px-lg-5 px-md-1 mt-4 sop-font">
            <div class="row pb-5 pb-md-0">
                <div class="col-lg-8 col-md-12">
                    <div class="sn-main-promo">
                     
                        @if(dofile_exists('/news_&_events/event/' . $event->photo))
                        <img class="w-100" src="{{ filedopath('/news_&_events/event/' . $event->photo)}}" alt=""
                         >
                         @else
                         <img class="w-100" src="{{ url('/images/news_&_events/event/' . $event->photo)}}" alt=""
                         >
                         @endif      
                        <h3 class="sn-main-promo-title">{{ $event->title }}</h3>
                        <p class="mb-3 mt-2"><span><i class="fa-solid fa-calendar-days"></i></span> {{ $event->created_at->format('d M Y')}}</p>
                        <p class="sn-main-promo-desc">{{ $event->description }}</p>
                        {{--<div class="sn-main-promo-period"><i class="fa-solid fa-calendar-alt"></i> Promotion Period : 7
                            June to 15 June
                        </div>--}}
                    </div>
                  
                    <div class="d-lg-block" id="eventsPanel">
                
                    </div>
                    {{-- </div> --}}
                </div>
                <div class="col-lg-4 col-md-12" id="newsPanel">
                    <div class="sn-latest-news">
                        {{--<h2 class="sn-latest-news-title"><a href="http://" class="d-flex"><span class="flex-grow-1">More News</span><i
                                    class="fa-solid fa-long-arrow-alt-right"></i></a></h2>--}}
                        <h2 class="sn-latest-news-title">More Events</h2>
                        @forelse ($other_events as $e)
                        <div class="mb-5">
                            @if($premium == "Yes")
                                <a href="{{route('pEvents.detail',['id'=> $e->id , 'shopid' => $e->shop_id])}}" target="_blank" rel="noopener noreferrer">
                                    <img class="w-100" src="{{ filedopath('/shop_owner/events/' . $e->photo)}}" alt="">
                                    <h6 class="mt-3 text-black  more-events-title">{{ $e->title }}</h6>
                                </a>
                            @else
                                <a href="{{route('events.detail',$e->id)}}" target="_blank" rel="noopener noreferrer">
                                    @if(dofile_exists('/news_&_events/events/' . $e->photo))
                                    <img class="w-100" src="{{ filedopath('/news_&_events/event/' . $e->photo)}}" alt=""
                                     >
                                     @else
                                     <img class="w-100" src="{{ url('/images/news_&_events/event/' . $e->photo)}}" alt=""
                                     >
                                     @endif   
                                                                         <h6 class="mt-3 text-black  more-events-title">{{ $e->title }}</h6>
                                </a>
                            @endif
                            <p class="mb-3 mt-2"><span><i class="fa-solid fa-calendar-days"></i></span> {{ $e->created_at->format('d M Y')}}</p>
                            {{--                  <a class="sn-latest-news-sub">Up to 70% off sale</a>--}}
                            <p>{{ Str::words($e->description , 5)}}</p>
                        </div>
                        @empty
                        <div class="mb-5">
                            <span>No Data Found</span>
                        </div>
                        @endforelse

                        {{--                <div class="mb-5">--}}
                        {{--                  <img class="" src="{{ asset('images/news/62ab47867b0f7.png')}}" alt="">--}}
                        {{--                  <a class="sn-latest-news-sub">Up to 70% off sale</a>--}}
                        {{--                  <p>Lorem ipsum dolor sit amet. At suscipit voluptatem ut quod libero ea tenetur modi. Ut molestias sapiente ab harum illum quo voluptatem ...</p>--}}
                        {{--                </div>--}}
                        @if($premium == "Yes")
                            <a class="sn-latest-news-button float" href="/all_events/{{$event->shop_id}}">More News</a>
                        @else
                            <a class="sn-latest-news-button float" href="/events">More News</a>
                        @endif
                    </div>
                    {{-- <div class="sn-ads-img">
                      <img class="" src="{{ asset('images/news/62ab47867b0f7.png')}}" alt="">
                    </div> --}}
                    {{--<div class="sn-top-stories mb-sm-5">
                        <h2 class="sn-top-stories-title"><a href="http://" class="d-flex"><span class="flex-grow-1">Top Stories</span><i
                                    class="fa-solid fa-long-arrow-alt-right"></i></a></h2>
                        <div>
                            <a href="#" class="sn-top-stories-sub">Lorem ipsum dolor sit amet</a>
                            <p>Lorem ipsum dolor sit amet. At suscipit voluptatem ut quod libero ea tenetur modi...</p>
                        </div>
                        <div>
                            <a href="#" class="sn-top-stories-sub">Lorem ipsum dolor sit amet</a>
                            <p>Lorem ipsum dolor sit amet. At suscipit voluptatem ut quod libero ea tenetur modi...</p>
                        </div>
                        <div>
                            <a href="#" class="sn-top-stories-sub">Lorem ipsum dolor sit amet</a>
                            <p>Lorem ipsum dolor sit amet. At suscipit voluptatem ut quod libero ea tenetur modi...</p>
                        </div>
                        <a class="sn-top-stories-button float d-md-none">More News</a>
                    </div>--}}
                </div>

            </div>
        </div>
        {{--  --}}
        <script>
            function showEventsPanel() {
                document.getElementById("eventsPanel").classList.remove("d-none");
                document.getElementById("newsPanel").classList.add("d-none");
            }

            function showNewsPanel() {
                document.getElementById("newsPanel").classList.remove("d-none");
                document.getElementById("eventsPanel").classList.add("d-none");
            }
        </script>
        {{--<!-- #content -->--}}

        @include('layouts.frontend.allpart.footer')
    </div>

    {{--    <!-- .site-content-contain -->--}}


    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('shwe_news/js/app.js')}}"></script>
@endpush
