@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    {{--MENU--}}
    @include('layouts.frontend.allpart.upper_menu')
    <header id="masthead" class="site-header ">

    <div class="ftc-header-template header-ftc-element">
        <div class="header-mobile" style="height:62px !important;">
            <div class="mobile-button">
                <div class="mobile-nav">
                    <span aria-hidden="true" class="fa fa-bars"></span>
                </div>
            </div>

            <div class="logo-wrapper is-mobile">
                <div class="logo" style="font-family: sans-serif">
                    <a href="/"><h3>Shwe Shops</h3></a>

                </div>

            </div>

            <div class="pe-3 dropdown sop-drop d-none">
                {{-- ဘာသာစကား<i class="fa-solid fa-angle-down ps-1"></i> --}}
                <ul>
                    <li class="nav-item dropdown" style="list-style-type:none;margin-right: 0px;">
                        <a href="#language-change" class="nav-link" data-toggle="dropdown">
                            ဘာသာစကား<i class="fa-solid fa-angle-down ps-1"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a href="" class="dropdown-item">မြန်မာ</a>
                            <a href="" class="dropdown-item">English</a>
                        </div>
                    </li>
                </ul>
            </div>
            @if(isset(Auth::guard('web')->user()->id)|| isset(Auth::guard('shop_owner')->user()->id) || isset(Auth::guard('shop_role')->user()->id))
                <div class="ftc-shop-cart">

                    <div class="ftc-tini-cart">
                        <div class="cart-item">
                            <a href="" data-toggle="modal" data-target="#notiModal">
                                <i class="fa-solid fa-bell fa-xl" style="color:#780116"></i>
                            </a>

                        </div>
                    </div>
                </div>

            @endif
        </div>

        

    </div>

</header><!-- #masthead -->
    <div class="container-fluid">
        <div class="text text-center">
            <img src="{{ url('test/img/maintain.png')}}" alt="" data-aos="zoom-in-up" class="mx-auto d-block" style="width: 8.5rem; height: auto;">
            <div class="h2">
                <h2>Shwe Shop Website</h2>
                <h2>သည်ပြုပြင်နေဆဲကာလဖြစ်ပါသည်</h2>
            </div>
            <div class="p">
                <p>အခက်အခဲများရှိသွားပါက အနူးညွှတ်တောင်းပန်အပ်ပါသည် ။ မကြာမီအချိန်အတွင်း</p>
                <p>ပြန်လည်ရောက်ရှိလာပါမည်။ ခေတ္တစောင့်ဆိုင်းပေးပါ။</p>
            </div>
            <div class="mobile-p">
                <p>အခက်အခဲများရှိသွားပါက အနူးညွှတ်တောင်းပန်အပ်ပါသည် ။ </p>
                <p>မကြာမီအချိန်အတွင်း ပြန်လည်ရောက်ရှိလာပါမည်။ </p>
                <p>ခေတ္တစောင့်ဆိုင်းပေးပါ။</p>
            </div>
          
        </div>
    </div>
    <div class="footer-mobile">
    <div class="mobile-home">
        <a href="{{url('/')}}">
            <i class="zh-icon fa fa-home" style="color:#780116 !important;"></i>
            Home </a>
    </div>
    <div class="mobile-home">
        <a href="{{url('see_by_categories')}}">

            <i class="zh-icon fa-solid fa-magnifying-glass" style="color:#780116 !important;"></i>
            Search</a>
    </div>
    <div
        class="sop-mobile-nav ">
        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
        <a>
            <i
                id="mobile-a2c-icon"
                class="fa-solid fa-basket-shopping"
                style="margin-top: 3px; color: #fff"
            ></i>
       </a>
    </div>
    </div>

    
    
        <div class="mobile-home">
        <a href="{{url('/myfav')}}">
            <div class="position-relative">
                <i class="fa-regular fa-heart" style="color:#780116 !important;" id="mobileFootHeart"></i>
                {{-- <span id="favm-a2c-count" class="position-absolute" style="top:0;right:5px;color:#780116 !important;">0</span> --}}
            </div>
            
            Favourite </a>
            
    </div>
    
    @if(isset(Auth::guard('web')->user()->id))
    <form type="hidden" id="fav-server"  method="POST" style="display: none;">
        @csrf
    </form>
    <form type="hidden" id="selection-server"  method="POST" style="display: none;">
        @csrf
    </form>
        <div class="mobile-account">
            <a href="{{route('backside.user.user_profile')}}">
                <!--<i class="zh-icon fa-solid fa-arrow-right-from-bracket" style="color:#780116 !important;"></i>-->
                <!--Logout-->
                 <i class="zh-icon fa-solid fa-user-gear a-arrow-right-from-bracket" style="color:#780116 !important;"></i>
                 Profile
            </a>
        </div>

    @elseif(isset(Auth::guard('shop_owner')->user()->id))
        <div class="mobile-account">
            <a href="{{url('backside/shop_owner/detail')}}">
                <i class="zh-icon fa-solid fa-user-gear" style="color:#780116 !important;"></i>
                Shop Owner
            </a>
        </div>

    @elseif(isset(Auth::guard('shop_role')->user()->id))
        <div class="mobile-account">
            <a href="{{url('backside/shop_owner/detail')}}" title="Logout">
                <i class="zh-icon fa-solid fa-user-gear" style="color:#780116 !important;"></i>
                Shop
            </a>
        </div>
    @else
    <div class="mobile-account">

            <a href="" class="checkForm" title="checkForm" data-toggle="modal" data-target="#orangeModalSubscription">
                <i class="zh-icon fa fa-user" style="color:#780116 !important;"></i>
                Login</a>
                
        </div>
    @endif


