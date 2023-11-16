<div class="sop-upper d-none d-lg-block px-lg-5">
    <div class="h-100 d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-between  col-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="pe-3 dropdown sop-drop d-none">
                    {{-- ဘာသာစကား<i class="fa-solid fa-angle-down ps-1"></i> --}}
                    <ul>
                        <li class="nav-item dropdown" style="list-style-type:none;margin-right: 0px;">
                            <a href="#language-change-w" class="nav-link" data-toggle="dropdown"
                                style="font-weight: 600">
                                <i class="fas fa-globe pe-2" style="color: #F7B538!important;"></i> ဘာသာစကား<i
                                    class="fa-solid fa-angle-down ps-1"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="" class="dropdown-item">မြန်မာ</a>
                                <a href="" class="dropdown-item">English</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="pe-3">
                    <a href="#">​<i class="fa fa-chevron-left" aria-hidden="true" onclick="back()"></i> &nbsp;&nbsp;​Back</a>
                </div>
            </div>
        </div>
        <div class="shoplogo-w col-4 d-flex flex-row justify-content-center align-items-top ">
            <a href="/" class="d-flex flex-row justify-content-center align-items-end">
                <img src="{{ url('test/img/logo-m.png') }}" class="" alt="">
                <div class="d-flex flex-row justify-content-start align-items-end">
                    <p class="logo-text">SHWESHOPS</p>
                </div>
                {{-- <img src="{{url('test/img/logo.png')}}" class="d-xl-block d-none" alt=""> --}}
                {{-- <img src="{{url('test/img/logo-m.png')}}" class="d-lg-block d-xl-none" alt=""> --}}
            </a>

        </div>

        <div class="d-flex justify-content-end align-items-center col-4">

        </div>
    </div>
</div>

@push('css')
   
    <style>
        .menu-profile {
            width: 30px;
            height: 30px;
            overflow: hidden;
            /*margin-top: -8px;*/
        }

        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');

        /* @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap'); */
        .logo-text {
            font-family: 'Cinzel', serif;
            margin: auto;
            padding: 0 10px;
            font-size: 2rem;
            color: #F7B538;
            text-transform: capitalize;
            margin: 0;
        }

        @media only screen and (min-width: 991px) {
            .logo-text {
                font-size: 1.5rem;
                line-height: 1.5rem;
            }
        }

        @media only screen and (min-width: 1200px) {
            .logo-text {
                font-size: 2rem;
                line-height: 2rem;
            }
        }

        .sop-upper {
            height: 90px;
            background-color: #780116;;
            color: white !important;
        }

        .shoplogo-w img {
            height: 40px;
            cursor: pointer;
        }

        .social-w-f {
            background-color: #F7B538 !important;
            padding: 7.2px 10px;
            color: #1B1A17;
            border-radius: 50%;
            cursor: pointer;
        }

        .social-w-i {
            background-color: #F7B538 !important;
            padding: 7.2px 8px;
            color: #1B1A17;
            border-radius: 50%;
            cursor: pointer;
        }

        .social-w-t {
            background-color: #F7B538 !important;
            padding: 7.2px 7.2px;
            color: #1B1A17;
            border-radius: 50%;
            cursor: pointer;
        }

        .sop-upper a {
            color: white !important;
        }

        .dropdown-menu a {
            color: #666 !important;
        }

        .sop-upper-nav-text-y {
            color: #F7B538 !important;
        }

        .sop-upper-nav-text {
            font-size: 0.8em;

            /* font-family: sans-serif!important; */
            font-weight: 600;
        }

        .sop-upper-nav-text-l {
            font-size: 1.1em;

            /* font-family: sans-serif!important; */
            cursor: pointer;
        }

        .sop-upper-s {
            height: 25px;
            background-color: #000000;
            color: white !important;
            width: 100%;
            overflow: hidden;
            position: relative;
            text-align: right;
        }

        .sop-upper-s .sop-upper-nav-text {
            width: 100%;
            flex-shrink: 0;
            align-items: center;
            position: absolute;
            display: block;
            top: 0;
        }

        .text1 {
            animation: slide 30s linear infinite;
        }

        .text2 {
            animation: slide-2 30s linear infinite;
        }

        .text3 {
            animation: slide-3 30s linear infinite;
        }

        @keyframes slide-3 {

            0%,
            66.66% {
                right: -100%;
                opacity: 0;
            }

            74.96%,
            91.62% {
                right: 4rem;
                opacity: 1;
            }

            100% {
                right: 110%;
                opacity: 0;
            }
        }

        @keyframes slide-2 {

            0%,
            33.33% {
                right: -100%;
                opacity: 0;
            }

            41.63%,
            58.29% {
                right: 4rem;
                opacity: 1;
            }

            66.66%,
            100% {
                right: 110%;
                opacity: 0;
            }
        }

        @keyframes slide {

            0%,
            8.3% {
                right: -100%;
                opacity: 0;
            }

            8.3%,
            25% {
                right: 4rem;
                opacity: 1;
            }

            33.33%,
            100% {
                right: 110%;
                opacity: 0;
            }
        }
    </style>
@endpush
