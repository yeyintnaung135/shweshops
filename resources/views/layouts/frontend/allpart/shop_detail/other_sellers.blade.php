
{{-- shop slide--}}
<div id="" class="col-12 d-none show_dev">
    <div id="primary2" class="sop-font px-md-3">
        {{--  product title--}}
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5">
            <div class="elementor-widget-container d-flex justify-content-between">
                <h3 class="elementor-heading-title elementor-size-default" style="font-family: sans-serif!important">Other Shops</h3>
            </div>
        </div>
        @if (count($shops) == 0)
          <div class="sn-no-items">
            <div class="sn-cross-sign"></div>
            <i class="fa-solid fa-box-open"></i>
            <span>No Shops Available.</span>
          </div>
        @else
        {{--  product title--}}
        <div class="col-12 mt-4 main-content ">
            <div id='other_shop_slide' class="owl-carousel owl-theme w-100 ps-4 px-md-5 d-flex justify-content-between align-items-center">
                @foreach($othersellers as $shop)

                <article class="post-wrapper">
                    <div class="post-img sop-cato-img">
                        <a class="" href="{{url('/'.$shop->withoutspace_shopname)}}">
                            @if(empty($shop->shop_logo))
                            <img src="test/test1.jpg"class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded  sop-image-w-h"alt="">
                            @else
                            <img src="{{url('images/logo/'.$shop->shop_logo)}}"class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded  sop-image-w-h"
                            alt="">
                            @endif
                        </a>
                    </div>
                    <div class="post-info w-100">

                            <!-- Blog Title -->
                            <h3 class="yk-product-title text-center mt-3">
                     <a class="sop-font-os" href="{{url('/'.$shop->withoutspace_shopname)}}">{{\Illuminate\Support\Str::limit($shop->shop_name, 12, '...')}}</a>
                            </h3>

                    </div>
                </article>
                @endforeach
                {{-- <div class="sn-similar-seeall">
                    <a href="">
                      <div>
                        <i class="fa-solid fa-arrow-right"></i>
                      </div>
                      <div class="see-all-text">See all</div>
                    </a>
                  </div> --}}
            </div>
        </div>
        @endif
    </div>
</div>
{{-- preminum seller slide--}}
@push('custom-scripts')
    <script>
$('#other_shop_slide').owlCarousel({
    loop: false,
            margin: 20,
            responsiveClass: true,
            autoplay: true,
            dots: false,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,

            responsive: {
                0: {
                    items: 3,
                    stagePadding: 0,
                },
                500: {
                    items: 4,
                    stagePadding: 0,
                },
                900: {
                    items: 5,
                    stagePadding: 0,
                },
                1200: {
                    items: 6,
                    stagePadding: 0,
                },
                1400: {
                    items: 7,
                    stagePadding: 0,
                }
            }
        });
        $(document).ready(function () {
            $('#other_shop_slide').removeClass('d-none');
        })

    </script>
@endpush
@push('css')
<style>

    .sop-img-r img{
        border-radius: 50%;
        aspect-ratio: 1/1;

    }
    .post-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    @media only screen and (max-width: 600px) {
            #other_shop_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
            h3 a.sop-font-os {
                font-size: 14px !important;
                font-weight: 500 !important;
                line-height: 28px !important;
            }
        }
        @media only screen and (min-width: 600px) {
            #other_shop_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
            h3 a.sop-font-os {
                font-size: 16px !important;
                font-weight: 600 !important;
                line-height: 28px !important;
            }
            .sop-img-r img{
                width:  150px!important;
                height: 150px!important;
            }
        }

</style>
@endpush
