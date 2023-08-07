@extends('layouts.frontend.frontend')
@section('content')

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
                    <div class="sn-main-promo mb-4">
                        <img class="" src="{{ asset('images/news_&_events/promotion/' . $promotion->photo)}}" alt="">
                        <h3 class="sn-main-promo-title">{{ $promotion->title }}</h3>
                        <p class="mb-3 mt-2"><span><i class="fa-solid fa-calendar-days"></i></span> 15 July
                            2022</p>
                        <p class="sn-main-promo-desc text-black-50">{{ $promotion->description }}</p>
                        <!-- <div class="sn-main-promo-period"><i class="fa-solid fa-calendar-alt"></i> Promotion Period : 7
                            June to 15 June
                        </div> -->
                    </div>
                    {{-- <div class="d-lg-none">
                        <a onclick="showEventsPanel()">Events</a>
                        <a onclick="showNewsPanel()">News</a>
                    </div> --}}
                    <div class="d-lg-block" id="eventsPanel">
                        <!-- <div class="sn-promo">
                            <h2 class="sn-promo-title">Promotions</h2>
                            <ul class="list-unstyled">
                                <li class="d-flex sn-promo-list">
                                    <div><img class="" src="{{ asset('images/news/62ab47867b0f7.png')}}" alt=""></div>
                                    <div>
                                        <a href={{ url('news_and_events/1') }} class="sn-promo-list-title">Up to 70% off
                                            sale</a>
                                        <a href="#" class="sn-promo-list-shop">Lucky Diamonds Myanmar</a>
                                        <p>Lorem ipsum dolor sit amet. At suscipit voluptatem ut quod libero ea tenetur
                                            modi ...</p>
                                    </div>
                                </li>
                                <li class="d-flex sn-promo-list">
                                    <div><img class="" src="{{ asset('images/news/62ab47867b0f7.png')}}" alt=""></div>
                                    <div>
                                        <a href={{ url('news_and_events/1') }} class="sn-promo-list-title">Up to 70% off
                                            sale</a>
                                        <a href="#" class="sn-promo-list-shop">Lucky Diamonds Myanmar</a>
                                        <p>Lorem ipsum dolor sit amet. At suscipit voluptatem ut quod libero ea tenetur
                                            modi ...</p>
                                    </div>
                                </li>
                                <li class="d-flex sn-promo-list mb-0">
                                    <div><img class="" src="{{ asset('images/news/62ab47867b0f7.png')}}" alt=""></div>
                                    <div>
                                        <a href={{ url('news_and_events/1') }} class="sn-promo-list-title">Up to 70% off
                                            sale</a>
                                        <a href="#" class="sn-promo-list-shop">Lucky Diamonds Myanmar</a>
                                        <p>Lorem ipsum dolor sit amet. At suscipit voluptatem ut quod libero ea tenetur
                                            modi ...</p>
                                    </div>
                                </li>
                            </ul>
                            <a class="sn-news-button float">More Promotions</a>
                        </div>
                        <div class="sn-upcoming-events">
                            <h2 class="sn-upcoming-events-title">Up Coming Events</h2>
                            <div>
                                <span class="sn-upcoming-events-date">7.7.2022</span>
                                <a href="#" class="sn-upcoming-events-sub">ShweShops Website Launch Event</a>
                                <p>Lorem ipsum dolor sit amet. At suscipit voluptatem ut quod libero ea tenetur modi. Ut
                                    molestias sapiente ab harum illum quo voluptatem ...</p>
                            </div>
                            <div>
                                <span class="sn-upcoming-events-date">7.7.2022</span>
                                <a href="#" class="sn-upcoming-events-sub">ShweShops Website Launch Event</a>
                                <p>Lorem ipsum dolor sit amet. At suscipit voluptatem ut quod libero ea tenetur modi. Ut
                                    molestias sapiente ab harum illum quo voluptatem ...</p>
                            </div>
                            <a class="sn-news-button float">More Events</a>
                        </div> -->
                    </div>
                    {{-- </div> --}}
                </div>
                <div class="col-lg-4 col-md-12" id="newsPanel">
                    <div class="sn-latest-news">
                        <h2 class="sn-latest-news-title">More Promotions</h2>
                        @forelse ($other_promotions as $p )
                        <div class="mb-5">
                            <img class="w-100" src="{{ asset('images/news_&_events/promotion/' . $p->photo)}}" alt="">
                            <a href="{{route('promotions.detail',$p->slug)}}">
                              <h4 class="mt-3 font-weight-bolder sn-sub-title">{{ $p->title }}</h4>
                            </a>
                            <p class="mb-3 mt-2"><span><i class="fa-solid fa-calendar-days"></i></span> {{ $p->created_at->format('d M Y')}}</p>
                            
                            <p class="text-black-50">{{ Str::words($p->description,20) }}</p>
                        </div>
                       
                        @empty
                            <div class="w-100  text-center p-3"><span>No Data Found</span></div>
                        @endforelse
                        <a href="/promotions" class="sn-latest-news-button float">Load More</a>
                    </div>
                    {{-- <div class="sn-ads-img">
                      <img class="" src="" alt="">
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
