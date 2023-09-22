@php
    use App\Models\FeaturesForShops;
    use App\Models\Ads;
    $ads_deleted_count = Ads::all()->count();
    $all_shops_count = FeaturesForShops::all()->count();
    $admin_request = DB::table('pos_super_admins')->count();
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="z-index: 99999;">
    <!-- Brand Logo -->
    {{-- <a href="{{url('/')}}" class="brand-link">
        <img src="{{url('test/img/logo-m.png')}}" alt="ShweShop Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">ShweShops</span>
    </a> --}}
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{url('/')}}" class="brand-link logo-switch">

            <span class=" logo-xl brand-text font-weight-light">ShweShops</span>
            <span class=" logo-xs brand-image-xs font-weight-light">ရွှေ</span>
        </a>
        <div class="hide-on-wide">
            <i id="sop-toggle" class="fas fa-times"></i>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        {{--  @php
            use App\Super_admin_role;
            $super_admin_role = Super_admin_role::where('id')->first();
            @endphp --}}
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <a href="{{url('/backside/super_admin')}}">
                <div class="image">
                    <img src="{{url('test/img/logo-m.png')}}" class="" alt="ShweShop Logo">
                </div>
                <div class="info text-capitalize">
                    <a href="{{url('/backside/super_admin')}}" class="d-block">
                        <p class="d-flex justify-content-center" style="margin:0; flex-direction: column;">
                            MOE Team <span>(PosSuperAdmin)</span></p>
                    </a>
                </div>
            </a>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                       aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="side-menu mt-2">
            <ul class="nav nav-pills nav-sidebar  flex-column nav-flat  " data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{url('backside/pos_super_admin')}}" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-chart-line"></i> -->
                        <img id="logo" class="logo rounded-5" src="{{'/images/logo/super_admin_logo/Dashboard.svg'}}" alt=""/>
                        <img id="mobile" class="logo rounded-5" src="{{'/images/logo/super_admin_mobile_logo/Dashboard.svg'}}" alt=""/>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                  <a href="{{route('superAdmin.gold_price_get')}}" class="mobile-nav nav-link">
                      <!-- <i class="nav-icon fas fa-chart-line"></i> -->
                      <img id="logo" class="logo rounded-5" src="{{'/images/logo/super_admin_logo/Dashboard.svg'}}" alt=""/>
                      <img id="mobile" class="logo rounded-5" src="{{'/images/logo/super_admin_mobile_logo/Dashboard.svg'}}" alt=""/>
                      <p>Gold Price</p>
                  </a>
                </li> --}}
                {{-- Shops --}}
                <li class="nav-item">
                    <a href="{{route('pos_super_admin_shops.all')}}" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-store"></i> -->
                        <img id="logo" class="logo rounded-5" src="{{'/images/logo/super_admin_logo/Shops.svg'}}" alt=""/>
                        <img id="mobile" class="logo mobile d-none rounded-5" src="{{'/images/logo/super_admin_mobile_logo/Shops.svg'}}" alt=""/>
                        <p>
                            Shops
                            <i class="right fas fa-angle-right"></i>
                            @if ($all_shops_count)
                                <span class="badge badge-danger right">{{ $all_shops_count }}</span>
                            @endif
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('pos_super_admin_shops.all')}}" class="nav-link border-0">
                                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">All Shops</p>
                                @if ($all_shops_count)
                                    <span class="badge badge-danger right">{{ $all_shops_count }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pos_super_admin_shops.create') }}" class="nav-link border-0">
                                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Add Shop</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                {{-- Admins --}}
                <li class="nav-item">
                    <a href="{{route('backside.super_admin.news.index')}}" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-address-card"></i> -->
                        <img id="logo" class="logo rounded-5" src="{{'/images/logo/super_admin_logo/Admins.svg'}}" alt=""/>
                        <img id="mobile" class="logo mobile d-none rounded-5" src="{{'/images/logo/super_admin_mobile_logo/Admins.svg'}}" alt=""/>
                        <p>
                            Admins
                            <i class="right fas fa-angle-right"></i>
                            @if ($admin_request)
                                <span class="badge badge-danger right">{{ $admin_request }}</span>
                            @endif
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('pos_super_admin_role.list')}}" class="nav-link border-0">
                                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Lists</p>
                                @if ($admin_request)
                                    <span class="badge badge-danger right">{{ $admin_request }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('pos_super_admin_role.create')}}" class="nav-link border-0">
                                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Create Admin</p>
                            </a>
                        </li>

                    </ul>
                </li>
                
            </ul>

            <ul class="nav nav-pills nav-sidebar mt-3 flex-column nav-flat">
                <li class="nav-item">
                    <a class="mobile-nav nav-link" href="#" role="button"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <!-- <i class="nav-icon fas fa-sign-out-alt"></i> -->
                        <img id="logo" class="logo rounded-5" src="{{'/images/logo/super_admin_logo/Log out.svg'}}" alt=""/>
                        <img id="mobile" class="logo mobile rounded-5" src="{{'/images/logo/super_admin_mobile_logo/Log out.svg'}}" alt=""/>
                        <p>Log Out</p>
                    </a>
                    <form id="logout-form" action="{{route('backside.pos_super_admin.logout')}}" method="POST"
                          style="display: none;">

                        @csrf
                    </form>
                </li>
            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@push('css')
    <style>
      .nav-sidebar .nav-link p {
        font-size: 18px !important;
      }
      .mobile-nav {
        margin: 5px 0;
      }
      .nav-item .login {
        margin-right: 10px !important;
      }
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #780116;
            border-radius: 3px;
            border: 4px solid transparent;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #780117cc;
        }

        .main-sidebar ::-webkit-scrollbar {
            display: none;
        }

        .sidebar-collapse .user-panel img {
            width: 2.3rem;
            height: 2.3rem;
        }

        .user-panel img {
            object-fit: cover;
        }

        .brand-link {
            border: none !important;
        }

        .brand-link span {
            font-size: 1.5rem;
        }


        .user-panel {
            border: none !important;
        }

        .sidebar-dark-primary {
            font-family: sans-serif;
        }

        .sop-btm-right {
            position: fixed;
            bottom: 10px;
            text-align: right;

        }

        .sidebar-collapse .sop-btm-right {

            text-align: left;
        }

        .sop-sidebar .disabled {
            opacity: 0.5;

        }

        .sop-btm-right li {
            opacity: 0.6;
        }

        .sop-btm-right li:hover {
            opacity: 1;
        }

        .main-sidebar {
            position: fixed !important;
            top: 0;
            bottom: 0;
            left: 0;
        }

        .hide-on-wide {
            text-align: right;
            cursor: pointer;
        }

        .hide-on-wide:hover {
            color: #3c56ff;
        }

        .fa-circle {
            font-size: 8px !important;
        }

        .nav-sidebar .menu-is-opening > .nav-link p >i {
            -webkit-transform: rotate(90deg) !important;
            transform: rotate(90deg) !important;
        }

        .coin-font-size{
            font-size: 20px;
        }

        @media only screen and (max-width: 992px) {
            .sidebar-dark-primary {
                background-color: #f0f7fa;
            }

            @supports ((-webkit-backdrop-filter: none) or (backdrop-filter: none)) {
                .sidebar-dark-primary {
                    background-color: #f0f7fab0;
                    color: #780116;
                    -webkit-backdrop-filter: blur(20px);
                    backdrop-filter: blur(20px);
                }
            }
            .sidebar-dark-primary a {
                color: #780116 !important;
            }

            svg{
                fill: #780116 !important;
            }

            .sidebar-dark-primary a:hover {
                color: #780116 !important;
            }

            .info img {
                width: 70px;
            }

        }

        @media only screen and (min-width: 992px) {
            .sidebar-dark-primary {
                background-color: #780116;
                color: #e5e5e5;
            }

            .sidebar-dark-primary a {
                color: #e5e5e5 !important;
            }

            .sidebar-dark-primary a {
                color: #e5e5e5 !important;
            }

            .sop-btm-right {
                background-color: #780116;
            }
        }

        @media only screen and (max-width: 576px) {
            .sidebar-open .main-sidebar, .main-sidebar::before {
                width: 100%;
                font-size: 1.3rem !important;
                padding: 1rem;
            }

            .sidebar-mini .main-sidebar .nav-flat .nav-link, .sidebar-mini-md .main-sidebar .nav-flat .nav-link, .sidebar-mini-xs .main-sidebar .nav-flat .nav-link {
                width: 100%;
            }

            .sop-btm-right {
                text-align: right;
            }

            .hide-on-wide {
                display: block;
            }

            .sidebar-open .sop-btm-right {
                width: 90%;
            }

            .user-panel img {
                width: 186px !important;
                height: 80px !important;;
                width: 100%;
                height: auto;
            }

            .info p {
                color: #000;
                font-weight: 600;

            }

            .info span {
                font-weight: 500 !important;
            }
        }

        @media only screen and (min-width: 576px) {
            .hide-on-wide {
                display: none;
            }

            .user-panel img {
                width: 58px !important;
                /* height: 58px!important;; */
                width: 100%;
                height: auto;
            }

        }

        @media only screen and (max-width: 576px) {
            .user-panel img{
                width: 100% !important;
            }

            .logo{
                margin-top: 0% !important;
            }


            .side-menu{
                margin-top: 8% !important;
            }

        }

        @media only screen and (max-width:390px) {
            /* .info p{
                font-size: 100% !important;
            } */
            .user-panel img {
                width: 130px !important;
                height: 0%!important;
                /* width: 100%; */
                height: auto;
            }

        }

        /* zh */
        .logo{
            width: 30px;
            height: 30px;
            margin-top: -2%;
            margin-right: 10px;
        }

        .right{
            /* margin-top: 5%; */
        }

        .mobile-nav{
            display: flex;
        }

        #mobile{
            display: none;
        }

        @media only screen and (max-width:991px) {
            #logo{
                display: none;
            }
            #mobile{
                display: block !important;
            }
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function () {
            $("#sop-toggle").click(function () {
                $("body").removeClass("sidebar-open").addClass("sidebar-closed sidebar-collapse");
            });
        });
    </script>
    <script src="{{url('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
@endpush


