{{-- <x-wrappercomponent div-id="preminumwrap" toshow-id="preminum"></x-wrappercomponent> --}}

{{-- shop slide--}}
<div id="preminum" class="col-12 d-none show_dev">
    <div id="primary2" class="sop-font">
        {{--  product title--}}
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5 d-flex justify-content-end">
            <div class="elementor-widget-container d-flex justify-content-between">
                <h3 class="elementor-heading-title elementor-size-default" style="font-family: sans-serif!important">လူကြည့်များသောဆိုင်များ</h3>
            </div>
            <div>
                <a class="btn see-more-button" href="/popular_shops" style="white-space: nowrap; border-radius: 7px;">See All <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
        @if (count($popular_shops) == 0)
        <div class="sn-no-items">
            <div class="sn-cross-sign"></div>
            <i class="fa-solid fa-box-open"></i>
            <span>No Shops Found</span>
        </div>
        @else
        {{--  product title--}}
        <div class="col-12 mt-4 main-content ">
            <div id='popularShop_slide' class="owl-carousel owl-theme w-100 ps-4 px-md-5">
                @foreach($popular_shops as $shop)

                <article class="post-wrapper">
                    <div class="post-img sop-img">
                        <a class="" href="{{url('/'.$shop->shop_name_url)}}">
                            @if(empty($shop->shop_logo))
                            <img src="test/test1.jpg"class="sn-shop-image attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded  sop-image-w-h"alt="">
                            @else
                            <img src="{{url('images/logo/mid/'.$shop->shop_logo)}}"class="sn-shop-image attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded  sop-image-w-h"
                            alt="">
                            @endif
                        </a>

                        
                    </div>
                    <div class="post-info">
                        <h3 class="yk-product-title "><a class="sop-font-content sop-font mt-2" style="font-family: sans-serif!important"
                            href="{{url('/'.$shop->shop_name_url)}}">{{\Illuminate\Support\Str::limit($shop->shop_name, 12, '...')}}</a>
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
<script type="text/javascript">
    $('#popularShop_slide').owlCarousel({
        loop: true,
        margin: 20,
        responsiveClass: true,
        autoplay: false,
        dots: false,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,

        responsive: {
            0: {
                items: 1.5,
                stagePadding: 0,
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
</script>
@endpush


