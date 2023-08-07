<div class="col-12" style="height: 222px !important;position:relative !important">
    @include('layouts.frontend.allpart.loading_wrapper')

</div>
{{--New arrival--}}
<div class="col-12 d-none show_dev  ">
    <div id="" class="sop-font px-md-3">
        {{--  product title--}}
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5">
            <div class="elementor-widget-container d-flex justify-content-between">
                <h3 class="elementor-heading-title elementor-size-default">New Arrivals</h3>

            </div>
        </div>
        {{--  products list--}}
        <div class="col-12 mt-4 main-content">
            <div id="new_arrival_slide" class="owl-carousel owl-theme w-100  ps-4 px-md-5">
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
