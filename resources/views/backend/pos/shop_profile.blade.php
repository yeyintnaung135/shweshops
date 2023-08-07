@extends('layouts.backend.backend')
@section('content')
    <div class="wrapper">
        <!-- Navbar -->
    @include('layouts.backend.pos_nav')
    <!-- /.navbar -->

        <!-- Main Sidebar Container -->
    @include('layouts.backend.pos_sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sop">
            @if(Session::has('message'))
                <x-alert>
                </x-alert>
            @endif
        <!-- Content Header (Page header) -->
            <section class="content-header sn-content-header">
                <div class="container-fluid">
                    @foreach($shopowner as $shopowner )
                    @endforeach
                    <div class="sn-admin-header d-sm-none">

                    </div>

                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->


            <section class="content ">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <!-- Profile Image -->

                            <div class="">
                            @if($shopowner->premium == 'yes')
                                @if(!empty($shopowner->shop_banner))
                                    <!-- Swiper -->
                                        <div class="swiper mySwiper">
                                            <div class="swiper-wrapper">
                                                @foreach ($shopowner->getPhotos as $p )
                                                    <div class="swiper-sliendforeachde">
                                                        <img src="{{ asset('images/banner/'.$p->location)}}" alt="">
                                                    </div>
                                                @endforeach

                                            </div>
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    @else
                                        <?php
                                        if (\App\ShopBanner::where('shop_owner_id', $shopowner->id)->first()) {
                                            $getbanner = \App\ShopBanner::where('shop_owner_id', $shopowner->id)->first()->location;
                                        } else {
                                            $getbanner = "default.jpg";
                                        }
                                        ?>
                                        <img class="img-fluid"
                                             src="{{url('images/banner/'.$getbanner)}}"
                                             alt="Photo">
                                    @endif
                                @endif
                            </div>
                            <div class="profile-content">
                                <div class=" profile position-relative mb-4">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{url('images/logo/'.$shopowner->shop_logo)}}"
                                         alt="User profile picture">
                                    <div class="shop_name">
                                        <h3>
                                            {{$shopowner->shop_name}} <br>
                                            @isset($shopowner->shop_name_myan)
                                                <span class="mm-font">( {{$shopowner->shop_name_myan}} )</span>
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
                                                <div class="col-6 px-0"><a href="{{$shopowner->page_link}}">Facebook
                                                        Page Link</a></div>
                                                <div class="col-6 px-0"><a href="{{$shopowner->messenger_link}}">Messenger
                                                        Link</a></div>
                                            </div>
                                            <p>Main Phone : {{$shopowner->main_phone}}</p>
                                            <p class="mm-font">Address : {!! $shopowner->address !!}</p>
                                        </div>
                                        <div class="col-12 pl-lg-5 col-lg-6">
                                            <p><span
                                                    class="mm-font">အထည်မပျက် ပြန်သွင်း :</span>{{$shopowner->အထည်မပျက်_ပြန်သွင်း}}
                                                <span style="font-size: 0.85rem">%</span></p>
                                            <p><span
                                                    class="mm-font">တန်ဖိုးမြင့်အထည် နှင့် အထည်မပျက်ပြန်လဲ : </span>{{$shopowner->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ}}
                                                <span style="font-size: 0.85rem">%</span></p>
                                            <p><span
                                                    class="mm-font">အထည်ပျက်စီးချို့ယွင်း : </span>{{$shopowner->အထည်ပျက်စီးချို့ယွင်း}}
                                                <span style="font-size: 0.85rem">%</span></p>
                                            @if(\App\sitesettings::where('id',1)->first()->action === 'on' && $shopowner->pos_only == 'no')

                                                <p v-if="fbdata.showdv=='yes'">
                                                    <a href="javascript:void(0)" @click="fblogin"
                                                       v-if="fbdata.connected == 'no'"
                                                       class="btn btn-primary "><b>
                                                                    <span
                                                                        class="fab fa-facebook-f"></span>&nbsp;&nbsp;<span
                                                                style="font-family: sans-serif!important">Connect to Facebook</span></b></a>
                                                    <a href="javascript:void(0)" id="" v-if="fbdata.connected == 'yes'"

                                                       class="btn btn-primary sop-btn-primary "><b>
                                                                    <span
                                                                        class="fab fa-facebook-f"></span>&nbsp;&nbsp;<span
                                                                style="font-family: sans-serif!important">Connected with Facebook</span></b></a>
                                                </p>

                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 px-4 px-md-5">
                                    <div class="col-12 col-md-8 col-lg-8  col-xl-6 row">
                                        @isset(Auth::guard('shop_role')->user()->id)
                                            <div class="col-6">
                                                @if(Auth::guard('shop_role')->user()->role_id == 1 || Auth::guard('shop_role')->user()->role_id == 2)

                                                    <a href="{{route('backside.shop_owner.pos.shop_edit')}}"
                                                       class="btn btn-primary btn-block"><b>
                                                            <span class="fa fa-edit"></span>&nbsp;&nbsp;<span
                                                                style="font-family: sans-serif!important">Edit Shop</span></b></a>
                                                @endif
                                            </div>
                                        @endisset

                                        @isset(Auth::guard('shop_owner')->user()->id)
                                            <div class="col-6">
                                                <a href="{{route('backside.shop_owner.pos.shop_edit')}}"
                                                   class="btn btn-color btn-block"><b><span
                                                            class="fa fa-edit"></span>&nbsp;&nbsp;<span
                                                            style="font-family: sans-serif!important">Edit Shop</span></b></a>
                                            </div>
                                        @endisset
                                        @isset(Auth::guard('shop_owner')->user()->id)
                                            <div class="col-6">
                                                <a href="{{route('backside.shop_owner.pos.change.password')}}"
                                                   class="btn btn-color btn-block sop-btn-primary"><b><span
                                                            class="fa fa-lock"></span>&nbsp;&nbsp;<span
                                                            style="font-family: sans-serif!important">Change Password</span></b></a>
                                            </div>
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
@push('scripts')
    <script>

            $(document).ready(function() {
                
            });
 
    </script>
@endpush
@push('css')
    <style>
        body {
            background: #F0F7FA;
            font-family: 'Myanmar3', Sans-Serif !important;
        }
        .btn-color{
        background-color: #780116;
        color: white;
    }
    .btn-color:hover{
            color: white;
        }
    .text-color{
        color: #780116;
    }
   

    </style>
@endpush

