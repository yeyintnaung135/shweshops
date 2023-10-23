@extends('layouts.frontend.frontend')
@section('content')
    @push('css')
        <style>
            .contact-modal-header {
                background-color: #fff !important;
            }

            .contact-modal-body {
                background-color: #fff !important;

            }

            .contact-modal {
                background-color: #fff !important;
            }
        </style>
    @endpush
    @include('layouts.frontend.allpart.for_mobile')
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')
    <div id="page" class="site my-0 py-0">

        {{-- MENU --}}

        {{-- end Menu --}}


        <!-- .site-content-contain -->

        <div class="site-content-contain sop-font">
            {{-- breadcum --}}
            {{-- banner pic --}}
            @if ($shop_data->premium == 'yes')
                <div class="  px-lg-5 mx-lg-3">
                    <div class="">
                        <div id='main_slide' class="text-center owl-carousel owl-theme w-100 ">
                            @if (count($shop_data->getPhotos) != 0)
                                @foreach ($shop_data->getPhotos as $img)
                                    <img class="item zh-main_slide" src="{{ filedopath('shop_owner/banner/' . $img->location) }}" />
                                @endforeach
                            @elseif(!empty($shop_data->shop_banner))
                                <img class="item zh-main_slide" src="{{ filedopath('shop_owner/banner/' . $shop_data->shop_banner) }}" />
                            @else
                                <img class="item zh-main_slide" src="{{ url('images/banner/default.jpg') }}" />
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            {{-- banner pic --}}
            <div id="content" class="site-content">
                {{-- profile --}}
                <div class="px-4 text-left px-md-5 mx-md-3 my-4 my-md-5 pb-md-0 pb-3">
                    <div class=" d-flex">
                        <div class="">
                            <img src="{{ filedopath('/shop_owner/logo/' . $shop_data->shop_logo) }}" class="sop-logo" alt="shop logo">
                        </div>
                        <div class="col-8 sop-font ">
                            <div class="pt-2 ps-4 col-lg-8">
                                <div class="row  py-lg-1">
                                    <h3 class="product_title page-title entry-title text-break text-dark text-capitalize">
                                        {{ $shop_data->shop_name }}
                                    </h3>
                                </div>
                                <div class="row  py-lg-1 pt-1">
                                    <p class="content sop-opacity-8 m-0 animation" style="font-size: 1.1em">
                                        {!! $shop_data->description !!}
                                    </p>
                                    <div class="txtcol"><a style="color: #780116!important;">... See More</a></div>

                                </div>
                                <div class="d-flex pt-1 py-lg-1">
                                    <div class="">
                                        <a href="{{ $shop_data->page_link }}" class=" sop-social">
                                            <i class="sop-social-i fa-brands fa-facebook pe-1 pe-md-2"></i>
                                            <div class="d-none d-sm-block">Facebook</div>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{ $shop_data->messenger_link }}" class=" sop-social">
                                            <i class="sop-social-i fab fa-facebook-messenger pe-1 pe-md-2"></i>
                                            <div class="d-none d-sm-block">Messenger</div>
                                        </a>
                                    </div>
                                    <div>
                                        @if (!empty($shop_data->additional_phones))
                                            <a href="#phoneModal" data-toggle="modal" data-target="#phoneModal"
                                                class="sop-social" id="phone-button">
                                                <i class="sop-social-i fa-solid fa-phone pe-1 pe-md-2 sn-phone"></i>
                                                <div class="d-none d-sm-block">Phone</div>
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade contact-modal-backside" id="phoneModal" tabindex="-1"
                                                aria-labelledby="phoneModal" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header ">
                                                            <h5 class="modal-title" id="phoneModal">Phones</h5>
                                                            <a type="button" class="close-style2" data-dismiss="modal"
                                                                aria-label="Close"><i class="fa-solid fa-xmark"></i></a>
                                                        </div>
                                                        <div class="modal-body mx-3" id="phone_modal">
                                                            @if (!empty($shop_data->main_phone))
                                                                <p class="text-break"
                                                                    style="text-align: left; font-size: 16px;height: auto; ;">
                                                                    <a href="tel:{{ $shop_data->main_phone }}"
                                                                        class=" sop-social">
                                                                        <i
                                                                            class="sop-social-i fa-solid fa-phone pe-1 pe-md-4 sn-phone"></i>
                                                                        {!! nl2br($shop_data->main_phone) !!}
                                                                    </a>
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- modal --}}
                                        @else
                                            <a href="tel:{{ $shop_data->main_phone }}" class=" sop-social">
                                                <i class="sop-social-i fa-solid fa-phone pe-1 pe-md-2 sn-phone"></i>
                                                <div class="d-none d-sm-block">Phone</div>
                                            </a>
                                        @endif

                                    </div>

                                    {{-- @if ($shop_data->premium == 'yes') --}}
                                    <div>
                                        <a href="#contact" data-toggle="modal" data-target="#contact" class="sop-social"
                                            id="contact-button">
                                            <i class="sop-social-i fa-solid fa-location-dot pe-1 pe-md-2"></i>
                                            <div class="d-none d-sm-block">Contact</div>
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade contact-modal-backside" id="contact" tabindex="-1"
                                            aria-labelledby="contactModal" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content contact-modal">
                                                    <div class="modal-header contact-modal-header">
                                                        <h3 class="modal-title mx-3" id="contactModal"
                                                            style="font-weight: 700; color:black">Shop <span
                                                                style="color:#780116">Address</span></h3>
                                                        <a type="button" class="close-style2" data-dismiss="modal"
                                                            aria-label="Close"><i class="fa-solid fa-xmark"></i></a>
                                                    </div>
                                                    <div class="modal-body mx-3 contact-modal-body" id="address_modal">
                                                        @if (!empty($shop_data->address))
                                                            <p class="text-break mt-3"
                                                                style="text-align: left; font-size: 18px;height: auto; overflow: auto; line-height: 30px">
                                                                {!! $shop_data->address !!}
                                                            </p>
                                                        @else
                                                            <p class="text-break mt-3"
                                                                style="text-align: left; font-size: 18px;height: auto; overflow: auto; line-height: 30px">
                                                                No Address
                                                            </p>
                                                        @endif
                                                        <hr>
                                                    </div>

                                                    {{-- more address --}}
                                                    @if (isset($shop_data->other_address) || !is_null($shop_data->other_address) || !empty($shop_data->other_address))
                                                        <a class="w-100" data-toggle="collapse" href="#collapseMoreAddr"
                                                            role="button" aria-expanded="false"
                                                            aria-controls="collapseExample">
                                                            <div class="d-flex justify-content-between mx-4 px-2 py-0"
                                                                id="address-class">
                                                                <p class="text-break"
                                                                    style="text-align: left; font-size: 20px; height: auto; ; line-height: 32px;color:black;font-weight:700">
                                                                    Other Addresses
                                                                </p>
                                                                <i id="address-class-i"
                                                                    class="sop-arrow fa-solid fa-chevron-down"></i>
                                                            </div>
                                                        </a>
                                                        <div class="collapse" id="collapseMoreAddr">
                                                            <div class="modal-body pt-3 mx-3 mt-2"
                                                                id="other_address_modal">
                                                            </div>
                                                        </div>
                                                    @endif
                                                    {{-- more address --}}
                                                    @if ($shop_data->premium == 'yes')
                                                        {{-- Map --}}
                                                        <a class="w-100 mt-2" data-toggle="collapse" href="#collapseMap"
                                                            role="button" aria-expanded="false"
                                                            aria-controls="collapseExample">
                                                            <div class="d-flex justify-content-between modal-body mx-3 py-0 sop-chevron "
                                                                id="map-class">
                                                                <p class="font-weight-bold text-break"
                                                                    style="text-align: left; font-size: 20px;height: auto; ; line-height: 32px; color:black;font-weight:700">
                                                                    Google Map
                                                                </p>
                                                                <i id="map-class-i"
                                                                    class="sop-arrow fa-solid fa-chevron-down"></i>
                                                            </div>
                                                        </a>
                                                        <div class="collapse" id="collapseMap">
                                                            <div class="">
                                                                @if (!isset($shop_data->map) || is_null($shop_data->map) || empty($shop_data->map))
                                                                    <iframe class="sop-map"
                                                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15472351.946258605!2d87.60098124688682!3d18.778995379761387!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x305652a7714e2907%3A0xba7b0ee41c622b11!2sMyanmar%20(Burma)!5e0!3m2!1sen!2smm!4v1657253955978!5m2!1sen!2smm"
                                                                        width="2000" height="500" style="border:0;"
                                                                        allowfullscreen="" loading="lazy"
                                                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                                @else
                                                                    <iframe class="sop-map" src="{{ $shop_data->map }}"
                                                                        width="2000" height="500" style="border:0;"
                                                                        allowfullscreen="" loading="lazy"
                                                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {{-- map --}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- profile --}}
            </div>
            {{-- loading --}}

            {{-- loading --}}

            {{-- Categories --}}
            <div class="show_breadcrumb d-none show_dev">
                @include('layouts.frontend.allpart.shop_detail.categories_shop_details', [
                    'shop_data' => $shop_data,
                ])
            </div>
            {{-- Categories --}}
            @if ($shop_data->premium == 'yes')
                <div class="px-0" style="border-bottom: 2px solid rgba(160, 121, 54, 0.08);">
                    @if ($discount->count() != 0)
                        {{-- Discount --}}
                        @include('layouts.frontend.allpart.shop_detail.bestsellers')
                        {{-- Discount --}}
                    @endif
                </div>
            @endif
            @if ($shop_data->premium == 'yes')
                <div class="px-0" style="border-bottom: 2px solid rgba(160, 121, 54, 0.08);">
                    @if ($discount->count() != 0)
                        {{-- Discount --}}
                        @include('layouts.frontend.allpart.shop_detail.recommended4u')
                        {{-- Discount --}}
                    @endif
                </div>
            @endif
            <div class="pt-4 col-12 ">
            </div>

            <div class="px-4 px-md-5 mx-md-3 " style="border-bottom: 2px solid rgba(160, 121, 54, 0.08);">
                <nav class="navbar navbar-expand-sm bg-light justify-content-start mb-3"
                    style="background-color: #fff !important">
                    <ul class="navbar-nav">
                        <li class="popular_nav nav-item active">
                            <a class="nav-link-np" id="popular" style="">Popular</a>
                        </li>
                        <li class="newest_nav nav-item" id="newest">
                            <a class="nav-link-np" id="">Newest</a>
                        </li>
                        <li class="nav-item discount_nav">
                            <a class="nav-link-np" id="discount_pannel">Discount</a>
                        </li>
                    </ul>
                </nav>
                <div class="zh-new_item sop-font">
                    @if (count($items) == 0)
                        <div class="sn-no-items">
                            <div class="sn-cross-sign"></div>
                            <i class="fa-solid fa-box-open"></i>
                            <span>ပစ္စည်းမရှိသေးပါ</span>
                        </div>
                    @else
                        <newitems-forshop :newitems="{{ $items }}"
                            :uri="'get_newitems_forshop_ajax'"></newitems-forshop>
                    @endif
                </div>


                <div class="zh-pop_items sop-font">
                    @if (count($get_pop_items) == 0)
                        <div class="sn-no-items">
                            <div class="sn-cross-sign"></div>
                            <i class="fa-solid fa-box-open"></i>
                            <span>ပစ္စည်းမရှိသေးပါ</span>
                        </div>
                    @else
                        <pop-items-forshop :allitems="{{ $get_pop_items }}" :forcheck_count="{{ $forcheck_count }}"
                            :uri="'get_popitems_forshop_ajax'"></pop-items-forshop>
                    @endif
                </div>


                <div class="zh-discount_items sop-font">

                    @if (count($discount) == 0)
                        <div class="sn-no-items">
                            <div class="sn-cross-sign"></div>
                            <i class="fa-solid fa-box-open"></i>
                            <span>ပစ္စည်းမရှိသေးပါ</span>
                        </div>
                    @else
                        {{-- <discount-items :discountitems="{{$discount}}" :shop_id="{{$shop_data->id}}"></discount-items> --}}
                        <discount-items-for-shop :discountitems="{{ $discount }}"
                            :shop_id="{{ $shop_data->id }}"></discount-items-for-shop>
                    @endif
                </div>
                {{-- @endif --}}
            </div>

            {{-- map (change with dynamic degrees) --}}
            {{-- <div class="px-0 px-md-5 pt-3 w-100">
            <div class="px-lg-5 d-none show_dev">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d238.60995656534973!2d96.1980297770541!3d16.887797136151246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smm!4v1644909675991!5m2!1sen!2smm" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div> --}}
            {{-- map --}}

            {{-- //shop slide --}}
            @if ($shop_data->premium != 'yes')
                <div class="px-0 px-md-2">
                    @include('layouts.frontend.allpart.shop_detail.premium_sellers')
                </div>
                <div class="px-0 px-md-2">
                    @include('layouts.frontend.allpart.shop_detail.other_sellers')
                </div>
            @endif

            {{-- @if ($shop_data->premium == 'yes' && (isset($shop_data->address) && !is_null($shop_data->address) && !empty($shop_data->address)))
        <div class="px-0 px-md-2 pt-4 w-100">
            @include('layouts.frontend.allpart.shop_detail.map')
        </div>
        @endif --}}
            {{-- //shop slide --}}
        </div>
    </div>
    <div class="pt-5 pt-lg-3"></div>
    {{--        <!-- #content --> --}}
    <div class="pt-5">
        @include('layouts.frontend.allpart.footer')
    </div>
    {{--    <!-- .site-content-contain --> --}}
    <div class="ftc-close-popup"></div>
    @include('layouts.frontend.allpart.mobile_footer')
    <div id="to-top" class="scroll-button">
        <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>



@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(".zh-new_item").hide();
            $(".zh-pop_items").show();
            $(".zh-discount_items").hide();
            $(".shops_pannel").hide();

            $("#newest").click(function() {
                $(".zh-new_item").show();
                $(".zh-pop_items").hide();
                $(".zh-discount_items ").hide();

                $(".newest_nav").addClass('active');
                $(".popular_nav").removeClass('active');
                $(".discount_nav").removeClass('active');

                $(".shops_pannel ").hide();
                $(".shops ").removeClass('active');
                $(".shop_nav ").removeClass('active');

            });

            $("#popular").click(function() {
                $(".zh-pop_items").show();
                $(".zh-new_item").hide();
                $(".zh-discount_items ").hide();

                $(".popular_nav").addClass('active');
                $(".newest_nav").removeClass('active');
                $(".discount_nav").removeClass('active');

                $(".shops_pannel ").hide();
                $(".shops ").removeClass('active');
                $(".shop_nav ").removeClass('active');

            });

            $("#discount_pannel").click(function() {
                $(".zh-discount_items ").show();
                $(".zh-new_item").hide();
                $(".zh-pop_items").hide();

                $(".discount_nav").addClass('active');
                $(".popular_nav").removeClass('active');
                $(".newest_nav").removeClass('active');

                $(".shops_pannel ").hide();
                $(".shops ").removeClass('active');
                $(".shop_nav ").removeClass('active');
            });

            // $("#phone-button").click(function(){
            //     $("#phone").modal({backdrop: false});
            // });

            // $("#contact-button").click(function(){
            //     $("#contact").modal({backdrop: false});
            // });
        });
        $(document).ready(function() {
            var additionalPhones = {!! $shop_data->additional_phones !!};
            additionalPhones.forEach(phone => {
                $("#phone_modal").append(`<a href="tel:` + phone + `" class=" sop-social pb-3">
                    <i class="sop-social-i fa-solid fa-phone pe-1 pe-md-4 sn-phone"></i>
                    ` + phone + `
                </a>`);
            });
        });




        $(document).ready(function() {
            $(".content").each(function() {
                let height = Math.ceil($(this).height()) + 1;
                let overflow_height = $(this)[0].scrollHeight;
                console.log(height);
                console.log(overflow_height);
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
                    $(this).parent().find(".content").css("max-height", "3em");
                    $(this).children('a').text("... See More");
                }
                $(this).prev().toggleClass("truncate").toggleClass("animation");

            });
        });
        $(document).ready(function() {

            $("#address-class").click(function() {
                $("#address-class-i").toggleClass('fa-chevron-up fa-chevron-down ');
            });
            $("#map-class").click(function() {
                $("#map-class-i").toggleClass('fa-chevron-up fa-chevron-down ');
            });
        });

        $('#pshop_slide').owlCarousel({
            loop: false,
            margin: 20,
            responsiveClass: true,
            autoplay: true,
            dots: false,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,

            responsive: {
                0: {
                    items: 1.5,
                    stagePadding: 20,
                },
                600: {
                    items: 2,
                    stagePadding: 0,
                },
                900: {
                    items: 3,
                    stagePadding: 0,
                },
                1200: {
                    items: 4,
                    stagePadding: 0,
                },
                1400: {
                    items: 5,
                    stagePadding: 0,
                }
            }
        });

        $(window).on('load', function() {
            $('#popup-onload').modal('show');
        });

        $('#popup-onload').on('hidden.bs.modal', function() {
            $(this).remove();
        });
    </script>
    <script>
        $(document).ready(function() {
            var otherAddresses = {!! $shop_data->other_address !!};
            otherAddresses.forEach(address => {
                $("#other_address_modal").append(
                    `<p class="text-break mt-3" style="text-align: left; font-size: 18px;height: auto; overflow: auto; line-height: 30px">` +
                    address.value +
                    `</p>
                <hr>`
                );
            });
        });
    </script>
@endpush
@push('css')
    <style>
        .close-style2 {
            color: #780116 !important;
            background-color: #fff !important;
            font-size: 26px !important;
            font-weight: normal !important;
            margin-right: 0.5em;
        }

        .close-style2:hover,
        .close-style2:focus {
            background-color: #fff !important;
            color: #420001 !important;
            cursor: pointer !important;
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

        .truncate {
            transition: 0.5s ease-in-out;
        }

        .animation {
            transition: 0.5s ease-in-out;
        }

        @media only screen and (max-width: 576px) {
            #main_slide img {
                width: 100%;
                /* max-height: 240px!important; */
                object-fit: cover;
                object-position: center;
                /* aspect-ratio: 32/9; */
                /* aspect-ratio: 32/11; */
                aspect-ratio: 2/1;
            }

            @supports not (aspect-ratio: auto) {
                #main_slide img {
                    width: 100%;
                    max-height: 160px !important;
                }
            }
        }

        @media only screen and (min-width: 576px) {
            #main_slide img {
                width: 100%;
                /* max-height: 500px!important; */
                object-fit: cover;
                object-position: center;
                /* aspect-ratio: 32/9; */
                /* aspect-ratio: 32/11; */
                aspect-ratio: 3/1;
            }

            @supports not (aspect-ratio: auto) {
                #main_slide img {
                    width: 100%;
                    max-height: 450px !important;
                }
            }
        }

        @media only screen and (min-width: 992px) {
            #main_slide img {
                width: 100%;
                /* max-height: 550px!important; */
                object-fit: cover;
                object-position: center;
                /* aspect-ratio: 32/9; */
                /* aspect-ratio: 32/11; */
                aspect-ratio: 3/1;
            }

            @supports not (aspect-ratio: auto) {
                #main_slide img {
                    width: 100%;
                    max-height: 450px !important;
                }
            }
        }


        .sop-social {
            display: flex !important;

            /* font-family: sans-serif; */

            font-size: 1.1em !important;
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 1.2rem 0.375rem 0;
            font-size: 1rem;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .fa-facebook {
            color: #1877f2 !important;
        }

        .fa-facebook-messenger {
            color: #0695FF !important;
        }

        .sn-phone,
        .fa-location-dot {
            color: #780116 !important;
        }

        .nav-link-np {
            color: #666666 !important;
            margin-right: 10px;
            padding: 8px 10px !important;
        }

        .active .nav-link-np {
            /* background-color: #780116 !important; */
            color: #780116 !important;
            position: relative;
        }

        @media (max-width: 576px) {
            .nav-link-np {
                margin-right: 4px;
            }
        }

        @media only screen and (min-width: 576px) {
            .sop-social-i {
                /* color: #780116 !important; */
                font-size: 24px !important;
            }
        }

        @media only screen and (max-width: 576px) {
            .sop-social {
                font-size: 0.9em !important;
            }

            .sop-social-i {
                /* color: #780116 !important; */
                font-size: 24px !important;
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

        /* button:hover, button:focus, input[type="button"]:hover, input[type="button"]:focus, input[type="submit"]:hover, input[type="submit"]:focus {
            background-color: white!important;
            color: #fff;
            transform: scale(1.1)
        } */
    </style>
@endpush
