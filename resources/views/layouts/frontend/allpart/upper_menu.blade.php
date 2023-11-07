<div class="sop-upper-s d-none px-lg-5">
    <div class="sop-upper-nav-text text1">
        {{-- Get <span class="sop-upper-nav-text-y">Daily Rewards</span> by logging daily to <span class="sop-upper-nav-text-y">Shwe Shops!</span> --}}
        မြန်မာတစ်နိုင်ငံလုံးရှိ <span class="sop-upper-nav-text-y">စိန်ရွှေရတနာဆိုင်များကို</span> တစ်နေရာတည်းတွင်
        ဝင်ရောက်ကြည့်ရှုကာ ယုံကြည်စိတ်ချစွာဝယ်ယူနိုင်မယ့် <span class="sop-upper-nav-text-y">Shwe Shops<span>
    </div>
    <div class="sop-upper-nav-text text2">
        Hot line : <span class="sop-upper-nav-text-y">09880904177, 09750139909</span>
    </div>
    <div class="sop-upper-nav-text text3">
        {{-- Discount up to <span class="sop-upper-nav-text-y">20%</span>! --}}
        Email : <span class="sop-upper-nav-text-y">admin@shweshops.com</span>
    </div>
</div>

@php
    $gold_price = App\Models\GoldPrice::first();
@endphp

<div class="sn-marquee">
    <div class="sn-marquee-item-container">
        <span class="sn-marquee-item">
            <span class="sell-price"><img
                    src="{{ asset('images/icons/Gold-Price.png') }}" />ရောင်းစျေး({{ isset($gold_price->sell_price) ? $gold_price->sell_price : '' }})</span>
            <span class="buy-price"><img
                    src="{{ asset('images/icons/Gold-Price.png') }}" />ဝယ်စျေး({{ isset($gold_price->buy_price) ? $gold_price->buy_price : '' }})</span>
        </span>
    </div>
