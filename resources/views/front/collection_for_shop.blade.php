@extends('layouts.frontend.frontend')
@section('content')
@push('css')
<style>
   .collection-name {
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2; 
               line-clamp: 2;
      -webkit-box-orient: vertical;
   }

   .back-to-text {
      font-size: 24px;
      color: #780116 !important;
   }
   .more-news-title{
      font-size: 20px;
   }
   .more-news-title:hover{
      color: #780116;
   }

   .card.col-card {
      box-shadow: 0 2px 12px 0 #edccaebd;
   }

   .sop-image-w-h.shop-collection-img {
      width: 100% !important;
      height: 100% !important;
      aspect-ratio: 5 / 2 !important;
   }

   .owl-carousel .owl-stage {
      padding-left: 0 !important;
      display: flex;
      align-items: center;
   }
</style>

@endpush

   @include('layouts.frontend.allpart.for_mobile')
   @include('layouts.frontend.allpart.upper_menu')
   @include('layouts.frontend.allpart.menu')

   <div id="page" class="site my-0 py-0">
      {{--Loading Wrapper--}}
      {{--@include('layouts.frontend.allpart.loading_wrapper')--}}
      {{-- Loading--}}
      <div class="container-fluid px-lg-5 px-md-1 mt-4 sop-font">
            <div class="row pb-5 pb-md-0">
               <div class="col-lg-8 col-md-12">
                  <div class="sn-main-promo">
                     
                     <a href="/{{ $shop_name }}" class=" my-5"><h2 class="back-to-text sn-latest-news-title"><i class="fas fa-arrow-left"></i> Back to Shop</h2></a>
                     <div class="">
                        <img class="card-img-top sop-image-w-h collection-img sop-img" src="
                           @if(isset($collection[0]->default_photo) || !is_null($collection[0]->default_photo) || !empty($collection[0]->default_photo))
                              {{ asset('images/items/' . $collection[0]->default_photo) }}
                           @else
                              {{ asset('images/items/default-placeholder.png') }}
                           @endif
                        " alt="Card image cap">
                        <h3 class="sn-main-promo-title py-3" style="line-height: 1.5em; font-weight: normal;">{{ $collection[0]->name }}</h3>
                     </div>
                  </div>
                  <div class="d-lg-block d-none">
                     <img src="/images/directory/banner/Separator.png" alt="" width="100%">
                  </div>
                  <div class="d-lg-none d-block">
                     <img src="/images/directory/banner/Separator_Mobile.png" alt="" width="100%">
                  </div>
                  <div class="row pt-3">
                     @foreach ($items as $item) 
                        <div class="col-sm-3 col-6 yk-fade">
                           <div class="ftc-product product mb-2" style="padding-top: 0px !important; box-shadow: none !important">
                              <div class="post-img sop-img">
                                 <span class="fa fa-user yk-viewcount">{{$item->view_count}}</span>
                                 <a href="{{route('front_productdetail',['shop_name' => $shop_name , 'product_id' => $item->id])}}">
                                    <img src="{{ url('/images/items/'.$item->photo_one)}}" class="sop-image-w-h" />
                                 </a>
                              </div>
                              <div>
                                 <a href="">{{Str::limit($item->name, 15, "...")}}</a>
                              </div>
                              <div>
                                 <p class="woocommerce-Price-amount amount sop-amount">
                                    {{$item->price}} MMK
                                 </p>
                              </div>
                           </div>
                        </div>
                     @endforeach
                  </div>
               </div>
               <div class="col-lg-4 col-md-12" id="collectionsPanel">
                  <div class="sn-latest-news">
                        <h2 class="sn-latest-news-title">Other collections</h2>
                        <div class="row d-sm-block d-none">
                           @forelse ($other_collections as $oc)
                           <div class="col-sm-12 col-6 mb-3">
                              <div class="card col-card">
                                 <a href="{{route('pCollections',['shop_name' => $shop_name , 'col_id' => $oc->id])}}" class="collection-card">
                                    <img class="card-img-top sop-image-w-h shop-collection-img sop-img" src="
                                       @if(isset($oc->default_photo) || !is_null($oc->default_photo) || !empty($oc->default_photo))
                                          {{ asset('images/items/' . $oc->default_photo) }}
                                       @else
                                          {{ asset('images/items/default-placeholder.png') }}
                                       @endif
                                    " alt="Card image cap">
                                    <div class="card-body" style="min-height: 80px; background-color: #FFFAF6">
                                       <p class="card-text collection-name collection-name">
                                          {{$oc->name}}
                                       </p>
                                    </div>
                                 </a>
                              </div>
                           </div>
                           @empty
                           <div class="mb-5">
                              <span>No Data Found</span>
                           </div>
                           @endforelse
                        </div>

                        <div class="row d-sm-none d-block mb-3" style="">
                           <div id="shop_collections_slide" class="shop-collection owl-carousel owl-theme w-100 d-none">
                           @forelse ($other_collections as $oc)
                           <div class="card" style="width: 100%">
                              <a href="{{route('pCollections',['shop_name' => $shop_name , 'col_id' => $oc->id])}}" class="collection-card">
                                 <div class="card-img-top sop-image-w-h collection-img sop-img">
                                 <img class="card-img-top sop-image-w-h collection-img sop-img" src="
                                    @if(isset($oc->default_photo) || !is_null($oc->default_photo) || !empty($oc->default_photo))
                                       {{ asset('images/items/' . $oc->default_photo) }}
                                    @else
                                       {{ asset('images/items/default-placeholder.png') }}
                                    @endif
                                 " alt="Card image cap">
                                 </div>
                                 <div class="card-body" style="min-height: 80px;">
                                    <p class="card-text collection-name">
                                       {{$oc->name}}
                                    </p>
                                 </div>
                              </a>
                           </div>
                           @empty
                           <div class="mb-5">
                              <span>No Data Found</span>
                           </div>
                           @endforelse
                        </div>
                        {{-- @if($premium == "Yes")
                           <a class="sn-latest-news-button float" href="/all_news/{{$news->shop_id}}">More News</a>
                        @else
                           <a class="sn-latest-news-button float" href="/news">More News</a>
                        @endif --}}
                  </div>

               </div>

            </div>
         </div>
      </div>
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

@push('custom-scripts')
<script>
$('#shop_collections_slide').owlCarousel({
         loop: false,
         margin: 20,
         responsiveClass: true,
         autoplay: false,
         dots: false,
         autoplayTimeout: 6000,
         autoplayHoverPause: true,
         stagePadding: 80,
         responsive: {
               0: {
                  items: 1,
               },
               600: {
                  items: 1,
               },
               900: {
                  items: 2,
               },
               1200: {
                  items: 3,
               },
               1400: {
                  items: 3,
               }
         }
      });
      $(document).ready(function () {
         $('#shop_collections_slide').removeClass('d-none');
      })
   </script>
@endpush