</div>



    @push('css')
    <style>
        body{
            background-color: #FFF7F6 !important;
            /* opacity: 80%; */
        }

        .text h2{
            color: #780116!important;
        }

        .text{
            margin-top: 5%;
            color: #780116!important;
        }

        .h2{
            margin-top: 1.5% !important;
        }

        .text p{
            margin-bottom: 0.3rem !important;
        }
        .p{
            margin-top: 1.5% !important;
        }

        .mobile-p{
            display: none;
        }

        @media only screen and (max-width: 991px) {
            .p{
                display: none;
            }

            .mobile-p{
                display: block;
            }
        }
        @media only screen and (min-width: 992px) {

            .mobile-p{
                display: none;
            }
        }
        @media only screen and (max-width: 420px) {

            .mobile-p{
                font-size: 16px;
            }
            
        }
        @media only screen and (max-width: 402px) {

            .mobile-p{
                font-size: 15px;
            }
            
        }
        @media only screen and (max-width: 378px) {

            .mobile-p{
                font-size: 14px;
            }
            
        }
        @media only screen and (max-width: 354px) {

            .mobile-p{
                font-size: 13px;
            }
            
        }
        @media only screen and (max-width: 350px) {

            .text .h2 h2{
                font-size: 1.5rem !important;
            }
            
        }
        @media only screen and (max-width: 345px) {

            .text .h2 h2{
                font-size: 1.4rem !important;
            }
            
        }
        @media only screen and (max-width: 323px) {

            .text .h2 h2{
                font-size: 1.3rem !important;
            }
            
        }
        @media only screen and (max-width: 331px) {

            .mobile-p{
                font-size: 12px;
            }
            
        }
        @media only screen and (max-width: 307px) {

            .mobile-p{
                font-size: 11px;
            }
            
        }
        @media only screen and (max-width: 302px) {

            .text .h2 h2{
                font-size: 1.2rem !important;
            }
            
        }
        @media only screen and (max-width: 284px) {

            .mobile-p{
                font-size: 10px;
            }

            
        }
        @media only screen and (max-width: 281px) {

            .text .h2 h2{
                font-size: 1.1rem !important;
            }

            
        }
    </style>
    @endpush