</div>
<div class="sop-upper d-none d-lg-block px-lg-5">
    <div class="h-100 d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-between align-items-center col-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="pe-3 dropdown sop-drop d-none">
                    {{-- ဘာသာစကား<i class="fa-solid fa-angle-down ps-1"></i> --}}
                    <ul>
                        <li class="nav-item dropdown" style="list-style-type:none;margin-right: 0px;">
                            <a href="#language-change-w" class="nav-link" data-toggle="dropdown"
                                style="font-weight: 600">
                                <i class="fas fa-globe pe-2" style="color: #F7B538!important;"></i> ဘာသာစကား<i
                                    class="fa-solid fa-angle-down ps-1"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="" class="dropdown-item">မြန်မာ</a>
                                <a href="" class="dropdown-item">English</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="pe-3">
                    <a href="https://www.facebook.com/shweshops123"><i class="fab fa-facebook-f social-w-f"></i></a>
                </div>
                <div class="pe-3 d-none">
                    <i class="fab fa-twitter social-w-t"></i>
                </div>
                <div class="pe-3 d-none">
                    <i class="fab fa-instagram social-w-i"></i>
                </div>
            </div>
        </div>
        <div class="shoplogo-w col-4 d-flex flex-row justify-content-center align-items-center ">
            <a href="/" class="d-flex flex-row justify-content-center align-items-end">
                <img src="{{ url('test/img/logo-m.png') }}" class="" alt="">
                <div class="d-flex flex-row justify-content-start align-items-end">
                    <p class="logo-text">SHWE SHOPS</p>
                </div>
                {{-- <img src="{{url('test/img/logo.png')}}" class="d-xl-block d-none" alt=""> --}}
                {{-- <img src="{{url('test/img/logo-m.png')}}" class="d-lg-block d-xl-none" alt=""> --}}
            </a>

        </div>

        <div class="d-flex justify-content-end align-items-center col-4">

            @if (isset(Auth::guard('web')->user()->id))
                <form type="hidden" id="fav-server" method="POST" style="display: none;">
                    @csrf
                </form>
                <form type="hidden" id="selection-server" method="POST" style="display: none;">
                    @csrf
                </form>
                <div class="sop-upper-nav-text-l px-3">
                    <a href="" data-toggle="modal" data-target="#notiModal">
                        <i class="far fa-bell fa-lg" style="color:#F7B538 !important;" id="mobileFootNoti"></i>
                    </a>
                </div>
                <div class="dropdown">
                    <div class="dropbtn menu-profile rounded-circle sop-upper-nav-text-l">
                        @if (Auth::guard('web')->user()->photo == null)
                            <img src="{{ asset('images/user-profile/default-profile.png') }}" class="w-100">
                        @else
                            <img src="{{ asset(Auth::guard('web')->user()->photo) }}" class="w-100">
                        @endif
                    </div>
                    <div class="dropdown-content rounded">
                        <a class="text-color" href="{{ route('backside.user.user_profile') }}">Profile</a>
                        <form method="POST" action="{{ route('backside.user.logout') }}" id="logout">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center text-white">
                                <i class="bi bi-box-arrow-right"></i><span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
                {{-- <div class="sop-upper-nav-text-l menu-profile rounded-circle ml-2">
                        <a href="{{route('backside.user.user_profile')}}">
                           @if (Auth::guard('web')->user()->photo == null)
                            <img src="{{ asset('images/user-profile/default-profile.png')}}" class="w-100">
                          @else
                            <img src="{{ asset( Auth::guard('web')->user()->photo)}}" class="w-100">
                          @endif
                        </a>
                    </div> --}}
            @elseif(isset(Auth::guard('shop_owners_and_staffs')->user()->id))
                <div class="sop-upper-nav-text-l px-3">
                    <a href="" data-toggle="modal" data-target="#notiModal">
                        <i class="far fa-bell  fa-lg" style="color:#F7B538 !important;" id="mobileFootNoti"></i>
                    </a>
                </div>
                <div class="sop-upper-nav-text-l px-3">
                    <a href="{{ url('backside/shop_owner/detail') }}">
                        <i class="zh-icon fa-solid fa-user-gear  fa-lg" style="color:#F7B538 !important;"></i>

                    </a>
                </div>
            @elseif(isset(Auth::guard('super_admin')->user()->id))
                <div class="sop-upper-nav-text-l px-3">
                    <a href="" data-toggle="modal" data-target="#notiModal">
                        <i class="far fa-bell  fa-lg" style="color:#F7B538 !important;" id="mobileFootNoti"></i>
                    </a>
                </div>
                <div class="sop-upper-nav-text-l px-3">
                    <a href="{{ url('backside/super_admin') }}">
                        <i class="zh-icon fa-solid fa-user-gear  fa-lg" style="color:#F7B538 !important;"></i>

                    </a>
                </div>
            @elseif(isset(Auth::guard('shop_owners_and_staffs')->user()->id))
                <div class="sop-upper-nav-text-l px-3">
                    <a href="" data-toggle="modal" data-target="#notiModal">
                        <i class="far fa-bell  fa-lg" style="color:#F7B538 !important;" id="mobileFootNoti"></i>
                    </a>
                </div>
                <div class="sop-upper-nav-text-l px-3">
                    <a href="{{ url('backside/shop_owner/detail') }}" title="Logout">
                        <i class="zh-icon fa-solid fa-user-gear  fa-lg" style="color:#F7B538 !important;"></i>

                    </a>
                </div>
            @else
                <!-- <div class="sop-upper-nav-text-l px-2">
                        <a href="" class='reg' title="Login" data-toggle="modal" data-target="#orangeModalSubscription">
                            Login</a>
                </div>  -->
                <div class="sop-upper-nav-text-l px-2">
                    <a href="" title="checkForm" data-toggle="modal" data-target="#orangeModalSubscription"
                        class="checkForm">Login</a>
                </div>
            @endif

            @php
                use App\Models\AppFile;
                $appFile = AppFile::where('user_type', 'Regular User')
                    ->where('operating_system', 'Android')
                    ->first();
            @endphp

            @if ($appFile)
                <div class="text-center mx-3">
                    <a href="" class="btn btn-primary rounded-pill" data-toggle="modal"
                        data-target="#appDownloadModal" style="background-color:#F7B538">Download now</a>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="appDownloadModal" tabindex="-1" aria-labelledby="appDownloadModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-center  border-0">
                                <h5 class="modal-title text-color" id="appDownloadModalLabel">
                                    DOWNLOAD SHWESHOPS
                                </h5>
                            </div>
                            <div class="modal-body text-center  border-0">
                                <p class="text-dark">Are you sure you want to download?</p>
                            </div>
                            <div class="modal-footer justify-content-center  border-0">
                                <button type="button" class="btn btn-outline-danger px-4"
                                    data-dismiss="modal">No</button>
                                <a href="{{ route('front.app-files.download', $appFile) }}"
                                    class="btn btn-success px-4">Yes</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('css')
    <style>
        .sn-marquee {
            height: 30px;
            background-image: linear-gradient(to right, rgb(166 124 0 / 82%), rgb(166 124 0 / 82%), #392800);
            color: white !important;
            width: 100%;
            overflow: hidden;
            position: relative;
            text-align: right;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sn-marquee img {
            height: 22px;
            width: auto;
            margin-right: 7px;
        }

        .sn-marquee .sell-price {
            margin-right: 2rem;
        }

        .sn-marquee .sn-marquee-item-container {
            display: block;
            width: 100%;
            height: 25px;

            position: absolute;
            overflow: hidden;

            animation: sn-marquee 20s linear infinite;
        }

        @media only screen and (min-width: 768px) {
            .sn-marquee .sn-marquee-item-container {
                animation: sn-marquee-lg 20s linear infinite;
            }
        }

        .sn-marquee .sn-marquee-item {
            float: left;
            height: 25px;
            width: 100%;
        }

        @keyframes sn-marquee {
            0% {
                left: 100%;
            }

            100% {
                left: -100%;
            }
        }

        @keyframes sn-marquee-lg {
            0% {
                left: 30%;
            }

            100% {
                left: -100%;
            }
        }

        .text-color {
            color: rgb(120, 1, 22) !important;
        }

        .dropdown {
            position: relative;
            display: inline-block;
            color: rgb(120, 1, 22) !important;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 32px;
            left: -96px;
            background-color: #6c757d;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            color: rgb(120, 1, 22) !important;
        }

        .dropdown-content a {
            color: rgb(120, 1, 22) !important;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
            color: rgb(120, 1, 22) !important;

        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /*.dropdown:hover .dropbtn {background-color: #3e8e41;}*/
    </style>
    <style>
        .menu-profile {
            width: 30px;
            height: 30px;
            overflow: hidden;
            /*margin-top: -8px;*/
        }

        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');

        /* @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap'); */
        .logo-text {
            font-family: 'Cinzel', serif;
            margin: auto;
            padding: 0 10px;
            font-size: 2rem;
            color: #F7B538;
            text-transform: capitalize;
            margin: 0;
        }

        @media only screen and (min-width: 991px) {
            .logo-text {
                font-size: 1.5rem;
                line-height: 1.5rem;
            }
        }

        @media only screen and (min-width: 1200px) {
            .logo-text {
                font-size: 2rem;
                line-height: 2rem;
            }
        }

        .sop-upper {
            height: 65px;
            background-color: #1B1A17;
            color: white !important;
        }

        .shoplogo-w img {
            height: 40px;
            cursor: pointer;
        }

        .social-w-f {
            background-color: #F7B538 !important;
            padding: 7.2px 10px;
            color: #1B1A17;
            border-radius: 50%;
            cursor: pointer;
        }

        .social-w-i {
            background-color: #F7B538 !important;
            padding: 7.2px 8px;
            color: #1B1A17;
            border-radius: 50%;
            cursor: pointer;
        }

        .social-w-t {
            background-color: #F7B538 !important;
            padding: 7.2px 7.2px;
            color: #1B1A17;
            border-radius: 50%;
            cursor: pointer;
        }

        .sop-upper a {
            color: white !important;
        }

        .dropdown-menu a {
            color: #666 !important;
        }

        .sop-upper-nav-text-y {
            color: #F7B538 !important;
        }

        .sop-upper-nav-text {
            font-size: 0.8em;

            /* font-family: sans-serif!important; */
            font-weight: 600;
        }

        .sop-upper-nav-text-l {
            font-size: 1.1em;

            /* font-family: sans-serif!important; */
            cursor: pointer;
        }

        .sop-upper-s {
            height: 25px;
            background-color: #000000;
            color: white !important;
            width: 100%;
            overflow: hidden;
            position: relative;
            text-align: right;
        }

        .sop-upper-s .sop-upper-nav-text {
            width: 100%;
            flex-shrink: 0;
            align-items: center;
            position: absolute;
            display: block;
            top: 0;
        }

        .text1 {
            animation: slide 30s linear infinite;
        }

        .text2 {
            animation: slide-2 30s linear infinite;
        }

        .text3 {
            animation: slide-3 30s linear infinite;
        }

        @keyframes slide-3 {

            0%,
            66.66% {
                right: -100%;
                opacity: 0;
            }

            74.96%,
            91.62% {
                right: 4rem;
                opacity: 1;
            }

            100% {
                right: 110%;
                opacity: 0;
            }
        }

        @keyframes slide-2 {

            0%,
            33.33% {
                right: -100%;
                opacity: 0;
            }

            41.63%,
            58.29% {
                right: 4rem;
                opacity: 1;
            }

            66.66%,
            100% {
                right: 110%;
                opacity: 0;
            }
        }

        @keyframes slide {

            0%,
            8.3% {
                right: -100%;
                opacity: 0;
            }

            8.3%,
            25% {
                right: 4rem;
                opacity: 1;
            }

            33.33%,
            100% {
                right: 110%;
                opacity: 0;
            }
        }
    </style>
@endpush
