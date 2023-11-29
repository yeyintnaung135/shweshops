<aside class="main-sidebar sidebar-dark-primary elevation-4" style="z-index: 99999;">
    <!-- Brand Logo -->
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="brand-link logo-switch">
            <span class=" logo-xl brand-text font-weight-light">ShweShops</span>
            <span class=" logo-xs brand-image-xs font-weight-light">ရွှေ</span>
        </a>
        <div class="hide-on-wide">
            <i id="sop-toggle" class="fas fa-times"></i>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @php
            use App\Models\Shops;

            if (isset(Auth::guard('shop_owners_and_staffs')->user()->id)) {
                $current_shop = Shops::where('id', Auth::guard('shop_owners_and_staffs')->user()->shop_id)->first();
                $premium_status = $current_shop->preminum;
            }

        @endphp


        <a href="{{ url('backside/shop_owner/shop') }}" class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="{{ filedopath('/shop_owner/logo/' . $current_shop->shop_logo) }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info text-capitalize">
                {{ \Illuminate\Support\Str::limit($current_shop->shop_name, 20, '...') }}
            </div>
        </a>



        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar  flex-column nav-flat sop-sidebar" data-widget="treeview"
                role="menu" data-accordion="false" style="margin-bottom: 40px">

                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @can ('can_show_dashboard')
                    <li class="nav-item py-1">
                        <a href="{{ url('backside/shop_owner/detail') }}" class="nav-link">
                            <i class="fi fi-rr-home nav-icon"></i>
                            <p>
                                Dashboard
                                {{-- {{\Illuminate\Support\Str::limit($current_shop->shop_name, 20, '...')}} --}}

                            </p>
                        </a>
                    </li>
                @endif

               @isRole('staff')
               @else
                        <li class="nav-item py-1">
                            <a href="#" class="nav-link">
                                <i class="fi fi-rr-user nav-icon"></i>
                                <p>
                                    Users
                                    <i class="right fas fa-angle-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item py-1">
                                    <a href="{{ url('backside/shop_owner/users') }}" class="nav-link border-0">
                                        <i class="fa fa-circle pl-5"></i>
                                        <p class="ml-3">List</p>
                                    </a>
                                </li>
                                <li class="nav-item py-1">
                                    <a href="{{ url('backside/shop_owner/users/create') }}" class="nav-link border-0">
                                        <i class="fa fa-circle pl-5"></i>
                                        <p class="ml-3">Add User</p>
                                    </a>
                                </li>
                                @isRole('admin')
                                @else
                                <li class="nav-item py-1">
                                    <a href="{{url('/backside/shop_owner/users/trash')}}" class="nav-link border-0">
                                        <i class="fa fa-circle pl-5"></i>
                                        <p class="ml-3">Trash</p>
                                    </a>
                                 </li>
                                @endisRole



                            </ul>
                        </li>
                   @endisRole


                <li class="nav-item py-1">
                    <a href="#" class="nav-link">
                        <i class="fi fi-rs-gift nav-icon"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item py-1">
                            <a href="{{ route('backside.shop_owner.items.index') }}" class="nav-link border-0">
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">List</p>
                            </a>
                        </li>
                        <li class="nav-item py-1">
                            <a href="{{ route('backside.shop_owner.items.create') }}" class="nav-link border-0">
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Add</p>
                            </a>
                        </li>

                        <li class="nav-item py-1">
                            <a href="{{ route('backside.shop_owner.items.trash') }}" class="nav-link border-0">
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Trash</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item py-1">
                    <a href="#" class="nav-link">
                        <i class="fi fi-rs-humidity nav-icon"></i>
                        <p>
                            Percent Template
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item py-1">
                            <a href="{{ route('backside.shop_owner.items.template.list') }}"
                                class="nav-link border-0">
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">List</p>
                            </a>
                        </li>
                        <li class="nav-item py-1">
                            <a href="{{ route('backside.shop_owner.items.template.create') }}"
                                class="nav-link border-0">
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Create</p>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="nav-item py-1">
                    <a href="{{ url('backside/shop_owner/item/discount_list') }}" class="nav-link">
                        <i class="fi fi-rr-megaphone nav-icon"></i>
                        <p>
                            Discount Products List
                        </p>
                    </a>
                </li>
               @isRole('staff')
               @else
               <li class="nav-item py-1">
                <a href="{{ url('backside/shop_owner/edit') }}" class="nav-link">
                    <i class="nav-icon fi fi-rr-edit"></i>
                    <p>
                        Edit Shop
                    </p>
                </a>
               </li>
               @endisRole

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fi fi-rr-document-signed"></i>
                        <p>
                            User Activity Logs
                            <i class="right fas fa-angle-right"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backside.shop_owner.so_activity.u_product') }}"
                                class="nav-link border-0">
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Product Activities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backside.shop_owner.so_activity.u_role') }}"
                                class="nav-link border-0">
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Role Activities</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fi fi-rr-document-signed"></i>
                        <p>
                            Product Activity Logs
                            <i class="right fas fa-angle-right"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('backside.shop_owner.so_activity.p_product') }}"
                                class="nav-link border-0">
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Item Activities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backside.shop_owner.so_activity.p_multiprice') }}"
                                class="nav-link d-flex border-0 align-items-center">
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Multiple Price Activities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backside.shop_owner.so_activity.p_multidiscount') }}"
                                class="nav-link d-flex border-0 align-items-center">
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Multiple Discount Activities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backside.shop_owner.so_activity.p_multipercent') }}"
                                class="nav-link d-flex border-0 align-items-center">
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Multiple Percent Activities</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{route('backside.shop_owner.popup_specialEvent')}}">

                            </a>
                        </li> --}}
                    </ul>
                </li>

                @canany(['access-shop-owner-premium', 'access-shop-role-premium'])
                    <hr />

                    <li class="nav-item nav-header ml-2">
                        Premium
                    </li>

                    <li class="nav-item py-1">
                        <a href="{{ route('backside.shop_owner.collections.index') }}" class="nav-link">
                            <i class="nav-icon fi fi-rr-gem"></i>
                            <span>
                                Collections
                            </span>
                        </a>
                    </li>

                    <li class="nav-item py-1">
                        <a href="{{ route('backside.shop_owner.news.index') }}" class="nav-link">
                            <i class="nav-icon fi fi-rr-world"></i>
                            <span>
                                News
                            </span>
                        </a>
                    </li>

                    <li class="nav-item py-1">
                        <a href="{{ route('backside.shop_owner.events.index') }}" class="nav-link">
                            <i class="nav-icon fi fi-rs-calendar"></i>
                            <span>
                                Events
                            </span>
                        </a>
                    </li>

                    <li class="nav-item py-1">
                        <a href="#" class="nav-link @if ($premium_status == 'no') disabled @endif">
                            <i class="nav-icon fi fi-rr-megaphone"></i>
                            <p style="font-family: 'Myanmar3'!important">
                                ကြော်ညာထည့်ရန်
                                <i class="right fas fa-angle-right"></i>
                            </p>

                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                {{-- <a href="{{route('backside.shop_owner.popup_specialEvent')}}"> --}}
                                <a href="{{ route('backside.shop_owner.ads.main_popup') }}"
                                    class="nav-link d-flex border-0 align-items-center">
                                    <i class="fa fa-circle pl-5"></i>
                                    <p class="ml-3">Main Popup</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item py-1">
                        <a href="{{ route('backside.shop_owner.opening_times') }}"
                            class="nav-link @if ($premium_status == 'no') disabled @endif">
                            <i class="nav-icon fa fa-clock"></i>
                            <p style="font-family: 'Myanmar3'!important">
                                Opening Hours
                            </p>
                        </a>
                    </li>

                    <hr />
                @endcanany
                {{-- <li class="nav-item nav-header ml-2">
                    Download Files
                </li>
                <li class="nav-item py-1">
                    <a href="{{ route('backside.shop_owner.app-files.android') }}" class="nav-link">
                        <i class="nav-icon fi fi-brands-android"></i>
                        <span>
                            Android
                        </span>
                    </a>
                </li> --}}

                {{-- wlk --}}
                <li class="nav-item py-1">
                    <a href="{{ route('backside.shop_owner.orders') }}" class="nav-link">
                        <i class="fas fa-coins ml-3"></i>
                        <span>
                            Orders
                        </span>
                    </a>
                </li>
                {{-- wlk --}}

                {{-- maymyat --}}
                @can('can_use_pos')
                    <li class="nav-item py-1">
                        <a href="{{ route('backside.shop_owner.pos.dashboard') }}" class="nav-link">
                            <i class="nav-icon fi fi-rs-print"></i>
                            <p style="font-family: 'Myanmar3'!important">
                                POS
                            </p>
                        </a>
                    </li>
                @endcan
                {{-- end maymyat --}}
                {{--     <li class="nav-item">
                        <a  href="#" class="nav-link">
                        <i class="nav-icon fi fi-rr-document-signed"></i>
                            <p>
                                Add Point
                                <i class="right fas fa-angle-right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('backside.shop_owner.add_price')}}" class="nav-link border-0">
                                    <i class="fa fa-circle pl-5"></i>
                                    <p class="ml-3">Add Price</p>
                                </a>
                            </li>
                        </ul>
                    </li> --}}


                <li class="nav-item py-1">
                    <a href="" class="nav-link disabled">
                        <i class="nav-icon fi fi-rr-book"></i>
                        <p>
                            User Guide
                        </p>
                    </a>
                </li>
                <li class="nav-item py-1">
                    <a href="{{ url('backside/shop_owner/support') }}" class="nav-link ">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>
                            Help and Support
                        </p>
                    </a>
                </li>
                <li class="nav-item py-1">
                    <a href="{{ url('backside/shop_owner/chatpannel') }}" class="nav-link ">
                        <i class="nav-icon fi fi-rr-headphones"></i>
                        <p>
                            Chat
                        </p>
                    </a>
                </li>
            </ul>
            <div class="sop-btm-right">
                <ul class="nav nav-pills nav-sidebar  flex-column nav-flat">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backside.shop_owner.logout') }}" role="button"
                            onclick="event.preventDefault();deleteLocalData(); document.getElementById('logout-form').submit(); ">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Log Out</p>
                        </a>

                        <form id="logout-form" action="{{ route('backside.shop_owner.logout') }}" method="POST"
                            style="display: none;">

                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@push('css')
    <style>
        @import url({{ url('fonts/css/flaticon-straight.css') }});
        @import url({{ url('fonts/css/flaticon-rounded.css') }});

        body {
            word-wrap: break-word;
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
            /* font-family: sans-serif; */
            font-family: 'Myanmar3', Sans-Serif !important;
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

        .nav-sub-header {
            padding: 0.5rem 1rem;
        }

        .longtext-margin {
            margin-left: 0.3rem !important;
        }

        .nav-treeview {
            margin-left: 0;
        }

        .fa-circle {
            font-size: 8px !important;
        }

        .nav-sidebar .menu-is-opening>.nav-link p>i {
            -webkit-transform: rotate(90deg) !important;
            transform: rotate(90deg) !important;
        }

        @media only screen and (max-width: 992px) {
            .sidebar-dark-primary {
                background-color: #f0f7fa;
            }

            @supports ((-webkit-backdrop-filter: none) or (backdrop-filter: none)) {
                .sidebar-dark-primary {
                    background-color: #f0f7fab0;
                    color: #4E73F8;
                    -webkit-backdrop-filter: blur(20px);
                    backdrop-filter: blur(20px);
                }
            }

            .sidebar-dark-primary a {
                color: #2755fd !important;
            }

            .sidebar-dark-primary a:hover {
                color: #3c56ff !important;
            }

            .info img {
                width: 70px;
            }

        }

        @media only screen and (min-width: 992px) {
            .sidebar-dark-primary {
                background-color: #4E73F8;
                color: #e5e5e5;
            }

            .sidebar-dark-primary a {
                color: #e5e5e5 !important;
            }

            .sidebar-dark-primary a {
                color: #e5e5e5 !important;
            }

            .sop-btm-right {
                background-color: #4E73F8;
            }
        }

        @media only screen and (max-width: 576px) {

            .sidebar-open .main-sidebar,
            .main-sidebar::before {
                width: 100%;
                font-size: 1.3rem !important;
                padding: 1rem;
            }

            .sidebar-mini .main-sidebar .nav-flat .nav-link,
            .sidebar-mini-md .main-sidebar .nav-flat .nav-link,
            .sidebar-mini-xs .main-sidebar .nav-flat .nav-link {
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
                width: 80px !important;
                height: 80px !important;
                ;
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
                height: 58px !important;
                ;
                width: 100%;
                height: auto;
            }

        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#sop-toggle").click(function() {
                $("body").removeClass("sidebar-open").addClass("sidebar-closed sidebar-collapse");
            });
        });

        function deleteLocalData() {
            // window.localStorage.removeItem('fav');
            // window.localStorage.removeItem('selection');
            // window.localStorage.removeItem('favID');
            // window.localStorage.removeItem('selectionID');
            // window.localStorage.removeItem('discountedID');
        }
    </script>
@endpush
