<div class="page-container show_breadcrumb_" style="">
    <div class="row g-0 py-0 justify-content-center" style="margin-left:0px !important;margin-right:0px !important;">
        {{--main slider--}}
        <div class="col-12 main-content tablet-main-slide">
        {{-- <div class="col-12 main-content tablet-main-slide sop-ads-banner"> --}}
            <div class="remove_wrapp" style="height: 222px !important;">
                @include('layouts.frontend.allpart.loading_wrapper')
            </div>

            <div id='ads_slide' class="text-center owl-carousel owl-theme w-100 d-none">

           {{-- @foreach($ads as $ads)
                <img class=" item zh-main_slide" src="{{url('/images/ads/'.$ads->ad_one)}}"/>
                <img class=" item zh-main_slide" src="{{url('/images/ads/'.$ads->ad_two) }}"/>
                <img class=" item zh-main_slide" src="{{url('/images/ads/'.$ads->ad_three) }}"/>
                <img class=" item zh-main_slide" src="{{url('/images/ads/'.$ads->ad_four) }}"/>
            @endforeach --}}


            </div>


        </div>
        {{--main slider--}}

    </div>
</div>
@push('css')
    <style>
        @media only screen and (max-width: 576px) {
        #ads_slide img {
            width: 100%;
            /* max-height: 240px!important; */
            object-fit: cover;
            object-position: center;
            aspect-ratio: 17/5;
        }
        @supports not (aspect-ratio: auto) {
            #ads_slide img {
                width: 100%;
                max-height: 100px!important;
            }
        }
    }
        @media only screen and (min-width: 576px) {
        #ads_slide img {
            width: 100%;
            /* max-height: 500px!important; */
            object-fit: cover;
            object-position: center;
            aspect-ratio: 17/5;
        }
        @supports not (aspect-ratio: auto) {
            #ads_slide img {
                width: 100%;
                max-height: 200px!important;
            }
        }
    }
    @media only screen and (min-width: 992px) {
        #ads_slide img {
            width: 100%;
            /* max-height: 550px!important; */
            object-fit: cover;
            object-position: center;
            /* aspect-ratio: 16/3; */
            aspect-ratio: 17/5;
        }
        @supports not (aspect-ratio: auto) {
            #main_slide img {
                width: 100%;
                max-height: 300px!important;
            }
        }
    }
    </style>
@endpush
@push('custom-scripts')
<script>
    $('#ads_slide').owlCarousel({
            responsiveClass: true,
            autoplay: true,
            autoplayTimeout: 8000,
            dots: false,
            nav: false,
            loop: true,
            navText: [
                '<button class="yk-slide-btn"><i class="fa fa-angle-left" aria-hidden="true"></button></i>',
                '<button class="yk-slide-btn"><i class="fa fa-angle-right" aria-hidden="true"></button></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 1,
                },
                1000: {
                    items: 1,
                }
            }
        });
</script>
@endpush