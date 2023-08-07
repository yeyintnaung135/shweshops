<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shwe Shops</title>
    <link rel="icon" type="image/png" sizes="19x19" href="{{ url('images/logo/favicon.png')}}">
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

    <link rel='stylesheet' id='ftc-style-css' href="{{url('test/wp-content/themes/karo1/style.css')}}" type='text/css'
          media='all'/>

    <?php
    if (session()->has('guest_id')) {
        $getid = \App\Guestoruserid::where('guest_id', session()->get('guest_id'));
        if(!empty($getid->first())){
            \App\frontuserlogs::where('userorguestid', $getid->first()->id)->delete();
            $getid->delete();
        }

    }
    ?>

    @if(\Illuminate\Support\Facades\Session::has('loginedSO'))
        <script>
            window.facebook={{$is_fb_on}};

            var myItem = localStorage.getItem('guest_id');

            localStorage.clear();
            localStorage.setItem('guest_id',myItem);

        </script>
    @endif
    {{--    <script>--}}
    {{--        localStorage.clear();--}}

    {{--    </script>--}}
<!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{url('plugins/daterangepicker/daterangepicker.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{url('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{url('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{url('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{url('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{url('plugins/bs-stepper/css/bs-stepper.min.css')}}">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('plugins/summernote/summernote-bs4.min.css') }}">
    <!-- dropzonejs -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('dist/css/adminlte.min.css')}}">
    <link
        rel="stylesheet"
        href="{{url('test/css/fancybox.css')}}"
    />
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
    {{-- <link rel='stylesheet' id='wcfm_fa_icon_css-css'
          href="{{url('test/wp-content/plugins/wc-frontend-manager/assets/fonts/font-awesome/css/wcfmicon.min.css')}}"
          type='text/css' media='all'/> --}}
    {{-- <link rel='stylesheet' id='font-awesome-css'
    href="{{url('test/wp-content/themes/karo1/assets/css/font-awesome.css')}}"
    type='text/css' media='all'/> --}}
    <script src="https://kit.fontawesome.com/be7d01d228.js" crossorigin="anonymous"></script>
    {{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
    @if(Auth::check())
        <?php
        if(Auth::guard('shop_owner')->check()){
            $shopid= Auth::guard('shop_owner')->user()->id;


        }else if(Auth::guard('shop_role')->check()){
            $shopid= Auth::guard('shop_role')->user()->shop_id;

        }
        ?>
        <script>
            window.facebook='{{$is_fb_on}}';

            window.userid = {{$shopid}};
            function calculateVh() {
                var vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', vh + 'px');
            }

            // Initial calculation
            calculateVh();

            // Re-calculate on resize
            window.addEventListener('resize', calculateVh);
            var user_id_for_android ={type:"shopid", id:window.userid};
            localStorage.setItem('user_id_for_android', JSON.stringify(user_id_for_android));

        </script>
    @endif
    <style>
        @font-face {
            font-family: 'Myanmar3';
            src: local('Myanmar3'), url("{{url('mmfont/PyidaungsuZawDecode.woff2?93a8fffb927d8bfcaac5683829dcd048')}}") format('woff2'), url("{{url('PyidaungsuZawDecode.woff?0e8dd9ee5f902f7ff573524de8b4f94d')}}") format('woff');
        }
        .imgcenter {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        body {
            font-family: 'Myanmar3', Sans-Serif !important;
            /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;*/

        }

        .imgform-input {
            width: 350px;
            padding: 20px;
            background: #fff;
            box-shadow: -3px -3px 7px rgba(94, 104, 121, 0.377),
            3px 3px 7px rgba(94, 104, 121, 0.377);
        }

        .imgform-input input {
            display: none;
        }

        .swal-yk-title {
            color: #28a745 !important;
        }

        .imgform-input label {
            display: block;
            width: 45%;
            height: 45px;
            margin-left: 25%;
            line-height: 50px;
            text-align: center;
            background: #1172c2;
            color: #fff;
            font-size: 15px;
            /* font-family:"Open Sans",sans-serif; */
            font-family: 'Myanmar3', Sans-Serif !important;
            text-transform: Uppercase;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        .back {
            background-color: #d4af37;
        }

        .back:hover {
            color: #fff;
        }

        /* zh-media-query */
        @media (max-width: 576px) {
            .zh-header_shop {
                margin-left: 0% !important;
            }
        }

        /* zh-product-image */
        .yk-product-image {
            width: 416px !important;
            height: 362px !important;
            vertical-align: inherit !important;

        }

        .yk-photozoom-text {
            display: none;
            position: absolute;
            width: 100%;
            top: 149px;
            /* left: 171px; */
            text-align: center;
            color: white;
            font-weight: bolder;
        }

        /* these styles are for the zoom, but are not required for the plugin */
        .zoom {
            display: inline-block;
            position: relative;
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

        @media (min-width: 1025px) {
            .details-img {
                width: 420px !important;
            }

        }

        /* these styles are for the zoom, but are not required for the plugin */
        .zoom {
            display: inline-block;
            position: relative;
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


            .yk-product-image {
                width: 344px !important;
                height: 356px !important;
                vertical-align: inherit !important;
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

            .yk-product-image {
                width: 599px !important;
                height: 451px !important;
                vertical-align: inherit !important;
            }

        }

        @media only screen and (min-width: 768px) {
            .yk-product-image {
                width: 344px !important;
                height: 356px !important;
                vertical-align: inherit !important;
            }
        }

        @media only screen and (min-width: 992px) {
            .fancybox__container {
                margin-left: 250px;
            }
            .yk-product-image {
                width: 418px !important;
                height: 383px !important;
                vertical-align: inherit !important;
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
            font-family: 'Myanmar3' !important;

        }

        /* zh-product-title */
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

        .woocommerce div.product .summary h1.product_title.entry-title {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 8px;
            margin-bottom: 17px;
            width: 100%;
        }

        .zh-title {
            margin-left: 8px !important;
            font-family: 'Myanmar3', Sans-Serif !important;
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            text-transform: capitalize !important;
            font-size: 20px;
            font-weight: bold;
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

        .sn-product-des .fa-arrow-up, .sn-product-des .fa-arrow-down {
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

        .sn-product-detail {
            margin-left: 10px;
            line-height: 2rem;
            /* zh-modify */
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .sn-product-detail h1 {
            margin: 15px auto 10px;
            font-size: 20px;
        }

        h1 {
            margin: 15px auto 10px;
            font-size: 20px;
            font-weight: bold;
        }

        .sn-product-des button {
            background: none !important;
            padding: 0 !important;
            color: #646464 !important;
            border-bottom: 1.5px dotted;
            border-radius: 0;
            border: none;
            border-bottom: 1px dotted;
        }

        .zh-row {
            margin-bottom: 10px !important;
        }

        .sn-wrapper .sn-detail-title {
            font-size: 16px !important;
            font-weight: bold !important;
            color: #000;
            margin-right: 7px;
        }

        .sn-shop-link {
            border-bottom: 1px dotted;
            color: #ee6412 !important;
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

        .disable-form {
            background: none !important;
            border: 0;
        }

        .sn-cancel-form {
            position: absolute;
            left: 35px;
            border-bottom: 1px dotted;
            color: #4d4d4d;
        }

        .sn-cancel-form:hover {
            color: #333;
        }

        /* Swe Password Generate */
        .sn_generatepass_wrapper button {
            font-size: 12px;
            margin: 5px 0;
        }

        /* Swe Admin Dashboard */
        .sn-background-light-blue {
            background: #F0F7FA !important;
        }

        .sn-background-white {
            background: #fff;
        }

        .sn-admin-wrapper, .sn-content-header {
            /* font-family: sans-serif; */
        }

        .sn-content-header {
            padding: 0 !important;
        }

        .sn-update-product, .sn-user-list {
            /* padding: 0 17px; */
            font-size: 14px;
        }

        .sn-update-product thead tr:first-child {
            padding-top: 10px;
        }

        .sn-update-product thead {
            color: #170724;
        }

        .sn-update-product tbody tr:last-child {
            padding-bottom: 12px;
        }

        .sn-user-list ul li {
            border: 0;
            border-radius: 0 !important;
            position: relative;
        }

        .sn-user-list i {
            position: absolute;
            right: 20px;
            top: 40%;
            color: #878787;
        }

        .sn-user-list ul li:first-child {
            padding-top: 18px;
        }

        .sn-user-list ul li:last-child {
            padding-bottom: 18px;
        }

        .sn-purpose, .sn-shop-profile, .sn-shop-general-info {
            padding: auto 0 !important;
        }

        .sn-purpose h2 {
            font-size: 18px;
            font-weight: 700;
            margin-left: 17px;
        }

        .sn-update-product h2, .sn-user-list h2 {
            font-size: 25px;
            font-weight: 700;
        }

        .sn-shop-general-info div div p:first-child {
            color: #273AB5;
            font-weight: 500;
        }

        .sn-purpose p, .sn-user-list p {
            margin: 0 !important;
            font-size: 14px;
            font-weight: 600;
            color: #000;
        }

        .sn-user-list p {
            font-weight: normal;
        }

        .sn-purpose i {
            color: #4E73F8;
            margin-bottom: 12px;
            font-size: 1.4rem;
        }

        .sn-purpose .fa-bullhorn {
            transform: rotateZ(-20deg);
        }

        /* .sn-purpose .sn-purpose-grid {
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          margin: 0 10px;
        } */
        .sn-purpose a {
            background-color: #fff;
            border-radius: 3px;
            margin: 8px;
            padding: 16px 10px;
            cursor: pointer;
        }

        .sn-cover-img img {
            height: 180px;
            width: 100%;
            object-fit: cover;
        }

        .sn-profile-img {
            position: relative;
        }

        .sn-profile-img .sn-img-wrap {
            /* position: absolute; */
            /* top: -45px; */
            /* left: 0; */
            /* right: 0; */
            margin: auto;
        }

        .sn-shop-general-info {
            /* padding-top: 90px; */
            padding-top: 30px;
            line-height: 0.7rem;
        }

        .sn-shop-info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .sn-shop-profile img {
            height: 100px;
            width: 100px;
            object-fit: cover;
        }

        /* For Desktop */
        @media only screen and (min-width: 768px) {

            .sn-profile-img .sn-img-wrap {
                position: relative;
                top: 0;
            }

            .sn-profile-img {
                margin-bottom: 10px;
            }

            /* .content-wrapper {
              background: #F0F7FA !important;
            } */
            /* .sn-shop-profile {
              background: #fff;
              border-radius: 3px;
              margin: 40px 0 35px 40px;
              padding: 15px 15px 5px;
              box-shadow: 0px 0px 4px 1px #efefef;
              grid-column: 1;
              grid-row: 1;
            } */
            /* .sn-user-list{
              margin-right: 23px;
              grid-column: 3/5;
              margin-left: 3px;
            } */
            .sn-shop-profile img {
                height: 80px;
                width: 80px;
                object-fit: cover;
            }

            .sn-shop-general-info {
                padding-top: 20px;
            }

            /* .sn-shop-general-info p:first-child {
              float: right;
            }
            .sn-shop-general-info p:last-child {
              float: left;
            } */
            /* .sn-purpose {
              margin: auto 20px auto 15px;
              grid-column: 2/5;
              grid-row: 1;
            } */
            /* .sn-purpose a {
              margin: 15px 25px;
              box-shadow: 0px 0px 4px 1px #efefef;
            } */
            /* .sn-update-product table, .sn-user-list ul {
              box-shadow: 0px 0px 4px 1px #efefef;
            } */
            /* .sn-update-product {
              margin-left: 23px;
              grid-column: 1/3;
              grid-row: 2;
              margin-right: 3px;
            } */
            .sn-img-wrap h3 {
                margin-bottom: 0 !important;
            }

            .sn-user-list ul li:first-child {
                padding-top: 16px;
            }

            .sn-user-list ul li:last-child {
                padding-bottom: 15px;
            }

            .sn-user-list ul li {
                padding: 0.57rem 1.25rem;
            }

            /* .sn-shop-info-grid {
              grid-template-columns: none;
            } */
        }

        /* Swe Item Create */

        .sn-percent {
            border: 1px solid #e9e9e9;
            border-radius: 5px;
            background: #e9e9e9;
        }

        .sn-item-create-wrapper {
            /* font-family: sans-serif; */
            font-family: 'Myanmar3', Sans-Serif !important;
            padding: 0 15px 40px;
        }

        .sn-item-create-wrapper fieldset {
            border: 1px solid #E1E3E6;
            border-radius: 8px;
            height: 50px;
        }

        .sn-item-create-wrapper .sop-texarea {
            border: 1px solid #E1E3E6;
            border-radius: 8px;
            height: auto;
        }

        .sn-item-create-wrapper legend {
            margin-bottom: 0px;
            margin-left: 18px;
            font-size: 13px;
            padding: 0 5px;
            color: rgba(64, 77, 97, 0.55);
            width: auto !important;
            font-weight: 700;
        }

        .sn-item-create-wrapper fieldset input,
        .sn-item-create-wrapper fieldset .select2-container--default .select2-selection--single,
        .sn-item-create-wrapper fieldset .multiselect__input,
        .sn-item-create-wrapper fieldset select,
            /* .sn-item-create-wrapper fieldset textarea, */
        .sn-item-create-wrapper fieldset .h-auto,
        .sn-item-create-wrapper fieldset #customdropzone {
            width: 100%;
            border: 0;
            border-radius: 8px;
            margin-top: -9px;
            padding: 4px 20px 3px 23px;
            height: 38px;
            font-size: 14px;
        }

        .sn-item-create-wrapper fieldset textarea {
            width: 100%;
            border: 0;
            border-radius: 8px;
            padding: 4px 20px 3px 23px;
            height: 100px;
            font-size: 14px;
        }

        .sn-item-create-wrapper fieldset select {
            padding-left: 19px;
        }

        .sn-item-create-wrapper .multiselect__tags {
            padding: 8px 40px 0 0px !important;
        }

        .sn-item-create-wrapper #customdropzone {
            border: 1px solid #ebebeb;
        }

        .sn-item-create-wrapper h3 {
            padding-top: 2rem;
            margin-bottom: 8px;
            font-size: 1.3rem;
            font-weight: 700;
            color: #404D61;
        }

        .sn-item-create-wrapper .create-user-text {
            font-family: 'Myanmar3' !important;
            font-size: 13px;
            color: #757D8A;
        }

        .sn-item-create-wrapper .sn-pin-noti {
            font-family: 'Myanmar3' !important;
            background: #F7EFDC;
            color: #F9D066;
            font-size: 12px;
            line-height: 1.2rem;
            padding: 8px 0;
            margin-top: 13px;
            border-radius: 8px;
            display: flex;
            align-items: baseline;
            justify-content: center;
        }

        .sn-pin-noti p {
            margin-left: 5px;
            margin-bottom: 0;
        }

        .sn-item-create-wrapper .form-group {
            margin: 15px 0;
            position: relative;
        }

        .sn-item-create-wrapper #customdropzone i {
            color: #b9b9b9;
        }
        .sn-item-create-button {
          float: left !important;
        }

        .sn-item-create-wrapper .sn-item-create-button {
            background: #4E73F8;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            padding: 7px 15px 5px;
        }

        .sn-required-asterick {
            color: red;
            margin-left: 5px;
        }

        .sn-shop-header {
            font-size: 20px !important;
            position: absolute;
            top: -57px;
            z-index: 9999;
            left: 44px;
            /* font-family: sans-serif; */
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .sn-form-button {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
        }

        .sn-form-button a {
            margin-top: 25px;
            border: 1px solid #c4c4c4;
            padding: 7px 15px 5px;
            border-radius: 5px;
            color: #525252;
        }

        .sop-font, .sn-product-title {
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .multiselect__input {
            border: 0 !important;
            padding: 0 15px !important;
        }
        .linkified {
            text-decoration: underline !important;
            color: #2196f3 !important;
        }

        /* Swe User List Table */

        /* Swe Loading Wrapper */

        #ct-loadding {
            background-color: rgb(255 255 255 / 50%) !important;
        }

        /* For Desktop */
        @media only screen and (min-width: 768px) {

            /* Swe Item Create */
            .sn-item-create-wrapper {
                padding: 40px 24px 40px;
                background: #fff;
                border-radius: 5px;
                margin: 0 30px;
            }

            .sn-item-container {
                padding-bottom: 40px;
            }

            .sn-item-create-wrapper h3 {
                font-size: 1.5rem;
            }

            .sn-item-create-wrapper .create-user-text {
                font-size: 16px;
                margin-bottom: 20px;
            }

            .sn-item-create-wrapper .sn-pin-noti {
                font-size: 14px;
            }

            .sn-item-create-wrapper fieldset {
                height: 55px;
            }

            .sn-item-create-wrapper .sop-texarea {
                height: auto !important;
            }

            .sn-item-create-wrapper legend {
                font-size: 14px;
            }

            .sn-item-create-wrapper fieldset input,
            .sn-item-create-wrapper fieldset .select2-container--default .select2-selection--single,
            .sn-item-create-wrapper fieldset .multiselect__input,
            .sn-item-create-wrapper fieldset select,
                /* .sn-item-create-wrapper fieldset textarea, */
            .sn-item-create-wrapper fieldset .h-auto,
            .sn-item-create-wrapper fieldset #customdropzone {
                font-size: 15px;
                height: 40px;
            }

            .sn-item-create-wrapper fieldset textarea,
            {
                font-size: 15px;
                height: 100px;
            }

            /* Swe User List Table */
        }

        fieldset .sop-form-control {
            background-color: transparent !important;
        }

        @media (max-width: 576px) {
            .zh-header_shop {
                margin-left: 0% !important;
            }
            .yk-info .yk-tootips{
                border: 2px solid #680606;
                background: #730d18;
                color: white;
                padding: 10px;
                width: 314px;
                position: absolute;
                left: 14px;
                z-index: 2222;
                visibility: hidden;
                font-family: 'Myanmar3', Sans-Serif !important;
                line-height: 1.5;


            }
        }

    </style>
    @stack('css')
</head>
<body onbeforeunload="useroffline()" class="hold-transition sidebar-mini">
{{--get current shop data for chat--}}
@php
    use App\Shopowner;
    use App\Manager;
if($is_chat_on){

       if(isset(Auth::guard('shop_owner')->user()->id)){
          $current_shop=Shopowner::where('id',Auth::guard('shop_owner')->user()->id)->first();
       }else{
           $manager= Manager::where('id', Auth::guard('shop_role')->user()->id)->pluck('shop_id');
           $current_shop=Shopowner::where('id',$manager)->first();
       }

      if(isset(Auth::guard('shop_owner')->user()->id)) {
        $shop_role = Auth::guard('shop_owner')->user()->name . ' (Owner)';
      } else if(Auth::guard('shop_role')->user()->role_id == 1) {
        $shop_role = Auth::guard('shop_role')->user()->name . ' (Admin)';
      } else if(Auth::guard('shop_role')->user()->role_id == 2) {
        $shop_role = Auth::guard('shop_role')->user()->name . ' (Manager)';
      } else if(Auth::guard('shop_role')->user()->role_id == 3) {
        $shop_role = Auth::guard('shop_role')->user()->name . ' (Staff)';
      }
  }

@endphp
{{--get current shop data for chat--}}

<div id="backend">
    @if($is_chat_on='on')
        <shopownerchatwrapper
            ref="chatwrapper"
            v-on:getfromid="getfromidparent"
            v-bind:shopid="{{$current_shop->id}}"
        ></shopownerchatwrapper>
        <shopownerchattemplate ref="chatref" v-on:openmain="toopenmainchatwrapper"
                               v-bind:chatdatafromparent="this.chatdata"
                               v-bind:shopdatafromparent="{{$current_shop}}"
                               v-bind:shop_role="'{{ $shop_role }}'"
        ></shopownerchattemplate>
    @endif
    @yield('content')
</div>



<script type='text/javascript' src="{{url('js/backend.js')}}"></script>

<script src="{{url('plugins/jquery/jquery.min.js')}}"></script>

<!-- ./wrapper -->

<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Select2 -->
<script src="{{url('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{url('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<!-- InputMask -->
<script src="{{url('plugins/moment/moment.min.js')}}"></script>
<script src="{{url('plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{url('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{url('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<!-- BS-Stepper -->
<script src="{{url('plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
<!-- dropzonejs -->
<!-- AdminLTE App -->
<script src="{{url('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('dist/js/demo.js')}}"></script>
<!-- Page specific script -->
<!-- Summernote -->
<script src="{{ url('plugins/summernote/summernote-bs4.min.js')}}"></script>

<script src="{{url('plugins/sweetalert2/sweetalert2.all.js')}}"></script>
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
<script src="{{url('test/js/fancybox.js')}}"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

{{--//for zoom--}}

<script type="text/javascript">
    function useroffline() {
        if (typeof Window.userid != undefined) {
            return Window.allfrommsg.sendwhatuserisoffline(window.userid);

        }
    }

    // Initialise Carousel
    const mainCarousel = new Carousel(document.querySelector("#mainCarousel"), {
        Dots: false,
    });

    // $('.carousel').carousel();

    // Thumbnails
    const thumbCarousel = new Carousel(document.querySelector("#thumbCarousel"), {
        Sync: {
            target: mainCarousel,
            friction: 0,
        },
        Dots: false,
        Navigation: false,
        center: true,
        slidesPerPage: 1,
        infinite: false,
    });

    // Customize Fancybox
    Fancybox.bind('[data-fancybox="gallery"]', {
        Carousel: {
            on: {
                change: (that) => {
                    mainCarousel.slideTo(mainCarousel.findPageForSlide(that.page), {
                        friction: 0,
                    });
                },
            },
        },
    });

    (function ($) {
        "use strict";
        $('.header-dropdown-element').each(function () {
            $(this).find('.header-icon i').on('click', function () {
                $(this).closest('.header-dropdown-element').find('.content-dropdown').slideToggle();
            });
        });
    });

    //zomm to hide text
    setTimeout(function () {
        $('.yk-photozoom-text').addClass('d-none');
    }, 2000);

    $(document).ready(function () {
        $(".zh-up").hide();
        $(".sn-wrapper").hide();

        // zh-detail dropdown arrow
        $("#zh-detail_up").click(function () {
            $(".zh-up").hide();
            $(".zh-down").show();
            $(".sn-wrapper").hide();
        });

        $("#zh-detail_down").click(function () {
            $(".zh-up").show();
            $(".zh-down").hide();
            $(".sn-wrapper").show();
        });
    })

</script>
{{--//for zoom--}}

@stack('scripts')

</body>
</html>