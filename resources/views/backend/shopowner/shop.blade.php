@extends('layouts.backend.backend')

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.backend.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sop">
            @if (Session::has('message'))
                <x-alert>
                </x-alert>
            @endif
            <!-- Content Header (Page header) -->
            <section class="content-header sn-content-header">
                <div class="container-fluid">
                    @foreach ($shopowner as $shopowner)
                    @endforeach
                    <div class="sn-admin-header d-sm-none">

                    </div>

                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->


            <section class="content ">
                <div class="container-fluid">
                    <div class="">
                        <div class="">
                            <!-- Profile Image -->

                            <div class="">
                                @if ($shopowner->premium == 'yes')
                                    @if (!empty($shopowner->shop_banner))
                                        <!-- Swiper -->
                                        <div class="swiper mySwiper">
                                            <div class="swiper-wrapper">
                                                @foreach ($shopowner->getPhotos as $p)
                                                    <div class="swiper-sliendforeachde">
                                                        <img src="{{ filedopath('/shop_owner/banner/' . $p->location) }}"
                                                            alt="">
                                                    </div>
                                                @endforeach

                                            </div>
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    @else
                                        <?php
                                        if ($banner) {
                                            $getbanner = $banner->location;
                                        } else {
                                            $getbanner = 'default.jpg';
                                        }
                                        ?>
                                        <img class="img-fluid" src="{{ filedopath('/shop_owner/banner/' . $getbanner) }}"
                                            alt="Photo">
                                    @endif
                                @endif
                            </div>
                            <div class="profile-content">
                                <div class=" profile position-relative mb-4">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ filedopath('/shop_owner/logo/' . $shopowner->shop_logo) }}"
                                        alt="User profile picture">
                                    <div class="shop_name">
                                        <h3>
                                            {{ $shopowner->shop_name }} <br>
                                            @isset($shopowner->shop_name_myan)
                                                <span class="mm-font">( {{ $shopowner->shop_name_myan }} )</span>
                                            @endisset
                                        </h3>
                                    </div>

                                </div>
                                <div class="px-4 px-md-5 pt-4">
                                    @isset($shopowner->description)
                                        <p class="mm-font pt-3 col-lg-8"
                                            style="padding-bottom:16px;font-size: 1rem; color:#737373">
                                            {!! $shopowner->description !!}
                                        </p>
                                    @endisset
                                </div>
                                <div class="px-4 px-md-5 pb-4">
                                    <h3>Shop Informations</h3>
                                    <div class="row px-1">
                                        <div class="col-12 col-lg-6">
                                            <div class="d-flex col-md-8 col-lg-8 py-3 px-0">
                                                <div class="col-6 px-0"><a href="{{ $shopowner->page_link }}">Facebook
                                                        Page Link</a></div>
                                                <div class="col-6 px-0"><a href="{{ $shopowner->messenger_link }}">Messenger
                                                        Link</a></div>
                                            </div>
                                            <p>Main Phone : {{ $shopowner->main_phone }}</p>
                                            <p class="mm-font">Address : {!! $shopowner->address !!}</p>
                                        </div>
                                        <div class="col-12 pl-lg-5 col-lg-6">
                                            <p><span class="mm-font">အထည်မပျက် ပြန်သွင်း
                                                    :</span>{{ $shopowner->undamaged_product }}
                                                <span style="font-size: 0.85rem">%</span>
                                            </p>
                                            <p><span class="mm-font">တန်ဖိုးမြင့်အထည် နှင့် အထည်မပျက်ပြန်လဲ :
                                                </span>{{ $shopowner->valuable_product }}
                                                <span style="font-size: 0.85rem">%</span>
                                            </p>
                                            <p><span class="mm-font">အထည်ပျက်စီး ချို့ယွင်း :
                                                </span>{{ $shopowner->damaged_product }}
                                                <span style="font-size: 0.85rem">%</span>
                                            </p>
                                            @if ($siteSettingAction === 'on')
                                                <p v-if="fbdata.showdv=='yes'">
                                                    <a href="javascript:void(0)" @click="fblogin"
                                                        v-if="fbdata.connected == 'no'" class="btn btn-primary "><b>
                                                            <span class="fab fa-facebook-f"></span>&nbsp;&nbsp;<span
                                                                style="font-family: sans-serif!important;font-size:13px;">Connect to
                                                                Facebook</span></b></a>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <a href="javascript:void(0)" id=""
                                                            v-if="fbdata.connected == 'yes'"
                                                            class="btn btn-primary sop-btn-primary "><b>
                                                                <span class="fab fa-facebook-f"></span>&nbsp;&nbsp;<span
                                                                    style="font-family: sans-serif!important;font-size:13px;">Connected with
                                                                    Facebook</span></b></a>
                                                    </div>
                                                    <div class="col-6">

                                                        <a v-if="fbdata.connected == 'yes'" class="btn btn-danger "
                                                            onclick="disfb()"><b>
                                                                <span class="fab fa-facebook-f"
                                                                    id="fb_dis"></span>&nbsp;&nbsp;<span
                                                                    style="font-family: sans-serif!important;font-size:13px;">Disconnect
                                                                    From
                                                                    Facebook</span></b></a>
                                                        <form id="fb_dis_form"
                                                            action="{{ url('backside/shop_owner/disconnect_fb') }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </div>

                                                </p>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 px-4 px-md-5">
                                    <div class="col-12 col-md-8 col-lg-8  col-xl-6 row">
                                        @isset(Auth::guard('shop_owners_and_staffs')->user()->id)
                                            @if (Auth::guard('shop_owners_and_staffs')->user()->role_id == 4)
                                                <div class="col-6">
                                                    @if (Auth::guard('shop_owners_and_staffs')->user()->role_id == 1 ||
                                                            Auth::guard('shop_owners_and_staffs')->user()->role_id == 2 ||
                                                            Auth::guard('shop_owners_and_staffs')->user()->role_id == 4)
                                                        <a href="{{ route('backside.shop_owner.edit') }}"
                                                            class="btn btn-primary btn-block"><b>
                                                                <span class="fa fa-edit"></span>&nbsp;&nbsp;<span
                                                                    style="font-family: sans-serif!important">Edit
                                                                    Shop</span></b></a>
                                                    @endif
                                                </div>
                                                <div class="col-6">
                                                    <a href="{{ route('backside.shop_owner.change.password') }}"
                                                        class="btn btn-primary btn-block sop-btn-primary"><b><span
                                                                class="fa fa-lock"></span>&nbsp;&nbsp;<span
                                                                style="font-family: sans-serif!important">Change
                                                                Password</span></b></a>

                                                </div>
                                            @endif
                                        @endisset
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->


                            <!-- /.card -->
                        </div>
                        <!-- /.col -->

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    {{-- @include('components.searchbyproductcode') --}}
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        {{-- @include('layouts.backend.footer') --}}


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@endsection

