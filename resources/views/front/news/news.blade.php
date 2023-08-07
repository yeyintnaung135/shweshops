@extends('layouts.frontend.frontend')
@section('content')

@php
  use Illuminate\Support\Carbon;
@endphp
@include('layouts.frontend.allpart.for_mobile')
@include('layouts.frontend.allpart.upper_menu')
@include('layouts.frontend.allpart.menu')


    <div id="page" class="site my-0 py-0">

        <div class="container-fluid px-lg-5 mt-4 sop-font px-3">
          <div id="snNepTap" class="d-flex d-lg-none">
            <div id="newsTab" class="tab-focus">News</div>
            <div id="eventsTab">Events</div>
            <div id="promotionsTab">Promotions</div>
          </div>
            <div class="row pb-5 pb-md-0">
                <div class="col-lg-8 col-md-12">
                  <div id="newsPanel" class="d-lg-block">
                    <div>
                      <h1 class="mb-4 d-none d-lg-block">Latest News</h1>
                      <h2 class="mb-4 d-lg-none sn-latest-news-title">Latest News</h2>
                      @if ($latestNews)
                          <a href="{{ route('news.detail',$latestNews->id)}}" class="sn-fs-promo">
                              <img class="" src="{{ asset('images/news_&_events/news/'. $latestNews->image)}}" alt="">
                          </a>
                          <div>
                              <a href="{{ route('news.detail',$latestNews->id)}}">
                                  <h2 class="my-3">{{ $latestNews->title }}</h2>
                              </a>
                              {{-- <p><span><i class="fa-solid fa-calendar-days"></i></span> {{ $latestNews->created_at->format("d M Y")}}</p> --}}
                              <p> {{ Str::words($latestNews->description , 20) }}
                              <span><a class="text-blue text-decoration-underline" href="{{route('news.detail',$latestNews->id)}}">... See More</a></span></p>
                          </div>
                      @else
                          <div class="d-flex p-5 justify-content-center">
                              <span>No Data found</span>
                          </div>
                      @endif
                    </div>

                    {{-- <div class="d-lg-block"> --}}
                    <div class="sn-promo">
                        <h2 class="sn-promo-title">More News</h2>
                        <ul class="list-unstyled">
                          @forelse ($news as $n )
                            <li class="d-block mb-3 d-lg-flex">
                                  <img class="photos" src="{{ asset('images/news_&_events/news/'.$n->image)}}" alt="">
                                <div class="mt-2">
                                    <a href="{{ route('news.detail',$n->id)}}">
                                        <p class="mb-2 sn-sub-title"><strong>{{ Str::words($n->title, 5) }}</strong></p>
                                    </a>
                                    {{-- <p class="mb-2">
                                      <span><i class="fa-solid fa-calendar-days"></i></span>
                                      {{ $latestNews->created_at->format("d M Y") }}
                                      </p> --}}
                                    <p>{{ Str::words($n->description , 6)}}</p>
                                </div>
                            </li>
                          @empty
                            <li class="d-block mb-3 d-lg-flex justify-content-center p-5">
                                <span>No Data Found</span>
                            </li>
                          @endforelse
                        </ul>
                        <a href="news" class="sn-news-button float">Load More</a>
                    </div>
                  </div>

                  <div class="sn-upcoming-events d-none d-lg-block" id="eventsPanel">
                      <h2 class="sn-upcoming-events-title">Up Coming Events</h2>
                      <ul class="list-unstyled">
                          @forelse ($events as $e)
                          <li class="d-block d-lg-flex mb-4">
                              <img class="photos" src="{{ asset('images/news_&_events/event/'. $e->photo)}}" alt="Event photo">
                              <div class="mt-2">
                                  <a href="{{route('events.detail',$e->id)}}">
                                      <p class="mb-2 sn-sub-title"><strong>{{ Str::words($e->title, 5) }}</strong></p>
                                  </a>
                                  {{-- <p class="mb-2"><span><i class="fa-solid fa-calendar-days"></i></span> {{ $e->created_at->format('d M Y')}}</p> --}}
                                  <p>{{ Str::words($e->description, 6)}}</p>
                              </div>
                          </li>
                          @empty
                              <li class="d-block mb-3 d-lg-flex justify-content-center p-5">
                                  <span>No Data Found</span>
                              </li>
                          @endforelse

                      </ul>
                      <a class="sn-news-button float" href="/events">Load More</a>
                  </div>
                    {{-- </div> --}}
                </div>
                <div class="col-lg-4 col-md-12 d-lg-block d-none" id="promotionsPanel">
                    <div class="sn-latest-news">
                        <h2 class="sn-promo-title">
                            {{-- <a href="" class="d-flex">
                                <span class="flex-grow-1">Promotions</span>
                                <!-- <i class="fa-solid fa-long-arrow-alt-right"></i> -->
                            </a> --}}
                            Promotions
                        </h2>
                        @forelse ($promotions as $p )
                        <div class="mb-3 p-lg-3">
                            <img class="w-100 photos" src="{{ asset('images/news_&_events/promotion/'.$p->photo)}}" alt="">
                            <a href="{{route('promotions.detail',$p->id)}}">
                                <p class="sn-latest-news-sub">{{ $p->title }}</p>
                            </a>
                            {{-- <p class="mb-2"><span><i class="fa-solid fa-calendar-days"></i></span> {{ $p->created_at->format('d M Y')}}</p> --}}
                            <p>{{ Str::words($p->description,20)}}</p>
                        </div>
                        @empty
                        <div class="mb-5">
                           <li class="d-block mb-3 d-lg-flex justify-content-center p-5">
                                   <span>No Data Found</span>
                           </li>
                        </div>
                        @endforelse

                        <div class="sn-upcoming-events">
                            <a class="sn-news-button float" href="promotions">Load More</a>
                        </div>
                        <!-- <a class="sn-latest-news-button float d-md-none">More News</a> -->
                    </div>
                </div>

            </div>
        </div>

        @include('layouts.frontend.allpart.footer')
    </div>
    {{--    <!-- .site-content-contain -->--}}


    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

    <div id="to-top" class="scroll-button">
        <a class="scroll-button" href="javascript:void(0)" title="Back to Top">Back to Top</a>
    </div>

    <div class="popupshadow" style="display:none"></div>

    <div class="ftc-off-canvas-cart">
        <div class="off-canvas-cart-title">
            <div class="title">Shopping Cart</div>
            <a href="#" class="close-cart"> Close</a>
        </div>
        <div class="off-can-vas-inner">
            <div class="woocommerce widget_shopping_cart">
                <div class="widget_shopping_cart_content">


                    <p class="woocommerce-mini-cart__empty-message">No products in the cart.</p>


                </div>
            </div>
        </div>
    </div>

