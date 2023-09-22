@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Shop Detail')

@section('content')
    @include('backend.super_admin.navbar')
    @include('backend.super_admin.sidebar')
    <div class="wrapper">
        <section class="content-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-6 p-4">
                        <!--Main Title-->
                        <div class="d-lg-flex align-items-center justify-content-between mb-5">
                            <div class="d-lg-flex d-md-flex align-items-center">
                                <div class="detail_logo mx-auto">
                                    <img src="{{ url('images/logo/' . $shop->shop_logo) }}" alt=""
                                        class="rounded-circle">
                                </div>
                                <div class="ml-md-3 mt-3 mt-lg-0 text-center">
                                    <p class="h5">{{ $shop->shop_name }}</p>
                                    @isset($shop->shop_name_myan)
                                        <span class="mm-font">( {{ $shop->shop_name_myan }} )</span>
                                    @endisset
                                </div>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                @if ($shop->premium == 'yes')
                                    <div class="bg-gradient-orange px-2 py-1 text-white">
                                        <i class="fa fa-star"></i>
                                        <span class="">Premium</span>
                                    </div>
                                    <div class="bg-gradient-orange px-2 py-1 mt-3 text-white">
                                        <i class="fa fa-tag" aria-hidden="true"></i>
                                        <span class="">{{ $premium_template->name }}</span>
                                    </div>

                                @else
                                    <div class="bg-gradient-orange px-2 py-1 text-white">
                                        <span>Normal</span>
                                    </div>
                                @endif
                            </div>

                        </div>
                        <!-- Description -->
                        <div class="p-4 shadow-sm rounded-3 mb-4">
                            <div class=" " style="word-break: break-word">
                                <h5 class="h5 font-weight-bold mb-2">Shop Description</h5>
                                <p class="mb-2 content animation">{!! $shop->description !!}</p>
                                <div class="txtcol mb-4"><a>... See More</a></div>

                            </div>
                            <div class="pb-4">
                                <h5 class="h5 font-weight-bold mb-2">Shop Address</h5>
                                <div style="word-break: break-word">
                                    <p class="content animation mb-2">{!! $shop->address !!}</p>
                                    <div class="txtcol mb-4"><a>... See More</a></div>
                                </div>
                            </div>
                        </div>
                        <!--Extra Information-->
                        <div class="p-4 shadow-sm rounded-3 mb-5">
                            <h5 class="h5 font-weight-bold mb-4">Extra Information</h5>
                            <div>
                                <div class="mb-2 d-flex justify-content-between">
                                    <span class="mm-font">အထည်မပျက် ပြန်သွင်း : </span>
                                    <span class="font-weight-bold">{{ $shop->undamaged_product }} %</span>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    <span class="mm-font">တန်ဖိုးမြင့်အထည် နှင့် အထည်မပျက်ပြန်လဲ : </span>
                                    <span class="font-weight-bold">{{ $shop->valuable_product }}
                                        %</span>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    <span class="mm-font">အထည်ပျက်စီး ချို့ယွင်း : </span>
                                    <span class="font-weight-bold">{{ $shop->damaged_product }} %</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 border col-md-6 p-4">
                        <!--Shop Information-->
                        <div class="p-4 shadow-sm rounded-3 mb-4">
                            <h5 class="h5 font-weight-bold mb-2">Shop Information</h5>
                            <p>{{ $shop->shop_name }}</p>
                            <hr>
                            <div class="mb-3">
                                <p class="mb-1">Facebook Page Link : </p>
                                <a href="{{ $shop->page_link }}"><u>
                                        {{ $shop->shop_name }} Facebook</u>
                                </a>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1">Messenger Link : </p>
                                <a href="{{ $shop->messenger_link }}"><u>
                                        {{ $shop->shop_name }} Messenger</u>
                                </a>
                            </div>
                            <div class="main-phone mb-3">
                                <p class="mb-1">Main Phone : </p>
                                <span> {{ $shop->main_phone }}</span>
                            </div>

                        </div>
                        <div class="p-4 shadow-sm rounded-3 mb-4">
                            <h5 class="h5 font-weight-bold mb-2">Features</h5>
                            <hr>
                            <form class="option">
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div>All</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="all" class="custom-control-input"
                                                id="settingToggle">
                                            <label class="custom-control-label" id="statusText" for="settingToggle"></label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-group">

                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div> Products Counts</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="items" class="custom-control-input"
                                                id="settingToggle1">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle1"></label>
                                        </div>
                                    </li>

                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div>Users Counts</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="user_counts" class="custom-control-input"
                                                id="settingToggle2">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle2"></label>
                                        </div>
                                    </li>

                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div>User Inquiry</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="user_inquiry" class="custom-control-input"
                                                id="settingToggle11">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle11"></label>
                                        </div>
                                    </li>

                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div> Shops View Counts</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="shop_view" class="custom-control-input"
                                                id="settingToggle3">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle3"></label>
                                        </div>
                                    </li>

                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div> Products View Counts</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="products_view" class="custom-control-input"
                                                id="settingToggle4">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle4"></label>
                                        </div>
                                    </li>

                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div> Unique Products View</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="unique_products_view"
                                                class="custom-control-input" id="settingToggle5">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle5"></label>
                                        </div>
                                    </li>

                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div> Buy Now Click Counts</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="buy_now_click" class="custom-control-input"
                                                id="settingToggle6">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle6"></label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div> Add To Cart Click Counts</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="addToCartClickView" class="custom-control-input"
                                                id="settingToggle7">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle7"></label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div> Unique Whishlist Click</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="UniqueWhishlistClick"
                                                class="custom-control-input" id="settingToggle8">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle8"></label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-group ">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div> Unique ads View</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="UniqueAdsView" class="custom-control-input"
                                                id="settingToggle9">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle9"></label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div> Discount Products View</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="discount" class="custom-control-input"
                                                id="settingToggle10">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle10"></label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent">
                                        <div>POS ON</div>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" id="{{ $shop->id }}">
                                            <input type="checkbox" name="poson" class="custom-control-input"
                                                id="settingToggle111">
                                            <label class="custom-control-label" id="statusText"
                                                for="settingToggle111"></label>
                                        </div>
                                    </li>
                                </ul>
                            </form>
                        </div>
                        <div class="p-3">
                            <a href="{{ route('backside.super_admin.shop.monthly_report', $shop->id) }}"> View Monthly Report </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <style>
        .container {
            background-color: #fff;
        }

        .detail_logo {
            width: 100px;
        }

        .detail_logo img {
            width: 100px;
            height: 100px;
        }

        .content {
            /* width:100px; */
            overflow: hidden;
            white-space: normal;
            text-overflow: ellipsis;
            line-height: 1.5em;
            max-height: 4.5em;
        }

        .txtcol {
            display: none;
            cursor: pointer;
            opacity: 0.8;

        }

        .animation {
            transition: 0.5s ease-in-out;
        }

        .truncate {
            transition: 0.5s ease-in-out;
        }

        .report-container {
            display: none;
        }

        .report-gradient {
            height: 300px;
            background: #C33764;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #C33764, #1D2671);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #C33764, #1D2671);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

        .report-title {
            height: 100px;
        }

        .report-title img {
            width: 100px;
            height: 100px;
        }

        .report-shweshop-logo {
            height: 50px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var all_count_setting = {!! json_encode($all) !!};
        var products_count_setting = {!! json_encode($products_count_setting) !!};
        var users_count_setting = {!! json_encode($users_count_setting) !!};
        var users_inquiry_setting = {!! json_encode($users_inquiry_setting) !!};
        var shops_view_count_setting = {!! json_encode($shops_view_count_setting) !!};
        var items_view_count_setting = {!! json_encode($items_view_count_setting) !!}
        var unique_product_click_count_setting = {!! json_encode($unique_product_click_count_setting) !!};
        var buy_now_count_setting = {!! json_encode($buy_now_count_setting) !!};
        var addtocartclick_count_setting = {!! json_encode($addtocartclick_count_setting) !!};
        var whislistclick_count_setting = {!! json_encode($whislistclick_count_setting) !!};
        var discountview_count_setting = {!! json_encode($discountview_count_setting) !!};
        var adsview_count_setting = {!! json_encode($adsview_count_setting) !!};
        var poson_ini = {!! json_encode($poson) !!};

        var all = $('[name="all"]');
        var items = $('[name="items"]');
        var usersView = $('[name="user_counts"]');
        var userInquiry = $('[name="user_inquiry"]');
        var shopView = $('[name="shop_view"]');
        var productsView = $('[name="products_view"]');
        var UniqueProductsView = $('[name="unique_products_view"]');
        var BuyNowClickView = $('[name="buy_now_click"]');
        var addToCartClickView = $('[name="addToCartClickView"]');
        var UniqueWhishlistClick = $('[name="UniqueWhishlistClick"]');
        var UniqueAdsView = $('[name="UniqueAdsView"]');
        var DiscountProductsView = $('[name="discount"]');
        var UniqueAdsView = $('[name="UniqueAdsView"]');
        var poson = $('[name="poson"]');

        all.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            if (this.checked) {
                $("form input:checkbox").prop("checked", true);
                action = 1;
            } else {
                $("form input:checkbox").prop("checked", false);
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action_all') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                },
            });

        });
        items.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;

            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 0,
                },

            });
        });

        usersView.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;
            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 1,
                },

            });


        });
        shopView.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;
            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 2,
                },

            });
        });
        productsView.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;
            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 3,
                },

            });
        });
        UniqueProductsView.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;
            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 4,
                },

            });
        });
        BuyNowClickView.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;
            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 5,
                },

            });
        });
        addToCartClickView.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;
            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 6,
                },

            });
        });
        UniqueWhishlistClick.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;
            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 7,
                },

            });
        });
        DiscountProductsView.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;
            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 8,
                },

            });
        });
        UniqueAdsView.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;
            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 9,
                },

            });
        });
        poson.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;
            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 111,
                },

            });
        });

        userInquiry.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = 1;
            } else {
                action = 0;
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.shops.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                    setting: 10,
                },

            });


        });

        if (all_count_setting.length > 0) {

            $(all).prop('checked', true);
        } else {

            $(all).prop('checked', false);
        }

        if (products_count_setting.length > 0) {
            $(items).prop('checked', true);
        } else {
            $(items).prop('checked', false);
        }
        if (poson_ini.length > 0) {
            $(poson).prop('checked', true);
        } else {
            $(poson).prop('checked', false);
        }
        if (users_count_setting.length > 0) {
            $(usersView).prop('checked', true);
        } else {
            $(usersView).prop('checked', false);
        }

        if (shops_view_count_setting.length > 0) {
            $(shopView).prop('checked', true);
        } else {
            $(shopView).prop('checked', false);
        }
        if (items_view_count_setting.length > 0) {
            $(productsView).prop('checked', true);

        } else {
            $(productsView).prop('checked', false);
        }
        if (unique_product_click_count_setting.length > 0) {
            $(UniqueProductsView).prop('checked', true);

        } else {
            $(UniqueProductsView).prop('checked', false);
        }

        if (buy_now_count_setting.length > 0) {
            $(BuyNowClickView).prop('checked', true);

        } else {
            $(BuyNowClickView).prop('checked', false);
        }

        if (addtocartclick_count_setting.length > 0) {
            $(addToCartClickView).prop('checked', true);

        } else {
            $(addToCartClickView).prop('checked', false);
        }

        if (whislistclick_count_setting.length > 0) {
            $(UniqueWhishlistClick).prop('checked', true);

        } else {
            $(UniqueWhishlistClick).prop('checked', false);
        }

        if (adsview_count_setting.length > 0) {
            $(UniqueAdsView).prop('checked', true);

        } else {
            $(UniqueAdsView).prop('checked', false);
        }

        if (discountview_count_setting.length > 0) {
            $(DiscountProductsView).prop('checked', true);

        } else {
            $(DiscountProductsView).prop('checked', false);
        }

        if (users_inquiry_setting.length > 0) {
            $(userInquiry).prop('checked', true);

        } else {
            $(userInquiry).prop('checked', false);
        }




        $(document).ready(function() {
            $(".content").each(function() {
                let height = Math.ceil($(this).height()) + 1;
                let overflow_height = $(this)[0].scrollHeight;
                // console.log(height);
                // console.log(overflow_height);
                if (height < overflow_height) {

                    $(this).parent().find(".txtcol").show();
                    $(this).toggleClass("truncate").toggleClass("animation");
                }
            });
            $(".txtcol").click(function() {
                if ($(this).prev().hasClass("truncate")) {
                    $(this).parent().find(".content").css("max-height", $(this).parent().find(".content")[0]
                        .scrollHeight);
                    $(this).children('a').text("See Less");
                } else {
                    $(this).parent().find(".content").css("max-height", "4.2em");
                    $(this).children('a').text("... See More");
                }
                $(this).prev().toggleClass("truncate").toggleClass("animation");

            });
        });
    </script>
@endpush
