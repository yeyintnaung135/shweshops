<div class="ftc-mobile-wrapper">
    <div class="menu-text sop-sans d-flex justify-content-between align-items-center logo-nav-m" style="background: #000000!important;color:rgb(255, 255, 255);">
        <div class="d-flex justify-content-start align-items-end">
            <div style="width: 100px">
                <img src="{{url('test/img/logo-m.png')}}"style="width:100%;object-fit:cover;" class="" alt="" style="">
            </div>
            <p class="logo-sop mb-0">Shwe Shops</p>
        </div>

        <button type="button" class="btn btn-toggle-canvas btn-danger d-flex justify-content-center align-items-center" data-toggle="offcanvas">
            <i class="fa fa-close"></i>
        </button>

    </div>
    <div class=" ps-3 pt-3 sop-menus">
        <div class="menu-text sop-sans " style="background: transparent!important;color:black;">
            <h3>Menu</h3>
        </div>
        <div class="menu-mobile">
            <div class="">
                <div class="">
                    <a title="" href="{{url('/')}}" class="d-flex">
                        {{-- <i class="fa-solid fa-house col-2"></i>
                         --}}
                         <i class="fi fi-rs-home col-2"></i>
                        ပင်မ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="">
                <div class="">
                    <a title="" href="{{url('/shops')}}" class="d-flex">
                        {{-- <i class="fa-solid fa-store col-2"></i> --}}
                        <i class="fi fi-rs-shop col-2"></i>
                        ဆိုင်များ
                    </a>
                </div>
            </div>
        </div>
     <div class="menu-mobile">
            <div class="">
                <div class="">
                    <a title="" href="{{url('/news')}}" class="d-flex">
                        <i class="fas fa-newspaper col-2"></i>
                        သတင်း နှင့် ပွဲများ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile d-none">
            <div class="    ">
                <div class="">
                    <a title="" href="{{url('/see_all_discount/all')}}" class="d-flex text-capitalize">
                        <i class="fa-solid fa-exclamation col-2 ps-2"></i>
                        <span class="sop-sans">Promotions&nbsp;</span>များ
                    </a>
                </div>
            </div>
        </div>

        <div class="menu-text sop-sans mt-3" style="background: transparent!important;color:black;">
            <h3>quick links</h3>

        </div>
        <div class="menu-mobile">
            <div class="">
                <div class="">
                    <a title="" href="{{url('see_all_new')}}" class="d-flex">
                        {{-- <i class="fa-solid fa-gem col-2"></i> --}}
                        <i class="fi fi-rs-confetti col-2"></i>
                        အသစ်ရောက် ပစ္စည်းများ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="">
                <div class="">
                    <a title="" href="{{url('see_all_pop')}}" class="d-flex">
                        {{-- <i class="fa-solid fa-fire col-2"></i> --}}
                        <i class="fi fi-rr-crown col-2"></i>
                        လူကြိုက်များသော ပစ္စည်းများ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="    ">
                <div class="">
                    <a title="" href="{{url('/see_all_discount/all')}}" class="text-capitalize d-flex">
                        {{-- <i class="fa-solid fa-percent col-2"></i> --}}
                        <i class="fi fi-rr-megaphone col-2"></i>
                        <span class="sop-sans">Discount&nbsp;</span>ပစ္စည်းများ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="    ">
                <div class="sop-sans">
                    <a title="" href="{{url('/myfav')}}" class="d-flex">
                        <i class="fa-regular fa-heart col-2"></i>
                        wishlist
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="    ">
                <div class="">
                    <a title="" href="{{url('addtocart')}}" class=" d-flex">
                        {{-- <i class="fa-solid fa-bag-shopping  col-2"></i> --}}
                        <i class="fi fi-rs-shopping-cart-check col-2"></i>
                        ‌ရွေးထားတာလေးများ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="    ">
                <div class="">
                    <a title="" href="{{url('directory/all')}}" class=" d-flex">
                        {{-- <i class="fa-solid fa-bag-shopping  col-2"></i> --}}
                        <i class="fi fi-rs-shop col-2"></i>
                        Shops Directory
                    </a>
                </div>
            </div>
        </div>

        <div class="menu-mobile">
            <div class="">
                <div class="sop-sans">
                    <a title="" href="{{url('/support')}}" class=" d-flex">
                        <i class="fi fi-rr-comment-info col-2"></i>

                        Help & Support
                    </a>
                </div>
            </div>
        </div>
            <div class="menu-mobile">
                <div class="">
                    <div class="sop-sans">
                        <a title="" href="{{url('/contact-us')}}" class=" d-flex">
                            <i class="fi fi-rr-comment-info col-2"></i>

                            Contact us
                        </a>
                    </div>
                </div>
            </div>

        <div class="menu-mobile">
            <div class="">
                <div class="sop-sans">
                    <a title="" href="{{url('/')}}" class="d-none sop-disable d-flex">
                        <i class="fa-solid fa-headphones-simple  col-2"></i>
                        customer service
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="menu-mobile">
        <div class="mobile-wishlist">
            <div class="ftc-my-wishlist"> --}}
    {{--                <a title="" href="{{ route('news') }}" class="tini-wishlist">--}}
    {{--                    <i class="fa fa-heart"></i>--}}
    {{--                    News  </a>--}}
    {{-- </div>
</div>
</div> --}}

    {{-- <div class="mobile-menu-wrapper">

        <div class="menu-main-menu-container">

            <ul id="main-menu" class="ftc-smartmenu ftc-simple">
                <li
                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-8331">
                    <a href="#">About ShweShops</a>
                    <ul class="sub-menu">
                        <li id="menu-item-8276"
                            class="sub-style menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-8276">
                            <a href="#">About Us</a>

                        </li>
                        <li id="menu-item-8280"
                            class="sub-style sub-style1 menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-8280">
                            <a href="#">Contact Us</a>
                        </li>
                        <li id="menu-item-8278"
                            class="sub-style sub-style1 menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-8278">
                            <a href="#">Shwe News</a>
                        </li>
                        <li id="menu-item-8279"
                            class="sub-style sub-style2 menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-8279">
                            <a href="#">FAQ</a>

                        </li>
                    </ul>
                </li>
                <li id="menu-item-8275"
                    class="blog-menu-s s2 menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-8275">
                    <a href="">Premium Sellers</a>
                    <ul class="sub-menu">
                        <li
                            class="sub-style menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-8281">
                            <a href="#">ရွှေနန်းတော်</a>
                            <ul class="sub-menu">
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">Messenger
                                    </a>
                                </li>
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">09-123-123-123
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="sub-style menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-8281">
                            <a href="#">Myat Yadanar</a>
                            <ul class="sub-menu">
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">Messenger
                                    </a>
                                </li>
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">09-123-123-123
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="sub-style menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-8281">
                            <a href="#">Her. Precious</a>
                            <ul class="sub-menu">
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">Messenger
                                    </a>
                                </li>
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">09-123-123-123
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="sub-style menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-8281">
                            <a href="#">သီတာ</a>
                            <ul class="sub-menu">
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">Messenger
                                    </a>
                                </li>
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">09-123-123-123
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="sub-style menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-8281">
                            <a href="#">Lady Grace</a>
                            <ul class="sub-menu">
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">Messenger
                                    </a>
                                </li>
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">09-123-123-123
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="sub-style menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-8281">
                            <a href="#">အောင်မာဓိ</a>
                            <ul class="sub-menu">
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">Messenger
                                    </a>
                                </li>
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">09-123-123-123
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="sub-style menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-8281">
                            <a href="#">ဇွဲထက်</a>
                            <ul class="sub-menu">
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">Messenger
                                    </a>
                                </li>
                                <li
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8323">
                                    <a
                                        href="">09-123-123-123
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
    <div class="menu-mobile">
        <div class="mobile-wishlist">
            <div class="ftc-my-wishlist">
                <a title="" href="{{url('/addtocart')}}" class="tini-wishlist">
                    <i class="fa-solid fa-basket-shopping"></i>
                    ရွေးထားတာလေးများ ( <span id="nav-a2c-count">0</span> ) </a>
            </div>
        </div>
        <div class="mobile-account">
            <a href="" title="Login">
                User Login </a>
        </div>
    </div>
    <div class="menu-mobile">
        <div class="mobile-wishlist">
            <div class="ftc-my-wishlist">
                <a title="" href="{{route('backside.shop_owner.register')}}" class="tini-wishlist">
                    <i class="fa fa-heart"></i>
                    SHOP ONWER login </a>


            </div>
        </div>
    </div> --}}
    <div class="header-mobile-social d-flex justify-content-center mt-5">
        <ul>
            <li class=""><a href="https://www.facebook.com/shweshops123"><i class="fab fa-facebook-f fa-size"></i>.</a></li>
            <li class="d-none"><a href="#"><i class="fab fa-twitter fa-size"></i></i>.</a></li>
            <li class="d-none"><a href="#"><i class="fab fa-instagram fa-size"></i>.</a></li>
        </ul>
    </div>


