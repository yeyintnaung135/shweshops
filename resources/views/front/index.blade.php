@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    {{--MENU--}}
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')
    @include('layouts.frontend.allpart.mobile_search')
    {{-- end Menu--}}

    {{-- Main Content --}}
    <div id="page" class="site my-0 py-0">
        <div id="main-content" class="col-sm-12 col-xs-12 site-content-contain">

            {{-- Banner --}}
            <div class="site-content-contain">
                <div id="content" class="site-content ">
                    {{--main bradcum--}}
                        @include('layouts.frontend.allpart.mainbradcum')
                    {{--main bradcum--}}
                </div>
            </div>

            {{-- <div class="px-md-5 px-3">
                <img class="d-block w-100 banner" src="{{ asset('images/banner/63da4e19e086d.jpg') }}">
            </div> --}}

            {{-- End Banner --}}

            {{-- Product Type Links (Desktop) --}}
            <div class="choose-product-type">
                <div class="row gx-3 px-md-5 px-3 m-0 ">
                    <div class="col-lg-3 col-6">
                        <a href="{{ url('see_by_categories') }}/Gold ( ရွှေ )">
                            <div class="choose-product-type-btn">
                                <div class="d-flex align-items-center">
                                    <div class="product-text-area">
                                        <p class="product-text-mmr">ရွှေထည်</p>
                                        <p class="product-text-eng">GOLD</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center product-icon-area">
                                    <img src="{{ asset('test/forcategory/Gold.png')}}" alt="" srcset="" class="product-icon">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a href="{{ url('see_by_categories') }}/Diamond ( စိန် )">
                            <div class="choose-product-type-btn">
                                <div class="d-flex align-items-center">
                                    <div class="product-text-area">
                                        <p class="product-text-mmr">စိန်ထည်</p>
                                        <p class="product-text-eng">DIAMOND</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center product-icon-area">
                                    <img src="{{ asset('test/forcategory/Diamond.png')}}" alt="" srcset="" class="product-icon">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a href="{{ url('see_by_categories') }}/Platinum ( ပလက်တီနမ် )">
                            <div class="choose-product-type-btn">
                                <div class="d-flex align-items-center">
                                    <div class="product-text-area">
                                        <p class="product-text-mmr">ပလက်တီနမ်</p>
                                        <p class="product-text-eng">PLATINUM</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center product-icon-area">
                                    <img src="{{ asset('test/forcategory/Platinum.png')}}" alt="" srcset="" class="product-icon">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a href="{{ url('see_by_categories') }}/White Gold ( ရွှေဖြူ )">
                            <div class="choose-product-type-btn">
                                <div class="d-flex align-items-center">
                                    <div class="product-text-area">
                                        <p class="product-text-mmr">ရွှေဖြူ</p>
                                        <p class="product-text-eng">WHITE-GOLD</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center product-icon-area">
                                    <img src="{{ asset('test/forcategory/WhiteGold.png')}}" alt="" srcset="" class="product-icon">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            {{-- End Product Type Links (Desktop) --}}

            {{-- Premium Shops --}}
            @if(\App\Models\sitesettings::where('id',4)->first()->action === 'on')
                <div class="px-md-3 px-0">@include('layouts.frontend.allpart.shop_detail.premium_sellers')</div>
            @endif
            {{-- End Premium Shops --}}

            {{-- Categories --}}
                @if(\App\Models\sitesettings::where('id',3)->first()->action === 'on')
                    <div class="row gx-3 px-md-5 px-3 m-0 mt-2">
                        <h3 class="heading-font ps-3">လက်ဝတ်ရတနာများ</h3>
                    </div>
                    <div class="mt-lg-0 mt-4">
                        @include('layouts.frontend.allpart.categories')
                    </div>
                @endif
            {{-- End Categories --}}

            

            {{-- Product Type Links (Mobile) --}}
            {{-- <div class="choose-product-type d-lg-none d-block pt-2">
                <div class="row gx-3 px-md-5 px-3 m-0">
                    <div class="col-lg-3 col-6 g-3 mt-0">
                        <a href="{{ url('see_by_categories') }}/Gold ( ရွှေ )">
                            <div class="choose-product-type-btn" style="padding:0px !important">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('test/forcategory/Gold.png')}}" alt="" srcset="" class="product-icon" style="margin:10px 20px !important; width:90px; height:90px;" >
                                </div>
                                <div class="product-text-area text-center">
                                    <p class="product-text-mmr-mobile">ရွှေထည်</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 g-3 mt-0">
                        <a href="{{ url('see_by_categories') }}/Diamond ( စိန် )">
                            <div class="choose-product-type-btn" style="padding:0px !important">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('test/forcategory/Diamond.png')}}" alt="" srcset="" class="product-icon" style="margin:10px 20px !important; width:90px; height:90px;" >
                                </div>
                                <div class="product-text-area text-center">
                                    <p class="product-text-mmr-mobile">စိန်ထည်</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 g-3 mt-0">
                        <a href="{{ url('see_by_categories') }}/Platinum ( ပလက်တီနမ် )">
                            <div class="choose-product-type-btn" style="padding:0px !important">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('test/forcategory/Platinum.png')}}" alt="" srcset="" class="product-icon" style="margin:10px 20px !important; width:90px; height:90px;" >
                                </div>
                                <div class="product-text-area text-center">
                                    <p class="product-text-mmr-mobile">ပလက်တီနမ်</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 g-3 mt-0">
                        <a href="{{ url('see_by_categories') }}/White Gold ( ရွှေဖြူ )">
                            <div class="choose-product-type-btn" style="padding:0px !important">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('test/forcategory/WhiteGold.png')}}" alt="" srcset="" class="product-icon" style="margin:10px 20px !important; width:90px; height:90px;" >
                                </div>
                                <div class="product-text-area text-center">
                                    <p class="product-text-mmr-mobile">ရွှေဖြူ</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
            {{-- End Product Type Links (Mobile) --}}
            
            {{-- Popular Shops --}}
            <div class="px-md-3 px-0">@include('front.popularShops')</div>
            {{-- End Popular Shops --}}


            @if($is_foryou_on == 'on')
            {{-- For You Products --}}
            <div class="px-md-3 px-0">@include('front.recommendedForYou')</div>
            {{-- End For You Products --}}
