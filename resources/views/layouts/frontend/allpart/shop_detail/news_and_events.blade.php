{{-- New & Events --}}
<div class="col-12 d-none show_dev  ">
    <div id="" class="sop-font px-md-3">
        {{--  product title --}}
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading">
            <div class="elementor-widget-container d-flex justify-content-between align-items-center">
                <h3 class="mb-3 elementor-heading-title elementor-size-default mx-0 pt-3"
                    style="font-family: sans-serif!important">News & Events</h3>
                <a href="{{ url('/news') }}"
                    class="icon-bg text-center d-sm-block d-none
                    @if ($premium_type == '1') icon-bg-gold
                    @elseif($premium_type == '2') icon-bg-diamond
                    @elseif($premium_type == '3') icon-bg-platinum @endif"
                    style="width:40px; height:40px; cursor: pointer;">
                    <i class="fas fa-arrow-right text-secondary" style="padding-top:13px;"></i>
                </a>
                <a href="{{ url('/news') }}" class="d-block d-sm-none">
                    <i class="fas fa-long-arrow-alt-right mt-3 text-secondary pb-2" style="font-size:24px;"></i>
                </a>
            </div>
        </div>
        {{--  products list --}}
        <div class="col-12 mt-4 main-content">
            <div id="newsNevents_slide" class="owl-carousel owl-theme w-100 d-none">
                @foreach ($newsNevents as $ne)
                    <div class="ftc-product product">

                        <div class="card" style="width: 100%">
                            <a href="{{ url($ne->type . '/p/' . $ne->id . '/' . $ne->shop_id) }}">
                                @if ($ne->type == 'events')
                                    <img class=""
                                        src="{{ filedopath('/news_&_events/event/' . $ne->photo) }}"
                                        alt="Card image cap">
                                @elseif($ne->type == 'news')
                                    <img class=""
                                        src="{{ filedopath('/news_&_events/news/' . $ne->image) }}"
                                        alt="Card image cap">
                                @endif
                            </a>
                        </div>
                        <div class="pt-3" style="min-height: 120px">
                            <a href="{{ url($ne->type . '/p/' . $ne->id . '/' . $ne->shop_id) }}">
                                <div style="min-height: 55px" class="pt-2">
                                    <h4 class="card-text fw-bold n-e-title" style="line-height: 26px !important;">
                                        {{-- {{ Str::words($ne->title ,10) }} --}}
                                        {{ $ne->title }}
                                    </h4>
                                </div>
                                <a href=""></a>
                                <div style="min-height: 60px" class="d-lg-block d-none pt-1">
                                    <p class="card-text n-e-desc">{{ $ne->description }}</p>
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
{{-- New arrival --}}
@push('custom-scripts')
    <script>
        $('#newsNevents_slide').owlCarousel({
            loop: false,
            margin: 20,
            responsiveClass: true,
            autoplay: false,
            dots: false,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1,
                    stagePadding: 70,
                },
                600: {
                    items: 1,
                    stagePadding: 100,
                },
                900: {
                    items: 2,
                    stagePadding: 100,
                },
                1200: {
                    items: 3,
                    stagePadding: 100,
                },
                1400: {
                    items: 3,
                    stagePadding: 100,
                }
            }
        });
        $(document).ready(function() {
            $('#newsNevents_slide').removeClass('d-none');
        })
    </script>
@endpush
@push('css')
    <style>
        .n-e-img:hover {
            opacity: 0.9 !important;
        }

        .owl-carousel .owl-stage {
            display: flex;
            align-items: center;
        }

        .n-e-title {
            font-size: 18px !important;
        }

        .n-e-title,
        .n-e-desc {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* number of lines to show */
            line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .n-e-title:hover {
            color: #780116 !important;
        }

        .sop-image-w-h.n-e {
            width: 100% !important;
            height: 100% !important;
            aspect-ratio: 3 / 2 !important;
        }

        @media only screen and (max-width: 600px) {
            #newsNevents_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 25px !important;
            }
        }

        @media only screen and (min-width: 600px) {
            #newsNevents_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
        }

        @media only screen and (max-width: 576px) {
            .n-e-title {
                font-size: 14px !important;
            }

            .sop-image-w-h.n-e {
                width: 100% !important;
                height: 100% !important;
                aspect-ratio: 3 / 2 !important;
            }
        }
    </style>
@endpush
