<div class="col-12" style="height: 222px !important;position:relative !important">
    @include('layouts.frontend.allpart.loading_wrapper')

</div>


{{--Discount--}}
<div class="col-12 d-none show_dev">
    <div id="" class="sop-font px-md-3">
        {{--  product title--}}
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5">
            <div class="elementor-widget-container d-flex justify-content-start">
                <h3 class="elementor-heading-title elementor-size-default" style="font-family: sans-serif!important">Discount Products</h3>
            </div>
        </div>
        @if (count($discount) == 0)

          <div class="sn-no-items">
            <div class="sn-cross-sign"></div>
            <i class="fa-solid fa-box-open"></i>
            <span>ပစ္စည်းမရှိသေးပါ</span>
          </div>
        @else

        {{--  products list--}}
        <div class="col-12 mt-4 main-content">
            <div id="discount_slide" class="owl-carousel owl-theme w-100  ps-4 px-md-5">
                @foreach($discount as $dis)

                <div class="ftc-product product" style="position: relative!important;">
                    <a href="{{url($dis->itemby_discount->WithoutspaceShopname.'/product_detail/'.$dis->itemby_discount->id)}}">
                        <div class="sop-ribbon ">
                            <span>-{{$dis->percent}}%</span>
                        </div>
                    </a>
                    <div class="post-img sop-img" style="margin-bottom: 0px !important;">
                        <a href="{{url('/'.$dis->itemby_discount->WithoutspaceShopname)}}" style="color: #ffe775 !important">

                        <div class="yk-hover-title sop-rounded-top text-capitalize text-left g-0" style="width:100% !important;">
                            <img src="{{url('images/logo/thumbs/'.$dis->itemby_discount->shop_name->shop_logo)}}" class="yk-hover-logo float-left"/>
                            <span>
                                {{\Illuminate\Support\Str::limit($dis->itemby_discount->shop_name->shop_name, 15, '...')}}
                            </span>
                        </div>
                        </a>

                        <span class=" fa fa-user yk-viewcount">
                            {{$dis->itemby_discount->yk_view}}
                        </span>
                        <a href="{{url($dis->itemby_discount->WithoutspaceShopname.'/product_detail/'.$dis->itemby_discount->id)}}">
                            <img class="sop-image-w-h" src="{{url($dis->itemby_discount->check_photo)}}"/>
                        </a>
                    </div>


                    <div class="item-description mt-2">
                        <div class="price ">


                            {{-- <span class="woocommerce-Price-amount amount sop-amount sop-opacity-50" style="color:black !important;font-weight: 300 !important;">

                                <bdi style="float:left !important;text-decoration: line-through !important;">
                                    {!!$dis->itemby_discount->mm_price !!}

                                </bdi>

                            </span> --}}

                            <span class="woocommerce-Price-amount amount sop-amount" style="color:#780116 !important;font-weight: 600 !important;">

                                <bdi style="float:left !important;">
                                    {!!$dis->mm_price!!}
                                </bdi>
                            </span>
                        </div>


                    </div>
                    {{-- <div class="price">
                        <a href="{{url('product_detail/'.$dis->itemby_discount->id)}}" class=" float-start sop-btmn">Buy Now</a>
                    </div> --}}
                </div>

                @endforeach
                @if (count($discount) >= 20)
                  <div class="sn-similar-seeall">
                    <a href="{{url('/see_all_discount')}}">
                      <div>
                        <i class="fa-solid fa-arrow-right"></i>
                      </div>
                      <div class="see-all-text">See all</div>
                    </a>
                  </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
{{--Discount--}}