@endsection
@push('css')
  <style>
  </style>
@endpush
@push('scripts')
<script>
  const tabButtons = document.querySelectorAll('div#snNepTap > div');
  tabButtons.forEach(button => button.addEventListener('click', changeTab));

  function selectDiv(id) {
    return document.getElementById(id);
  }

  function selectedTab(tab1, tab2, tab3, panel1, panel2, panel3) {
    selectDiv(panel1).classList.remove('d-none');
    selectDiv(panel2).classList.add('d-none');
    selectDiv(panel3).classList.add('d-none');

    selectDiv(tab1).classList.add('tab-focus');
    selectDiv(tab2).classList.remove('tab-focus');
    selectDiv(tab3).classList.remove('tab-focus');
  }

  function changeTab(event) {
    if(event.target.id == "newsTab") {
      selectedTab("newsTab", "eventsTab", "promotionsTab", "newsPanel", "eventsPanel", "promotionsPanel");
    }
    if(event.target.id == "eventsTab") {
      selectedTab("eventsTab", "newsTab", "promotionsTab", "eventsPanel", "newsPanel", "promotionsPanel");
    }
    if(event.target.id == "promotionsTab") {
      selectedTab("promotionsTab", "newsTab", "eventsTab", "promotionsPanel", "eventsPanel", "newsPanel");
    }
  }
</script>
@endpush
