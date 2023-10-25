<div class="col-12" style="height: 222px !important;position:relative !important">
    @include('layouts.frontend.allpart.loading_wrapper')

</div>


{{--Discount--}}
<div class="col-12 d-none show_dev px-lg-5  ">
    <div id="" class="sop-font px-md-3">
        {{--  product title--}}
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5">
            <div class="elementor-widget-container d-flex justify-content-between">
                <h3 class="elementor-heading-title elementor-size-default">Collections Items</h3>
                <a href="{{url('allcollections')}}" class="sop-opacity-8">... See more</i></a>
            </div>
        </div>
        {{--  products list--}}
        <div class="col-12 mt-4 main-content ">
            <div id="collection_slide" class="owl-carousel owl-theme w-100  ps-4 px-md-5">
                @foreach($collection_items as $col)

                    <div class="ftc-product product ">
                        <div class="images post-img sop-img" style="margin-bottom: 0px !important;">
                            <div class="yk-hover-title sop-rounded-top text-capitalize text-left g-0" style="width:100% !important;">
                                <img src="{{filedopath('shop_owner/logo/mid'.$col->shop_name->shop_logo)}}" class="yk-hover-logo float-left"/>
                                <span>
                                {{\Illuminate\Support\Str::limit($col->shop_name->shop_name, 15, '...')}}
                            </span>
                            </div>
                            
                                <span class=" fa fa-eye yk-viewcount ">
                                    {{$col->yk_view}}
                                </span>
                            
                            
                            <a href="{{url('product_detail/'.$col->id)}}">
                                <img class="sop-image-w-h" src="{{filedopath('items/mid/'.$col->check_photo)}}"/>
                            </a>
                        </div>


                        <div class="item-description mt-2">


                            <div class="price ">
                            <span class="woocommerce-Price-amount amount sop-amount" style="color:#780116 !important;font-weight: 600 !important;">
                                <bdi style="float:left !important;">
                                    {!!$col->mm_price!!}
                                </bdi>
                            </span>
                            </div>
                        </div>
                        {{-- <div class="price">
                            <a href="{{url('product_detail/'.$col->id)}}" class=" float-start sop-btmn">Buy Now</a>
                        </div> --}}
                    </div>

                @endforeach

            </div>
        </div>
    </div>
</div>
{{--Discount--}}
@push('custom-scripts')
    <script>
    jQuery(function ($) {
        $('#collection_slide').owlCarousel({
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
                    stagePadding: 0,
                },
                900: {
                    items: 4,
                    stagePadding: 0,
                },
                1200: {
                    items: 5,
                    stagePadding: 0,
                },
                1400:{
                    items: 6,
                    stagePadding: 0,
                }
            }
        });

});
    </script>
@endpush
