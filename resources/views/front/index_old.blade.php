@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    {{--MENU--}}
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')
    @include('layouts.frontend.allpart.mobile_search')
    {{-- end Menu--}}
    <div id="page" class="site my-0 py-0">

        <div id="main-content" class="col-sm-12 col-xs-12 ">
            <!-- search bar -->
        {{-- <div class="">
            @include('layouts.frontend.allpart.searchbar')
        </div> --}}
        <!-- end search -->
            <!--.site-content-contain -->
            <div class="site-content-contain">
                <div id="content" class="site-content ">
                    {{--main bradcum--}}
                    @include('layouts.frontend.allpart.mainbradcum')
                    {{--main bradcum--}}

                </div>
            </div>
            <!--end.site-content-contain -->
            <!-- search bar -->
        {{-- @include('layouts.frontend.allpart.tabletsearchbar') --}}
        <!-- end search -->

            <!-- page container -->

            {{--<div class="row">--}}
            {{--    <div class="col-6">--}}
            {{--        <button class="addth-button"  style="background:red;">Add to home screen</button>--}}
            {{--        <br>--}}
            {{--    </div>--}}

            {{--</div>--}}
            {{--            <div class=" show_breadcrumb_ sop-nav">--}}
            <div class="px-md-5">

                <div id="main-content" class="mt-2 col-sm-12 col-xs-12 ">
                    <!-- Categories -->
                @if(\App\sitesettings::where('id',3)->first()->action === 'on')
                    @include('layouts.frontend.allpart.categories')
                @endif
                <!-- //Categories -->
                </div>
                <div class="mx-4 mx-md-3">


                    <!-- zh-navbar -->
                    {{-- <nav class="navbar navbar-expand-sm bg-light justify-content-start mb-3" style="background-color: #fff !important">
                        <ul class="zh_nav navbar-nav">
                            <li class="popular_nav nav-item active">
                                <a class="nav-link" id="popular" style="">Popular</a>
                            </li>
                            <li class="newest_nav nav-item">
                                <a class="nav-link" id="newest" >Newest</a>
                            </li>
                            <li class="nav-item discount_nav">
                                <a class="nav-link" id="discount_pannel">Promotions</a>
                            </li>
                            <li class="nav-item shop_nav">
                                <a class="nav-link" id="official_store">Shops</a>
                            </li>
                        </ul>
                    </nav> --}}
                    {{--new item--}}
                    {{-- <div class="zh-new_item sop-font">
                        @if (count($new_items) == 0)
                            <div class="sn-no-items">
                                <div class="sn-cross-sign"></div>
                                <i class="fa-solid fa-box-open"></i>
                                <span>ပစ္စည်းမရှိသေးပါ</span>
                            </div>
                        @else
                            <new-items :newitems="{{$new_items}}" :uri="'get_newitems_ajax'"></new-items>
                        @endif
                    </div> --}}

                    {{-- <!-- Right Sidebar -->--}}
                    {{--new item--}}
                    {{-- pop item--}}
                    {{-- <div class="zh-pop_items sop-font">
                        @if (count($pop_items) == 0)
                            <div class="sn-no-items">
                                <div class="sn-cross-sign"></div>
                                <i class="fa-solid fa-box-open"></i>
                                <span>ပစ္စည်းမရှိသေးပါ</span>
                            </div>
                        @else
                            <pop-items :popitems="{{$pop_items}}"></pop-items>
                        @endif
                    </div> --}}
                    {{--pop item--}}

                    {{-- <!-- Right Sidebar -->--}}
                    {{--new item--}}
                    {{-- pop item--}}
                    {{-- <div class="zh-discount_items sop-font">

                        @if (count($discount_orderby_percent) == 0)
                            <div class="sn-no-items">
                                <div class="sn-cross-sign"></div>
                                <i class="fa-solid fa-box-open"></i>
                                <span>ပစ္စည်းမရှိသေးပါ</span>
                            </div>
                        @else
                            <discount-items :discountitems="{{$discount_orderby_percent}}"></discount-items>
                        @endif
                    </div> --}}
                    {{--pop item--}}
                    {{-- <div class="shops_pannel sop-font">

                        <shops-component :latest_shops="{{$shops}}"></shops-component>
                    </div> --}}
                </div>

            </div>

        </div>

        @if(\App\sitesettings::where('id',4)->first()->action === 'on')
            @include('layouts.frontend.allpart.shop_detail.premium_sellers')
        @endif

        <div class="sop-font px-md-3">
            <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5">
                <div class="elementor-widget-container d-flex justify-content-between">
                    <h3 class="elementor-heading-title elementor-size-default" style="font-family: sans-serif!important">Shweshops Directory List</h3>
                </div>
                <a href="{{ url('directory/all') }}">
                    <div class="sn-directory">
                        <div class="sn-directory-desc">
                            <h3>Directory</h3>
                            <p>ရန်ကုန်မြို့တွင်းရှိ ရွှေဆိုင်များလမ်းညွှန်</p>
                        </div>
                        <div class="sn-directory-link">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php
        $checkdison=\App\sitesettings::where('name','discount_products')->first();
        ?>

        <main-items-component :newitems="{{$new_items}}" :checkdison="'{{$checkdison->action}}'" :current_shop_count="{{$current_shop_count}}"
                              ></main-items-component>