@push('css')
    @if ($shopowner->premium == 'yes')
        <style>
            @media only screen and (min-width: 768px) {
                .profile img {
                    position: absolute;
                    top: -5em;
                    z-index: 100;
                }
            }

            @media only screen and (max-width: 768px) {
                .profile img {
                    position: absolute;
                    top: -3.5em;
                }
            }
        </style>
    @else
        <style>
            @media only screen and (min-width: 768px) {
                .profile img {}
            }

            @media only screen and (max-width: 768px) {
                .profile img {}
            }
        </style>
    @endif
    <style>
        body {
            background: #ffffff !important;
            /* font-family: sans-serif !important; */
            font-family: 'Myanmar3', Sans-Serif !important;
            color: #353535;
            word-wrap: break-word;
        }

        .content-wrapper {
            background: #ffffff !important;
        }


        .sop-banner-backend {
            object-fit: cover;
            width: 100%;
        }

        .profile-user-img {
            border: 5px solid #ffffff !important;
            padding: 0px !important;
        }

        .mm-font {
            font-family: "Myanmar3" !important;
        }

        .content-wrapper>.content {
            padding: 0 !important;
        }

        .container,
        .container-fluid,
        .container-lg,
        .container-md,
        .container-sm,
        .container-xl {
            padding-right: 0px !important;
            padding-left: 0px !important;
        }

        .btn-primary {
            background-color: #4E73F8;
            border: 1px solid #4E73F8;
        }

        .sop-btn-primary {
            background-color: transparent !important;
            border: 1px solid #4E73F8;
            color: #4E73F8;
        }

        .sop-btn-primary:hover {
            background-color: transparent !important;
            border: 1px solid #001f90;
            color: #001f90;
        }

        .sop p,
        a {
            font-size: 1.1rem;
        }


        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .profile {
            height: auto;
            padding: 10px;
        }

        /* .profile img{
                                                  position: absolute;
                                                  top: -5em;
                                                  z-index: 100;
                                                } */

        .shop_name {
            position: absolute;
            left: 12em;
            top: 13px;
        }


        @media only screen and (max-width: 768px) {
            .profile-user-img {
                width: 120PX;
                height: 120px;
            }

            .sop-banner-backend {
                max-height: 300px;
            }

            .banner-img {
                width: 100%;
                height: 250px;
            }


            .swiper-slide img {
                height: 200px;

            }

            .profile {
                height: auto;
            }

            /* .profile img{
                                                        position: absolute;
                                                        top: -3.5em;

                                                    } */
            .shop_name {
                position: absolute;
                left: 8em;
                top: 13px;
            }

            .shop_name h3 {
                font-size: 12px;
                font-weight: bolder;
            }

        }

        @media only screen and (min-width: 768px) {
            .profile-user-img {
                width: 150px;
                height: 150px;
            }

            .sop-banner-backend {
                max-height: 500px;
            }

            .banner-img {
                width: 500px;
                height: 250px;
            }


            /* .sop-profile-back {
                                                        margin-top: -75px !important;
                                                        margin-left: 25px;
                                                    } */
        }
    </style>
@endpush

@push('scripts')
    <script>
        function disfb() {
            console.log('ffff')
            event.preventDefault();
            var check = confirm("Do you really want to Disconnect from Facebook?");
            if (check) {
                document.getElementById('fb_dis_form').submit();
            }
        }
        $(document).ready(function() {


            $('.product-image-thumb').on('click', function() {
                var $image_element = $(this).find('img')
                $('.product-image').fadeOut('slow', function() {
                    $('.product-image').prop('src', $image_element.attr('src')).fadeIn();

                })

                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
            })
        })
    </script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
            },
        });
    </script>
@endpush