@endif
            

            {{-- Highlight Features --}}
            @if(\App\Models\sitesettings::where('id',7)->first()->action === 'on')
                <div class="choose-product-type">
                    <div class="row gx-3 px-md-5 px-3 m-0">
                        <h3 class="heading-font ps-3">Shweshops မှကဏ္ဍအစုံအလင်</h3>
                    </div>
                    <div class="row g-3 px-md-5 px-3 m-0">
                        <div class="col-6">
                            <a href="{{ url('baydin') }}">
                                <div class="baydin d-flex align-items-end bg-overlay-baydin">
                                    <div class="">ရာသီခွင်အလိုက် ဗေဒင်တွက်ကြည့်မယ်</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="{{ url('directory/all') }}">
                                <div class="shops-guide d-flex flex-column align-items-center justify-content-end bg-overlay-shops-guide">
                                    <div class="d-flex align-items-center justify-content-center shops-guide-icon">
                                        <i class="fa-solid fa-location-dot text-center row"></i>
                                    </div>
                                    <div class="">မြန်မာတစ်နိုင်ငံလုံးရှိ ရွှေဆိုင်များလမ်းညွှန်</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            {{-- End Highlight Features --}}


            <?php
            $checkdison=\App\Models\sitesettings::where('name','discount_products')->first();
            ?>
            <main-items-component :newitems="{{$new_items}}" :checkdison="'{{$checkdison->action}}'" :isscrollon="'{{$is_scroll_on}}'" :current_shop_count="{{$current_shop_count}}"
            ></main-items-component>
        </div>
    </div>
    {{-- End Main Content --}}

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

    
@endsection()

