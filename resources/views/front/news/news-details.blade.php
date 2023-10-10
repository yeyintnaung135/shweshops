@extends('layouts.frontend.frontend')
@section('content')
    @push('css')
        <style>
            .more-news-title {
                font-size: 20px;
            }

            .more-news-title:hover {
                color: #780116;
            }
        </style>
    @endpush

    @include('layouts.frontend.allpart.for_mobile')
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')

    <div id="page" class="site my-0 py-0">
        {{-- Loading Wrapper --}}
        {{-- @include('layouts.frontend.allpart.loading_wrapper') --}}
        {{-- Loading --}}
        <div class="container-fluid px-lg-5 px-md-1 mt-4 sop-font">
            <div class="row pb-5 pb-md-0">
                <div class="col-lg-8 col-md-12">
                    <div class="sn-main-promo">

                        @if (dofile_exists('/news_&_events/news/' . $news->image))
                            <img class="w-100" src="{{ filedopath('/news_&_events/news/' . $news->image) }}" alt="">
                        @else
                            <img class="w-100" src="{{ url('/images/news_&_events/news/' . $news->image) }}" alt="">
                        @endif
                        <h3 class="sn-main-promo-title">{{ $news->title }}</h3>
                        <p class="mb-3 mt-2"><span><i class="fa-solid fa-calendar-days"></i></span>
                            {{ $news->created_at->format('d M Y') }}</p>
                        <p class="sn-main-promo-desc">{{ $news->description }}</p>
                        {{-- <div class="sn-main-promo-period"><i class="fa-solid fa-calendar-alt"></i> Promotion Period : 7
                            June to 15 June
                        </div> --}}
                    </div>
                    {{-- <div class="d-lg-none">
                        <a onclick="showEventsPanel()">Events</a>
                        <a onclick="showNewsPanel()">News</a>
                    </div> --}}
                    <div class="d-lg-block" id="eventsPanel">
                        {{-- <div class="sn-promo">
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
                        </div> --}}
                    </div>
                    {{-- </div> --}}
                </div>
                <div class="col-lg-4 col-md-12" id="newsPanel">
                    <div class="sn-latest-news">
                        <h2 class="sn-latest-news-title">More News</h2>
                        @forelse ($other_news as $n)
                            <div class="mb-5">
                                @if ($premium == 'Yes')
                                    <a href="{{ route('pNews.detail', ['id' => $n->id, 'shopid' => $n->shop_id]) }}"
                                        target="_blank" rel="noopener noreferrer">
                                        <img class="" src="{{ filedopath('/news_&_events/news/' . $n->image) }}"
                                            alt="">
                                        <h6 class="mt-3 text-black more-news-title">{{ $n->title }}</h6>
                                    </a>
                                @else
                                    <a href="{{ route('news.detail', $n->id) }}" target="_blank" rel="noopener noreferrer">
                                        @if (dofile_exists('/news_&_events/news/' . $n->image))
                                            <img class="w-100" src="{{ filedopath('/news_&_events/news/' . $n->image) }}"
                                                alt="">
                                        @else
                                            <img class="w-100" src="{{ url('/images/news_&_events/news/' . $n->image) }}"
                                                alt="">
                                        @endif
                                        <h6 class="mt-3 text-black more-news-title">{{ $n->title }}</h6>
                                    </a>
                                @endif
                                <p class="mb-3 mt-2"><span><i class="fa-solid fa-calendar-days"></i></span>
                                    {{ $n->created_at->format('d M Y') }}</p>
                                <p>{{ Str::words($n->title, 20) }}</p>
                            </div>
                        @empty
                            <div class="mb-5">
                                <span>No Data Found</span>
                            </div>
                        @endforelse

                        @if ($premium == 'Yes')
                            <a class="sn-latest-news-button float" href="/all_news/{{ $news->shop_id }}">More News</a>
                        @else
                            <a class="sn-latest-news-button float" href="/news">More News</a>
                        @endif
                    </div>

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
        {{-- <!-- #content --> --}}

        @include('layouts.frontend.allpart.footer')
    </div>

    {{--    <!-- .site-content-contain --> --}}


    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('shwe_news/js/app.js') }}"></script>
@endpush