{{--        --}}{{-- @include('layouts.frontend.allpart.Recommend_for_u') --}}
{{--        --}}{{-- @include('front.collections.collectionslide')--}}
{{--        @if(\App\sitesettings::where('id',5)->first()->action === 'on')--}}
{{--            @include('layouts.frontend.allpart.discount_items')--}}
{{--            --}}{{-- @include('layouts.frontend.allpart.ads2') --}}
{{--        @endif--}}

    </div>
    {{--<!-- #content -->--}}
    <div class="pt-5">
        @include('layouts.frontend.allpart.footer')
    </div>


    {{--    <!-- .site-content-contain -->--}}
    <div class="ftc-close-popup"></div>
    @include('layouts.frontend.allpart.mobile_footer')
    {{-- <div id="to-top" class="scroll-button">
        <a class="" href="javascript:void(0)" title="Back to Top">Back to Top</a>
    </div> --}}
    <div id="to-top" class="scroll-button">
        <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>
    <div class="popupshadow" style="display:none"></div>


@endsection
@push('custom-scripts')
<script>
$(document).ready(function () {
    $('#pshop_slide').owlCarousel({
        loop: false,
        margin: 20,
        responsiveClass: true,
        autoplay: true,
        dots: false,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,

        responsive: {
            0: {
                items: 1.5,
                stagePadding: 20,
            },
            600: {
                items: 2,
                stagePadding: 0,
            },
            900: {
                items: 3,
                stagePadding: 0,
            },
            1200: {
                items: 4,
                stagePadding: 0,
            },
            1400: {
                items: 5,
                stagePadding: 0,
            }
        }
    });
    $('#main_slide').owlCarousel({
        loop: false,
        margin: 20,
        responsiveClass: true,
        autoplay: true,
        dots: false,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,

        responsive: {
            0: {
                items: 1,
                stagePadding: 20,
            },
            600: {
                items: 1,
                stagePadding: 0,
            },
            900: {
                items: 1,
                stagePadding: 0,
            },
            1200: {
                items:1,
                stagePadding: 0,
            },
            1400: {
                items: 1,
                stagePadding: 0,
            }
        }
    });
      
});
</script>
    
@endpush

@push('css')
    <style>
        .remove_wrapp{
            height: 222px !important;
            position:relative !important;
        }
        .elementor-heading-title{
            font-family: sans-serif!important;
        }
        /* .elementor-heading-title{
            font-family: sans-serif!important;
        } */
        @media (min-width: 576px) {

        }


        @media (min-width: 576px) {
            .sop-nav .navbar-expand-sm .navbar-nav .nav-link {
                padding-right: 1.5rem !important;
                padding-left: 0rem !important;
            }

            .zh_nav a {
                font-size: 1.3rem;
            }
        }

    </style>
@endpush
