@extends('layouts.frontend.frontend')
@section('content')
@include('layouts.frontend.allpart.for_mobile')
@include('layouts.frontend.allpart.upper_menu')
@include('layouts.frontend.allpart.menu')

    <div id="page" class="site my-0 py-0">


        <br><br>

 

    {{--Filter--}}
    <header id="masthead" class="zh-header collections_head site-header d-none" style="border-bottom: none;margin-top: -33px;margin-bottom: -14px;">
        <div class="zh-col-b" style="margin-bottom: 10px;">
            <a href="{{asset(('/'))}}">
                <i class="fa fa-angle-left" aria-hidden="true" style="margin-right: 10px;"></i>
                Collections
            </a>
        </div>

        <!-- zh-nav-bar -->
        <!-- nav-bar -->
        @include('front.collections.nav')
        <!-- end nav-bar -->
    </header>
     
    {{--Filter--}}

    {{--Loading Wrapper--}}
      @include('layouts.frontend.allpart.loading_wrapper')
    {{-- Loading--}}


     <!-- .site-content-contain -->
        <div class="site-content-contain">
            <div id="content" class="site-content ">
            @include('front.collections.items')
            </div>
        </div>
        {{--<!-- #content -->--}}

        @include('layouts.frontend.allpart.footer')
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


@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="{{ asset('shwe_news/js/app.js')}}"></script>
@endpush
