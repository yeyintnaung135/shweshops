<div class="d-flex justify-content-between align-items-center">
    <div>
        <h3>Shops 
            <span style="font-size: 16px;">( တစ်ဆိုင်ထက်ပို၍ ရွေးချယ်နိုင်ပါသည် )
            </span>
        </h3>
    </div>
    <button>
        <i class="fas fa-search"></i>
    </button>
    
    </div>
<div class="col-12  pt-4 main-content">
    <div id='cato_slide' class="owl-carousel owl-theme w-100 ps-2 px-md-0">
        @foreach($shops as $shop)
        <article class="post-wrapper">
            <div class="post-img sop-cato-img">
                <a class="" href="{{url('shops/'.$shop->id)}}">
                    @if(empty($shop->shop_banner))
                    <img src="test/test1.jpg"class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded sop-image"alt="">
                    @else
                    <img src="{{url($shop->shop_banner)}}"class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded sop-image"
                    alt="">
                    @endif
                </a>
            </div>  
            <div class="post-info">
                <div class=" mt-2 sop-font-content text-center w-100">
                    <p class="sop-item-count">30 ခု</p>
                </div>
        </article>
        @endforeach
    </div>
</div>
@push('css')
<style>
     .sop-cato-img{
            object-fit: cover;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            aspect-ratio: 1 / 1;
            }
    @media only screen and (max-width: 576px) {
        #cato_slide .owl-stage{
                padding-left:0px !important;
                padding-right:25px !important;
            }
        .sop-item-count{
            font-size: 1em;
        }
        .sop-cato-img{
            
        }
    }
    @media only screen and (min-width: 576px) {
        #cato_slide .owl-stage{
                padding-left:0px !important;
                padding-right:0px !important;
            }
            .sop-item-count{
            font-size: 1.5em;
        }
        
    }
    
    
</style>
    
@endpush

@push('custom-scripts')
<script>
    $('#cato_slide').owlCarousel({
            loop: true,
            margin: 20,
            responsiveClass: true,
            autoplay: true,
            dots: false,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,

            responsive: {
                0: {
                    items: 3,
                    stagePadding: 25,
                },
                576: {
                    items: 4,
                    stagePadding: 0,
                },
                768: {
                    items: 4,
                    stagePadding: 0,
                },
                900: {
                    items:5,
                    stagePadding: 0,
                },
                992: {
                    items: 6,
                    stagePadding: 0,
                },
                1200:{
                    items: 7,
                    stagePadding: 0,
                },
                1400:{
                    items: 8,
                    stagePadding: 0,
                },
            }
        });
        
        
</script>
@endpush