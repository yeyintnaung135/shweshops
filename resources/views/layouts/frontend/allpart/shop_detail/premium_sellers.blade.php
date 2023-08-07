<x-wrappercomponent div-id="preminumwrap" toshow-id="preminum"></x-wrappercomponent>

{{-- shop slide--}}
<div id="preminum" class="col-12 d-none show_dev">
    <div id="primary2" class="sop-font">
        {{--  product title--}}
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5 d-flex justify-content-end">
            <div class="elementor-widget-container d-flex justify-content-between">
                <h3 class="elementor-heading-title elementor-size-default" style="font-family: sans-serif!important">Premium ဆိုင်များ</h3>
            </div>
            <div>
                <a class="btn see-more-button" href="/premium_shops" style="white-space: nowrap; border-radius: 7px;">See All <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
        @if (count($premium) == 0)
        <div class="sn-no-items">
            <div class="sn-cross-sign"></div>
            <i class="fa-solid fa-box-open"></i>
            <span>No Premium Shops Available.</span>
        </div>
        @else
        {{--  product title--}}
        <div class="col-12 mt-4 main-content ">
            <div id='pshop_slide' class="owl-carousel owl-theme w-100 px-md-5">
                @foreach($premium as $shop)

                <article class="post-wrapper">
                    <div class="post-img sop-img">
                        <a class="" href="{{url('/'.$shop->withoutspace_shopname)}}">
                            @if(empty($shop->shop_logo))
                            <img src="test/test1.jpg"class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded  sop-image-w-h"alt="">
                            @else
                            <img src="{{url('images/logo/mid/'.$shop->shop_logo)}}"class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded  sop-image-w-h p-1 px-2"
                            alt="">
                            <img src="{{url('/images/directory/banner/Frame 925.png')}}" alt="" srcset="" class="kanok-frame">
                            @endif
                        </a>
                    </div>
                    <div class="post-info">
                        <header class="entry-header">
                            <!-- Blog Title -->
                            <h3 class="yk-product-title ps-2"><a class="sop-font-content sop-font mt-2" style="font-family: sans-serif!important"
                                href="{{url('/'.$shop->withoutspace_shopname)}}">{{\Illuminate\Support\Str::limit($shop->shop_name, 12, '...')}}</a>
                            </h3>
                            <!-- Blog Author -->
                            <span class="vcard author" style=""></span>
                            <!-- Blog Categories -->
                        </header>
                        <div class="clear"></div>
                        {{-- <div class="entry-content sop-amount sop-font-content sop-font sop-color-vermilion">
                            <p>{{\Illuminate\Support\Str::limit($shop->description, 16, '..')}}</p>
                        </div> --}}
                        <div class="clear"></div>
                        {{-- <a href="{{url('shops/'.$shop->id)}}"class=" float-start sop-btmn">Shop Now
                        </a> --}}
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
});
</script>
@endpush