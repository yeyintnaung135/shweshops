@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')

    <div id="page" class="site container-fluid my-0 py-0">
    {{--MENU--}}

    {{-- end Menu--}}
    <!-- .site-content-contain -->

        <div class="site-content-contain sn-site-content">
        </div>

        <!-- .site-content-contain -->
        <div class="site-content-contain">
            <div class="mx-4 px-md-5 show_breadcrumb_">
                <div class="remove_wrapp" style="position:relative !important;">
                    @include('layouts.frontend.allpart.loading_wrapper')
                </div>
                <div class="row">
                    <div id="main-content" class="show_dev col-sm-9 col-xs-12 d-none">

                        {{-- for photo slide and tilte--}}
                        <div id="sn-directory-container"
                             class="row product type-product post-553 status-publish first instock product_cat-accessories product_cat-bracelet product_cat-brand product_cat-earrings product_cat-fragrances product_cat-gift-for-men has-post-thumbnail shipping-taxable purchasable product-type-simple ">


                            <div class="d-flex justify-content-between mb-5 align-items-center">
                                <div class="d-flex align-items-center">
                                  <div>
                                    @if ($item->shop_logo)
                                      <img
                                        src="{{url('/images/directory/'.$item->shop_logo)}}"
                                        class="sn-dir-detail-img"
                                      />
                                    @endif
                                  </div>
                                  <h1 class="sop-font">{{$item->shop_name}}</h1>
                                </div>

                                <div class="shop-dir-links">
                                  <a href="{!! $item->facebook_link !!}"><i class="fa-brands fa-facebook"></i></a>
                                  <a href="{!! $item->website_link !!}"><i class="fa-solid fa-globe"></i></a>
                                </div>

                            </div>


                            <div class="summary entry-summary col-12 col-md-6 d-none" style="padding-right: 0;">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- zh view count -->
                                        <div class="d-flex">
                                            <div style="
                                                    margin-left: 10px;
                                                ">
                                                <span style="
                                                        color: grey;
                                                    " class="sop-font">Uploaded on </span>
                                                <span style="
                                                    color: grey;
                                                ">{{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">


                                        <h1 class="product_title entry-title sn-product-title sop-font">{{$item->shop_name}}
                                            </h1>

                                    </div>

                                    <div class="col-8 mt-2">


                                        <h1 class="product_title entry-title sn-product-title sop-font">Main Phone
                                        </h1>
                                        <div style="margin-left: 11px;">
                                            {{$item->main_phone}}

                                        </div>

                                    </div>
                                    <div class="col-8 mt-2">


                                        <h1 class="product_title entry-title sn-product-title sop-font">Address
                                        </h1>
                                        <div style="margin-left: 11px;">
                                            {!! $item->address !!}
                                        </div>

                                    </div>
                                    <div class="col-8 mt-2">


                                        <h1 class="product_title entry-title sn-product-title sop-font">Facebook
                                        </h1>
                                        <div style="margin-left: 11px;">
                                          <a href="{!! $item->facebook_link !!}" style="color: blue !important;">{{$item->facebook_link}}</a>

                                        </div>

                                    </div>
                                    <div class="col-8 mt-2">


                                        <h1 class="product_title entry-title sn-product-title sop-font">Website
                                        </h1>
                                        <div style="margin-left: 11px;">
                                          <a href="{!! $item->website_link !!}" style="color: blue !important;">{{$item->website_link}}</a>

                                        </div>

                                    </div>
                                </div>




                            </div>

                            <div>
                              <ul class="nav nav-tabs" id="sn-directory-tab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Address</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Phone Numbers</a>
                                </li>
                              </ul>
                              <div class="tab-content" id="sn-directory-tab-content">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    {!! $item->address !!}
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                  <div>
                                    <p>Main Phone : {{$item->main_phone}}</p>
                                  </div>
                                  <div class="">
                                    @if ($item->additional_phones)
                                      @foreach ( json_decode($item->additional_phones,true) as $adphone)
                                        <p>Other Phone : {{ $adphone }}</p>
                                      @endforeach
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-5">
        @include('layouts.frontend.allpart.footer')
    </div>
    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

    <div id="to-top" class="scroll-button">
        <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>

@endsection

@push('css')
    <style>
        .sop-ribbon-pd span {
            width: 136px;
            height: 30px;
            top: 13px;
            right: -46px;
            position: absolute;
            display: block;
            background: #FF0000;
            color: #333;
            font-family: arial;
            font-size: 14px;
            color: white;
            text-align: center;
            line-height: 30px;
            transform: rotate(
                45deg
            );
            -webkit-transform: rotate(52deg);
        }

        .sop-ribbon-pd {
            height: 110px;
            display: block;
            position: absolute;
            overflow: hidden;
            z-index: 111;
            top: 0;
            right: 0;
        }

        .sn-buynow-button {
            /* zh-modify */
            background: #fff !important;
            border-radius: 5px !important;
            border-color: #780116 !important;
            width: 100% !important;
            margin: 20px auto 0;
            color: #000 !important;
            font-size: 18px !important;
            padding: 7px 0 !important;
            /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;*/
            font-weight: 500 !important;
        }

        .sn-buynow-button:HOVER {
            background: #f3f3f3b9 !important;
        }

        .zh-addtocart-button {
            background: #780116 !important;
            border-radius: 5px !important;
            border-color: #780116 !important;
            width: 100% !important;
            margin: 20px auto 0;
            color: rgba(247, 181, 56, 1) !important;
            font-size: 18px !important;
            padding: 7px 0 !important;
            /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;*/
            font-weight: 500 !important;
        }

        .sop-product-image-d {
            width: 100% !important;

            aspect-ratio: 3/2;
            vertical-align: inherit !important;
        }
    </style>
@endpush

