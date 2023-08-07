@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')
    @include('layouts.frontend.allpart.mobile_search')
    <div id="page" class="site my-0 py-0">

    {{--MENU--}}
    
    {{-- end Menu--}}

    {{--Loading Wrapper--}}
    @include('layouts.frontend.allpart.loading_wrapper')
    {{-- Loading--}}


    <!-- .site-content-contain -->
        <div class="site-content-contain">
            <div id="content" class="site-content">
                <div class="col-12">
                    <img class="w-100" style="height:253px;" src="{{url('test/test.jpg')}}"></div>
                </div>


            </div>
            <div class="page-container container pl-0 pr-0 show_breadcrumb_">
                <div class="row">

                    <!-- Left Sidebar -->


                    <div id="main-content" class="mt-4 col-12 ">

                        <div class="site-content " style="border-bottom: 2px solid #a0793614;">

                            {{--  product title--}}

                            <div
                                class="text-center mt-0 mt-sm-5 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading">
                                <div class="elementor-widget-container">
                                    <h3 class="elementor-heading-title elementor-size-default" style="">SEARCH BY TYPING
                                    </h3>
                                    <figure class="wp-caption">
                                        <img width="139" height="21"
                                             src="{{url('test/title-after.png')}}"
                                             class="attachment-large size-large" alt=""/>
                                    </figure>
                                </div>

                            </div>
                            {{--  products list--}}
                            <div class="col-12 main-content mb-5">
                                <form method="post" action="{{url('search')}}">
                                    <div class="d-flex "
                                         style="padding-left: 0px !important;padding-right: 0px !important;margin-left:0px !important;margin-right:0px !important;">


                                        <input class="w-auto" name='data' style="width:77% !important;    border: 1px solid #ee6412;" type="text" placeholder="Type what you want to search....." id="">

                                        @csrf
                                        @method('PUT')


                                        <button style="width:30% !important;" type="submit"
                                                class="btn btn-primary yk-button">
                                            Submits
                                            <span class="fa-solid fa-search" style="font-weight: bold;">

                                                    </span>
                                        </button>


                                    </div>

                                </form>
                            </div>
                        </div>


                    </div>


                </div>
            </div>


            <div class="page-container container pl-0 pr-0 show_breadcrumb_">
                <div class="row">

                    <!-- Left Sidebar -->


                    <div id="main-content" class="mt-4 col-12 ">

                        <div class="site-content " style="border-bottom: 2px solid #a0793614;">

                            {{--  product title--}}

                            <div
                                class="text-center mt-0 mt-sm-5 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading">
                                <div class="elementor-widget-container">
                                    <h3 class="elementor-heading-title elementor-size-default" style="">SEARCH ITEMS AS
                                        YOU LIKE
                                    </h3>
                                    <figure class="wp-caption">
                                        <img width="139" height="21"
                                             src="{{url('test/title-after.png')}}"
                                             class="attachment-large size-large" alt=""/>
                                    </figure>
                                </div>

                            </div>
                            {{--  products list--}}
                            <div class="col-12 main-content">
                                <form method="post" action="{{url('search')}}">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Categories</label>
                                                <select class="form-control" name="category_id"
                                                        id="exampleFormControlSelect1">
                                                    <option value="" selected>Any</option>

                                                    <option value="hair_clip">ကလစ် [ Hair Clip ]</option>
                                                    <option value="comb">ဘီး[ Comb ]</option>
                                                    <option value="hair_pin">ဆံထိုး [ Hair ]</option>
                                                    <option value="headband">ဘီးကုတ် [ Headband ]</option>
                                                    <option value="necklace">ဆွဲကြိုး [ Necklace ]</option>
                                                    <option value="bayat">ဘယက် [ Necklace ]</option>
                                                    <option value="pendant">လောကပ်သီး [ Pendant ]</option>
                                                    <option value="earring">နားကပ် [ Earring ]</option>
                                                    <option value="nrrswel">နားဆွဲ [ Earring ]</option>
                                                    <option value="brooch">ရင်ထိုး [ Brooch ]</option>
                                                    <option value="ring">လက်စွပ် [ Ring ]</option>
                                                    <option value="braceket">လက်ကောက် [ Braceket ]</option>
                                                    <option value="hand_chain">ဟန်းချိန်း [ HandChain ]</option>
                                                    <option value="pixiu">ပီချူး [ Pixiu ]</option>
                                                    <option value="footchain">ခြေကျင်း [ FootChain ]</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 mt-3 mt-md-0">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Shops</label>
                                                <div class="select2-purple">

                                                    <select class="select2" multiple="multiple" name="shops[]"
                                                            data-placeholder="Select Shops"
                                                            data-dropdown-css-class="select2-purple"
                                                            style="width: 100%;">
                                                        @foreach($shops as $shop)
                                                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 mt-3 ">
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1">PRICE RANGE</label>

                                                        <select class="form-control" name="price_range"
                                                                id="exampleFormControlSelect4">
                                                            <option value="" selected>Any</option>
                                                            <option value="50000-100000">From 5သောင်း To 1သိန်း</option>
                                                            <option value="100000-500000">From 1သိန်း To 5သိန်း</option>
                                                            <option value="500000-1000000">From 5သိန်း To 10သိန်း
                                                            </option>
                                                            <option value="1000000-5000000">From 10သိန်း To 50သိန်း
                                                            </option>
                                                            <option value="5000000-10000000">From 50သိန်း To
                                                                100သိန်း
                                                            </option>
                                                            <option value="10000000-50000000">From 100သိန်း To
                                                                500သိန်း
                                                            </option>
                                                            <option value="50000000-100000000">From 500သိန်း To
                                                                1000သိန်း
                                                            </option>

                                                        </select>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 mt-3 ">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Gold Quality</label>
                                                <select class="form-control" name="gold_quality"
                                                        id="exampleFormControlSelect6">
                                                    <option value="" selected>Any</option>
                                                    <option value="24K">24K</option>
                                                    <option value="22K">22K</option>
                                                    <option value="18K">18K</option>
                                                    <option value="14K">14K</option>
                                                    <option value="12K">12K</option>
                                                    <option value="10K">10K</option>
                                                    <option value="9K">9K</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 mt-3 ">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Gold Color</label>
                                                <select class="form-control" name="gold_color"
                                                        id="exampleFormControlSelect7">
                                                    <option value="" selected>Any</option>
                                                    @foreach($gold_color as $gc)
                                                        <option
                                                            value="{{$gc->gold_colour}}">{{$gc->gold_colour}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    @csrf
                                    <div class="col-auto  mt-3 " style="float:right;">
                                        <button type="submit" class="btn btn-primary mb-2  yk-button ">Submit <span
                                                class="fa-solid fa-search" style="font-weight: bold;"></span></button>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>


                </div>
            </div>
        </div>
        {{--        <!-- #content -->--}}

        <div class="pt-5">
            @include('layouts.frontend.allpart.footer')
        </div>
    </div>
    {{--    <!-- .site-content-contain -->--}}


    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

    <div id="to-top" class="scroll-button">
      <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>

    <div class="popupshadow" style="display:none"></div>

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

    <script type="text/javascript">
        $(document).ready(function () {
            $(".zh-f-d").hide();
        });

    </script>

@endsection
@push('script')

@endpush
