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

                <div class="row mb-2" style="text-align: center;">
                    <h1>Check out</h1>
                </div>
                <?php
                $item = \App\Item::where('id', $item_id)->first();
                ?>
                @if($item->check_discount != 0)
                    <?php
                    $get_dis = \App\discount::where('id', $item->check_discount)->first();
                    if($get_dis->discount_price=0){
                        $fee=($get_dis->discount_price/100) * 10;
                    }else{
                        $fee=($get_dis->discount_max/100) * 10;

                    }
                    ?>
                    {{-- <h3 class="product_title entry-title yk-jello-horizontal sn-discount-badge">
                        {{$get_dis->percent}}% <span class="sn-off-text">OFF</span></h3> --}}
                @else
                    <?php
                    $get_dis='no';
                    if($item->price!=0){
                        $fee=($item->price/100) * 10;
                    }else{
                        $fee=($item->max_price/100) * 10;

                    }
                    ?>

                @endif
<checkout :item="{{$item}}" :fee="{{$fee}}" :disitem="'{{$get_dis}}'" :orderid="{{$order_id}}" :csrf="'{{csrf_token()}}'"></checkout>



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
@push('custom-scripts')
    <script>


        // zh buynow log

        //zh add to cart log


        // Initialise Carousel
        const mainCarousel = new Carousel(document.querySelector("#mainCarousel"), {
            Dots: false,
        });

        // Thumbnails
        const thumbCarousel = new Carousel(document.querySelector("#thumbCarousel"), {
            Sync: {
                target: mainCarousel,
                friction: 0,
            },
            Dots: false,
            Navigation: false,
            center: true,
            slidesPerPage: 1,
            infinite: false,
        });

        // Customize Fancybox
        Fancybox.bind('[data-fancybox="gallery"]', {
            Carousel: {
                on: {
                    change: (that) => {
                        mainCarousel.slideTo(mainCarousel.findPageForSlide(that.page), {
                            friction: 0,
                        });
                    },
                },
            },
        });


        jQuery(function ($) {


            $('#button_slide_collection').owlCarousel({
                loop: false,
                margin: 29,
                responsiveClass: true,
                autoplay: false,
                dots: false,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                nav: false,

                responsive: {

                    0: {
                        items: 2,
                        stagePadding: 25,
                    },
                    600: {
                        items: 3,
                    },
                    900: {
                        items: 4,
                    },
                    1200: {
                        items: 5,
                    },
                    1400: {
                        items: 6,
                    }
                }
            });

        });
    </script>



@endpush
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

        .ss-chat-wrapper {
            background: #780116;
            width: 35px;
            height: 35px;
            padding: 3px;
            border-radius: 50%;
        }

        .chat-with-us img:hover {
            cursor: pointer;
        }

        .chat-with-us-container {
            background: #ffffff;
            bottom: 70px;
            z-index: 999;
            border: 1px solid #c1c1c1;
            box-shadow: 0px 0px 5px 0px #dbdbdb;
            border-radius: 20px;
            padding: 25px 0;
        }

        .chat-with-us-container ul li:hover {
            background: #efefef;
            cursor: pointer;
        }

        .sn-buynow-button {
            /* zh-modify */
            background: #fff !important;
            border-radius: 5px !important;
            border-color: #780116 !important;
            width: 100% !important;
            color: #780116 !important;
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

