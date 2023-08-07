@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    {{--MENU--}}
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')
    {{-- end Menu--}}
    <div id="page" class="site my-0 py-0">

    {{--MENU--}}

    {{-- end Menu--}}




    <!-- .site-content-contain -->
        <div class="site-content-contain">
            {{-- breadcum--}}
            <div id="content" class="site-content">
                      {{-- profile --}}
                    <div class=" text-left container my-5 pb-md-0 pb-3">
                        <div class="row">
                            <div class="col-5 col-md-6 d-flex justify-content-end">
                                <img src="{{url($shop_data->shop_logo)}}" class="sop-logo" alt="shop logo">
                            </div>
                            <div class="col-7 col-md-6 sop-font ">
                                <div class="pt-2 ps-1">
                                    <div class="row">
                                        <h3 class="product_title page-title entry-title text-break text-dark">
                                            {{\Illuminate\Support\Str::limit($shop_data->shop_name, 22, '..')}}
                                        </h3>
                                    </div>
                                    <div class="row col-md-6">
                                        <p class="sop-opacity-8">
                                            {{$shop_data->description}}

                                        </p>
                                    </div>
                                    <div class="row">
                                        <a href="#address" data-toggle="modal" data-target="#address" class="sop-opacity-8">
                                            <i class="fa fa-external-link"></i> Address </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="address" tabindex="-1" aria-labelledby="addressModal" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addressModal">Address</h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if(!empty($shop_data->main_phone))
                                                            <p class="text-break phone">
                                                            <span class="fa fa-phone yk-color text"
                                                            ></span>
                                                            {!!nl2br($shop_data->main_phone)!!}

                                                        </p>
                                                        @endif
                                                        <p class="text-break address">
                                                            <span class="fa fa-map-marker yk-color text" ></span>
                                                            {!!nl2br($shop_data->address)!!}
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- modal --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- profile --}}

            </div>

            {{-- loading --}}
            <div class="col-12 loading">
                @include('layouts.frontend.allpart.loading_wrapper')
            </div>
            {{-- loading --}}
            {{-- Categories--}}
            <div class="show_breadcrumb d-none show_dev">
                @include('layouts.frontend.allpart.categories_shop_details')
            </div>
            {{-- Categories--}}
            {{-- breadcum--}}
            <div class="pt-4 col-12 ">
            <div class="px-0 ">
                @if($items->count()!=0)
            {{--new item--}}
            <all-items-forshop :allitems="{{$items}}" :forcheck_count="{{$forcheck_count}}" :uri="'get_newitems_forshop_ajax'"></all-items-forshop>
            {{--new item--}}
            @endif
            </div>
        </div>

        <div class="px-0 px-md-2">
            {{--New Arrival--}}
            @if($items->count()!=0)
            @include('layouts.frontend.allpart.new_arrival_items')
            @endif
            {{--New Arrival--}}
        </div>
        {{-- asalebanner --}}
        {{-- salebanner (currently set banner pic) --}}
        <div class="px-2 px-md-5 mx-lg-5 pt-3 ">
            <div class="sop-rounded">
                <img src="{{url($shop_data->shop_banner)}}" alt="sale banner" class="sop-banner sop-rounded">
            </div>
        </div>
        {{-- dsalebanner --}}

        {{-- dsalebanner --}}
        <div class="px-0">
            @if($discount->count()!=0)
            {{--Discount--}}
            @include('layouts.frontend.allpart.discount_items')

            {{--Discount--}}
            @endif
        </div>
        {{-- dsalebanner --}}

        {{-- map (change with dynamic degrees) --}}
        <div class="px-0 px-md-5 pt-3 w-100">
            <div class="px-lg-5 d-none show_dev">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d238.60995656534973!2d96.1980297770541!3d16.887797136151246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smm!4v1644909675991!5m2!1sen!2smm" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
        {{-- map --}}
        {{--//shop slide--}}
        <div class="px-0">
            @include('layouts.frontend.allpart.premium_sellers')
        </div>
        {{--//shop slide--}}

        </div>
                <!-- #content -->

                <div class="pt-5">
                    @include('layouts.frontend.allpart.footer')
                </div>
    </div>
        <!-- .site-content-contain -->


    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

    <div id="to-top" class="scroll-button">
      <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>

    <div class="popupshadow pop"></div>

    <div class="ftc-off-canvas-cart">
        <div class="off-canvas-cart-title">
            <div class="title">Shopping Cart</div>
            <a href="#" class="close-cart"> Close</a>
        </div>
        <div class="off-can-vas-inner">
            <div class="woocommerce widget_shopping_cart">
                <div class="widget_shopping_cart_content">


                    <p class="woocommerce-mini-cart__empty-message">No products in the cart.</p>


                </div>
            </div>
        </div>
    </div>


@endsection
@push('custom-scripts')
    <script>
        jQuery(function ($) {
            $('html, body').animate({
                scrollTop: 444
            }, 'slow');
        });
    </script>
@endpush
@push('css')
    <style>
        .phone{
           text-align: left;
           font-size: 16px;
           height: auto;
           overflow: auto;
        }
        .address{
            text-align: left;
            font-size: 16px;
            height: 222px;
            overflow: auto;
        }
        .text{
            font-size:32px;
        }
        .loading{
            height: 222px !important;
            position: relative !important;
        }
        .pop{
           display:none;
        }
    </style>
@endpush
