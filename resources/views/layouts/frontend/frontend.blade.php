<?php
// $headerCSP = "Content-Security-Policy:".
//     "base-uri 'self';".
//     "default-src 'self';".
//     "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net/npm/vue@2.7.10/dist/vue.runtime.min.js http://localhost/moe/public/js/app.js https://stats.pusher.com/timeline/v2/jsonp/1 https://www.googletagmanager.com/gtag/js;".
//     "style-src 'self' 'unsafe-inline' ;".
//     "object-src 'none';".
//     "connect-src 'self' https://fcmregistrations.googleapis.com https://firebaseinstallations.googleapis.com".
//     " wss://localhost:6001 https://www.google-analytics.com wss://test.shweshops.com:6001;".
//     "font-src 'self';".
//     "frame-src 'self';".
//     "img-src 'self';".
//     "manifest-src 'self';".
//     "media-src 'self';".
//     "report-uri https://63d22e9c1110c9e871bfc411.endpoint.csper.io/?v=1;".
//     "worker-src 'self';";
// header('X-Frame-Options: DENY');
//header($headerCSP);

header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
?>
<!DOCTYPE html>
<html lang="en-US">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta name="facebook-domain-verification" content="ibbyacpbyurvwyfd5sb5whu9ybjjt1" />
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <link rel="manifest" href="{{ url('shweshopsaddtohomescreen.webmanifest') }}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--    <script> --}}
    {{--        localStorage.clear(); --}}

    {{--    </script> --}}


    @if (Auth::check())
        <script>
            window.userid = {{ \Illuminate\Support\Facades\Auth::user('guard')->id }};
        </script>
    @endif
    <?php
    if (Auth::guard('shop_owners_and_staffs')->check()) {
        $userid = Auth::guard('shop_owners_and_staffs')->user()->id;
    } elseif (Auth::guard('shop_owners_and_staffs')->check()) {
        $userid = Auth::guard('shop_owners_and_staffs')->user()->shop_id;
    } else {
        $userid = 0;
    }
    ?>
    <title>Shwe Shops</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ url('images/logo/favicon.gif') }}">
    <link rel='stylesheet' href="{{ url('test/css/normalize.css') }}" type='text/css' />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="{{url('plugins/google/formaingoogle.js')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-JYC8KYZNMZ');
    </script>
    <script>
        if (window.userid == undefined) {
            let userid = {{ $userid }};
            var user_id_for_android = {
                type: "shopid",
                id: userid
            };
        } else {
            var user_id_for_android = {
                type: "userid",
                id: window.userid
            };
        }

        // localStorage.setItem("user_id_for_android", window.userid);

        localStorage.setItem('user_id_for_android', JSON.stringify(user_id_for_android));
    </script>
    <link rel='stylesheet' id='jquery-ui-style-css' href="{{ url('test/css/forfoot.css') }}" type='text/css'
        media='all' />
    {{--    <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    @stack('css')
    <style id='dashicons-inline-css' type='text/css'>
        @font-face {
            font-family: 'Myanmar3';
            src: local('Myanmar3'), url("{{ url('mmfont/PyidaungsuZawDecode.woff2?93a8fffb927d8bfcaac5683829dcd048') }}") format('woff2'), url("{{ url('PyidaungsuZawDecode.woff?0e8dd9ee5f902f7ff573524de8b4f94d') }}") format('woff');
        }


        #button_slide .owl-stage {
            padding-left: 0px important;
            padding-right: 0px important;
        }

        /* these styles are for the zoom, but are not required for the plugin */
        .zoom {
            display: inline-block;
            position: relative;
        }

        .checkbox-component>input+label>.input-box>.input-box-tick {
            width: 75% !important;
            height: 75% !important;
            position: absolute;
            top: 22%;
            left: 15%;
        }

        .radio-component>input+label>.input-box {
            border: 1px solid #a9a9a9 !important;
            margin-right: 3px !important;
        }

        .radio-component>input:checked+label>.input-box {
            border: 1px solid #780116 !important;
        }

        .radio-component>input+label>.input-box>.input-box-circle {
            background: #780116 !important;
        }

        .checkbox-component>input+label>.input-box {
            border: 1px solid #a9a9a9 !important;
            position: relative;
            margin-right: 3px !important;
        }

        .checkbox-component>input+label>.input-box>.input-box-tick>path {
            stroke: #780116 !important;
        }

        .checkbox-component>input:checked+label>.input-box {
            border: 1px solid #780116 !important;
        }

        .gems-container .checkbox-component>input+label>.input-box {
            display: none !important;
        }

        .gems-container .checkbox-component>input:checked+label>.gem-img img {
            border: 0px solid #78011685 !important;
            border-radius: 50%;
        }

        .gem-checked-icon {
            display: none;
            z-index: 99;
            top: -5px;
            left: -5px;
        }

        .gem-checked-icon i {
            border: 1px solid white;
            font-size: 10px;
            border-radius: 50%;
            background: #780116;
            color: #fff;
            padding: 2px;
        }

        .gems-container .checkbox-component>input:checked+label>.gem-checked-icon {
            display: block;
        }

        .gems-container .gem-img img {
            width: 40px;
            margin-right: 10px;
        }

        /*for photo zoom and slide*/
        #mainCarousel {
            width: 100%;
            margin: 0 auto 1rem auto;

            --carousel-button-color: #170724;
            --carousel-button-bg: #fff;
            --carousel-button-shadow: 0 2px 1px -1px rgb(0 0 0 / 20%),
                0 1px 1px 0 rgb(0 0 0 / 14%), 0 1px 3px 0 rgb(0 0 0 / 12%);

            --carousel-button-svg-width: 20px;
            --carousel-button-svg-height: 20px;
            --carousel-button-svg-stroke-width: 2.5;
        }

        @media only screen and (max-width: 600px) {
            #new_arrival_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 25px !important;
            }

            #discount_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 25px !important;
            }

            #pd-discount_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 25px !important;
            }

            #collection_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 25px !important;
            }

            #similar_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 25px !important;
            }

            #shop_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 25px !important;
            }

            #button_slide_collection .owl-stage {
                padding-left: 0px !important;
                padding-right: 25px !important;
            }
        }

        @media only screen and (min-width: 600px) {
            #new_arrival_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            #discount_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            #pd-discount_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            #collection_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            #similar_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            #shop_slide .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            #button_slide_collection .owl-stage {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
        }

        @media only screen and (max-width: 991px) {
            .mobile-button .mobile-nav {
                font-size: 18px !important;
                z-index: 999999;
            }
        }


        #mainCarousel .carousel__slide {
            width: 100%;
            padding: 0;
        }

        #mainCarousel .carousel__button.is-prev {
            left: -1.5rem;
        }

        #mainCarousel .carousel__button.is-next {
            right: -1.5rem;
        }

        #mainCarousel .carousel__button:focus {
            outline: none;
            box-shadow: 0 0 0 4px #A78BFA;
        }

        #thumbCarousel .carousel__slide {
            opacity: 0.5;
            padding: 0;
            margin: 0.25rem;
            width: 96px;
            height: 64px;
        }

        #thumbCarousel .carousel__slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }

        #thumbCarousel .carousel__slide.is-nav-selected {
            opacity: 1;
        }

        .yk-photozoom-text {
            position: absolute;
            width: 100%;
            top: 149px;
            /* left: 171px; */
            text-align: center;
            color: white;
            font-weight: bolder;
        }

        /*for photo zoom and slide*/

        /* magnifying glass icon */
        .zoom:after {
            content: '';
            display: block;
            width: 33px;
            height: 33px;
            position: absolute;
            top: 0;
            right: 0;
            background: url(icon.png);
        }

        .zoom img {
            display: block;
        }

        .zoom img::selection {
            background-color: transparent;
        }

        #ex2 img:hover {
            cursor: url(grab.cur), default;
        }

        #ex2 img:active {
            cursor: url(grabbed.cur), default;
        }

        .product-name {
            font-family: 'Myanmar3', Sans-Serif !important;

        }

        .woocommerce div.product div.images {
            margin-bottom: 6px !important;
        }

        body {
            font-family: 'Myanmar3', Sans-Serif !important;
            /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;*/

        }

        .entry-content p {
            font-family: 'Myanmar3', Sans-Serif !important;

        }

        .price {
            font-family: 'Myanmar3', Sans-Serif !important;
            margin-bottom: 3px !important;
        }

        .yk-jello-horizontal {
            -webkit-animation: heartbeat 1.5s ease-in-out infinite both;
            animation: heartbeat 1.5s ease-in-out infinite both;
        }

        /* ----------------------------------------------
    * Generated by Animista on 2022-1-26 14:32:42
    * Licensed under FreeBSD License.
    * See http://animista.net/license for more info.
    * w: http://animista.net, t: @cssanimista
    * ---------------------------------------------- */

        /**
         * ----------------------------------------
         * animation heartbeat
         * ----------------------------------------
         */
        @-webkit-keyframes heartbeat {
            from {
                -webkit-transform: scale(1);
                transform: scale(1);
                -webkit-transform-origin: center center;
                transform-origin: center center;
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }

            10% {
                -webkit-transform: scale(0.91);
                transform: scale(0.91);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in;
            }

            17% {
                -webkit-transform: scale(0.98);
                transform: scale(0.98);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }

            33% {
                -webkit-transform: scale(0.87);
                transform: scale(0.87);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in;
            }

            45% {
                -webkit-transform: scale(1);
                transform: scale(1);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }
        }

        @keyframes heartbeat {
            from {
                -webkit-transform: scale(1);
                transform: scale(1);
                -webkit-transform-origin: center center;
                transform-origin: center center;
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }

            10% {
                -webkit-transform: scale(0.91);
                transform: scale(0.91);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in;
            }

            17% {
                -webkit-transform: scale(0.98);
                transform: scale(0.98);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }

            33% {
                -webkit-transform: scale(0.87);
                transform: scale(0.87);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in;
            }

            45% {
                -webkit-transform: scale(1);
                transform: scale(1);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }
        }


        .yk-ribbon {
            height: 110px;
            display: block;
            position: absolute;
            overflow: hidden;
            z-index: 111;
            top: 0;
            right: 0;
        }

        .yk-ribbon span {
            width: 136px;
            height: 34px;
            top: 13px;
            right: -46px;
            position: absolute;
            display: block;
            background: #FF0000;
            color: #333;
            font-family: arial;
            font-size: 18px;
            color: white;
            text-align: center;
            line-height: 34px;
            transform: rotate(45deg);
            -webkit-transform: rotate(52deg);
        }

        .yk-wrapper {
            position: absolute !important;
        }

        .yk-hover-logo {
            width: 28px !important;
            height: 28px !important;
            border-radius: 22px;
            display: inline !important;
        }

        .yk-button-shop-detail {
            background: white !important;
            color: #ed5902ee !important;
            width: 100% !important;
            height: 32px !important;
            padding-top: 5px !important;
            padding-left: 1px !important;
            padding-right: 1px !important;
            border-radius: 0px !important;
            border-color: #ed5902ee !important;
        }


        .yk-active {
            background: #ed5902ee !important;
            color: white !important;
            border-radius: 0px !important;
            border-color: #ed5902ee !important;
        }

        .ftc-breadcrumb-title.container {
            padding: 40px 0 40px !important;
        }

        .yk-owl {
            transform: translateY(-50px);
            z-index: 2;
        }

        .yk-main-color {
            color: #ee6412 !important;
        }


        @font-face {
            font-family: star;
            src: url('test/wp-content/plugins/woocommerce/assets/fonts/star.eot');
            src: url('test/wp-content/plugins/woocommerce/assets/fonts/star.eot?#iefix') format("embedded-opentype"), url('test/wp-content/plugins/woocommerce/assets/fonts/star.woff') format("woff"), url('test/wp-content/plugins/woocommerce/assets/fonts/star.ttf') format("truetype"), url('test/wp-content/plugins/woocommerce/assets/fonts/star.svg#star') format("svg");
            font-weight: 400;
            font-style: normal
        }

        @font-face {
            font-family: WooCommerce;
            src: url('test/wp-content/plugins/woocommerce/assets/fonts/WooCommerce.eot');
            src: url('test/wp-content/plugins/woocommerce/assets/fonts/WooCommerce.eot?#iefix') format("embedded-opentype"), url('test/wp-content/plugins/woocommerce/assets/fonts/WooCommerce.woff') format("woff"), url('test/wp-content/plugins/woocommerce/assets/fonts/WooCommerce.ttf') format("truetype"), url('test/wp-content/plugins/woocommerce/assets/fonts/WooCommerce.svg#WooCommerce') format("svg");
            font-weight: 400;
            font-style: normal
        }

        .disabled {
            display: none;
        }

        .select2-container--default .select2-purple .select2-selection--multiple .select2-selection__choice,
        .select2-purple .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #6f42c1;
            border-color: #643ab0;
            color: #fff;
        }


        /* zh main-slide style */
        .zh-main_slide {
            width: 100% !important;
        }

        /* zh-nav_bar */
        .zh_nav a {
            color: #780116 !important;
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
             */
            font-family: 'Myanmar3', Sans-Serif !important;
            font-weight: 500;
            font-size: 16px;
        }

        .zh_nav .active a {
            color: #fff8db !important;
            position: relative;
        }

        .zh_nav .active a:after {}

        /*
                .zh_margin{
                    margin-top:20px !important;
                } */
        img {
            object-fit: cover;
        }

        .zh_slide_arr_left {
            font-size: 25px !important;
            color: #780116 !important;
            font-weight: bold !important;
        }

        .zh_slide_arr_right {
            font-size: 25px !important;
            color: #780116 !important;
            font-weight: bold !important;
        }

        /* zh-collections */
        .zh-col-b {
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            font-family: 'Myanmar3', Sans-Serif !important;
            font-weight: bold;

        }

        .zh-col-b a {
            color: #000 !important;
            margin-left: 20px;
        }

        .zh-col_nav {
            /* font-family: 'Font Awesome', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            display: flex;
            margin-left: 5px;
            display: flex;
            margin-bottom: 20px;
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .zh-col_nav i {
            margin-top: 14px;
            margin-left: 4px;

        }


        .zh-col_nav select {
            font-weight: 500;
            border: none;
            width: 92px;
            background-position: top 0.6rem right 1rem;
            margin-left: 10px;
            height: 28px;
            background-color: #ebe1e1;
            color: grey;
            border-radius: 0px;
            margin-bottom: 10px;
        }

        .zh-col_nav .active {
            color: #000;
        }

        .zh-col-card {
            width: 10.6rem !important;
            /* font-family: 'Font Awesome', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            margin-left: 25px;
            margin-top: 10px !important;
            margin-bottom: 10px;
            height: 230px;
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .zh-col-card .card-body {
            padding-left: 2px;
        }

        .zh-col-card .card-body .col-name {
            display: flex;
        }

        .zh-instock {
            color: #b8ffb8 !important;
        }

        .zh-col-card img {
            height: 136px;
            margin-top: 10px;
        }

        .zh-col-card h5 {
            font-size: 16px;
        }

        .zh-col-card p {
            margin-bottom: 0px;
            color: grey;
            font-size: 13px;
        }

        .zh-col-card label {
            font-size: 16x;
            color: #780116 !important;
            font-weight: bold !important;
            margin-bottom: 0px !important;
        }

        /* zh product-detail */
        .zh-title {
            margin-left: 8px !important;
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI',
            Roboto, Oxygen, Ubuntu, Cantarell,
            'Open Sans', 'Helvetica Neue', sans-serif; */
            font-family: 'Myanmar3', Sans-Serif !important;
            text-transform: capitalize !important;
        }

        #pd-discount_slide .owl-item {
            /* margin-right:2px !important; */
            /* width:145px !important; */
        }

        .zh-addtocart-button:hover {
            background: #780117d8 !important;
        }

        /* zh pop up */
        .modal-notify .modal-header {
            border-radius: 3px 3px 0 0;
        }

        .modal-notify .modal-content {
            border-radius: 3px;
        }


        /*        .sn-buynow-button:HOVER {*/
        /*            background: #f3f3f3b9 !important;*/
        /*        }*/


        /*        */
        .scroll-button {
            background: #000000 !important;
            color: white !important;
            box-shadow: 0px 0ch 5px rgba(0, 0, 0, 0.452);
        }

        .scroll-button a:before {
            color: #fff;
        }

        .mobile-nav {
            background: #fff !important;
        }

        .mobile-nav .fa-bars:before {
            color: #780117 !important;
        }

        .font-red {
            color: #ac0221 !important;
            font-weight: 700 !important;
            font-size: 17px;
        }

        .font-yellow {
            color: #0a0a0a !important;
            font-weight: 600 !important;
        }

        /* scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #000000;
            border-radius: 3px;
            border: 4px solid transparent;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #161616cc;
        }


        .ftc-mobile-wrapper .menu-text .btn-toggle-canvas.btn-danger:hover {

            border-color: #780117cc !important;
            opacity: 0.9;

        }

        .op-100 {
            opacity: 1;
            animation: dance 1s both;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            perspective: 1000px;
        }

        .op-90 {
            opacity: 0.9;
        }

        @keyframes dance {

            10%,
            90% {
                transform: translate3d(-1px, 0, 0);
            }

            20%,
            80% {
                transform: translate3d(2px, 0, 0);
            }

            30%,
            50%,
            70% {
                transform: translate3d(-4px, 0, 0);
            }

            40%,
            60% {
                transform: translate3d(4px, 0, 0);
            }
        }

        textarea:hover,
        input:hover,
        textarea:active,
        input:active,
        textarea:focus,
        input:focus,
        button:focus,
        button:active,
        button:hover,
        label:focus,
        .btn:active,
        .btn.active {
            outline: 0px !important;
            -webkit-appearance: none;
            box-shadow: none !important;
        }

        .noselect {
            -webkit-touch-callout: none;
            /* iOS Safari */
            -webkit-user-select: none;
            /* Safari */
            -khtml-user-select: none;
            /* Konqueror HTML */
            -moz-user-select: none;
            /* Old versions of Firefox */
            -ms-user-select: none;
            /* Internet Explorer/Edge */
            user-select: none;
            /* Non-prefixed version, currently
            supported by Chrome, Edge, Opera and Firefox */
        }


        /* .elementor-container.elementor-column-gap-extended {
            max-width: 1400px !important;
        } */

        .mega_main_menu.primary>.menu_holder>.menu_inner>.nav_logo>.mobile_toggle>.mobile_button,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li>.item_link,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li>.item_link .link_text,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.nav_search_box input,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li .post_details>.post_title,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li .post_details>.post_title>.item_link {
            /* font-family: sans-serif !important; */
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        #cato_slide .shop-icon+label:before {
            content: '';
            position: absolute;
            z-index: 100;
            transform: scale(0.5);
            top: 0;
            right: 0;
        }

        #cato_slide :checked+label:before {
            content: url("/test/img/checked_checkbox.webp");
        }

        .sop-mobile-nav {
            border-radius: 50%;
            background: #780116;
            aspect-ratio: 1 / 1;
            max-width: 60px;
            max-height: 60px;
            margin-top: -35px;
            position: relative;
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.452);
        }

        .sop-filter .form-control {
            border: 0;
            border-bottom: 1px solid #ced4da70;

            /* font-family: sans-serif; */

        }

        .sop-cato-img {
            display: inline-block;
        }

        .sop-cato-img img {
            object-fit: cover;
            margin: 0 auto;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            aspect-ratio: 1 / 1;
            cursor: pointer;
        }

        .sop-cato-img div {
            object-fit: cover;
            width: 100%;
            height: 100%;

            border-radius: 50%;
            aspect-ratio: 1 / 1;
            cursor: pointer;
        }

        .sop-mobile-nav:hover {
            background: #780117d8 !important;
            color: white;
        }

        /* disable this to disable view point showing only on hover */

        .sop-eye:hover+a img {
            opacity: 0.7;
        }

        .sopfont .price bdi {
            margin: 5px 0 5px 0;
        }

        .sop-bg {
            box-shadow: 0px 0px 0px 1px #c5c5c54f inset;
            border-radius: 5px;
        }

        .sop-amount {
            color: #780116 !important;
            font-size: 16px !important;

            line-height: 28px !important;
            float: left !important;
        }

        .sop-font h3 {
            font-weight: 700;
        }

        .sop-sans {

            /* font-family: sans-serif !important; */
            font-family: 'Myanmar3', Sans-Serif !important;

        }

        .sop-font .sop-opacity-8 {
            opacity: 0.8;
            ;
        }

        .sop-img img {
            border-radius: 5px;
        }

        .sop-img .yk-hover-title img {
            border-radius: 50%;
            padding: 3px;
        }

        .sop-view-button {
            background: #780116 !important;
            border-radius: 6px !important;
            border-color: #81021917 !important;
            /* font-family: sans-serif; */
        }

        .sop-view-button :hover {
            background: #720015 !important;
        }

        .sop-btmn {
            background-color: #780116 !important;
            /* margin-left: 10px !important; */
            color: #ffffff !important;
            height: 35px;
            line-height: 35px;
            width: 110px;
            text-transform: capitalize;
            border-radius: 3px;
            text-align: center;
            /* font-family: sans-serif; */
        }

        .sop-messenger {
            background: #E4E6EB !important;
            border-radius: 5px !important;
            border-color: #E4E6EB !important;
            width: 150px !important;
            color: #000 !important;
            font-size: 18px !important;
            padding: 7px 0 !important;
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            font-weight: 500 !important;
        }

        .sop-messenger:hover {
            background: rgba(0, 0, 0, 0.17) !important;
        }

        .sop-font,
        .woocommerce div.product .summary h1.product_title.entry-title,
        .sn-buynow-button,
        .sn-shop-link,
        .sn-no-items {
            font-family: 'Myanmar3', Sans-Serif !important;

        }

        .zawg {
            font-family: 'Zawgyi-One', Sans-Serif !important;

        }

        .sop-font-content {
            float: left !important;
            /* margin-left: 10px !important; */
            text-transform: capitalize;
        }

        .sop-color-vermilion {
            color: #780116 !important;
            font-weight: 600;
        }

        h3 a.sop-font-content {
            font-size: 16px !important;
            font-weight: 700 !important;
            line-height: 28px !important;
        }

        .sop-categories: {
            color: black !important;
        }

        .sop-rounded {
            border-radius: 17px;
            background-color: gray;
        }

        .sop-rounded-top {
            border-radius: 5px 5px 0 0;
        }

        .sop-opacity-50 {
            opacity: 50%;
        }

        .c-pointer {
            cursor: pointer;
        }

        .sop-selection {
            background-color: #cc0025 !important;
            border-radius: 5px !important;
            border: none !important;
            width: 95% !important;
            margin: 20px auto 0;

            font-size: 18px !important;
            padding: 7px 0 !important;
            font-family: 'Myanmar3', Sans-Serif !important;
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            font-weight: 500 !important;
        }

        .sn-shop-image {
            border-radius: 0 !important;
            border: 1px solid #d3cece !important;
        }

        .sn-shop-image:hover {
            opacity: 1 !important;
        }

        @media only screen and (max-width: 576px) {
            .sop-image-w-h {
                width: 100% !important;
                height: 100% !important;
                aspect-ratio: 3 / 2;
            }

            .zh_cat_count {
                font-size: 14px;
            }

            .sop-cato-img img {

                max-height: 80px;
                max-width: 80px;


            }

            .sop-cato-img div {

                max-height: 100px;
                max-width: 100px;

            }

            .sop-item-count {
                font-size: 0.9em;
                cursor: pointer;
            }

            .textsmall {
                font-size: 0.85em;
            }

            .sop-font .yk-viewcount {
                bottom: 10px;
                background: #00000073 !important;
            }

            .sop-ribbon span {
                width: 126px;
                height: 20px;
                top: 13px;
                right: -46px;
                position: absolute;
                display: block;
                background: #FF0000;
                color: #333;
                font-family: arial;
                font-size: 12px;
                color: white;
                text-align: center;
                line-height: 20px;
                transform: rotate(45deg);
                -webkit-transform: rotate(52deg);
            }

            .sop-ribbon {
                height: 80px;
                display: block;
                position: absolute;
                overflow: hidden;
                z-index: 111;
                top: 0;
                right: 0;
            }

            .sop-amount {
                color: #780116 !important;
                font-size: 14px !important;

                line-height: 26px !important;
                float: left !important;
            }


            .sop-font .fa {
                font-size: 0.57rem;
                color: white;
            }
        }

        @media only screen and (max-width: 420px) {
            .sop-product-d-p {
                padding-top: 23px;
            }

        }

        @media only screen and (min-width: 1191px) {

            .item_img {
                width: 204px !important;
                height: 135px !important;
                aspect-ratio: 3/2;

            }
        }

        @media only screen and (max-width: 1190px) {
            .item_img {
                width: 170px !important;
                height: 135px !important;
                aspect-ratio: 3/2;

            }
        }


        @media only screen and (min-width: 576px) {
            .sop-image-w-h {
                width: 100% !important;
                height: 100% !important;
                aspect-ratio: 3/2;

            }



            .zh_cat_count {
                font-size: 18px;
            }

            .sop-cato-img img {
                max-height: 95px;
                max-width: 95px;
            }

            .sop-cato-img div {
                max-height: 120px;
                max-width: 200px;
            }

            .sop-item-count {
                font-size: 1em;
                cursor: pointer;
            }

            .textsmall {
                font-size: 1em;
            }

            .sop-font .yk-viewcount {
                bottom: 10px;
                background: #00000073 !important;
                padding: 5px 5px !important;
            }

            .sop-ribbon span {
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
                transform: rotate(45deg);
                -webkit-transform: rotate(52deg);
            }

            .sop-ribbon {
                height: 110px;
                display: block;
                position: absolute;
                overflow: hidden;
                z-index: 111;
                top: 0;
                right: 0;
            }

            .sop-banner {
                margin: 0;
                padding: 0;
                width: 100%;
                max-height: 400px;
                object-fit: cover;
            }

            .sop-amount {
                color: #780116 !important;
                font-size: 16px !important;

                line-height: 28px !important;
                float: left !important;
            }

            .sop-product-d-p {
                padding-top: 0px;
            }

            .sop-font .fa {
                font-size: 0.7rem;
                color: white;
            }
        }

        @media only screen and (max-width: 768px) {
            .sop-logo {
                width: 110px;

                height: 110px;
                border-radius: 50% !important;
                /* height: auto; */
            }

            .sop-image-w-h-m {
                width: 100% !important;
                height: 166px !important;
            }

            .sop-discount {
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
            }

            .sop-banner {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 200px;
                object-fit: cover;
            }
        }

        @media only screen and (min-width: 768px) {
            .sop-logo {
                width: 140px;

                height: 140px;
                border-radius: 50% !important;
                /* height: auto; */
            }

            .sop-discount {
                padding-left: 3rem;
                padding-right: 3rem;
            }

            .sop-image-w-h-m {
                width: 222px !important;
                height: 166px !important;
            }
        }

        @media only screen and (max-width: 992px) {
            .footer-mobile {
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.452) !important;
            }

            .site-footer {
                padding-bottom: 63px !important;
            }

            .ftc-header-template .header-mobile .logo-wrapper {
                text-align: left !important;
                margin-left: 5px !important;
            }

            .sop-ads-banner {
                padding: 0;
            }
        }

        @media only screen and (min-width: 992px) {
            .sop-discount {
                padding-left: 4rem;
                padding-right: 4rem;
            }

            .sop-ads-banner {
                padding: 0 116px !important;
            }

        }

        @media only screen and (min-width: 360px) {
            padding-left: 0px !important;
            padding-right: 25px !important;
        }

        @media only screen and (max-width: 360px) {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }

        @supports not (aspect-ratio: 1 / 1) {
            .sop-mobile-nav {
                width: 60px;
                height: 60px;
            }
        }

        @supports not (aspect-ratio: 16 / 13) {
            .sop-image-w-h {
                height: 146px !important;
                width: 222px !important;
            }

        }

        @supports not (aspect-ratio: 6 / 5) {
            .sop-image-w-h {
                height: 120px !important;
                width: 222px !important;
            }
        }
    </style>
    <link rel='stylesheet' id='ftc-element-css'
        href="{{ url('test/wp-content/plugins/themeftc-for-elementor/assets/css/default.css') }}" type='text/css'
        media='all' />

    <link rel='stylesheet' id='mmm_mega_main_menu-css'
        href="{{ url('test/wp-content/plugins/mega_main_menu/src/css/cache.skin.css') }}" type='text/css'
        media='all' />

    <link rel='stylesheet' id='jquery-ui-style-css'
        href="{{ url('test/wp-content/plugins/woocommerce/assets/css/jquery-ui/jquery-ui.min.css') }}" type='text/css'
        media='all' />

    <link rel='stylesheet' id='select2_css-css'
        href="{{ url('test/wp-content/plugins/wc-frontend-manager/includes/libs/select2/select2.css') }}"
        type='text/css' media='all' />
    <link rel='stylesheet' id='font-awesome-css' href="{{ url('fonts/css/all.min.css') }}" type='text/css'
        media='all' />

    <link rel='stylesheet' id='ftc-style-css' href="{{ url('test/wp-content/themes/karo1/style.css') }}"
        type='text/css' media='all' />


    <style id='ftc-reset-inline-css' type='text/css'>
        .products.list .short-description.list {
            display: inline-block !important;
        }

        .products.grid .short-description.grid {
            display: inline-block !important;
        }
    </style>
    <link rel='stylesheet' id='ftc-responsive-css'
        href="{{ url('test/wp-content/themes/karo1/assets/css/responsive.css') }}" type='text/css' media='all' />
    <script type='text/javascript' src="{{ url('test/js/jquery.latest.js') }}" id='jquery-core-js'></script>


    <link rel='stylesheet' id='elementor-frontend-css'
        href="{{ url('test/wp-content/plugins/elementor/assets/css/frontend.css') }}" type='text/css' media='all' />
    {{-- <link rel='stylesheet' id='elementor-post-13125-css'
          href="{{url('test/wp-content/uploads/elementor/css/post-13125.css')}}"
          type='text/css' media='all'/> --}}


    <link rel='stylesheet' id='jquery-ui-style-css' href="{{ url('test/css/bootstrap.css') }}" type='text/css'
        media='all' />


    {{-- Swe --}}
    <script src="{{ url('test/js/bootstrap-multi.js') }}"></script>
    <link rel="stylesheet" href="{{ url('test/css/bootstrap-multiselect.css') }}">

    <style>
        .ftc-header-template .ftc-search .search-button {
            right: 0;
        }

        .yk-image-for-cat {
            width: 100%;
            height: 147px;
        }

        .ftc-header-template .ftc-search .ftc_search_ajax {
            right: 0;
        }

        .ftc-header-template {
            z-index: 9999;
            background: #fff;
            width: 100%;
        }

        .ftc-header-template .is-sticky .header-content {
            background: #fff;
        }

        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li>.item_link * {
            color: #000;
        }

        .ftc-header-template .ftc-search .search-button:before {
            color: #000;
            font-weight: bold;
        }

        .ftc-header-template .ftc-cart-tini {
            color: #000;
        }

        .ftc-header-template .header-icon i,
        .ftc-header-template .header-icon i:before,
        .ftc-header-template .header-icon i:after {
            background-color: #000;
        }

        .header-dropdown-element .content-dropdown {
            border-top: 2px solid #ee6412;
            margin-top: 5px;
        }

        .header-dropdown-element .content-dropdown:before {
            position: absolute;
            content: "\f0d8";
            font-family: 'FontAwesome';
            font-size: 18px;
            line-height: 7px;
            color: #a07935;
            height: 7px;
            top: -7px;
            right: 3px;
        }

        .header-dropdown-element .content-dropdown .ftc-account {
            border-top: 1px solid #ebebeb;
        }

        .header-dropdown-element .content-dropdown>a {
            padding: 5px 0;
            display: block;
        }

        .header-dropdown-element .content-dropdown>div {
            padding: 5px 0;
        }

        .ftc-header-template .is-sticky .header-mobile {
            background: #fff;
        }

        .mega_main_menu li.multicolumn_dropdown.columns5>.mega_dropdown {
            transform: translateX(-20%);
        }

        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.submenu_full_width>.mega_dropdown {
            max-width: 1200px;
        }

        @media only screen and (max-width: 1024px) and (min-width: 992px) {
            .ftc-header-template .header-content>.container {
                display: block;
                width: 100%;
            }

            .ftc-header-template .header-content .container>div {
                width: 100%;
                float: left;
            }

            .ftc-header-template .mega_main_menu>.menu_holder>.menu_inner>ul>li:last-child {
                margin-right: 0;
            }

            .mega_main_menu li.multicolumn_dropdown.columns5>.mega_dropdown {
                transform: translateX(-23%);
            }

            .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.submenu_full_width>.mega_dropdown {
                max-width: 960px;
                left: 44%;
            }

            .mega_main_menu li.multicolumn_dropdown.drop_to_left>.mega_dropdown {
                right: -50px;
            }
        }


        @media only screen and (max-width: 991px) {
            .ftc-header-template .mobile-button .fa-bars:before {
                color: white;
            }

            .ftc-header-template .logo-wrapper img {
                max-height: 50px;
            }
        }

        /* Product Detail by Swe */
        /*@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');*/

        .sn-shop-title {
            margin: 20px auto 15px;
            text-align: center;
        }

        .sn-shop-title h2 {
            margin-top: 5px;
            font-size: 1.25rem;
            color: #747474;
        }

        .sn-site-content {
            margin-top: 20px;
            /* font-family: 'Roboto', sans-serif; */
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .sn-product-image {
            border-radius: 6px;
            width: 600px !important;
            vertical-align: inherit !important;
        }

        .sn-product-thumb {
            border-radius: 7px;
        }

        #sync2 .owl-stage {
            width: auto !important;
        }

        #sync2 .owl-item {
            width: auto !important;
            margin-right: 15px !important;
            margin-bottom: 15px !important;
        }

        .sn-discount-badge {
            background: #ff0000e0;
            display: inline-block;
            padding: 7px 10px 4px !important;
            margin-bottom: 10px !important;
            margin-left: 10px !important;
            font-size: 16px !important;
            font-weight: 900;
            color: #fff;
            border-radius: 50px;
        }

        .sn-off-text {
            font-size: 13px;
        }

        .sn-origin-amount {
            color: #6c6c6c !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            line-height: 28px !important;
            float: left !important;
            margin-left: 10px !important;
        }

        .sn-discount-amount bdi {
            letter-spacing: 1px !important;
        }

        .sn-product-title {
            margin: 0 0 5px 10px !important;
        }

        .sn-product-instock {
            margin: 3px auto 35px 10px !important;
        }

        .sn-product-instock span {
            background-color: #b8ffb8;
            color: #007000;
            padding: 3px 10px;
            border-radius: 50px;
            text-transform: none !important;
        }

        .sn-product-outstock {
            margin: 3px auto 35px 10px !important;
        }

        .sn-product-outstock span {
            background-color: #ffd9c3;
            color: #ff5f01;
            padding: 3px 10px;
            border-radius: 50px;
            text-transform: none !important;
        }

        .sn-product-des {
            margin-left: 10px;
            position: relative !important;
            line-height: 1.8;
        }

        .sn-product-des button {
            background: none !important;
            padding: 0 !important;
            color: #646464 !important;
            border-bottom: 1.5px dotted;
            border-radius: 0;
        }

        .sn-product-des .fa-arrow-up,
        .sn-product-des .fa-arrow-down {
            position: unset !important;
            margin-left: 7px;
        }

        .sn-product-des .fa-arrow-up::before {
            transform: translateX(2px) rotate(45deg);
        }

        .sn-product-des .fa-arrow-up::after {
            transform: translateX(-2px) rotate(-45deg);
        }

        .sn-product-des .fa-arrow-down::before {
            transform: translateX(-2px) rotate(45deg);
        }

        .sn-product-des .fa-arrow-down::after {
            transform: translateX(2px) rotate(-45deg);
        }

        .sn-product-des .fa-arrow-up::before,
        .sn-product-des .fa-arrow-up::after,
        .sn-product-des .fa-arrow-down::before,
        .sn-product-des .fa-arrow-down::after {
            content: "" !important;
            position: absolute !important;
            bottom: 10px;
            background-color: #646464;
            width: 2px;
            height: 8px;
            transition: transform 0.25s ease-in-out;
        }

        #sync2 .item {
            width: 75px !important;
        }

        .sn-product-detail {
            margin-top: 30px;
            margin-left: 10px;
            line-height: 2rem;
            /* zh-modify */
            /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;*/
        }

        .sn-product-detail h1 {
            margin: 15px auto 10px;
        }

        .sn-similar-seeall {
            position: absolute;
            top: 10%;
            margin: 0 40px;
            text-align: center;
        }

        .sn-similar-seeall a {
            padding: 10px;
        }

        .sn-similar-seeall i {
            padding: 15px;
            border: 1px solid #dbdbdb;
            background: white;
            border-radius: 50%;
            font-size: 25px;
            box-shadow: 0px 0px 5px 1px #e5e5e5;
            color: #a3a3a3;
        }

        .sn-similar-seeall .see-all-text {
            margin: 12px 0 0;
        }

        .sn-accordion {
            width: 100% !important;
        }

        .sn-accordion-checkbox {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            opacity: 0;
        }

        .sn-accordion-arrow {
            position: absolute;
            right: 0;
            margin-top: 10px;
            margin-right: 6%;
            z-index: -1;
        }

        .sn-accordion-arrow::before,
        .sn-accordion-arrow::after {
            content: "";
            position: absolute;
            background-color: #313131;
            width: 2px;
            height: 8px;
            transition: transform 0.25s ease-in-out;
        }

        .sn-accordion-arrow::before {
            transform: translateX(-2px) rotate(45deg);
        }

        .sn-accordion-arrow::after {
            transform: translateX(2px) rotate(-45deg);
        }

        .sn-accordion-checkbox:checked~.sn-accordion-arrow::before {
            transform: translateX(2px) rotate(45deg);
        }

        .sn-accordion-checkbox:checked~.sn-accordion-arrow::after {
            transform: translateX(-2px) rotate(-45deg);
        }

        .sn-accordion-title {
            margin-top: 30 !important;
            margin-bottom: 0 !important;
        }

        .sn-accordion-item {
            position: relative;
        }

        .sn-accordion-content {
            position: relative;

            margin: 25px 0 0;
            opacity: 1;
            overflow: hidden;
            transition: all 0.35s ease-in-out;
            line-height: 1.6;
            z-index: 2;
        }

        .sn-accordion-checkbox:checked~.sn-accordion-content {
            max-height: 0;
            opacity: 0;
        }

        .sn-shop-link {
            border-bottom: 1px dotted;
            color: #ee6412 !important;
        }

        .sn-wrapper {
            margin: 0 !important;
        }

        .sn-wrapper h3 {
            font-size: 16px;
            font-weight: 900;
            margin: 13px 0 10px !important;
        }

        .sn-wrapper .sn-detail-title {
            font-size: 16px !important;
            /* zh-modify */
            font-weight: bold !important;
            color: #000;
            margin-right: 7px;
        }

        /* zh animation */
        .sn-wrapper span {
            opacity: 0%;
            animation-name: span;
            animation-duration: 1s;
            animation-fill-mode: forwards;
        }

        @keyframes span {
            from {
                opacity: 0%;
            }

            to {
                opacity: 100%;
            }
        }


        .zh-pc {
            font-family: 'Myanmar3', Sans-Serif !important;
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
        }

        .zh-row {
            margin-bottom: 13px !important;
            border-bottom: 1px solid #d1d1d1;
            padding-bottom: 13px !important;
        }

        @media (min-width: 1025px) {
            .details-img {
                /* width: 420px !important; */
            }

            #main-content {
                width: 100% !important;
            }
        }

        @media (min-width: 600px) {
            .sn-shop-title {
                display: none;
            }

            .sn-site-content {
                margin-top: 50px;
            }
        }
    </style>
    <style type="text/css">
        .recentcomments a {
            display: inline !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .main-content .owl-theme .owl-nav {
            position: absolute;
            top: 40%;
            left: 0px;
            right: 0px;
        }

        #categories_slide .owl-nav {
            position: absolute;
            top: 20%;
            left: 0px;
            right: 0px;
        }

        .main-content .owl-theme .owl-nav .owl-prev,
        .main-content .owl-theme .owl-nav .owl-next {
            position: absolute;
            height: 100px;
            color: inherit;
            background: none;
            border: none;
            z-index: 100;
        }

        #categories_slide .owl-theme .owl-nav .owl-prev,
        #categories_slide .owl-theme .owl-nav .owl-next {
            position: absolute;
            height: 100px;
            color: inherit;
            background: none;
            border: none;
            z-index: 100;
        }


        .main-content .owl-theme .owl-nav .owl-prev i,
        .main-content .owl-theme .owl-nav .owl-next i {
            font-size: 27px;
            color: rgb(247, 181, 56);
            font-weight: bold;
        }

        #categories_slide .owl-theme .owl-nav .owl-prev i,
        #categories_slide .owl-theme .owl-nav .owl-next i {
            font-size: 27px;
            color: rgb(247, 181, 56);
            font-weight: bold;
        }

        .select2-container--default .select2-purple .select2-selection--multiple .select2-selection__choice,
        .select2-purple .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #ee6412;
            border-color: #ee6412;
            color: #fff;
        }

        .select2.select2-container {
            border: 1px solid #ee6412 !important;

        }

        .main-content .owl-theme .owl-nav .owl-prev {
            left: 0;
        }

        .main-content .owl-theme .owl-nav .owl-next {
            right: 0;
        }

        #categories_slide .owl-theme .owl-nav .owl-prev {
            left: 0;
        }

        #categories_slide .owl-theme .owl-nav .owl-next {
            right: 0;
        }

        /* .mobile-nav {
            text-align: center !important;
            background: #ee6412 !important;
        } */

        .link_text {
            color: black !important;
        }

        .main-content {
            position: relative;
        }

        .yk-shop-container {
            padding-left: 21% !important;

        }

        .yk-color {
            color: #ee6412 !important;

        }

        .ftc-breadcrumb-title.container {
            padding: 29px 0 66px;

        }

        .ftc-breadcrumbs-category a {
            color: #fff !important;
        }

        .shop-logo {
            width: 64px;
            border-radius: 38.25rem !important;
            height: 62px;
        }

        .layer {
            background-color: rgb(34 32 29 / 24%);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .yk-button {
            background: #780116 !important;
            border-radius: 6px !important;
            border-color: #ed5902ee !important;
            width: 97% !important;

        }

        .zh-button {
            background: #780116 !important;


        }

        /* .current-menu-ancestor .yk_link_content {
            color: white !important;
        } */

        /* .menu-item:hover .yk_link_content {
            color: white !important;

        } */

        /* .menu-item:focus .yk_link_content {
            color: white !important;

        } */

        .yk-button .fa.fa-search:before {
            font-family: 'simple-line-icons';
            content: "\e090";
            font-weight: bolder;
            font-size: 16px;
            line-height: 0px !important;
        }

        .yk-button-color {
            background-color: #ed5902ee !important;
        }

        .yk-button:hover {
            background: #a92c42 !important;

        }

        /* .mobile-nav {
            text-align: center !important;
            background: #780116 !important;
        } */
        #to-top {
            width: 40px !important;
            height: 40px !important;
        }

        #to-top a:hover {
            background: #383838;
        }

        .yk-hover-title {
            top: 0px;
            /* left: -32px; */
            z-index: 111 !important;
            color: #ffe775 !important;
            position: absolute;
            font-size: 11px;
            background: #00000033;
            width: 92%;

        }

        .yk-slide-btn {
            background: #6778a726 !important;
            border-radius: 27px;
            width: 42px;
        }

        .modal-backdrop {
            background: #4e4e4e66 !important;
        }

        #categories_slide .yk-slide-btn {
            background-color: transparent !important;
            border-radius: 27px;
            width: 30px;
            padding: 2px !important;
        }


        .zh-slide-btn_right {
            background: #fff !important;
            border-radius: 27px;
            width: 42px;
            margin-left: 29%;
        }

        .zh-slide-btn_left {
            background: #fff !important;
            border-radius: 27px;
            width: 42px;
            margin-left: 800%;
            margin-top: 170%;
        }

        .yk-slide-btn:focus,
        .yk-slide-btn:hover {
            background: white !important;

        }

        .yk-slide-btn:hover i,
        .yk-slide-btn:focus i {
            color: #ed9f0e !important;

        }

        @media only screen and (max-width: 601px) {
            .yk-image-for-cat {
                width: 100%;
                height: 94px;
            }

            .yk-hover-title {
                width: 91%;
            }
        }

        @media (max-width: 991px) {
            .yk-shop-container {
                padding-left: 1% !important;

            }


            .main-content .owl-theme .owl-nav {
                position: absolute;
                top: 30%;
                left: 0px;
                right: 0px;
            }

            #categories_slide .owl-theme .owl-nav {
                position: absolute;
                top: 30%;
                left: 0px;
                right: 0px;
            }

            /* .ftc-mobile-wrapper {
                left: 0;
                transform: translate3d(-326px, 0, 0);
            } */
            .ftc-mobile-wrapper {
                transform: translate3d(-400px, 0, 0);
            }

            #discount_slide .owl-nav {
                position: absolute;
                top: 30%;
                left: -14px;
                right: -14px;
            }

            #pd-discount_slide .owl-nav {
                position: absolute;
                top: 30%;
                left: -14px;
                right: -14px;
            }

            .main-content .owl-theme .owl-nav .owl-prev i,
            .main-content .owl-theme .owl-nav .owl-next i {
                font-size: 17px;
                color: #f8af29;
                font-weight: bold;
            }

            #categories_slide .owl-theme .owl-nav .owl-prev i,
            #categories_slide .owl-theme .owl-nav .owl-next i {
                font-size: 17px;
                color: #f8af29;
                font-weight: bold;
            }

            #discount_slide .yk-slide-btn {
                background: #6778a726 !important;
                border-radius: 27px;
                width: 30px;
                padding: 2px !important;
            }

            #pd-discount_slide .yk-slide-btn {
                background: #6778a726 !important;
                border-radius: 27px;
                width: 30px;
                padding: 2px !important;
            }

            #categories_slide .yk-slide-btn {
                background-color: transparent !important;
                border-radius: 27px;
                width: 30px;
                padding: 2px !important;
            }

            #discount_slide .yk-slide-btn:focus,
            #discount_slide .yk-slide-btn:hover {
                background: white !important;

            }

            #pd-discount_slide .yk-slide-btn:focus,
            #pd-discount_slide .yk-slide-btn:hover {
                background: white !important;

            }

            #categories_slide .yk-slide-btn:focus,
            #categories_slide .yk-slide-btn:hover {
                background: white !important;
            }


        }


        @media (max-width: 400px) {
            .ftc-mobile-wrapper {
                width: 100% !important;
            }

            .ftc-mobile-wrapper {
                transform: translate3d(-100%, 0, 0);
            }
        }

        @media (max-width: 400px) {
            .ftc-mobile-wrapper {
                width: 100% !important;
            }

            .ftc-mobile-wrapper {
                transform: translate3d(-100%, 0, 0);
            }

            .zh-eye-picon {
                z-index: 9999 !important;
                position: absolute !important;
                right: 0;

            }
        }

        .zh-eye-picon {
            z-index: 9999;
            position: absolute;
            right: 0;
        }

        .reg_password {
            -webkit-text-security: disc;
            -moz-text-security: circle;
            text-security: circle;
        }

        .password-confirm {
            -webkit-text-security: disc;
            -moz-text-security: circle;
            text-security: circle;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .mt-n2 {
            margin-top: -16px !important;
        }

        @media screen and (min-width: 800px) {
            .yk-mar-right {
                margin-right: 22px !important;
            }

        }

        .main-slider .owl-thumbs {
            text-align: center;
            padding: 1px;
            display: table;
            width: 100%;
        }

        .main-slider .owl-thumb-item {
            width: 20%;
            border: none;
            margin-right: 5px;
            background: none;
            padding: 0;
            opacity: 0.7;
            overflow: hidden;
        }

        .main-content {
            position: relative;
        }

        .main-slider .owl-thumb-item img {
            width: 100%;
            height: auto;
            /*vertical-align: middle;*/
        }

        .main-slider .owl-thumb-item.active {
            opacity: 1;
        }

        .main-slider .owl-thumb-item.active img {
            position: relative;
        }

        .overlay {
            width: 100%;
            height: 100%;
            display: block;
            background-color: black;
        }

        .owl-carousel .owl-item {
            padding: 0px !important;
        }

        .owl-dots {
            left: 43% !important;
            position: relative;
            transform: translateY(-150%) !important;
            z-index: 2;
        }

        a.ftc-load-more-button-shop {
            padding: 15px !important;
            background-color: #ee6412 !important;
            color: #fff !important;
            font-weight: 500 !important;
            position: relative !important;
            text-align: center !important;
        }

        a {
            color: #666 !important;
            text-decoration: none !important;
            cursor: pointer !important;


        }

        .linkified {
            text-decoration: underline !important;
            color: #2196f3 !important;
        }

        .elementor-heading-title {
            font-size: 22px;
        }

        .entry-content {
            font-size: 14px;
        }

        .author {
            color: #ee6412 !important;
        }

        .main-content-slide {
            position: relative;
        }


        .ftc-simple a .sub-arrow {
            color: black !important;
        }

        .woocommerce .products.grid .product:hover,
        .woocommerce-page .products.grid .product {
            z-index: 9;
        }

        .woocommerce-page .products .product,
        .woocommerce-page .products .product,
        .woocommerce .products .product,
        .woocommerce .products .product {
            box-shadow: 0px 1px 1px 1px rgb(0 0 0 / 10%) !important;
            background: #fff;
        }

        .list .product-meta .meta_info,
        .ftc-product.product .meta_info {
            opacity: 100 !important;
            visibility: visible !important;
        }

        .meta_info {
            position: relative !important;
            box-shadow: none !important;
        }

        .yk-product {
            border: 1px solid #ba9a384d !important;
            padding: 8px !important;
        }

        @media (max-width: 991px) {

            /*.ftc-mobile-wrapper {*/
            /* right:0 ;*/
            /*transform:translate3d(432px,0,0) ;*/
            /*}*/
            .mt-n2 {
                margin-top: -36px !important;
            }


        }

        /*for right menu*/
        #sync1 .item {

            margin-top: 2px;
            color: #FFF;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            text-align: center;
        }

        #sync2 .item {
            background: #C9C9C9;
            padding: 0px 0px;
            width: 81px;
            color: #FFF;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            text-align: center;
            cursor: pointer;
        }

        #sync2 .item h1 {
            font-size: 18px;
        }

        #sync2 .synced .item {
            /* background: #0c83e7; */
        }

        .yk-viewcount {
            position: absolute !important;
            bottom: 10px;
            ;
            background: #00000073 !important;
            font-size: 0.7rem;
            border-radius: 5px;
            -webkit-backdrop-filter: blur(50px);
            backdrop-filter: blur(50px);
            color: #ffffff;
            right: 9px;
            padding: 5px 5px !important;
            z-index: 16 !important;
        }


        /* .zh-viewcount {
            position: relative !important;
            top: 0px;
            background: red !important;
            color: white;
            right: 4px;
            padding-right: 5px;
            padding-left: 5px;
            z-index: 16 !important;
            border-radius: 50%;
            font-size: 9px;
        } */

        .zh_cat_count {
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            font-family: 'Myanmar3', Sans-Serif !important;
            font-weight: 500 !important;
            color: #780116 !important;
            /* font-size: 18px; */
        }

        .woocommerce .product .item-description h3.product_title {
            font-size: 13px !important;
            font-weight: 600 !important;
        }

        .yk-product-title {
            font-size: 20px !important;
            font-weight: 600 !important;

        }

        .zh-product-title {
            font-size: 20px !important;
            font-weight: 600 !important;
            margin-left: 10px !important;
            margin-top: 10px !important;

        }

        .zh-Recommend_title {
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            font-family: 'Myanmar3', Sans-Serif !important;
            font-weight: 500;
        }

        .woocommerce .product .item-description,
        .woocommerce .products.list .product .item-image {
            padding-bottom: 0px !important;
        }

        .product-name {
            display: none !important;
        }

        .zh-formchecked:checked {
            background-color: #780116;
            border-color: #780116;
        }

        .yk-amount {

            /* modify zh */
            color: #780116 !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            line-height: 28px !important;
            float: left !important;
            margin-left: 10px !important;
        }

        .zh-amount {
            color: #000000 !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            line-height: 28px !important;
            font-family: "Myanmar3" !important;
        }

        .zh-shop_name {
            color: grey;
            font-size: 16px !important;
            font-weight: 500 !important;
            line-height: 28px !important;
            float: left !important;
            margin-left: 10px !important;
        }

        .zh-datepicker select {
            border: 2px solid #8080807b !important;
            background-color: #F3F4F9;
            border-radius: 10px !important;

            margin-left: 10px;
            font-size: 14px;

            opacity: 50%;
        }

        .searchbar {
            display: none;
        }

        .select2.select2-container {
            width: 100% !important;
        }

        label {
            color: #444444 !important;
            display: block !important;
            font-weight: initial !important;
            margin-bottom: 0.5em !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #c7b088 !important;
            color: white !important;
        }

        .yk-image {
            width: 222px !important;
            height: 146px !important;
        }


        .yk-product-image {
            width: 100% !important;
            height: 300px !important;
            vertical-align: inherit !important;
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .yk-product-image {
                height: 500px !important;
            }
        }

        .yk-product-thumb {
            object-fit: contain;
        }

        @media (min-width: 576px) {

            .yk-mt-sm-4 {
                margin-top: -7px !important;
            }

            .yk-mb-sm-4 {
                margin-bottom: 7px !important;
            }


        }

        /* zh media query */
        @media (max-width: 820px) {
            .searchbar {
                display: none;
            }

            .tabletsearchbar {
                display: block;
            }

            .products .ftc-product.product {
                opacity: 1;
                width: 100%;
            }

            .tabletsearchbar .col-md-5 {
                width: 50% !important;
            }

            .tablet-main-slide {
                /* margin-top: -2rem !important; */
            }

            .mobile-nav {
                height: 27px;
            }

            .zh-col-card {
                margin-left: 32px;
            }

            .zh-header {
                margin-top: 0px !important;
                margin-bottom: 0px !important;
            }

            .zh-row {
                width: 100% !important;
                margin-left: -10px !important;
            }


        }

        @media (min-width: 768px) {
            .zh-col-card {
                margin-left: 18px;
            }
        }

        /* zh-media-query */
        @media (max-width: 576px) {
            .searchbar {
                display: block;
            }

            .tabletsearchbar {
                display: none;
            }

            .navbar-nav {
                display: flex;
                flex-direction: row;
                padding-left: 0;
                margin-bottom: 0;
                list-style: none;
            }

            .nav-item {
                margin-right: 10px;

            }

            .mobile-nav {
                height: 27px;
            }

            .tablet-main-slide {
                /* margin-top: 1rem !important; */
            }

            .zh-col-card {
                margin-left: 25px;
            }

        }

        @media (max-width: 576px) {
            .zh-col-card {
                margin-left: 10px;
            }

            .zh-shops {
                width: 85px !important;
            }
        }

        /* Swe No Item Design */
        .sn-cross-sign:after {
            /* display: inline-block; */
            content: "\00d7";
            color: #9b9b9b;
            font-weight: 900;
            position: absolute;
            top: -20px;
            font-size: 30px;
        }

        .sn-no-items {
            position: relative;
            text-align: center;
            display: flex;
            flex-direction: column;
            margin: 40px 0;
        }

        .sn-no-items i {
            color: #c1c1c1;
            font-size: 36px;
            margin-bottom: 12px;
        }

        .sn-no-items span {
            color: #818181;
            font-size: 18px;
        }

        /* Swe Filter */
        .sn-multiple-selection {
            position: relative;
        }

        .show .sn-checkbox-dropdown {
            display: block;
            position: absolute;
            z-index: 999;
            background: #fff;
            border: 1px solid #cbcbcb;
            border-radius: 5px;
            top: 70px;
            width: 100%;
            min-height: 150px;
            overflow-y: scroll;
            max-height: 250px;
        }

        .sn-checkbox-dropdown {
            display: none;
        }

        .sn-checkbox-dropdown input[type=checkbox] {
            -webkit-appearance: none;
            display: block;
            /* padding:10px 16px; */
            width: 100%;
            margin: 0;
            outline: none !important;
            transition: background 0.3s;
        }

        /* .sn-checkbox-dropdown label:hover {
            background: rgba(0, 0, 0, 0.1);
        } */


        .sn-checkbox-dropdown input[type=checkbox]:checked+label {
            background: rgba(0, 0, 0, 0.1);
        }

        .sn-checkbox-dropdown input[type=checkbox]:checked+label:after {
            content: '×';
            position: absolute;
            font-weight: bold;
            right: 10px;
            top: 48%;
            font-size: 18px;
            line-height: 0;
            color: #8d8d8d;
        }

        .sn-checkbox-dropdown input[type=checkbox]:after {
            display: none;
        }

        .sn-gemname {

            border: 1px solid #cbcbcb;
            border-radius: 5px;
            margin-bottom: 0 !important;
            padding: 0.375rem 0.75rem;
            line-height: 1.5;

        }

        .sn-gemname:after {
            content: '';
            position: absolute;
            right: 10px;
            top: 70%;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #cccccc;
        }

        .sn-gem-list label {
            padding: 8px 16px;
            margin-bottom: 0 !important;
            position: relative;
        }

        .sn-price-range {
            position: relative;
        }

        .sn-price-list {
            z-index: 99;
        }

        .sn-price-list div {
            padding: 7px;
        }

        .sn-price-list div:hover {
            background: aliceblue;
        }

        .sn-price-range input {
            padding: 6px;
            border-radius: 5px;
            border: none;
            border-bottom: 1px solid #ced4da70;
            line-height: 1.75;
            text-align: center;
            position: relative;
        }

        .sn-price-range .sn-price-list {
            z-index: 99;
            padding: 7px;
        }

        .sn-price-range .sn-price-list div:hover {
            background: aliceblue;
        }

        .sn-from-price,
        .sn-to-price {
            position: relative;
        }

        .sn-from-price .arrow,
        .sn-to-price .arrow {
            content: '';
            position: absolute;
            right: 20px;
            top: 50%;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #cccccc;
            pointer-events: none;
        }

        .sn-price-range input::-webkit-calendar-picker-indicator {
            display: none !important;
        }

        .sn-price-range .sn-price-error {
            position: absolute;
            top: -14px;
            font-size: 10px;
            color: #ff0000a6;
            left: 0;
        }

        .sn-price-range .price_error {
            border-color: #ff0000a6;
        }

        .sn-search-form input {
            padding: 12px 180px 12px 45px !important;
            height: 50px;
            border-bottom-left-radius: 5px !important;
            border-top-left-radius: 5px !important;
        }

        .sn-search-form button,
        .sn-advance-search-go {
            height: 50px;
            width: 80px;
            color: #fff;
            background: #780116;
            border-bottom-right-radius: 5px !important;
            border-top-right-radius: 5px !important;
            font-size: 1.2rem;
        }

        .sn-advance-search-go {
            width: 79px;
        }

        .sn-search-form button:hover {
            background: #000;
        }

        .sn-search-placeholder {
            position: absolute;
            left: 13px;
            top: 14px;
            color: #626262;
        }

        .sn-advanced-search {
            position: absolute;
            right: 105px;
            cursor: pointer;
        }

        .sn-advanced-search i {
            padding-right: 12px;
        }

        .noselect {
            margin: 15px 0 0;

        }

        .collapsing {
            -webkit-transition: none;
            transition: none;
            display: none;
        }

        .sn-collapse {
            text-align: left;
            border: 1px solid #e7e7e7;
            border-radius: 5px;
            box-shadow: 1px 2px 15px 1px #efefef;
            position: absolute;
            z-index: 999;
            background: #fff;
        }

        .sn-collapse .sn-collapse-wrapper::after,
        .sn-collapse .sn-collapse-wrapper::before {
            bottom: 100%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .sn-collapse .sn-collapse-wrapper::after {
            border-color: rgba(255, 255, 255, 0);
            border-bottom-color: #ffffff;
            border-width: 8px;
            right: 179px;
            margin-left: -19px;
        }

        .sn-collapse .sn-collapse-wrapper::before {
            border-color: rgba(113, 158, 206, 0);
            border-bottom-color: #efefef;
            border-width: 10px;
            right: 177px;
            margin-left: -20px;
        }

        .sn-collapse .sn-collapse-wrapper {
            padding: 25px 20px 20px;
            position: relative;
        }

        .sn-collapse .sn-collapse-wrapper .sn-label {
            color: #7e7e7e !important;
            font-size: 1rem !important;
            padding-top: 5px;
            padding-left: 12px;
            margin: 0 !important;
        }

        .sn-collapse-wrapper input::placeholder {
            color: #000;
            opacity: 1;
        }

        .sn-collapse .sn-collapse-wrapper .sn-dropdown-select {
            border: 0;
        }

        .sn-dropdown-select,
        .sn-filter-text {
            color: #000 !important;
        }

        .sn-adv-search-btn {
            float: right !important;
            color: #fff;
            background: #780116;
            border-radius: 5px;
        }

        .sn-adv-search-title {
            font-size: 20px;
            color: #000;
            padding-left: 12px;
            margin-bottom: 12px !important;
        }

        @media only screen and (max-width: 600px) {
            .sn-advanced-search span {
                display: none;
            }

            .sn-search-form input {
                padding-right: 50px !important;
                margin-right: 5px !important;
                border-radius: 5px !important;
            }

            .sn-search-form button,
            .sn-advance-search-go {
                border-radius: 5px !important;
            }

            .sn-advance-search-go {
                width: 74px;
            }

            .sn-advanced-search {
                right: 75px;
            }

            .sn-collapse .sn-collapse-wrapper::after {
                right: 100px;
            }

            .sn-collapse .sn-collapse-wrapper::before {
                right: 98px;
            }

            .sn-advanced-search i {
                padding: 16px 15px;
                width: 50px;
            }

            .sn-from-price .arrow,
            .sn-to-price .arrow {
                right: 10px;
            }

        }

        .sop-footer-text p,
        .sop-footer-text a {
            font-size: 20px !important;
            color: white !important;

            /* font-family: sans-serif !important;
             */
            font-family: 'Myanmar3', Sans-Serif !important;

            line-height: 2;
        }

        /* news and events */

        .sn-fs-promo {
            position: relative;
            display: block;
        }

        .sn-fs-layer {
            background: #00000094;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
        }

        .sn-fs-promo-title {
            background: #780116;
            color: #fff;
            font-size: 22px;
            position: absolute;
            bottom: 34%;
            left: 4%;
            padding: 5px 15px;
        }

        .sn-fs-promo-shop,
        .sn-fs-promo-desc {
            position: absolute;
            bottom: 24%;
            left: 4%;
            color: #fff;
            font-weight: 900;
            margin-bottom: 0px;
        }

        .sn-fs-promo-desc {
            bottom: 5%;
            width: 92%;
            font-weight: 100;
        }

        .sn-main-promo img,
        .sn-fs-promo img {
            aspect-ratio: 2/1;
            width: 100%;
        }

        .sn-main-promo .sn-main-promo-title,
        .sn-promo-title,
        .sn-latest-news-title,
        .sn-upcoming-events-title,
        .sn-latest-news .sn-latest-news-title,
        .sn-top-stories .sn-top-stories-title {
            font-size: 20px;
            /* font-family: sans-serif; */
            color: #000;
            margin: 20px 0 10px;
        }

        .sn-top-stories-title {
            margin-top: 60px !important;
        }

        .sn-latest-news-title a,
        .sn-top-stories-title a {
            color: #000 !important;
        }

        .sn-main-promo .sn-main-promo-shop {
            font-size: 16px;
            /* font-family: sans-serif; */
            color: #6e6e6e;
            margin-bottom: 25px;
        }

        .sn-main-promo .sn-main-promo-desc,
        .sn-promo-list p,
        .sn-latest-news p {
            color: #464646;
        }

        .sn-main-promo .sn-main-promo-period {
            margin-bottom: 30px;
            font-weight: 600;
        }

        .sn-promo-title,
        .sn-upcoming-events-title,
        .sn-latest-news-title,
        .sn-top-stories-title,
        .sn-latest-news-title {
            margin-bottom: 5px !important;
            font-weight: bold;
        }

        .sn-promo-title {
            margin-top: 50px !important;
        }

        .sn-latest-news-title,
        .sn-upcoming-events-title,
        .sn-promo-title {
            margin: 10px 0 20px !important;
            /* color: #000; */
        }

        .sn-promo-list {
            margin: 50px 0;
        }

        .sn-promo-list img,
        .sn-latest-news img {
            aspect-ratio: 2/1;
            /* width: 350px !important;
            height: 200px;
            object-fit: cover; */
            display: block;
            margin: 0 auto;
        }

        /* .sn-ads-img img{
          aspect-ratio: 1/1;
          width: 100%;
        } */
        .sn-promo-list .sn-promo-list-title,
        .sn-upcoming-events .sn-upcoming-events-sub,
        .sn-latest-news .sn-latest-news-sub,
        .sn-sub-title,
        .sn-top-stories .sn-top-stories-sub {
            font-size: 16px;
            color: #000 !important;
            margin: 0;
            display: block;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .sn-top-stories .sn-top-stories-sub {
            font-size: 14px;
        }

        .sn-top-stories div {
            border-bottom: 1px solid #cdcdcd;
            margin: 25px 0 10px;
        }

        .sn-latest-news .sn-latest-news-sub {
            margin: 15px 0 10px;
        }

        .sn-promo-list .sn-promo-list-shop {
            font-size: 14px;
            font-family: sans-serif;
            color: #6e6e6e;
            display: block;
            margin-bottom: 10px;
        }

        .sn-promo-list div:first-child {
            margin-right: 20px !important;
        }

        .sn-promo .sn-news-button,
        .sn-upcoming-events .sn-news-button,
        .sn-latest-news-button,
        .sn-top-stories-button {
            float: right;
            margin-bottom: 50px;
            background: #780116;
            color: #fff !important;
            padding: 8px 12px;
        }

        .sn-promo .sn-news-button:hover,
        .sn-upcoming-events .sn-news-button:hover,
        .sn-latest-news-button:hover,
        .sn-top-stories-button:hover {
            background-color: #000;
            color: #fff !important;
        }

        .sn-upcoming-events-date {
            background: #780116;
            color: #fff;
            font-weight: bold;
            font-size: 14px;
            padding: 3px 10px;
            border-radius: 2px;
            margin: 30px 0 13px;
            display: inline-block;
        }

        .event-seemore-link:hover {
            color: #780116 !important;
        }

        @media only screen and (max-width: 768px) {
            .sn-promo-list img {
                aspect-ratio: 1/1;
                width: 35em !important;
            }

            .sn-promo .sn-news-button,
            .sn-upcoming-events .sn-news-button,
            .sn-latest-news-button,
            .sn-top-stories-button {
                width: 100%;
                text-align: center;
            }

            .sn-fs-promo-shop {
                bottom: 6%;
                font-size: 18px;
            }

            .sn-fs-promo-title {
                bottom: 23%;
                font-size: 16px;
            }

            .sn-promo-list {
                margin: 0;
            }

            .sn-promo-title {
                margin-bottom: 20px !important;
                margin-top: 10px !important;
            }

            #sn-events-tab1,
            #sn-events-tab2 {
                margin: 15px 10px !important;
                color: rgb(22, 22, 22);
                display: inline-block;

            }

            .sn-events-tab-active {
                color: #780116 !important;
                border-bottom: 2px solid #780116;
            }
        }

        .sn-no-news {
            text-align: center;
            margin: 10em;
        }

        .photos {
            width: 350px;
            height: 200px;
            margin-right: 40px;
        }

        @media screen and (max-width: 680px) {
            .photos {
                width: 500px;
                height: 200px;
                margin-right: 0;
            }
        }

        #snNepTap {
            justify-content: space-between;
            padding: 0 3px 0px;
            border-bottom: 1px solid #c5c5c5;
            font-size: 18px;
            margin-bottom: 20px;
        }

        #newsTab,
        #eventsTab,
        #promotionsTab {
            background: none;
            padding: 0 0 8px;
        }

        .tab-focus {
            color: #000;
            border-bottom: 1px solid #780116;
        }

        /* end of news and events */
    </style>
    <link rel="stylesheet" href="{{ url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('test/css/fancybox.css') }}" />
    <style>
        .header-content {
            padding: 11px 0;
        }


        .mega_main_menu-2-2-1 {
            font-family: Georgia, 'Times New Roman', Times, serif
        }

        .mm_font {
            font-family: 'Myanmar3', Sans-Serif !important;

        }

        ::-webkit-input-placeholder {
            /* Chrome/Opera/Safari */
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        ::-moz-placeholder {
            /* Firefox 19+ */
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        :-ms-input-placeholder {
            /* IE 10+ */
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        :-moz-placeholder {
            /* Firefox 18- */
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .sop-disable {
            cursor: not-allowed;
            opacity: 0.8;
            color: rgb(147, 147, 147) !important;
            pointer-events: none;
        }

        .sop-disable:hover {
            cursor: not-allowed;
            opacity: 0.8;
            color: rgb(147, 147, 147) !important;
        }

        .sop-disable-f {
            cursor: not-allowed;
            opacity: 0.5;
            color: rgb(147, 147, 147) !important;
            pointer-events: none;
        }

        .sop-disable-f:hover {
            cursor: not-allowed;
            opacity: 0.5;
            color: rgb(147, 147, 147) !important;
        }

        #categories_slide {
            position: relative;
        }

        #categories_slide .owl-prev {
            padding-left: 0px;
        }

        #categories_slide .owl-next {
            padding-right: 0px;
        }

        .sn-nep-dropdown {
            margin-left: 25px;
            position: unset;
            margin-top: 10px;
        }

        .sn-nep-dropdown button {
            background: #fff !important;
            color: #333 !important;
            position: unset !important;
        }

        /* Shop Directory */
        .sn-directory {
            background-image: linear-gradient(to right, #f7d7fd, #f3cc74, #ffff6b);
            padding: 35px 40px;
            margin: 25px 0px 35px;
            position: relative;
            border-radius: 5px;
        }

        .sn-directory-desc h3 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .sn-directory-desc p {
            margin: 1px;
        }

        .sn-directory-link {
            position: absolute;
            right: 35px;
            top: 35%;
            border: 1px solid;
            padding: 10px 15px 5px;
            border-radius: 50%;
        }

        .directory-banner {
            background-image: url("{{ asset('images/directory/banner/shopdirectorybanner.jpg') }}");
            background-repeat: no-repeat;
            background-position: center;
            object-fit: cover;
            background-size: 100%;
            opacity: 1 !important;
            background-size: cover;
            width: 100%;
            height: 400px;
            vertical-align: middle;
            text-align: center;
        }

        .directory-banner .sn-dir-banner {
            text-align: center;
            color: #fff;
            /* padding: 152px 0px; */
        }

        .directory-banner .sn-dir-banner h1 {
            font-size: 30px;
            font-weight: 900;
            line-height: 3rem;
        }

        .sn-image-w-h {
            width: 95% !important;
            height: 100% !important;
            aspect-ratio: 5 / 3;
            border-radius: 0 !important;
            margin: 0 auto;
        }

        .shop-dir-links {
            display: flex;
            flex-direction: row;
        }

        .shop-dir-links .fa-globe {
            color: #158f00;
            font-size: 22px;
        }

        .shop-dir-links .fa-facebook {
            color: #3b5998;
            font-size: 22px;
        }

        .sn-dir-detail-img {
            width: 150px;
            height: auto;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 50%;
        }

        #sn-directory-container h1 {
            margin-left: 30px;
            font-size: 32px;
            width: 81%;
        }

        #sn-directory-container .fa-globe,
        #sn-directory-container .fa-facebook {
            font-size: 32px;
            margin-left: 20px;
        }

        .sn-directory-title img {
            width: 30px;
            height: 30px;
            float: right;
            background: #780116;
            padding: 4px;
            border-radius: 50%;
        }

        .sn-premium-ribbon {
            width: 70px;
            height: 88px;
            background: rgba(255, 255, 255, 0);
            top: 1px;
            right: 0;
            position: absolute;
            z-index: 9;
            border-radius: 3px;

            border-left: 35px solid #ffe670;
            border-right: 35px solid #ffe670;
            border-bottom: 22px solid transparent;
            bottom: -30px;
        }

        .sn-premium-text {
            position: absolute;
            top: 22px;
            right: 0;
            z-index: 99;
            width: 70px;
            text-align: center;
            line-height: 1rem;
            font-size: 14px;
            color: #780116;
        }

        .grey-out {
            cursor: default;
            pointer-events: none;
        }

        .grey-out i {
            color: gray !important;
        }

        #sn-directory-tab-content .tab-pane {
            padding: 30px 0 30px 10px;
        }

        #newest {
            /* padding-left: 0 !important; */
        }

        .sn-dir-banner {
            display: inline-block;
            margin: 140px 0;
        }

        .sn-dir-search {
            width: 700px;
        }

        .sn-dir-search {
            background: #fff;
        }

        #sn-dir-state {
            border-right: 1px solid #e7e7e7 !important;
        }

        .sn-dir-search-button button {
            background: #780116;
            color: #fff;
            border-radius: 0.25rem !important;
            height: 45px;
            width: 100px;
        }

        .sn-dir-search-button button:hover {
            background: #000;
        }

        .sn-dir-search-icon i {
            color: #780116;
            padding-top: 6px;
        }

        .sn-dir-store {
            font-size: 180px;
            text-align: center;
            padding: 20px;
            color: #d7d7d7;
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .sn-dir-search {
                width: 650px;
            }
        }

        @media only screen and (max-width: 765px) {
            .directory-banner .sn-dir-banner h1 {
                font-size: 24px;
            }

            .sn-directory {
                padding: 35px 18px;
                margin: 25px 0px 35px;
            }

            .sn-directory-desc h3 {
                font-size: 20px;
            }

            .sn-directory-link {
                right: 18px;
            }

            .directory-banner {
                height: 290px;
            }

            .directory-banner .sn-dir-banner {
                font-size: 22px;
            }

            .directory-banner .sn-dir-banner {
                /* padding: 72px 0; */
            }

            .sn-dir-search {
                width: 300px;
                background: transparent !important;
            }

            #sn-dir-state,
            #sn-dir-township {
                border-radius: 4px !important;
            }

            #sn-dir-state {
                border-right: 0 !important;
            }

            .sn-dir-detail-img {
                width: 80px;
                height: auto;
            }

            #sn-directory-container h1 {
                font-size: 18px;
                margin-left: 10px;
                width: 65%;
            }

            #sn-directory-container .fa-globe,
            #sn-directory-container .fa-facebook {
                font-size: 18px;
                margin-left: 5px;
            }

            .sn-dir-banner {
                margin: 35px 0;
            }

            .sn-dir-search-button button {
                height: 38px;
                font-size: 16px;
                margin-top: 10px;
            }

        }
    </style>
