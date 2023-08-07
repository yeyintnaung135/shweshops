
{{--New arrival--}}
<div class="col-12 d-none show_dev  ">
    <div id="" class="sop-font px-md-3">
        {{--  product title--}}
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5">
            <div class="elementor-widget-container d-flex justify-content-center">
                <h3 class="mb-3 elementor-heading-title elementor-size-default" style="font-family: sans-serif!important">Best Sellers</h3>

            </div>
        </div>
        {{--  products list--}}
        <div class="col-12 mt-4 main-content">
            <div id="bestsellers_slide" class="owl-carousel owl-theme w-100 d-none  ps-4 px-md-5">
                @foreach($items as $item)
                <div class="ftc-product product">
                    <div class="images post-img sop-img" style="margin-bottom: 0px !important;">
                        <span class=" fa fa-user yk-viewcount sop-hover-show">
                            {{$item->yk_view}}
                        </span>
                        <a href="{{url($item->WithoutspaceShopname.'/product_detail/'.$item->id)}}">
                            <img class="sop-image-w-h sop-img" src="{{url($item->check_photo)}}"/>
                        </a>
                    </div>
                    <div class="item-description mt-2">
                        <div class="price">
                            <span class="woocommerce-Price-amount amount sop-amount" style="color:#780116 !important;font-weight: 600 !important;">
                                <bdi style="float:left !important;">
                                    {!!$item->mm_price!!}
                                </bdi>
                            </span>
                        </div>
                    </div>
                    {{-- <div class="price">
                        <a href="{{url('product_detail/'.$item->id)}}" class=" float-start sop-btmn">Buy Now</a>
                    </div> --}}
                </div>
                @endforeach
                @if (count($items) >= 20)
                <div class="sn-similar-seeall">
                    <a href="{{url('/see_all_for_shop/latest/'.$shop_data->id)}}">
                      <div>
                        <i class="fa-solid fa-arrow-right"></i>
                      </div>
                      <div class="see-all-text">See all</div>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
{{--New arrival--}}
@push('custom-scripts')
    <script>
$('#bestsellers_slide').owlCarousel({
            loop: false,
            margin: 20,
            responsiveClass: true,
            autoplay: false,
            dots: false,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
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
                    stagePadding: 0,
                },
                1200: {
                    items: 5,
                    stagePadding: 0,
                },
                1400: {
                    items: 6,
                    stagePadding: 0,
                }
            }
        });
        $(document).ready(function () {
            $('#bestsellers_slide').removeClass('d-none');
        })
    </script>
@endpush
@push('css')
<style>
    @media only screen and (max-width: 600px) {
            #bestsellers_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 25px !important;
            }
        }
        @media only screen and (min-width: 600px) {
            #bestsellers_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
        }

</style>
@endpush
