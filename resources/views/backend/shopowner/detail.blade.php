@extends('layouts.backend.backend')
@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.backend.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            @if (Session::has('message'))
                <x-alert>

                </x-alert>
            @endif
            <!-- Content Header (Page header) -->
            <section class="content-header sn-content-header">
                <div class="container-fluid">
                    @foreach ($shopowner as $shopowner)
                    @endforeach


                </div><!-- /.container-fluid -->
            </section>

            {{-- <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section> --}}

            <!-- Main content -->
            <section class="sn-admin-wrapper">
                {{-- <div class="sn-cover-img d-md-none">
                    <img class="img-fluid"
                    src="{{url('/images/banner/'.$shopowner->shop_banner)}}"
                    alt="User profile picture">
                </div> --}}
                <div class="sn-shop-profile">
                    <div class="sn-profile-img">
                        <div class="sn-img-wrap text-center">
                            <img class=" img-fluid img-circle" src="{{ url('images/logo/' . $shopowner->shop_logo) }}"
                                alt="User profile picture">
                            <h3 class="d-none d-md-block profile-username text-center">
                                {{ \Illuminate\Support\Str::limit($shopowner->shop_name, 20, '..') }}

                            </h3>
                            <p class="d-none d-md-block text-muted text-center">
                                {{ \Illuminate\Support\Str::limit($shopowner->name, 20, '..') }}
                            </p>
                        </div>
                    </div>
                    <div class="container sn-shop-general-info mb-4 mb-sm-1">
                        <div class="sn-shop-info-grid text-center">
                            @if (count($products_count_setting) != 0)
                                <div class="">
                                    <a href="{{ route('backside.shop_owner.items.index') }}">
                                        <p>
                                            {{ count($items) }}
                                        </p>
                                        <p
                                            style="
                                                    color: #000;
                                                ">
                                            Products</p>
                                    </a>
                                </div>
                            @endif
                            @if (count($users_count_setting) != 0)
                                <div class="">
                                    <a href="{{ url('backside/shop_owner/users') }}">

                                        <p>

                                            {{ count($managers) }}

                                        </p>
                                        <p
                                            style="
                                            color: #000;
                                        ">
                                            Users</p>
                                    </a>
                                </div>
                            @endif
                            @if (count($items_view_count_setting) != 0)
                                <div class="">
                                    <a href="{{ route('backside.shop_owner.detail.product_view') }}">
                                        <p>{{ count($productclick) }}</p>
                                        <p
                                            style="
                                                    color: #000;
                                                ">
                                            Products View</p>
                                    </a>
                                </div>
                            @endif
                            <!-- Check Premium shop  -->

                            @if (count($shops_view_count_setting) != 0)
                                <div class="">
                                    <a href="{{ route('backside.shop_owner.detail.shop_view') }}">
                                        <p>{{ count($shopview) }}</p>
                                        <p
                                            style="
                                            color: #000;
                                        ">
                                            Shop View</p>
                                    </a>
                                </div>
                            @endif

                            @if (count($unique_product_click_count_setting) != 0)
                                <div class="">
                                    <a href="{{ route('backside.shop_owner.detail.unique_product_view') }}">
                                        <p>{{ count($unique_productclick) }}</p>
                                        <p
                                            style="
                                                color: #000;
                                            ">
                                            Unique Products View</p>
                                    </a>
                                </div>
                            @endif
                            @if (count($buy_now_count_setting) != 0)
                                <div class="">
                                    <a href="{{ route('backside.shop_owner.detail.buy_now_click') }}">
                                        <p>{{ count($buynowclick) }}</p>
                                        <p
                                            style="
                                                color: #000;
                                            ">
                                            Buy Now</p>
                                    </a>
                                </div>
                            @endif
                            @if (count($addtocartclick_count_setting) != 0)
                                <div class="">
                                    <a href="{{ route('backside.shop_owner.detail.unique_add_to_cart_click') }}">
                                        <p>{{ count($addtocartclick) }}</p>
                                        <p
                                            style="
                                                color: #000;
                                            ">
                                            Unique Add To Cart Click</p>
                                    </a>
                                </div>
                            @endif
                            @if (count($whislistclick_count_setting) != 0)
                                <div class="">
                                    <a href="{{ route('backside.shop_owner.detail.unique_whishlist_click') }}">
                                        <p>{{ count($whislistclick) }}</p>
                                        <p
                                            style="
                                                color: #000;
                                            ">
                                            Unique Whishlist Click</p>
                                    </a>
                                </div>
                            @endif
                            @if (count($adsview_count_setting) != 0)
                                <div class="">
                                    <a href="{{ route('backside.shop_owner.detail.unique_ads_view') }}">
                                        <p>{{ count($adsview) }}</p>
                                        <p
                                            style="
                                                color: #000;
                                            ">
                                            Unique Ads View</p>
                                    </a>
                                </div>
                            @endif
                            @if (count($discountview_count_setting) != 0)
                                <div class="">
                                    <a href="{{ route('backside.shop_owner.detail.product_discount_view') }}">
                                        <p>{{ count($discountview) }}</p>
                                        <p
                                            style="
                                                color: #000;
                                            ">
                                            Discount Products View</p>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="sn-purpose mb-4 mb-sm-auto">
                    <h2 class="mb-4 d-sm-none">What's Your Purpose?</h2>
                    <div class="sn-purpose-grid text-center">
                        <a href="{{ url('backside/shop_owner/items/create') }}" class="">
                            <i class="fa fa-plus"></i>
                            <p>Create Item</p>
                        </a>
                        @if (isset(Auth::guard('shop_owner')->user()->id) ||
                                Auth::guard('shop_role')->user()->role_id == 1 ||
                                Auth::guard('shop_role')->user()->role_id == 2)
                            <a href="{{ url('backside/shop_owner/users/create') }}" class="">
                                <i class="fa fa-user-plus"></i>
                                <p>Create User</p>
                            </a>
                        @endif
                        @if (isset(Auth::guard('shop_owner')->user()->id) || Auth::guard('shop_role')->user()->role_id == 1)
                            <a href="{{ route('backside.shop_owner.edit') }}" class="">
                                <i class="fa fa-edit"></i>
                                <p>Edit Shop</p>
                            </a>
                        @endif
                        <a href="#" class="sop-detail-disabled">
                            <i class="fa fa-ad"></i>
                            <p>Ads Create</p>
                        </a>
                        <a href="#" class="sop-detail-disabled">
                            <i class="fa fa-cog"></i>
                            <p>Setting</p>
                        </a>
                    </div>
                </div>
                <div class="sn-update-product mb-1">
                    <div class="sop-update-product px-4 pb-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class=" pt-3">Latest Update Products</h2>
                                <p class=" mb-4">Check your store’s updates</p>
                            </div>

                            <div class="  d-flex justify-content-center align-items-center">
                                <p><a href="{{ url('backside/shop_owner/items') }}" style="font-size: 16px;">All Products
                                        <i class="fas fa-arrow-right"></i></a></p>
                            </div>
                        </div>
                        <table class="table table-borderless table-responsive-sm table-responsive-md">
                            <thead>
                                <tr class="sop-tr-bg">
                                    <td class="">Product</td>
                                    <td class="">Price</td>
                                    <td class="">Code No.</td>
                                    <td class="">Uploaded By</td>
                                    <td class="">Date</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($items)
                                    @if (count($items) != 0)
                                        @foreach ($items->slice(0, 6) as $item)
                                            <tr class="">
                                                <td class="" style="font: 'myanmar3">
                                                    <img class="sop-image-table"
                                                        src="{{ filedopath($item->CheckPhotothumbs) }}" alt=""><br
                                                        class="sop-sm-md"> {{ $item->YkbeautyCat }}
                                                </td>
                                                <td class="">{!! $item->MmPrice !!}</td>
                                                <td class="">{{ $item->product_code }}</td>
                                                @if ($item->UserName == 0)
                                                    <td class="">
                                                        {{ \Illuminate\Support\Str::limit($item->shop_name->name, 10, '..') }}
                                                    </td>
                                                @else
                                                    <td class="">
                                                        {{ \Illuminate\Support\Str::limit($item->UserName, 10, '..') }}</td>
                                                @endif


                                                <td class="">{{ $item->updated_at }}</td>
                                                <td><a href="javascript:void(0)" data-toggle="modal"
                                                        data-target="#quickEditeModal{{ $item->id }}"><i
                                                            class="fas fa-ellipsis-v" style="width:20px"></i></a>
                                                </td>
                                            </tr>
                                            {{-- //modal --}}
                                        @endforeach
                                    @else
                                        <tr colspan="5">
                                            <td>No Item yet</td>
                                        </tr>
                                    @endif
                                @endisset

                            </tbody>
                        </table>
                    </div>
                    @isset($items)
                        @foreach ($items->slice(0, 6) as $item)
                            <div class="modal fade quickEditModal" id="quickEditeModal{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">

                                        <div class="modal-body d-flex flex-column m-3">
                                            <div class="m-2">
                                                <a href="{{ url('backside/shop_owner/items/' . $item->id) }}">
                                                    <div class="d-flex justify-contents-between align-items-center w-100">
                                                        <i class="fas fa-external-link "
                                                            style="font-size: 35px;width:45px"></i>
                                                        <div class="mx-2">
                                                            View Item<br />
                                                            <span>မိမိတင်လိုက်သောပစ္စည်းကိုကြည့်ရန်</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="m-2">
                                                <a href="{{ url('backside/shop_owner/items/' . $item->id . '/edit') }}">
                                                    <div class="d-flex justify-contents-center align-items-center">
                                                        <i class="fas fa-edit" style="font-size: 35px;width:45px"></i>
                                                        <div class="mx-2">
                                                            Edit Item<br />
                                                            <span>မိမိတင်လိုက်သောပစ္စည်းကိုပြန်လည် edit လုပ်ရန်</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="m-2">
                                                <a href="{{ url('backside/shop_owner/item/discount/' . $item->id) }}">
                                                    <div class="d-flex justify-contents-center align-items-center">
                                                        <i class="fas fa-percent" style="font-size: 35px;width:45px"></i>
                                                        <div class="mx-2">
                                                            Discount<br />
                                                            <span>မိမိတင်ထားသောပစ္စည်းကို discount ချရန်</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="m-2 w-100" id="">
                                                <a class="w-100" data-toggle="collapse" href="#collapseQucikEdit"
                                                    role="button" aria-expanded="false" aria-controls="collapseExample">
                                                    <div
                                                        class="d-flex justify-contents-center align-items-center w-100 sop-chevron">
                                                        <i class="fas fa-pencil" style="font-size: 35px ;width:45px"></i>
                                                        <div class="mx-2 w-75">
                                                            Quick Edit<br />
                                                            <span>အမြန်ပြင်ဆင်မှုများပြုလုပ်ရန်</span>
                                                        </div>
                                                        <i id=""
                                                            class="sop-arrow fa-solid fa-chevron-down justify-self-end "></i>
                                                    </div>
                                                </a>
                                                <div class="collapse " id="collapseQucikEdit">
                                                    <div class="my-2 py-3">
                                                        <form action="{{ route('backside.shop_owner.detail.update') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group my-2">
                                                                <div class="d-flex my-2">
                                                                    <input type="hidden" name="id" id=""
                                                                        value="{{ $item->id }}">
                                                                    <div class="col-6">
                                                                        <label for="exampleInputEmail1">Product Code</label>
                                                                        <input type="number"
                                                                            class="form-control input-number" id=""
                                                                            name="product_code" placeholder="Price"
                                                                            value="{{ $item->product_code }}">
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label for="exampleInputEmail1">Stock Count</label>
                                                                        <input type="number"
                                                                            class="form-control input-number" id=""
                                                                            name="stock_count" placeholder="Stock Count"
                                                                            value="{{ $item->stock_count }}">
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex my-2">
                                                                    @if ($item->price != 0)
                                                                        <div class="col-6">
                                                                            <label for="exampleInputEmail1">Price</label>
                                                                            <input type="number"
                                                                                class="form-control input-number"
                                                                                id="" name="price"
                                                                                placeholder="Price"
                                                                                value="{{ $item->price }}">
                                                                        </div>
                                                                    @elseif ($item->max_price != 0)
                                                                        <div class="col-6">
                                                                            <label for="exampleInputEmail1">Min
                                                                                Price</label>
                                                                            <input type="number"
                                                                                class="form-control input-number"
                                                                                id="" name="min_price"
                                                                                placeholder="Min Price"
                                                                                value="{{ $item->min_price }}">
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <label for="exampleInputEmail1">Max
                                                                                Price</label>
                                                                            <input type="number"
                                                                                class="form-control input-number"
                                                                                id="max_price" placeholder="Max Price"
                                                                                value="{{ $item->max_price }}">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end my-3">
                                                                <button type="button" class="btn btn-secondary "
                                                                    data-dismiss="modal">Cancel
                                                                </button>
                                                                <input type="submit" class="btn btn-primary  mx-2"
                                                                    value="Submit">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endisset

                </div>
                <div class="sn-user-list pb-4">
                    <div class="sop-user-list">
                        <h2 class="mb-4 pt-3 px-3">Users List</h2>
                        <ul class="list-group mb-3">
                            @isset($managers)
                                @foreach ($managers->slice(0, 5) as $manager)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div style="width: 70%;text-transform:capitalize;">
                                            <p class="font-weight-bold">
                                                {{ \Illuminate\Support\Str::limit($manager->name, 10, '..') }}</p>
                                        </div>

                                        <div style="width: 30%;text-transform:capitalize;">
                                            <p>{{ $manager->role->name }}</p>
                                        </div>

                                    </li>
                                @endforeach
                            @endisset

                            @if (isset(Auth::guard('shop_owner')->user()->id) ||
                                    Auth::guard('shop_role')->user()->role_id == 2 ||
                                    Auth::guard('shop_role')->user()->role_id == 1)
                                <li class="d-flex justify-content-center"><a
                                        href="{{ url('backside/shop_owner/users/create') }}"
                                        class="btn btn-outline-secondary px-5">Add New User +</a></li>
                            @endif
                        </ul>
                    </div>

                    {{-- <p class="text-right"><a class="text-dark font-weight-bold" href="{{url('backside/shop_owner/users')}}">more</a></p> --}}
                </div>
            </section>

            <section class="content d-none">
                <div class="container-fluid">
                    <div class="">
                        <div class="">

                            <!-- Profile Image -->
                            <div class="">
                                <div class="">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle"
                                            src="{{ url('images/logo/' . $shopowner->shop_logo) }}"
                                            alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center"> {{ $shopowner->name }}</h3>


                                    <p class="text-muted text-center">{{ $shopowner->shop_name }}</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Name</b> <a class="float-right">{{ $shopowner->name }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>ဆိုင် အမည်</b> <a class="float-right">{{ $shopowner->shop_name_myan }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>shop name</b> <a class="float-right">{{ $shopowner->shop_name }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>အထည်မပျက်_ပြန်သွင်း</b> <a
                                                class="float-right">{{ $shopowner->အထည်မပျက်_ပြန်သွင်း }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>တန်ဖိုးမြင့်အထည်</b> <a
                                                class="float-right">{{ $shopowner->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ }}
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>အထည်မပျက်ပြန်လဲ</b> <a
                                                class="float-right">{{ $shopowner->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ }}
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>အထည်ပျက်စီးချို့ယွင်း</b> <a
                                                class="float-right">{{ $shopowner->အထည်ပျက်စီးချို့ယွင်း }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Page Link</b> <a
                                                href="{{ $shopowner->page_link }}">{{ $shopowner->page_link }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Messenger Link</b> <a
                                                href="{{ $shopowner->messenger_link }}">{{ $shopowner->messenger_link }}</a>
                                        </li>
                                        <!-- <li class="list-group-item">
                                                <b>Address</b><br> <a class="text-muted">{{ $shopowner->address }}</a>
                                            </li> -->

                                    </ul>

                                    <div class="row">
                                        <div class="col-12">
                                            @isset(Auth::guard('shop_role')->user()->id)
                                                @if (Auth::guard('shop_role')->user()->role_id == 1)
                                                    <a href="{{ route('backside.shop_owner.edit') }}"
                                                        class="btn btn-primary btn-block"><b><span
                                                                class="fa fa-edit"></span>&nbsp;&nbsp;Edit</b></a>
                                                @elseif(Auth::guard('shop_role')->user()->role_id == 2)
                                                    <a href="{{ route('backside.shop_owner.edit') }}"
                                                        class="btn btn-primary btn-block"><b><span
                                                                class="fa fa-edit"></span>&nbsp;&nbsp;Edit</b></a>
                                                @endif
                                            @endisset

                                            @isset(Auth::guard('shop_owner')->user()->id)
                                                <a href="{{ route('backside.shop_owner.edit') }}"
                                                    class="btn btn-primary btn-block"><b><span
                                                            class="fa fa-edit"></span>&nbsp;&nbsp;Edit</b></a>
                                            @endisset

                                            @isset(Auth::guard('shop_role')->user()->id)
                                                @if (Auth::guard('shop_role')->user()->role_id == 1)
                                                    <a href="{{ route('backside.shop_owner.change.password') }}"
                                                        class="btn btn-primary btn-block"><b><span
                                                                class="fa fa-lock"></span>&nbsp;&nbsp;Edit</b></a>
                                                @elseif(Auth::guard('shop_role')->user()->role_id == 2)
                                                    <a href="{{ route('backside.shop_owner.change.password') }}"
                                                        class="btn btn-primary btn-block"><b><span
                                                                class="fa fa-lock"></span>&nbsp;&nbsp;Edit</b></a>
                                                @endif
                                            @endisset

                                            @isset(Auth::guard('shop_owner')->user()->id)
                                                <a href="{{ route('backside.shop_owner.change.password') }}"
                                                    class="btn btn-primary btn-block"><b><span
                                                            class="fa fa-lock"></span>&nbsp;&nbsp;Edit</b></a>
                                            @endisset
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->


                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <!-- /.post -->

                                            <!-- Post -->
                                            <div class="post">
                                                <div class="user-block">


                                                </div>
                                                <!-- /.user-block -->

                                                @if ($shopowner->premium == 'yes')
                                                    <div class="row mb-3">
                                                        <div class="col-sm-6">
                                                            @if (!empty($shopowner->shop_banner))
                                                                <img class="img-fluid"
                                                                    src="{{ url('images/banner/' . $shopowner->shop_banner) }}"
                                                                    alt="Photo">
                                                            @else
                                                                <?php
                                                                if (\App\ShopBanner::where('shop_owner_id', $shopowner->id)->first()) {
                                                                    $getbanner = \App\ShopBanner::where('shop_owner_id', $shopowner->id)->first()->location;
                                                                } else {
                                                                    $getbanner = 'default.jpg';
                                                                }
                                                                ?>
                                                                <img class="img-fluid"
                                                                    src="{{ url('images/banner/' . $getbanner) }}"
                                                                    alt="Photo">
                                                            @endif
                                                        </div>

                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.row -->
                                                @endif



                                            </div>
                                            <!-- Post -->
                                            <div class="post">
                                                <div class="user-block">

                                                    <p class="font-weight-bold">Description</p>
                                                    <!-- /.user-block -->
                                                    <p>
                                                        {{ $shopowner->description }}
                                                    </p>
                                                    <p class="font-weight-bold">
                                                        Address
                                                    </p>
                                                    <p>
                                                        {{ $shopowner->address }}
                                                    </p>
                                                    <p class="font-weight-bold">
                                                        Phone No
                                                    </p>
                                                    <p>
                                                        {{ $shopowner->main_phone }}
                                                    </p>


                                                </div>

                                            </div>

                                            <!-- /.post -->
                                            <!-- /.post -->
                                        </div>
                                        <!-- /.tab-pane -->
                                        {{-- <div class="tab-pane" id="timeline">
                                            <!-- The timeline -->
                                            <div class="timeline timeline-inverse">
                                                <!-- timeline time label -->
                                                <div class="time-label">
                                                    <span class="bg-danger">
                                                        10 Feb. 2014
                                                    </span>
                                                </div>
                                                <!-- /.timeline-label -->
                                                <!-- timeline item -->
                                                <div>
                                                    <i class="fas fa-envelope bg-primary"></i>

                                                    <div class="timeline-item">
                                                        <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent
                                                            you an email</h3>

                                                            <div class="timeline-body">
                                                                Etsy doostang zoodles disqus groupon greplin oooj voxy
                                                                zoodles,
                                                                weebly ning heekya handango imeem plugg dopplr jibjab,
                                                                movity
                                                                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo
                                                                kaboodle
                                                                quora plaxo ideeli hulu weebly balihoo...
                                                            </div>
                                                            <div class="timeline-footer">
                                                                <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                                <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END timeline item -->
                                                    <!-- timeline item -->
                                                    <div>
                                                        <i class="fas fa-user bg-info"></i>

                                                        <div class="timeline-item">

                                                            <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                                            <h3 class="timeline-header"><a href="#">Support Team</a> sent
                                                                you an email</h3>

                                                                <div class="timeline-body">
                                                                    Etsy doostang zoodles disqus groupon greplin oooj voxy
                                                                    zoodles,
                                                                    weebly ning heekya handango imeem plugg dopplr jibjab,
                                                                    movity
                                                                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo
                                                                    kaboodle
                                                                    quora plaxo ideeli hulu weebly balihoo...
                                                                </div>
                                                                <div class="timeline-footer">
                                                                    <a href="#" class="btn btn-primary btn-sm">... See more</a>
                                                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END timeline item -->
                                                        <!-- timeline item -->
                                                        <div>
                                                            <i class="fas fa-comments bg-warning"></i>

                                                            <div class="timeline-item">
                                                                <span class="time"><i
                                                                    class="far fa-clock"></i> 27 mins ago</span>

                                                                    <h3 class="timeline-header"><a href="#">Jay White</a> commented
                                                                        on your post</h3>

                                                                        <div class="timeline-body">
                                                                            Take me to your leader!
                                                                            Switzerland is small and neutral!
                                                                            We are more like Germany, ambitious and misunderstood!
                                                                        </div>
                                                                        <div class="timeline-footer">
                                                                            <a href="#" class="btn btn-warning btn-flat btn-sm">View
                                                                                comment</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- END timeline item -->
                                                                    <!-- timeline time label -->
                                                                    <div class="time-label">
                                                                        <span class="bg-success">
                                                                            3 Jan. 2014
                                                                        </span>
                                                                    </div>
                                                                    <!-- /.timeline-label -->
                                                                    <!-- timeline item -->
                                                                    <div>
                                                                        <i class="fas fa-camera bg-purple"></i>

                                                                        <div class="timeline-item">
                                                                            <span class="time"><i
                                                                                class="far fa-clock"></i> 2 days ago</span>

                                                                                <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded
                                                                                    new photos</h3>

                                                                                    <div class="timeline-body">
                                                                                        {{--                              //this code will take more loading time --}}
                                        {{--                            <img src="https://placehold.it/150x100" alt="..."> --}}
                                        {{--                            <img src="https://placehold.it/150x100" alt="..."> --}}
                                        {{--                            <img src="https://placehold.it/150x100" alt="..."> --}}
                                        {{--                            <img src="https://placehold.it/150x100" alt="..."> --}}
                                        {{--                              //this code will take more loading time --}}

                                    </div>
                                </div>
                            </div>
                            <!-- END timeline item -->
                            <div>
                                <i class="far fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    {{-- <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputName"
                                placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail"
                            class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail"
                                placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName2"
                                placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="inputExperience"
                                placeholder="Experience"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSkills"
                            class="col-sm-2 col-form-label">Skills</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputSkills"
                                placeholder="Skills">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> I agree to the <a href="#">terms
                                            and conditions</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
        </div><!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>
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
    <style>
        body {
            background: #F0F7FA;
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .sn-user-list {
            margin: 20px;

        }

        .sn-shop-info-grid p {
            margin-bottom: 3px;
            line-height: 20px !important;
        }

        .sop-detail-disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        .sop-update-product p {
            font-size: 18px;
            color: #636363;
        }

        .sop-user-list {
            background-color: #fff;
            box-shadow: 0px 0px 4px 1px #efefef;
        }

        .sn-update-product {
            margin: 20px;
        }

        .sop-update-product {
            background-color: #fff;
            box-shadow: 0px 0px 4px 1px #efefef;
        }

        .sop-tr-bg {
            background-color: #F8F8F8;
            border-radius: 3px;
        }

        .sop-tr-bg td:first-child,
        th:first-child {
            border-radius: 10px 0 0 10px;
        }

        .sop-tr-bg td:last-child,
        th:last-child {
            border-radius: 0 10px 10px 0;
        }

        .sop-image-table {
            height: 35px;
            width: 35px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 3px;
        }

        .sn-shop-profile {
            height: auto;
            background: #fff;
            border-radius: 3px;
            box-shadow: 0px 0px 4px 1px #efefef;
        }

        .quickEditModal {
            color: black !important;
        }

        .quickEditModal a {
            color: black !important;
        }


        @media only screen and (max-width: 768px) {
            .sn-shop-profile {
                padding: 20px 0 10px 0;
                margin: 20px;
            }

            .sop-sm-md {
                display: block;
            }
        }

        @media only screen and (min-width: 768px) {

            .sn-shop-profile {
                padding: 20px 0 10px 0;
                margin: 20px;
            }

            .sn-update-product {
                margin: 18px;
            }

            .sn-user-list {
                margin: 18px;
            }

            .sop-sm-md {
                display: none;
            }
        }

        @media only screen and (max-width: 1200px) {
            .sn-purpose .sn-purpose-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                margin: 0 10px;
            }
        }

        @media only screen and (min-width: 1200px) {

            .sn-admin-wrapper {
                display: grid;
                grid-template-rows: 135.4px 320px;
                gap: 15px;
                margin: 15px;
            }

            .sn-shop-profile {
                grid-column: 3;
                grid-row: span 2;
                margin: 0;
                height: auto;
            }

            .sn-purpose {
                grid-column: span 2;
                grid-row: 1;

            }

            .sn-purpose .sn-purpose-grid {
                display: grid;
                grid-template-columns: repeat(5, 1fr);

                gap: 5px;
            }

            .sn-purpose a {
                margin: 0;
                box-shadow: 0px 0px 4px 1px #efefef;
            }

            .sn-shop-profile {

                padding: 20px 0 10px 0;

            }

            .sn-purpose a {
                margin: 0px;
                padding: 40px 0;
                cursor: pointer;
            }

            .sn-update-product {
                /* margin-left: 23px; */
                grid-column: span 2;
                grid-row: 2/span 2;
                /* margin-right: 3px; */
            }

            .sn-update-product {
                margin: 0;
            }

            .sn-user-list {
                margin: 0;
            }

        }

        .collapsing {

            height: 0;
            overflow: hidden;
            -webkit-transition-property: height, visibility;
            transition-property: height, visibility;
            -webkit-transition-duration: 0.35s;
            transition-duration: 0.35s;
            -webkit-transition-timing-function: ease;
            transition-timing-function: ease;
        }
    </style>
@endpush

@push('scripts')
    <script>
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
        $(document).ready(function() {
            $(".sop-chevron").click(function() {
                $(".sop-arrow").toggleClass('fa-chevron-up fa-chevron-down ');
            });
        });
        document.querySelector(".input-number").addEventListener("keypress", function(evt) {
            if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
                evt.preventDefault();
            }
        });
    </script>
@endpush