@push('custom-scripts')
<script>
$(document).ready(function () {
    $('#pshop_slide').owlCarousel({
        loop: true,
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
        /* * {
            background: #000 !important;
            color: #0f0 !important;
            outline: solid #f00 1px !important;
        } */

        .choose-product-type, .shweshops-features {
            padding: 2em 0;
        }

        .choose-product-type-btn {
            background-color: #fff8db;
            border-radius: 7px;
            box-shadow: 0 0 10px hsla(350, 42%, 43%, 0.6);
            padding: 20px 0px 20px 40px;
            margin-bottom: 18px;
            position: relative;
        }

        .choose-product-type-btn:hover {
            background-color: rgba(255, 108, 132, 0.2);
            transition: background-color linear 0.3s;
        }

        .baydin, .shops-guide {
            background-color: #780116;
            height: 200px;
            border-radius: 7px;
            padding: 20px 20px 15px 20px;
            margin-bottom: 18px;
            color: #fff8db;
            font-size: 16px;
            font-weight: bold;
        }

        .bg-overlay-baydin {
            width: 100%;
            background: linear-gradient(0deg, #2c2c2c50, #2c2c2c50 ), url(/images/baydin/sign/6422d9a4819b7_sign_logo.alpha-logo.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .bg-overlay-shops-guide {
            width: 100%;
            background: linear-gradient(0deg, #46000d50, #46000d50 ), url(/images/baydin/sign/642436478ec87_sign_logo.good-tiktok-profile-picture-16.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .shops-guide-icon {
            color:#fff8db;
            background-color: #780116;
            width: 60px !important;
            height: 60px !important;
            font-size: 30px;
            text-align: center;
            border-radius: 100%;
            margin-bottom: 30px;
        }

        .product-text-mmr {
            color: #780116;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-text-eng {
            color: #780116;
            font-size: 20px;
            margin-bottom: 0px;
        }

        .product-icon-area {
            position: absolute;
            top: 50%;
            left: 85%;
            transform: translate(-85%,-50%);
            width:80px;
            height:80px;
        }

        .image-circle {
            background-color: #fff8db;
            border-radius: 100%;
        }
        
        .heading-font {
            font-size: 22px;
            font-weight: bold;
        }

        .product-text-mmr-mobile {
            font-size: 20px;
            color: white;
            background-color: #780116;
            padding: 10px 0;
            border-radius: 0 0 7px 7px;
        }

        .see-more-button {
            background: #780116 !important;
            color: #fff !important;
            padding: 8px 12px;
        }

        .see-more-button:hover {
            background-color: #000 !important;
            color: #fff !important;
        }

        @media (max-width: 768px) {
            .banner {
                min-height: 250px;
                max-height: 600px;
            }

            .product-text-mmr {
                font-size: 26px;
            }

            .product-text-eng {
                font-size: 16px;
            }
        }

        .kanok-frame {
            position: absolute;
            top: 0;
            z-index: 9;
            height: 101% !important;
            width: 98% !important; 
            object-fit: fill;
            left: 4px !important;
        }
        .kanok-frame img:hover {
        opacity: 1 !important;
        }

        @media (max-width: 576px){
            .product-icon-area {
                top: 75%;
                left: 85%;
                transform: translate(-85%,-75%);
                width:50px;
                height:50px;
            }

            .product-text-mmr {
                font-size: 5vw;
            }

            .product-text-eng {
                font-size: 3vw;
            }

            .choose-product-type-btn{
                padding-left: 20px;
            }

            .kanok-frame {
                width: 98% !important;
                padding-left: 2px;
            }

            .banner {
                height: 250px;
            }
        }
    </style>
@endpush