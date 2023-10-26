<header id="masthead" class="site-header ">

    <div class="ftc-header-template header-ftc-element">
        <div class="header-mobile" style="height:62px !important;">
            <div class="mobile-button">
                <div class="mobile-nav">
                    <span aria-hidden="true" class="fas fa-bars" style="color:#780117 !important; font-size:24px;"></span>
                </div>
            </div>

            <div class="logo-wrapper is-mobile">
                <div class="logo" style="font-family: sans-serif">
                    <a href="/">
                        <h3 style="color:#780117; font-family: 'Gabriela', Sans-Serif !important; font-weight:bolder">
                            SHWESHOPS</h3>
                    </a>
                </div>
            </div>

            {{-- <div class="elementor-widget-container is-mobile d-flex"> --}}
            @if (isset(Auth::guard('web')->user()->id) || isset(Auth::guard('shop_owners_and_staffs')->user()->id))

                <div class="ftc-cart-element is-mobile mt-1 me-4">

                    <div class="ftc-tini-cart">
                        <div class="cart-item">
                            <a href="" data-toggle="modal" data-target="#notiModal">
                                <i class="fa-solid fa-bell fa-xl" style="color:#6f6a6a"></i>
                            </a>

                        </div>
                    </div>
                </div>
            @endif

            <div class="ftc-cart-element is-mobile">
                <i class=""></i>
                <div class="ftc-tini-cart">
                    <div class="cart-item">
                        <a href="{{ url('myfav/see_all') }}">
                            <div class="cart-total">

                                <i id="" class="fa-regular fa-heart fa-xl windowFavNav"
                                    style="color:rgb(167 6 6) !important"></i>
                                {{-- <span id="favw-a2c-count" class="sop-cart-count">0</span> --}}
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            {{-- </div> --}}



        </div>

        <div class="header-content">
            {{-- container --}}
            <div class="">
                <div data-elementor-type="wp-post" data-elementor-id="13125" class="elementor elementor-13125"
                    data-elementor-settings="[]">
                    <div class="elementor-section-wrap">

                        <section
                            class="pt-xl-2 pb-xl-3 pt-lg-1 pb-lg-2 elementor-section elementor-top-section elementor-element elementor-element-6fc1126d elementor-section-full_width elementor-section-stretched elementor-section-height-default elementor-section-height-default selection-is-not-sticked"
                            data-id="6fc1126d" data-element_type="section"
                            data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="px-lg-3 mx-lg-3 elementor-container elementor-column-gap-extended">

                                <div class="elementor-column elementor-col-20 elementor-top-column elementor-element elementor-element-32c3785c"
                                    data-id="32c3785c" data-element_type="column" style="flex-grow: 5;">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-15a73719 mme-hover-style-background elementor-nav-menu--indicator-classic elementor-nav-menu--dropdown-tablet elementor-nav-menu__text-align-aside elementor-nav-menu--toggle elementor-nav-menu--burger elementor-widget elementor-widget-ftc-nav"
                                            data-id="15a73719" data-element_type="widget"
                                            data-settings="{&quot;layout&quot;:&quot;horizontal&quot;,&quot;toggle&quot;:&quot;burger&quot;}"
                                            data-widget_type="ftc-nav.default">
                                            <div class="elementor-widget-container">
                                                <nav id="site-navigation" class="main-navigation" aria-label="">

                                                    <!-- begin "mega_main_menu" -->
                                                    <div id="primary"
                                                        class="mega_main_menu primary primary_style-flat icons-left first-lvl-align-center first-lvl-separator-none direction-horizontal fullwidth-disable pushing_content-disable mobile_minimized-enable dropdowns_trigger-hover dropdowns_animation-none no-search no-woo_cart no-buddypress responsive-enable coercive_styles-disable indefinite_location_mode-disable language_direction-ltr version-2-2-1 mega_main">
                                                        <div class="menu_holder">
                                                            <div class="mmm_fullwidth_container"></div>
                                                            <!-- class="fullwidth_container" -->
                                                            <div class="menu_inner" role="navigation">
                                                                <ul id="main_ul-primary"
                                                                    class="mega_main_menu_ul d-flex" role="menubar"
                                                                    aria-label="Menu">
                                                                    <li style="margin-right: 5px;"
                                                                        class="home-demo menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-has-children menu-item-8660 multicolumn_dropdown default_style drop_to_right submenu_default_width columns5">
                                                                        <a href="{{ url('/') }}"
                                                                            class="item_link   disable_icon"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            role="menuitem" tabindex="0">
                                                                            <i class=""></i>
                                                                            <span class="link_content">
                                                                                <span class="link_text yk_link_content">
                                                                                    Home
                                                                                </span><!-- /.link_text -->
                                                                            </span><!-- /.link_content -->
                                                                        </a><!-- /.item_link  -->
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8260 multicolumn_dropdown default_style drop_to_right submenu_full_width columns5">
                                                                        <a href="\shops" class="item_link disable_icon"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            role="menuitem" tabindex="0">
                                                                            <i class=""></i>
                                                                            <span class="link_content">
                                                                                <span class="link_text yk_link_content">
                                                                                    Shops
                                                                                </span><!-- /.link_text -->
                                                                            </span><!-- /.link_content -->
                                                                        </a><!-- /.item_link  -->

                                                                    </li>
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8260 multicolumn_dropdown default_style drop_to_right submenu_full_width columns5">
                                                                        <a href="{{ url('see_by_categories') }}"
                                                                            class="item_link   disable_icon"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            role="menuitem" tabindex="0">
                                                                            <i class=""></i>
                                                                            <span class="link_content">
                                                                                <span class="link_text yk_link_content">
                                                                                    Products
                                                                                </span><!-- /.link_text -->
                                                                            </span><!-- /.link_content -->
                                                                        </a><!-- /.item_link  -->
                                                                    </li>

                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-8299 default_dropdown  drop_to_right submenu_default_width columns1">
                                                                        <a href="{{ url('/news') }}"
                                                                            class="item_link" aria-haspopup="true"
                                                                            aria-expanded="false" role="menuitem"
                                                                            tabindex="0">
                                                                            <i class=""></i>
                                                                            <span class="link_content ">
                                                                                <span
                                                                                    class="link_text yk_link_content">
                                                                                    News&nbsp;&&nbsp;Events
                                                                                </span><!-- /.link_text -->
                                                                            </span><!-- /.link_content -->
                                                                        </a><!-- /.item_link  -->
                                                                    </li>
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8260 multicolumn_dropdown default_style drop_to_right submenu_full_width columns5">
                                                                        <a href="{{ url('contact-us') }}"
                                                                            class="item_link " aria-haspopup="true"
                                                                            aria-expanded="false" role="menuitem"
                                                                            tabindex="0">
                                                                            <i class=""></i>
                                                                            <span class="link_content">
                                                                                <span
                                                                                    class="link_text yk_link_content">
                                                                                    Contact&nbsp;Us
                                                                                </span><!-- /.link_text -->
                                                                            </span><!-- /.link_content -->
                                                                        </a><!-- /.item_link  -->
                                                                    </li>
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8260 multicolumn_dropdown default_style drop_to_right submenu_full_width columns5">
                                                                        <a href="{{ url('support') }}"
                                                                            class="item_link " aria-haspopup="true"
                                                                            aria-expanded="false" role="menuitem"
                                                                            tabindex="0">
                                                                            <i class=""></i>
                                                                            <span class="link_content"
                                                                                style="width: 125px;">
                                                                                <span
                                                                                    class="link_text yk_link_content">
                                                                                    Help & Support
                                                                                </span><!-- /.link_text -->
                                                                            </span><!-- /.link_content -->
                                                                        </a><!-- /.item_link  -->
                                                                    </li>

                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8260 multicolumn_dropdown default_style drop_to_right submenu_full_width columns5">
                                                                        <a href="{{ url('directory/all') }}"
                                                                            class="item_link " aria-haspopup="true"
                                                                            aria-expanded="false" role="menuitem"
                                                                            tabindex="0">
                                                                            <i class=""></i>
                                                                            <span class="link_content"
                                                                                style="width: 125px;">
                                                                                <span
                                                                                    class="link_text yk_link_content">
                                                                                    Shop Directory
                                                                                </span><!-- /.link_text -->
                                                                            </span><!-- /.link_content -->
                                                                        </a><!-- /.item_link  -->
                                                                    </li>



                                                                    {{-- <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8260 multicolumn_dropdown default_style drop_to_right submenu_full_width columns5">
                                                                    <a href="{{url('see_all_discount/all')}}"
                                                                        class="item_link   disable_icon"
                                                                        aria-haspopup="true"
                                                                        aria-expanded="false" role="menuitem"
                                                                        tabindex="0">
                                                                        <i class=""></i>
                                                                        <span class="link_content">
                                                                            <span class="link_text yk_link_content">
                                                                                Promotions
                                                                            </span><!-- /.link_text -->
                                                                        </span><!-- /.link_content -->
                                                                    </a><!-- /.item_link  -->
                                                                </li> --}}
                                                                    <!-- /.mega_dropdown -->

                                                                </ul>
                                                            </div><!-- /class="menu_inner" -->
                                                        </div><!-- /class="menu_holder" -->
                                                    </div><!-- /id="mega_main_menu" -->
                                                </nav>
                                                <!-- #site-navigation -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Search Bar --}}
                                @if (!empty($display) && $display == 'product')
                                    <div>
                                        <form action="" id="productSearchForm">
                                            <div class="d-flex align-items-center">
                                                {{-- <i class="fa-solid fa-search"></i> --}}
                                                <svg class="fa-search" viewBox="0 0 20 20">
                                                    <path fill="none"
                                                        d="M18.109,17.776l-3.082-3.081c-0.059-0.059-0.135-0.077-0.211-0.087c1.373-1.38,2.221-3.28,2.221-5.379c0-4.212-3.414-7.626-7.625-7.626c-4.212,0-7.626,3.414-7.626,7.626s3.414,7.627,7.626,7.627c1.918,0,3.665-0.713,5.004-1.882c0.006,0.085,0.033,0.17,0.098,0.234l3.082,3.081c0.143,0.142,0.371,0.142,0.514,0C18.25,18.148,18.25,17.918,18.109,17.776zM9.412,16.13c-3.811,0-6.9-3.089-6.9-6.9c0-3.81,3.089-6.899,6.9-6.899c3.811,0,6.901,3.09,6.901,6.899C16.312,13.041,13.223,16.13,9.412,16.13z">
                                                    </path>
                                                </svg>
                                                <input class="" type="text" id="productSearchText"
                                                    placeholder="Productများရှာဖွေပါ" value="">
                                                <button class="product-search-button" type="submit">Go</button>

                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <div class="d-flex align-items-end">
                                        <form action="" id="searchform">
                                            <div class="cart-total d-flex align-items-end position-relative">
                                                <input class="sop-search" type="text" id="searchText"
                                                    placeholder="Search" value="">
                                                <button type="submit" class="sop-search-btm fa-solid fa-search px-2 "
                                                    style="font-size:1rem;opacity:0.9;color:#780116;position: absolute;right: 5px;top: -4px;"></button>

                                            </div>
                                        </form>
                                    </div>
                                @endif

                                {{-- Search Bar --}}

                                <div class="align-items-end elementor-column elementor-col-20 elementor-top-column elementor-element elementor-element-6aab2496"
                                    data-id="6aab2496" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-46ef4145 elementor-widget elementor-widget-ftc_shooping_cart"
                                            data-id="46ef4145" data-element_type="widget"
                                            data-widget_type="ftc_shooping_cart.default">
                                            <div class="elementor-widget-container">
                                                <div class="ftc-cart-element text-center">
                                                    <i class=""></i>
                                                    <div class="ftc-tini-cart">
                                                        <div class="cart-item">
                                                            <a href="{{ url('mycart/see_all') }}">
                                                                <div class="cart-total">

                                                                    <i id="windowA2cNav"
                                                                        class="fa-solid fa-shopping-bag fa-xl"
                                                                        style="color:#1B1A17"></i>
                                                                    <span id="cart_count"
                                                                        class="sop-cart-count">0</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-items-end elementor-column elementor-col-20 elementor-top-column elementor-element elementor-element-6aab2496"
                                    data-id="6aab2496" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-46ef4145 elementor-widget elementor-widget-ftc_shooping_cart"
                                            data-id="46ef4145" data-element_type="widget"
                                            data-widget_type="ftc_shooping_cart.default">

                                            <div class="elementor-widget-container">
                                                <div class="ftc-cart-element">
                                                    <i class=""></i>
                                                    <div class="ftc-tini-cart">
                                                        <div class="cart-item">
                                                            <a href="{{ url('myfav/see_all') }}">
                                                                <div class="cart-total">

                                                                    <i
                                                                        class="fa-regular fa-heart fa-xl windowFavNav"
                                                                        style="color:#780116!important"></i>
                                                                    {{-- <span id="favw-a2c-count" class="sop-cart-count">0</span> --}}
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>
                        {{-- <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-623f2d7b elementor-section-boxed elementor-section-height-default elementor-section-height-default selection-is-not-sticked"
                            data-id="623f2d7b" data-element_type="section">
                            <div class="elementor-container elementor-column-gap-default">
                                <div
                                class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-62a59e30"
                                data-id="62a59e30" data-element_type="column">
                                <div class="elementor-widget-wrap elementor-element-populated">
                                    <div
                                    class="elementor-element elementor-element-1216fcab elementor-widget elementor-widget-html"
                                    data-id="1216fcab" data-element_type="widget"
                                    data-widget_type="html.default">
                                    <div class="elementor-widget-container">
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </section> --}}
                    </div>
                </div>
            </div>
        </div>

    </div>