</div>
@push('css')
    <style>
        @import url({{url('fonts/css/flaticon-straight.css')}});
        @import url({{url('fonts/css/flaticon-rounded.css')}});

        .logo-sop{
            line-height: 30px;
            font-size: 25px;
            padding-left:5px;
            color: #f8af29;
        }
        .header-mobile-social {
            margin-top: 5px;
            padding-left: 0px !important;

        }

        .header-mobile-social ul {
            padding-left: 0 !important;
        }
        @media only screen and (max-width: 991px){
            .ftc-mobile-wrapper {

                width: 400px!important;
            }
            /* .ftc-mobile-wrapper {
                transform: translate3d(-400px, 0, 0);
            } */
        }

        /* .sop-sans{
            font-family: sans-serif;
        } */
        .sop-sans a{
            font-size: 1.1rem!important;
            text-transform: capitalize;
        }
        .fa-size{
            font-size: 18px!important;
            color: #780116;
        }

        .logo-nav-m{
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        }
        .ftc-mobile-wrapper .menu-text .btn-toggle-canvas.btn-danger {
            float: right;
            margin-right: 10px;
            background-color: white !important;
            border-color: #fffafa !important;
            color: #1B1A17;
            box-shadow: #fff;
        }
        .sop-menus i{

            font-size: 1.3rem;
            color: #780116;
        }
    </style>

@endpush
@push('custom-scripts')
    <Script>
        //  function ifChosenSelectionLengthM() {
        //     var selection = JSON.parse(window.localStorage.getItem("selection"));
        //     var selectionlength = 0;
        //     if (selection != null) {
        //         selectionlength = Object.keys(selection).length;

        //     }
        //     return document.getElementById('nav-a2c-count').innerHTML = selectionlength;

        // }
        // $( document ).ready(function() {
        //     if($("#nav-a2c-count").length){
        //         ifChosenSelectionLengthM();
        //     }
        // });

    </Script>
@endpush
