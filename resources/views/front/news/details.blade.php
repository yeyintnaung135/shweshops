@php
  use Illuminate\Support\Carbon;
@endphp
@extends('layouts.frontend.frontend')
@section('content')

@include('layouts.frontend.allpart.for_mobile')
@include('layouts.frontend.allpart.upper_menu')
@include('layouts.frontend.allpart.menu')

    <div id="page" class="site my-0 py-0">


    {{--Loading Wrapper--}}
        @include('layouts.frontend.allpart.loading_wrapper')

    {{-- Loading--}}


    <!-- .site-content-contain -->
        {{-- <div class="site-content-contain">
            <div id="content" class="site-content border "> --}}
              {{-- menu --}}
                {{-- @include('front.news.menu') --}}
              {{-- menu --}}
               {{-- <div class="container">
                   <div class="row">
                     <div class="col-12 col-lg-8 ">
                        <div class="news-detail-card">
                            <div class="detail-card-header">
                                <div class="my-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                      <h3 class="font-weight-bolder mb-2">{{ $news->title }}</h3>
                                      <i class="fa-solid fa-share-nodes my-text-color" style="font-size: 25px;"></i>
                                    </div> --}}
                                    {{-- <span> <i class="fa-thin fa-clock-nine"></i> {{ $news->created_at->diffForHumans()}}</span> --}}
                                    {{-- <span> <i class="fa-thin fa-clock-nine"></i> {{ $news->created_at->diffForHumans()}}</span> --}}
                                {{-- </div>
                                <img class="" src="{{ asset('images/news/'. $news->image)}}" alt="">
                            </div>
                            <div class="card-body p-0">
                               <div class="">
                                <p>{{ $news->description }}</p>
                               </div>
                               <div class="mb-2 p-0">
                                    <div class="widget-header-2">
                                         <h3 class="font-weight-bolder">အခြားသောသတင်းများ</h3>
                                    </div>
                                    @foreach ($otherNews as $other )
                                    <div class="row p-2 w-100 other-news">
                                        <div class="col-3 p-0 ">
                                            <img src="{{ asset('images/news/' . $other->image)}}" class="w-100 rounded" alt="">
                                        </div>
                                        <div class="col-9">
                                            <div class="mb-3">
                                              <a href="{{ url('news_and_events', $other->id )}}"> <h4 class="mb-1 other-news-header">‌‌{{ $other->title }}</h4></a>
                                              <span>{{ $other->created_at->diffForHumans()}}</span>
                                            </div>
                                            <p class="text-black-50">
                                              {{ Str::words($other->description, 10)}}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach

                               </div>
                            </div>
                        </div>
                     </div>
                     <div class="col-12 col-lg-4">
                        <div class="widget-header">
                            <h3 class="text-center">ထိပ်ဆုံးရောက်သတင်းများ</h3>
                        </div>
                        <div class="row mb-3">
                            @foreach ($topNews as $top )
                            <div class="col-12 mb-0">
                                <div class="card top-new border-0 p-2">
                                    <div class="mb-2">
                                        <a href="{{ url('news_and_events',$top->id)}}"><h4 class="font-weight-bolder">{{$top->title}}</h4></a>
                                        <span>6 hours ago</span>
                                    </div>
                                    <p class="text-black-50">
                                     {{ Str::words($top->description, 6)}}
                                    </p>
                                </div>
                                <hr>
                            </div>

                            @endforeach
                        </div>
                        <div class="widget-img">
                            <img src="{{ asset('images/news/widget-img.png')}}" alt="" class="w-100">
                        </div>
                        <div class="widget-header-2">
                            <h3 class="font-weight-bolder">ယနေ့သတင်းစဥ်</h3>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-0">
                                    <div class="mb-2">
                                      <img src="{{asset('images/news/'.$post->image )}}" alt="">
                                    </div>
                                    <div class="card-body">
                                       <div class="mb-1">
                                            <h4 class="mb-2">{{ $post->title }}</h4>
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p>
                                           {{ Str::words($post->description, 10)}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                   </div>
               </div>
            </div> --}}
        {{-- </div> --}}
        <div class="container-fluid px-lg-5 px-md-1 mt-4 sop-font">
          <div class="row pb-5 pb-md-0">
            <div class="col-lg-8 col-md-12">
              @if ($info == 'news')
                <div class="sn-main-promo">
                  <img class="" src="{{ asset('images/news_&_events/news/' . $detail_blog->image)}}" alt="">
                  <h3 class="sn-main-promo-title">{{ $detail_blog->title }}</h3>
                  {{-- <h4 class="sn-main-promo-shop">Lucky Diamonds Myanmar</h4> --}}
                  <p class="sn-main-promo-desc">{{  $detail_blog->description }}</p>
                </div>
              @elseif ($info == 'event')
                <div class="sn-main-promo">
                  <img class="" src="{{ asset('images/news_&_events/event/' . $detail_blog->photo)}}" alt="">
                  <h3 class="sn-main-promo-title">{{ $detail_blog->title }}</h3>
                  @if(isset($detail_blog->getShop))
                    <a href="{{ url('shops/'. $detail_blog->getShop->name . "/" . $detail_blog->getShop->id)}}" class="sn-main-promo-shop">{{ $detail_blog->getShop->name }}</a>
                  @else
                    <h4 class="sn-main-promo-shop text-danger">Unknown Shop</h4>
                  @endif
                  <p class="sn-main-promo-desc">{{ $detail_blog->description }}</p>
                  <div class="sn-main-promo-period"><i class="fa-solid fa-calendar-alt"></i> Promotion Period : {{ Carbon::createFromformat('Y-m-d H:i:s',$detail_blog->start)->format("d.m.Y") }} to {{ $detail_blog->deleted_at->format("d.m.Y") }}</div>
                </div>
              @elseif ($info == 'promotion')
                <div class="sn-main-promo">
                  <img class="" src="{{ asset('images/news_&_events/promotion/' . $detail_blog->photo)}}" alt="">
                  <h3 class="sn-main-promo-title">{{ $detail_blog->title }}</h3>
                  @if(isset($detail_blog->getShop))
                    <a href="{{ url('shops/'. $detail_blog->getShop->name . "/" . $detail_blog->getShop->id)}}" class="sn-main-promo-shop">{{ $detail_blog->getShop->name }}</a>
                  @else
                    <h4 class="sn-main-promo-shop text-danger">Unknown Shop</h4>
                  @endif
                  <p class="sn-main-promo-desc">{{ $detail_blog->description }}</p>
                  <div class="sn-main-promo-period"><i class="fa-solid fa-calendar-alt"></i> Promotion Period : {{ $detail_blog->created_at->format("d.m.Y") }} to {{ $detail_blog->deleted_at->format("d.m.Y") }}</div>
                </div>
              @endif
              <div class="d-lg-none">
                <a id="sn-events-tab1" class="sn-events-tab-active" onclick="showEventsPanel()">Events</a>
                <a id="sn-events-tab2" onclick="showNewsPanel()">News</a>
              </div>
              <div class="d-lg-block" id="eventsPanel">
                <div class="sn-promo">
                  <h2 class="sn-promo-title">Promotions</h2>
                  <ul class="list-unstyled">
                     @forelse ($promotions as $p )
                     <li class="d-flex sn-promo-list">
                      <div><img class="" src="{{ asset('images/news_&_events/promotion/'. $p->photo)}}" alt=""></div>
                      <div>
                        <a href="{{ url('promotion/'. $p->id)}}" class="sn-promo-list-title">{{ $p->title }}</a>
                         @if(isset($p->getShop))
                             <a href="{{ url('shops/'. $p->getShop->name . "/" . $p->getShop->id)}}" class="sn-promo-list-shop">{{ $p->getShop->name }}</a>
                         @else
                             <span class="text-danger">Unknow Shop</span>
                         @endif
                        <p>{{ Str::words($p->description, 20) }}</p>
                      </div>
                    </li>
                     @empty
                     <li class="d-flex sn-promo-list">
                       <p>No Data found</p>
                    </li>
                     @endforelse
                  
                  </ul>
                  {{-- <a class="sn-news-button float">More Promotions</a> --}}
                </div>
                <div class="sn-upcoming-events">
                  <h2 class="sn-upcoming-events-title">Up Coming Events</h2>
                  @forelse ($events as $event )
                  <div>
                    <span class="sn-upcoming-events-date">{{  $event->created_at->format("d.m.Y")}}</span>
                    <a href="{{ url('event/'. $event->id)}}"  class="sn-upcoming-events-sub">{{ $event->title }}</a>
                    <p>{{ Str::words($event->description,35) }} <span><a class="event-seemore-link" href="{{ url('event/'. $event->id)}}">... See More</a></span></p>
                  </div>
                  @empty
                    <div>No Data Found</div>
                  @endforelse
                  {{-- <a class="sn-news-button float">More Events</a> --}}
                </div>
              </div>
            {{-- </div> --}}
          </div>
          <div class="col-lg-4 col-md-12 d-none d-lg-block" id="newsPanel">
            <div class="sn-latest-news">
              <h2 class="sn-latest-news-title"><a href="#" class="d-flex"><span class="flex-grow-1">Latest News</span><i class="fa-solid fa-long-arrow-alt-right"></i></a></h2>
              @forelse ($news as $n)
              <div class="mb-5">
                <img class="" src="{{ asset('images/news_&_events/news/'. $n->image)}}" alt="">
                <a href="{{ url('news/'. $n->id)}}" class="sn-latest-news-sub">{{ $n->title }}</a>
                <p>{{ Str::words($n->description,15) }}</p>
              </div>
              @empty
              <div class="mb-5">
                 <p>No Data Found</p>
              </div>
              @endforelse
              <a class="sn-latest-news-button float d-md-none">More News</a>
            </div>
            {{-- <div class="sn-ads-img">
              <img class="" src="{{ asset('images/news/62ab47867b0f7.png')}}" alt="">
            </div> --}}
            <div class="sn-top-stories mb-sm-5 d-none">
              <h2 class="sn-top-stories-title"><a href="#" class="d-flex"><span class="flex-grow-1">Top Stories</span><i class="fa-solid fa-long-arrow-alt-right"></i></a></h2>
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
            </div>

          </div>
        </div>
        {{--  --}}
        <script>
          function showEventsPanel() {
            document.getElementById("eventsPanel").classList.remove("d-none");
            document.getElementById("newsPanel").classList.add("d-none");
            document.getElementById("sn-events-tab1").classList.add("sn-events-tab-active");
            document.getElementById("sn-events-tab2").classList.remove("sn-events-tab-active");
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