</header><!-- #masthead -->
@push('scripts')
@endpush

@push('custom-scripts')
    <script>
        $(document).ready(function() {
            if (typeof localStorage.getItem('cart') !== 'undefined' && localStorage.getItem('cart') !== null) {

                let tmpcartcount = JSON.parse(localStorage.getItem('cart')).length;
                if (tmpcartcount > 10) {
                    $('#cart_count').html("10+");

                } else {
                    $('#cart_count').html(JSON.parse(localStorage.getItem('cart')).length);

                }
            }
            if (typeof localStorage.getItem('favourite') !== 'undefined' && localStorage.getItem('favourite') !==
                null) {
                let tmpfavcount = JSON.parse(localStorage.getItem('favourite')).length;
                if (tmpfavcount > 0) {
                    $('.windowFavNav').removeClass("fa-regular");
                    $('.windowFavNav').addClass("fa-solid");
                } else {
                    $('.windowFavNav').removeClass("fa-solid");
                    $('.windowFavNav').addClass("fa-regular");
                }



            } else {
                $('.windowFavNav').removeClass("fa-solid");
                $('.windowFavNav').addClass("fa-regular");
            }


            if (window.localStorage.getItem('searchtext') != undefined) {
                $('#productSearchText').val(window.localStorage.getItem('searchtext'));
            } else {
                $('#productSearchText').val('');
            }
            //for search form
            $("#searchform").submit(function(event) {
                var inputval = $('#searchText').val();
                window.localStorage.setItem('searchtext', inputval);
                event.preventDefault();
                return location.assign("{{ url('ajax_search_result') }}" + '/' + inputval);
            });
            $('#productSearchForm').submit(function(event) {
                var inputval = $('#productSearchText').val();
                window.localStorage.setItem('productSearchtext', inputval);
                event.preventDefault();
                return location.assign("{{ url('ajax_search_result') }}" + '/' + inputval);
            });

            //for search form
            // trigger buynow fav function
            if ($("#navw-a2c-count").length) {
                ifChosenSelectionLength();
            }
            // if ($("#favw-a2c-count").length) {
            //     ifChosenFavLength();
            // }
            const pageUrl = window.location.href;
            const anchors = document.querySelectorAll('.menu-item a.item_link');
            const parent = document.querySelectorAll(
                '#main_ul-primary .menu-item.menu-item-type-post_type.menu-item-object-page')
            for (i = 0; i < anchors.length; i++) {
                var anchor = anchors[i]
                if (anchor.href == pageUrl) {
                    parent[i].classList.add('current-menu-ancestor', 'current_page_ancestor',
                        'current-menu-item',
                        'current_page_item');
                }
            }
        });
    </Script>