</head>

<body onbeforeunload="useroffline()"
    class="archive post-type-archive post-type-archive-product wp-embed-responsive theme-karo1 woocommerce woocommerce-page woocommerce-no-js rtwpvs rtwpvs-rounded rtwpvs-attribute-behavior-blur rtwpvs-tooltip yith-wcan-free yith-wishlist ftc-theme-demo group-blog hfeed has-header-image colors-light wcfm-theme-karo wpb-js-composer js-comp-ver-6.5.0 vc_responsive elementor-default elementor-kit-9036 jewelry dokan-theme-karo1 mmm mega_main_menu-2-2-1">
    <div id="app">
      

        @if (\Illuminate\Support\Facades\Auth::guard('web')->check())
            @if ($is_chat_on == 'on')
                <chat-wrapper ref='chatlistref' v-on:getfromid="getfromidparent"
                    v-bind:userid="{{ \Illuminate\Support\Facades\Auth::user()->id }}"></chat-wrapper>

                <chat-template ref="chatref" v-on:openmain="toopenmainchatwrapper"
                    v-bind:userid="{{ \Illuminate\Support\Facades\Auth::user()->id }}"
                    v-bind:username="'{{ \Illuminate\Support\Facades\Auth::user()->username }}'"></chat-template>
            @endif
        @endif


        @yield('content')

        <div class="modal fade" id="noti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="noti_title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="noti-modal-body">
                        <div class="d-flex flex-row">
                            <div>
                                <img style="width: 100px;height:100px;"
                                    src="{{ url('images/items/mid/16527968693160ab7b693-35b2-46e4-85cf-500cae96b99b.jpeg') }}"
                                    id="noti_img">
                            </div>
                            <div class="pl-2">
                                <div id="noti_body" class="ms-2">

                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>


        {{-- add to home screen --}}
        @include('front.addtohome')


    </div>
    <script type='text/javascript' src="{{ asset('js/app.js') }}"></script>

    <script>
        function ftc_open_menu() {
            var body = $("body");

            body.on("click", ".mobile-nav", function() {
                if (body.hasClass("has-mobile-menu")) {
                    body.removeClass("has-mobile-menu");
                } else {
                    body.addClass("has-mobile-menu");
                }
            });
            body.on("click", ".btn-toggle-canvas", function() {
                body.removeClass("has-mobile-menu");
            });
            body.on("click touchstart", ".ftc-close-popup", function() {
                body.removeClass("has-mobile-menu");
            });
        }
        ftc_open_menu();


        var cururl = '{{ url()->current() }}';
        if (!cururl.includes('see_by_categories') && !cururl.includes('product_detail')) {
            localStorage.removeItem('price_range');
            localStorage.removeItem('order');
            localStorage.removeItem('specific_cat_id');
            localStorage.removeItem('byspecificgems');
            localStorage.removeItem('selectedgender');

            localStorage.removeItem('byshop');


            localStorage.removeItem('from');
            localStorage.removeItem('to');
            localStorage.removeItem('product_quality');
            if (document.getElementById("radio-id-9") !== null) {
                document.getElementById("radio-id-9").checked = false;

            }
        }

        // window.fbAsyncInit = function() {
        //     FB.init({
        //         appId: '995588534410291',
        //         cookie: true,
        //         xfbml: true,
        //         version: 'v13.0'
        //     });


        // };
    </script>









    <script type='text/javascript'
        src="{{ url('test/wp-content/plugins/wc-frontend-manager/includes/libs/select2/select2.js') }}" id='select2_js-js'>
    </script>


    <script type='text/javascript' src="{{ url('test/js/owl.js') }}" id='owl-carousel-js'></script>
    <script src='{{ url('test/js/owl.thumbs.js') }}'></script>




    @if (session()->has('show_add_to_home'))
        <script>
            $(document).ready(function() {
                $('#atc').modal('show')

            });
        </script>
        <script>
            function updateaddtohome() {
                return new Promise(resolve => {
                    axios
                        .post(
                            "{{ url('/addtohome/update') }}", {
                                data: {
                                    addtohs: 'yes'

                                }
                            }, {
                                header: {
                                    "Content-Type": "multipart/form-data",
                                },
                            }
                        )
                        .then((response) => {
                            resolve(response.data)


                        });
                })

            }

            //for add to home screen

            if ('serviceWorker' in navigator) {
                navigator.serviceWorker
                    .register("{{ url('swath.js') }}")
                    .then(() => {
                        console.log('Service Worker Registered');
                    });
            }

            let deferredPrompt;
            var button = document.querySelector('.addth-button');
            window.addEventListener('beforeinstallprompt', (e) => {
                // Prevent Chrome 67 and earlier from automatically showing the prompt

                e.preventDefault();

                // Stash the event so it can be triggered later.
                deferredPrompt = e;
                button.addEventListener('click', (e) => {
                    // hide our user interface that shows our A2HS button
                    // Show the prompt
                    deferredPrompt.prompt();
                    // Wait for the user to respond to the prompt
                    deferredPrompt.userChoice
                        .then((choiceResult) => {
                            if (choiceResult.outcome === 'accepted') {
                                updateaddtohome();
                                $(document).ready(function() {
                                    $('#atc').modal('hide')

                                });
                                console.log('User accepted the A2HS prompt');
                            } else {
                                console.log('User dismissed the A2HS prompt');
                            }
                            deferredPrompt = null;
                        });
                });
            });
        </script>
    @endif
    {{-- add to home screen --}}
    @if (\Illuminate\Support\Facades\Session::has('logined'))
        <script>
            const upload_fav_localstorage_to_server_after_logined = function(data) {
                if (typeof localStorage.getItem(data) !== 'undefined' && localStorage.getItem(data) !== null) {
                    var tmp_rm = '[]';
                    if (typeof localStorage.getItem(data + "_rm") !== 'undefined' && localStorage.getItem(data + "_rm") !==
                        null) {
                        var tmp_rm = localStorage.getItem(data + "_rm");

                    }
                    return new Promise((resolve, reject) => {
                        let uri = "{{ url('/myfav/upload_after_logined') }}";
                        if (data == 'cart') {
                            uri = "{{ url('/mycart/upload_after_logined') }}";
                        }
                        axios.post(uri, {
                            ids: localStorage.getItem(data),
                            rm_ids: tmp_rm,
                        }).then(response => {
                            if (response.data.success) {
                                localStorage.setItem(data, JSON.stringify(response.data.data));
                                localStorage.setItem(data + '_rm', '[]');

                            }
                            resolve(response);
                        });
                    })


                }
            }
            const clearls = async function() {
                var foratclstmp = localStorage.getItem("foraddtocartitems");
                var dtlstmp = localStorage.getItem("datenow");
                var myItem = localStorage.getItem('guest_id');
                var favorite = localStorage.getItem('favourite');
                var favorite_rm = localStorage.getItem('favourite_rm');
                var cart = localStorage.getItem('cart');
                var cart_rm = localStorage.getItem('cart_rm');

                localStorage.clear();
                localStorage.setItem("datenow", dtlstmp);
                localStorage.setItem("foraddtocartitems", foratclstmp);
                localStorage.setItem("favourite", favorite);
                localStorage.setItem("cart", cart);
                localStorage.setItem("cart_rm", cart_rm);

                localStorage.setItem("favourite_rm", favorite_rm);



                localStorage.setItem("guest_id", foratclstmp);


                window.userid = {{ \Illuminate\Support\Facades\Auth::user('guard')->id }};
                const tempfu = await upload_fav_localstorage_to_server_after_logined('favourite');
                const tempcu = await upload_fav_localstorage_to_server_after_logined('cart');

            }
            clearls();
        </script>
    @endif
    <script>
        //array to object with key from object data
        const convertArrayToObject = (array, key) => {
            const initialValue = {};
            return array.reduce((obj, item) => {
                return {
                    ...obj,
                    [item[key]]: item,
                };
            }, initialValue);
        };
        //csrf
        let _token = $('meta[name="csrf-token"]').attr('content');
    </script>
    @stack('custom-scripts')
    @stack('favourite')


    <script type="text/javascript">
        function useroffline() {
            if (typeof Window.userid != undefined) {
                return Window.allfrommsg.sendwhatuserisoffline(window.userid);

            }
        }

        $(document).ready(function() {
            // Handler for .ready() called.

            //for loader
            $('#main_slide').removeClass('d-none');
            $('#ads_slide').removeClass('d-none');
            $('.show_dev').removeClass('d-none');
            // $('.remove_wrapp').addClass('d-none');
            // zh
            $('.collections_head').removeClass('d-none');


            //for loader

            //for photo zoom


        });


        //zomm to hide text
        setTimeout(function() {
            $('.yk-photozoom-text').addClass('d-none');
        }, 2000);


        jQuery(function($) {
            //Initialize Select2 Elements
            $('.select2').select2()
            $('#exampleFormControlSelect1').select2();
            $('#exampleFormControlSelect12').select2();
            $('#exampleFormControlSelect2').select2();
            $('#exampleFormControlSelect3').select2();
            $('#exampleFormControlSelect4').select2();
            $('#exampleFormControlSelect5').select2();
            $('#exampleFormControlSelect6').select2();
            $('#exampleFormControlSelect7').select2();


            $('#categories_slide').owlCarousel({
                loop: false,
                margin: 10,
                responsiveClass: true,
                autoplay: false,
                dots: false,
                autoplayTimeout: 6000,
                autoplayHoverPause: false,
                nav: true,
                navText: [
                    '<button class="yk-slide-btn"><i class="fa fa-angle-left" aria-hidden="true"></button></i>',
                    '<button class="yk-slide-btn"><i class="fa fa-angle-right" aria-hidden="true"></button></i>'
                ],
                responsive: {
                    0: {
                        items: 3,
                    },
                    600: {
                        items: 5,
                    },
                    1000: {
                        items: 7,
                    },
                    1500: {
                        items: 9,
                    }
                }
            });

            $('#main_slide').owlCarousel({
                loop: true,
                margin: 0,
                responsiveClass: true,
                autoplay: true,
                dots: false,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                responsive: {

                    0: {
                        items: 1,
                        stagePadding: 0,
                    },
                    600: {
                        items: 1,
                        stagePadding: 0,
                    },
                    900: {
                        items: 1,
                        stagePadding: 0,
                    },
                    1200: {
                        items: 1,
                        stagePadding: 0,
                    },
                    1400: {
                        items: 1,
                        stagePadding: 0,
                    }
                }
            });


            $('#product_slide').owlCarousel({

                margin: 10,
                responsiveClass: true,
                nav: true,
                loop: false,
                navText: [
                    '<button class="yk-slide-btn"><i class="fa fa-angle-left" aria-hidden="true"></button></i>',
                    '<button class="yk-slide-btn"><i class="fa fa-angle-right" aria-hidden="true"></button></i>'
                ],
                thumbs: true,
                thumbImage: false,
                thumbsPrerendered: false,
                thumbContainerClass: 'owl-thumbs mt-2',
                thumbItemClass: 'owl-thumb-item',
                dots: false,
                responsive: {
                    0: {
                        items: 1,
                    },
                    600: {
                        items: 1,
                    },
                    1000: {
                        items: 1,
                        loop: false
                    }
                }
            });

            $('#new_arrival_slide').owlCarousel({
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



            $('#discount_slide').owlCarousel({
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
                    1400: {
                        items: 6,
                        stagePadding: 0,
                    }
                }
            });









        });
    </script>



    {{-- //for zoom --}}

    <script type="text/javascript">
        (function($) {
            "use strict";
            $('.header-dropdown-element').each(function() {
                $(this).find('.header-icon i').on('click', function() {
                    $(this).closest('.header-dropdown-element').find('.content-dropdown').slideToggle();
                });
            });
        });
    </script>
    {{-- //for zoom --}}


    <script src="{{ url('test/js/firebase/firebase-app.js') }}"></script>
    <script src="{{ url('test/js/firebase/firebase-messaging.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {

            const firebaseConfig = {
                apiKey: "AIzaSyDBV05S5tzHy_O6Q4nTi_ffvnEz0NY_he0",
                authDomain: "shweshops-d289a.firebaseapp.com",
                projectId: "shweshops-d289a",
                storageBucket: "shweshops-d289a.appspot.com",
                messagingSenderId: "583933213745",
                appId: "1:583933213745:web:2892f64591132059922910",
                measurementId: "G-H4L7Q3SRWM"
            };
            const firebaseapp = firebase.initializeApp(firebaseConfig);

            const fmessaging = firebaseapp.messaging();

            // fmessaging.onMessage((payload) => {
            //     $('#noti_title').html(payload.data.title);
            //     $('#noti_body').html(payload.data.body);
            //     $('#noti_img').attr("src", payload.data.photo)
            //     $('#noti').modal('show');
            //     const notificationTitle = payload.data.title;
            //     const notificationOptions = {
            //         body: payload.data.body,
            //         icon: payload.data.photo,
            //         image: payload.data.photo,
            //         badge: 'https://dev.shweshops.com/images/logo/favicon.gif',
            //     };
            //
            //     $('#noti-modal-body').click(function () {
            //         event.preventDefault(); // prevent the browser from focusing the Notification's tab
            //         $('#noti').modal('hide');
            //
            //         location.assign(payload.data.link);
            //
            //     });
            //
            //     console.log(payload);
            // });

        });

        function calculateVh() {
            var vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', vh + 'px');
        }

        function scrollToTop() {
            // window.scrollTo(0, 0);
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }

        // Initial calculation
        calculateVh();

        // Re-calculate on resize
        window.addEventListener('resize', calculateVh);

        // Re-calculate on device orientation change
        window.addEventListener('orientationchange', calculateVh);
    </script>
 
    <div id="to-top" class="scroll-button">
        <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>

</body>
@stack('scripts')

</html>
