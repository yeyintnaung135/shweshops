<aside class="main-sidebar sidebar-dark-primary elevation-4" style="z-index: 99999;">
    <!-- Brand Logo -->
    <div class="justify-content-between align-items-center">
        <div class="row mt-2">
            <a href="{{url('/')}}" class="offset-3"><img src="https://test.shweshops.com/test/img/logo-m.png" alt="" width="100" height="100" ></a>
        </div>

        <a href="{{url('/')}}" class="brand-link logo-switch">
            <span class=" logo-xl brand-text font-weight-bold text-color text-center">ShweShops POS</span>
            {{-- <span class=" logo-xs brand-image-xs font-weight-bold">ရွှေ</span> --}}
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
        use App\Models\ShopOwnersAndStaffs;

              $current_shop=Shops::where('id',Auth::guard('shop_owners_and_staffs')->user()->shop_id)->first();
        @endphp




            <a href="{{url('backside/shop_owner/shop')}}"  class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                <div class="image">
                    <img src="{{filedopath('/shop_owner/logo/'.$current_shop->shop_logo)}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info text-capitalize text-color">
                    {{\Illuminate\Support\Str::limit($current_shop->shop_name, 20, '...')}}
                </div>
            </a>






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
        {{-- For Role Permission
            @if(Session::has('staff_role'))
            <h3>{{session::get('staff_role')}}</h3>
            @endif
        --}}
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar  flex-column nav-flat sop-sidebar" data-widget="treeview" role="menu" data-accordion="false" style="margin-bottom: 40px">

                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                     @if(Auth::guard('shop_owners_and_staffs')->check())
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.dashboard')}}" class="nav-link">
                            {{-- <i class="fi fi-rr-home nav-icon"></i> --}}
                            <p class="font-weight-bold text-color">
                                Dashboard
                            {{-- {{\Illuminate\Support\Str::limit($current_shop->shop_name, 20, '...')}} --}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="#" class="nav-link">
                            <!--<i class="fa fa-shopping-cart nav-icon"></i>-->
                            <p class="font-weight-bold  text-color">
                                အဝယ်စာရင်းသွင်းခြင်း
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                             <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.create_purchase')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေထည်အဝယ်စာရင်းသွင်းခြင်း
                            </p>
                        </a>
                           </li>
                            <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.create_kyout_purchase')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                စိန်ကျောက်ထည်အဝယ်စာရင်းသွင်းခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.create_ptm_purchase')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ပလက်တီနမ်အဝယ်စာရင်းသွင်းခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.create_wg_purchase')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေဖြူအဝယ်စာရင်းသွင်းခြင်း
                            </p>
                        </a>
                    </li>
                        </ul>
                    </li>

                    @if(Session::has('staff_role'))
                    @if(Session::get('staff_role') != 3)
                    <li class="nav-item py-1">
                        <a href="#" class="nav-link">
                            <!--<i class="fa fa-shopping-cart nav-icon"></i>-->
                            <p class="font-weight-bold  text-color">
                                အဝယ်စာရင်းစစ်ခြင်း
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.purchase_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေထည်အဝယ်စာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.kyout_purchase_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                စိန်ကျောက်ထည်အဝယ်စာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>

                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.ptm_purchase_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ပလက်တီနမ်အဝယ်စာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>

                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.wg_purchase_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေဖြူအဝယ်စာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                        </ul>
                    </li>
                    @endif
                    @else
                    <li class="nav-item py-1">
                        <a href="#" class="nav-link">
                            <!--<i class="fa fa-shopping-cart nav-icon"></i>-->
                            <p class="font-weight-bold  text-color">
                                အဝယ်စာရင်းစစ်ခြင်း
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.purchase_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေထည်အဝယ်စာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.kyout_purchase_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                စိန်ကျောက်ထည်အဝယ်စာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>

                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.ptm_purchase_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ပလက်တီနမ်အဝယ်စာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>

                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.wg_purchase_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေဖြူအဝယ်စာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                        </ul>
                    </li>
                    @endif

                    <li class="nav-item py-1">
                        <a href="#" class="nav-link">
                            <!--<i class="fa fa-shopping-cart nav-icon"></i>-->
                            <p class="font-weight-bold  text-color">
                                အရောင်းစာရင်းသွင်းခြင်း
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.sale_purchase')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေထည်အရောင်းစာရင်းသွင်းခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.sale_kyout_purchase')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                စိန်ကျောက်ထည်အရောင်းစာရင်းသွင်းခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.sale_ptm_purchase')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ပလက်တီနမ်အရောင်းစာရင်းသွင်းခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.sale_wg_purchase')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေဖြူအရောင်းစာရင်းသွင်းခြင်း
                            </p>
                        </a>
                    </li>
                        </ul>
                    </li>

                    @if(Session::has('staff_role'))
                    @if(Session::get('staff_role') != 3)
                    <li class="nav-item py-1">
                        <a href="#" class="nav-link">
                            <!--<i class="fa fa-shopping-cart nav-icon"></i>-->
                            <p class="font-weight-bold  text-color">
                                အရောင်းစာရင်းစစ်ခြင်း
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.gold_sale_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေထည်အရောင်းစာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.sale_kyout_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                စိန်ကျောက်ထည်အရောင်းစာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.ptm_sale_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ပလက်တီနမ်အရောင်းစာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.wg_sale_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေဖြူအရောင်းစာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                        </ul>
                    </li>
                    @endif
                    @else
                    <li class="nav-item py-1">
                        <a href="#" class="nav-link">
                            <!--<i class="fa fa-shopping-cart nav-icon"></i>-->
                            <p class="font-weight-bold  text-color">
                                အရောင်းစာရင်းစစ်ခြင်း
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.gold_sale_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေထည်အရောင်းစာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.sale_kyout_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                စိန်ကျောက်ထည်အရောင်းစာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.ptm_sale_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ပလက်တီနမ်အရောင်းစာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.wg_sale_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" style="font-size:13px" >
                                ရွှေဖြူအရောင်းစာရင်းစစ်ခြင်း
                            </p>
                        </a>
                    </li>
                        </ul>
                    </li>
                    @endif



                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.assign_gold_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" >
                                ရွှေဈေးသတ်မှတ်ခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.assign_platinum_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color">
                                ပလက်တီနမ်ဈေးသတ်မှတ်ခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.assign_whitegold_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" >
                                ရွှေဖြူဈေးသတ်မှတ်ခြင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.credit_list')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" >
                               ကြွေးကျန်စာရင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.return_list')}}" class="nav-link">
                            {{-- <i class="fa fa-undo nav-icon" aria-hidden="true"></i> --}}
                            <p class="font-weight-bold text-color">
                                အထည်​ဟောင်းစာရင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.diamond_list')}}" class="nav-link">
                            {{-- <i class="fa fa-diamond nav-icon" aria-hidden="true"></i> --}}
                            <p class="font-weight-bold text-color">
                                စိန်ကျောက်ထည်စာရင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.counter_list')}}" class="nav-link">
                            {{-- <i class="fa fa-home nav-icon" aria-hidden="true"></i> --}}
                            <p class="font-weight-bold text-color">
                                ဆိုင်ခွဲစာရင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.staff_list')}}" class="nav-link">
                            {{-- <i class="fa fa-users nav-icon"></i> --}}
                            <p class="font-weight-bold text-color">
                                Staff စာရင်း
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.supplier_list')}}" class="nav-link">
                            {{-- <i class="fa fa-user-plus nav-icon"></i> --}}
                            <p class="font-weight-bold text-color">
                                ကုန်သည်စာရင်း
                            </p>
                        </a>
                    </li>
                    {{-- <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.purchase_lists')}}" class="nav-link">

                            <p class="font-weight-bold text-color" >
                                အဝယ်စာရင်းများ
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.sale_lists')}}" class="nav-link">

                            <p class="font-weight-bold text-color" >
                                အရောင်းစာရင်းများ
                            </p>
                        </a>
                    </li> --}}
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.famous_sale_lists')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" >
                                အ​ရောင်းသွက်ပစ္စည်းများ
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.stock_lists')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" >
                                ပစ္စည်းလက်ကျန်စာရင်းများ
                            </p>
                        </a>
                    </li>
                    @if(Session::has('staff_role'))
                    @if(Session::get('staff_role') == 4)
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.income_lists')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" >
                                အမြတ်ငွေစာရင်းများ
                            </p>
                        </a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.income_lists')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" >
                                အမြတ်ငွေစာရင်းများ
                            </p>
                        </a>
                    </li>
                    @endif

                    <li class="nav-item py-1">
                        <a href="{{route('backside.shop_owner.pos.shop_profile')}}" class="nav-link">
                            {{-- <i class="fa fa-circle nav-icon"></i> --}}
                            <p class="font-weight-bold text-color" >
                                Profile
                            </p>
                        </a>
                    </li>
                    <li class="nav-item py-1">
                        <a href="#" class="nav-link">

                            <p class="font-weight-bold text-color" >

                            </p>
                        </a>
                    </li>


                @endif


            <div class="sop-btm-right">
                <ul class="nav nav-pills nav-sidebar  flex-column nav-flat">
                    <li class="nav-item">
                        <a class="nav-link"  href="{{route('backside.shop_owner.logout')}}"  role="button" onclick="event.preventDefault();deleteLocalData(); document.getElementById('logout-form').submit(); ">
                            <i class="nav-icon fas fa-sign-out-alt"></i> <p class="font-weight-bold text-color">Log Out</p>
                        </a>

                        <form id="logout-form" action="{{route('backside.shop_owner.logout')}}" method="POST" style="display: none;">

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
    @import url({{url('fonts/css/flaticon-straight.css')}});
    @import url({{url('fonts/css/flaticon-rounded.css')}});
    body {
        word-wrap: break-word;
    }
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        /* background: #780116; */
    }

    ::-webkit-scrollbar-thumb {
        /* background: #780116; */
        border-radius: 3px;
        border: 4px solid transparent;
    }

    ::-webkit-scrollbar-thumb:hover {
        /* background: #780117cc; */
    }
    .main-sidebar ::-webkit-scrollbar {
        display:none;
    }
    .sidebar-collapse .user-panel img {
        width: 2.3rem;
        height: 2.3rem;
    }
    .user-panel img {
        object-fit: cover;
    }
    .brand-link {
        border:none!important;
    }
    .brand-link span{
        font-size: 1.5rem;
    }


    .user-panel  {
        border:none!important;
    }
    .sidebar-dark-primary{
        /* font-family: sans-serif; */
        font-family: 'Myanmar3', Sans-Serif !important;
    }

    .sop-btm-right{
        position: fixed;
        bottom: 10px;
        text-align: right;

    }

    .sidebar-collapse .sop-btm-right{

        text-align:left;
    }
    .sop-sidebar .disabled{
        opacity: 0.5;

    }
    .sop-btm-right li{
        opacity: 0.6;
    }
    .sop-btm-right li:hover{
        opacity: 1;
    }
    .main-sidebar{
        position: fixed!important;
        top: 0;
        bottom: 0;
        left: 0;
    }
    .hide-on-wide {
        text-align: right;
        cursor: pointer;
    }
    .hide-on-wide:hover {
        color:#780116;
    }
    .nav-sub-header{
        padding: 0.5rem 1rem;
    }
    .longtext-margin{
        margin-left: 0.3rem!important;
    }

    .nav-treeview {
        margin-left: 0;
    }

    .fa-circle {
        font-size: 8px !important;
    }

    .nav-sidebar .menu-is-opening > .nav-link p >i {
        -webkit-transform: rotate(90deg) !important;
        transform: rotate(90deg) !important;
    }
    @media only screen and (max-width: 992px) {
        .sidebar-dark-primary{
            background-color: #780116;
        }
        @supports ((-webkit-backdrop-filter: none) or (backdrop-filter: none)) {
            .sidebar-dark-primary{
                background-color: #f0f7fab0;
                color: #4E73F8;
                -webkit-backdrop-filter: blur(20px);
                backdrop-filter: blur(20px);
            }
        }
        .sidebar-dark-primary a{
            color: #2755fd!important;
        }
        .sidebar-dark-primary a:hover{
            color: #780116!important;
        }

        .info img{
            width: 70px;
        }

    }
    @media only screen and (min-width: 992px) {
        .sidebar-dark-primary{
            background-color: white;
            color: black;
        }
        .sidebar-dark-primary a{
            color: black!important;
        }
        .sidebar-dark-primary a{
            color: black!important;
        }
        .sop-btm-right{
            background-color: white;
        }
    }
    @media only screen and (max-width: 576px) {
        .sidebar-open .main-sidebar, .main-sidebar::before {
            width: 100%;
            font-size: 1.3rem!important;
            padding: 1rem;
        }
        .sidebar-mini .main-sidebar .nav-flat .nav-link, .sidebar-mini-md .main-sidebar .nav-flat .nav-link, .sidebar-mini-xs .main-sidebar .nav-flat .nav-link {
            width: 100%;
            background-color: #780116;
        }
        .nav-link{

        }
        .sop-btm-right{
            text-align:right;
        }
        .hide-on-wide{
            display:block;
        }
        .sidebar-open .sop-btm-right{
            width: 90%;
        }
        .user-panel img {
            width: 80px!important;
            height: 80px!important;;
            width: 100%;
            height: auto;
        }
        .info p {
            color: #000;
            font-weight: 600;

        }
        .info span {
            font-weight: 500!important;
        }
    }
    @media only screen and (min-width: 576px) {
        .hide-on-wide{
            display:none;
        }
        .user-panel img {
            width: 58px!important;
            height: 58px!important;;
            width: 100%;
            height: auto;
        }

    }
    .text-color{
        color: #780116;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function(){
        $("#sop-toggle").click(function(){
            $("body").removeClass("sidebar-open").addClass("sidebar-closed sidebar-collapse");
        });
    });
    function deleteLocalData(){
        // window.localStorage.removeItem('fav');
        // window.localStorage.removeItem('selection');
        // window.localStorage.removeItem('favID');
        // window.localStorage.removeItem('selectionID');
        // window.localStorage.removeItem('discountedID');
    }
</script>
@endpush
