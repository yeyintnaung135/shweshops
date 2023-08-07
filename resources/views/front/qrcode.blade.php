@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')

    <div id="page" class="site container-fluid my-0 py-0">


    {{--MENU--}}

    {{-- end Menu--}}
    <!-- .site-content-contain -->


        <div class="site-content-contain sn-site-content">

        </div>

        <!-- .site-content-contain -->
        <div class="site-content-contain">

            <div class="mx-4 px-md-5 show_breadcrumb_">
                <div class="remove_wrapp">
                    @include('layouts.frontend.allpart.loading_wrapper')
                </div>


                <div class="row">
                    <div id="main-content" class="show_dev col-sm-9 col-xs-12 d-none">
                        <img src="{{url($imagename)}}" alt="My Happy SVG"/>

                        {{-- for photo slide and tilte--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-5">
        @include('layouts.frontend.allpart.footer')
    </div>
    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

    <div id="to-top" class="scroll-button">
        <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>





@endsection

@push('css')
    <style>
        .remove_wrapp{
            height: 822px !important;
            position:relative !important;
        }
        .summary{
            padding-right: 0;
        }
        .marginleft{
            margin-left: 10px;
        }
        .mprice{
            text-decoration: line-through !important;
        }
        .zh-icon{
            color: rgb(120, 1, 22) !important;
        }
        .sop-font .zh-p .grey{
            color: grey;
        }
        .userstyle{

            margin-bottom: 20px;
            margin-top: 12px;
            margin-left: 11px;
            color: grey;
            text-color: grey;
        }
        .leftgrey{
            margin-left: 5px;
            color: grey;
        }
        .product_title{
            text-transform: none!important;
        }
        .sn-product-outstock{
            color:red !important;
        }
        .kid{
            font-size:22px;
        }
        .couple{
            height:22px; color:#d80007;
        }
        .women{
            font-size:22px; color:#F7BEC0;
        }
        .men{
            font-size:22px; color:#2E8BC0;
        }
        .unisex{
            font-size:22px; color:#000000;
        }
        .elementor-size-default .product-name .size-content .elementor-widget-heading{
            border-bottom: 2px solid #a0793614;
        }
        .item_type{
            margin: 0 10px;
            font-weight:400;
        }
        .item_tag_name{
            color:#780116 !important;
            text-decoration: underline!important;
        }
        .fbold{
            font-weight: bold;
        }
        .zh-addtocart-button{
            color:white !important;
        }
        .yk-product{
            border: 0px !important;
        }
        .sop-amount{
            font-weight: 600!important;
        }

        .sop-ribbon-pd span {
            width: 136px;
            height: 30px;
            top: 13px;
            right: -46px;
            position: absolute;
            display: block;
            background: #FF0000;
            color: #333;
            font-family: arial;
            font-size: 14px;
            color: white;
            text-align: center;
            line-height: 30px;
            transform: rotate(
                45deg
            );
            -webkit-transform: rotate(52deg);
        }

        .sop-ribbon-pd {
            height: 110px;
            display: block;
            position: absolute;
            overflow: hidden;
            z-index: 111;
            top: 0;
            right: 0;
        }

        .ss-chat-wrapper {
            background: #780116;
            width: 35px;
            height: 35px;
            padding: 3px;
            border-radius: 50%;
        }

        .chat-with-us img:hover {
            cursor: pointer;
        }

        .chat-with-us-container {
            background: #ffffff;
            bottom: 70px;
            z-index: 999;
            border: 1px solid #c1c1c1;
            box-shadow: 0px 0px 5px 0px #dbdbdb;
            border-radius: 20px;
            padding: 25px 0;
        }

        .chat-with-us-container ul li:hover {
            background: #efefef;
            cursor: pointer;
        }

        .sn-buynow-button {
            /* zh-modify */
            background: #fff !important;
            border-radius: 5px !important;
            border-color: #780116 !important;
            width: 100% !important;
            color: #780116 !important;
            font-size: 18px !important;
            padding: 7px 0 !important;
            /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;*/
            font-weight: 500 !important;
        }

        .sn-buynow-button:HOVER {
            background: #f3f3f3b9 !important;
        }

        .zh-addtocart-button {
            background: #780116 !important;
            border-radius: 5px !important;
            border-color: #780116 !important;
            width: 100% !important;
            color: rgba(247, 181, 56, 1) !important;
            font-size: 18px !important;
            padding: 7px 0 !important;
            /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;*/
            font-weight: 500 !important;
        }

        .sop-product-image-d {
            width: 100% !important;

            aspect-ratio: 3/2;
            vertical-align: inherit !important;
        }
    </style>
@endpush

