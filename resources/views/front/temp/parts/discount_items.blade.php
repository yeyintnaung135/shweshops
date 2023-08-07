<div class="col-12" style="height: 222px !important;position:relative !important">
    @include('layouts.frontend.allpart.loading_wrapper')

</div>

@if(!empty($discount))
{{--Discount--}}
<div class="col-12 d-none show_dev px-lg-5 ">
    <div id="" class="sop-font px-md-3">
        {{--  product title--}}
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5">
            <div class="elementor-widget-container d-flex justify-content-between">
                <h3 class="elementor-heading-title elementor-size-default">Discount Items</h3>
                <a href="#" class="sop-opacity-8">... See More</a>
            </div>
        </div>
        {{--  products list--}}
        <div class="col-12 mt-4 main-content">
            <div id="discount_slide" class="owl-carousel owl-theme w-100  ps-4 px-md-5">
                @foreach($discount as $dis)

                <div class="ftc-product product">
                    <a href="{{url('product_detail/'.$dis->item_id)}}">
                        <div class="sop-ribbon ">
                            <span>-{{$dis->percent}}%</span>
                        </div>
                    </a>
                    <div class="images post-img sop-img" style="margin-bottom: 0px !important;">
                        <div class="yk-hover-title sop-rounded-top text-capitalize text-left g-0" style="width:100% !important;">
                            <img src="{{url($dis->item->shop_name->shop_logo)}}" class="yk-hover-logo float-left"/>
                            <span>
                                {{\Illuminate\Support\Str::limit($dis->item->shop_name->shop_name, 15, '...')}}
                            </span>
                        </div>
                        <span class=" fa fa-eye yk-viewcount sop-hover-show">
                            {{$dis->item->yk_view}}
                        </span>
                        <a href="{{url('product_detail/'.$dis->item_id)}}">
                            <img class="sop-image-w-h" src="{{url($dis->item->check_photo)}}"/>
                        </a>
                    </div>


                    <div class="item-description mt-2">
                        <div class="price ">

                            {{-- <span class="woocommerce-Price-amount amount sop-amount sop-opacity-50" style="color:black !important;font-weight: 300 !important;">
                                <bdi style="float:left !important;text-decoration: line-through !important;">
                                    {!!$dis->item->mm_price !!}

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
                        <a href="{{url('product_detail/'.$dis->item->id)}}" class=" float-start sop-btmn">Buy Now</a>
                    </div> --}}
                </div>

                @endforeach

            </div>
        </div>
    </div>
</div>
@endif
{{--Discount--}}