@endpush
@push('css')
    <style>
        .fa-search {
            width: 1.3em;
            height: 1.3em;
        }

        .fa-search path {
            stroke: #808080;
            stroke-width: 1;
        }

        .sop-m-search {
            width: 80px;
            background-color: #780116;
            color: white;
        }

        .elementor-container.elementor-column-gap-extended {
            max-width: 100% !important;
            margin: auto;
        }


        .current-menu-ancestor .yk_link_content {
            color: #780116 !important;
        }

        .menu-item:hover .yk_link_content {
            color: #780116 !important;
        }

        .menu-item:focus .yk_link_content {
            color: #780116 !important;
        }

        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li:hover>.item_link,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li>.item_link:hover,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li>.item_link:focus,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.keep_open>.item_link,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.current-menu-ancestor>.item_link,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.current-page-ancestor>.item_link,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.current-post-ancestor>.item_link,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.current-menu-item>.item_link {
            background: -moz-linear-gradient(top, #fff%, #fffee%) !important;
            background: -webkit-linear-gradient(top, #fff%, #fffee%) !important;
            background: -o-linear-gradient(top, #fff%, #fffee%) !important;
            background: -ms-linear-gradient(top, #fff%, #fffee%) !important;
            background: -webkit-gradient(linear, left top, left bottom, color-stop(%, #fff), color-stop(%, #fff)) !important;
            background: linear-gradient(to bottom, #fff%, #fffee%) !important;
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient( startColorstr='#fff', endColorstr='#fff',GradientType=0 )" !important;
            background-color: #fff !important;
            border-bottom: 2px solid #780116 !important;
            border-radius: 0px !important;
        }

        .mega_main_menu>.menu_holder>.menu_inner>ul>li>.item_link {

            padding: 0px 10px !important;

        }

        #productSearchForm {
            border: 1px solid #7e7e7e;
            border-radius: 4px;
            padding-left: 15px;
            width: 320px;
            margin-right: 10px;
        }

        #productSearchForm #productSearchText {
            height: 40px;
            border: none;
        }

        #productSearchForm .product-search-button {
            border-radius: 3px;
            background: #780116;
            color: #fff;
        }

        .ftc-header-template .mega_main_menu>.menu_holder>.menu_inner>ul>li {
            margin-right: 0 !important;
        }

        @media (min-width: 768px) {
            .elementor-13125 .elementor-element.elementor-element-32c3785c {
                width: 69.916% !important;
            }

            .elementor-13125 .elementor-element.elementor-element-6aaa2000 {
                width: 20%;
            }

            .elementor-13125 .elementor-element.elementor-element-6aab2496 {
                width: 5.042% !important;
            }

        }

        @media (min-width: 1200px) {
            .elementor-13125 .elementor-element.elementor-element-32c3785c {
                width: 71.916% !important;
            }

            .elementor-13125 .elementor-element.elementor-element-6aaa2000 {
                width: 20%;
            }

            .elementor-13125 .elementor-element.elementor-element-6aab2496 {
                width: 4.042% !important;
            }
        }

        .sop-cart-count {
            position: absolute;
            font-weight: 400;
            font-family: sans-serif;
            font-size: 12px;
        }

        .cart-total i {
            padding-top: 1.2rem;
            padding-bottom: 1.2rem;
        }

        .sop-search {
            border: 0 !important;
            border-bottom: 1px solid #780116 !important;
            padding: 0 !important;
            font-family: 'Myanmar3', sans-serif;
        }

        .sop-search::placeholder {
            padding-left: 10px;

            /*=======*/
        }

        ;
    </style>
    <style type="text/css">
        @font-face {
            font-family: Gabriela;
            src: url('/fonts/Gabriela-Regular.ttf');
        }
    </style>
@endpush
@push('css')
    <style>
        .elementor-container.elementor-column-gap-extended {
            max-width: 100% !important;
            margin: auto;
        }

        .current-menu-ancestor .yk_link_content {
            color: #780116 !important;
        }

        .menu-item:hover .yk_link_content {
            color: #780116 !important;
        }

        .menu-item:focus .yk_link_content {
            color: #780116 !important;
        }

        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li:hover>.item_link,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li>.item_link:hover,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li>.item_link:focus,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.keep_open>.item_link,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.current-menu-ancestor>.item_link,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.current-page-ancestor>.item_link,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.current-post-ancestor>.item_link,
        .mega_main_menu.primary>.menu_holder>.menu_inner>ul>li.current-menu-item>.item_link {
            background: -moz-linear-gradient(top, #fff%, #fffee%) !important;
            background: -webkit-linear-gradient(top, #fff%, #fffee%) !important;
            background: -o-linear-gradient(top, #fff%, #fffee%) !important;
            background: -ms-linear-gradient(top, #fff%, #fffee%) !important;
            background: -webkit-gradient(linear, left top, left bottom, color-stop(%, #fff), color-stop(%, #fff)) !important;
            background: linear-gradient(to bottom, #fff%, #fffee%) !important;
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient( startColorstr='#fff', endColorstr='#fff',GradientType=0 )" !important;
            background-color: #fff !important;
            border-bottom: 2px solid #780116 !important;
            border-radius: 0px !important;
        }

        .mega_main_menu>.menu_holder>.menu_inner>ul>li>.item_link {

            padding: 0px 10px !important;

        }

        @media (min-width: 768px) {
            .elementor-13125 .elementor-element.elementor-element-32c3785c {
                width: 69.916% !important;
            }

            .log img {
                height: 70%;
            }

            .sop-drop ul {
                margin: 0 !important;
                padding: 0 !important;
            }

            .site-header {
                box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            }

            .dropdown-item.active,
            .dropdown-item:active {
                background-color: #aeaeae !important;
            }

            .sop-search-btm {
                background-color: transparent !important;
            }
        }
    </style>
@endpush
