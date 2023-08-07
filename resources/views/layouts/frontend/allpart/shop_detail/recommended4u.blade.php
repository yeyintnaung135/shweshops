
{{--New arrival--}}
<div class="col-12 d-none show_dev ">
    <div id="" class="sop-font px-md-3">
        {{--  product title--}}
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5">
            <div class="elementor-widget-container d-flex justify-content-center">
                @if (isset(Auth::user()->id))
                <h3 class="mb-3 elementor-heading-title elementor-size-default" style="font-family: sans-serif!important">Recommended For
                    {{-- {{ Auth::user()->name}} --}}You
                </h3>
                @else
                <h3 class="mb-3 elementor-heading-title elementor-size-default" style="font-family: sans-serif!important">Recommended For You</h3>
                @endif
            </div>
        </div>


        <div class="col-12 mt-4 main-content">
            <div id="Recommended4u_slide" class="owl-carousel owl-theme w-100 d-none ps-4 px-md-5">
                @foreach($Recommended_items as $item)
                <div class="ftc-product product"  style="position: relative!important;">
                   @isset($item->YkgetDiscount->percent)
                    <a href="{{url($item->WithoutspaceShopname.'/product_detail/'.$item->id)}}">
                        <div class="sop-ribbon ">
                            <span>-{{$item->YkgetDiscount->percent}}%</span>
                        </div>
                    </a>
                   @endisset

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
                            <span class="woocommerce-Price-amount amount sop-amount-rc" style="color:#780116 !important;font-weight: 600 !important;">
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
$('#Recommended4u_slide').owlCarousel({
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
                    stagePadding: 75,
                },
                600: {
                    items: 2,

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
        $(document).ready(function () {
            $('#Recommended4u_slide').removeClass('d-none');
        })

    </script>
@endpush
@push('css')
<style>
    /* @media only screen and (min-width: 576px){
        .sop-amount-rc {
            color: #780116 !important;
            font-size: 20px !important;
            line-height: 32px !important;
            float: left !important;
        }
    } */

    .sop-amount-rc {
        color: #780116 !important;
        font-size: 20px !important;
        line-height: 32px !important;
        float: left !important;
    }
    .sop-amount-rc span{
        color: #780116 !important;
        font-size: 16px !important;
        line-height: 32px !important;
        font
        /* float: left !important; */
    }
    @media only screen and (max-width: 600px) {
            #Recommended4u_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 75px !important;
            }
        }
        @media only screen and (min-width: 600px) {
            #Recommended4u_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
        }

</style>
@endpush
