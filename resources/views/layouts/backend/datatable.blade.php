<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" sizes="19x19" href="{{ url('images/logo/favicon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    // if (session()->has('guest_id')) {
    //     $getid = \App\Guestoruserid::where('guest_id', session()->get('guest_id'));
    //     \App\frontuserlogs::where('userorguestid', $getid->first()->id)->delete();
    //     $getid->delete();
    //     }
    ?>
    @if (\Illuminate\Support\Facades\Session::has('loginedSO'))
        <script>
            window.facebook = {{ $is_fb_on }};

            var myItem = localStorage.getItem('guest_id');

            localStorage.clear();
            localStorage.setItem('guest_id', myItem);
        </script>
    @endif
    {{--    <script> --}}
    {{--        localStorage.clear(); --}}

    {{--    </script> --}}
    @if (Auth::check())
        <?php

        $shopid = Auth::guard('shop_owners_and_staffs')->user()->shop_id;

        ?>
        <script>
            window.userid = {{ $shopid }};

            function calculateVh() {
                var vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', vh + 'px');
            }

            // Initial calculation
            calculateVh();

            // Re-calculate on resize
            window.addEventListener('resize', calculateVh);

            // Re-calculate on device orientation change
            window.addEventListener('orientationchange', calculateVh);
        </script>
    @endif


    <link rel="stylesheet" type="text/css" href="{{ url('plugins/jquery-ui/jquery-ui.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ url('fonts/ssp.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">

    {{-- select2 --}}
    <link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ url('test/css/fancybox.css') }}" />
    <link rel='stylesheet' id='ftc-style-css' href="{{ url('test/wp-content/themes/karo1/style.css') }}" type='text/css'
        media='all' />
    <link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    {{--    <link rel="stylesheet" href="{{url('plugins/datatables-select/css/select.bootstrap4.css')}}"> --}}
    <link rel="stylesheet" href="{{ url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ url('test/css/bootstrap-toggle.css') }}">

    <!-- <script>
        -- >
        {{--        window.userid = {{\Illuminate\Support\Facades\Auth::user()->id}}; --}}
            <
            !--
    </script> -->

    <style>
        @font-face {
            font-family: 'Myanmar3';
            src: local('Myanmar3'), url("{{ url('mmfont/PyidaungsuZawDecode.woff2?93a8fffb927d8bfcaac5683829dcd048') }}") format('woff2'), url("{{ url('PyidaungsuZawDecode.woff?0e8dd9ee5f902f7ff573524de8b4f94d') }}") format('woff');
        }

        .swal-yk-title {
            color: #28a745 !important;
        }
    </style>
    <style>
        /* .chat-image-holder img {
            width: 150px;
        }
        .chat-image-holder .chat-list-forshow-close{
            right: -5px !important;
        }
        .chat-image-forshow-wrapper .chat-send-image {
            border: none !important;
            padding: 7px !important;
        } */
        .sop-font,
        .sn-product-title {
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .yk-circle {
            border: 2px solid black;
            width: 36px;
            height: 36px;
            border-radius: 20px;
            text-align: center;
        }

        .yk-info {
            color: black;
        }

        .yk-info .yk-tootips {
            border: 2px solid #680606;
            background: #730d18;
            color: white;
            padding: 10px;
            width: 333px;
            position: absolute;
            left: 154px;
            z-index: 2222;
            visibility: hidden;
            font-family: 'Myanmar3', Sans-Serif !important;
            line-height: 1.5;


        }

        .yk-info:hover .yk-tootips {
            visibility: visible;
        }

        .yk-background {
            background-color: #f7b538;

        }

        .yk-btn-success {
            color: #fff;
            background-color: #f7b538;
            border-color: #ffa713;
        }

        .yk-btn-success:hover {
            color: #fff;
            background-color: #f7b538;
            border-color: #d99421;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            overflow: auto;
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        h1 {
            font-weight: bold !important;
        }

        /* zh-media-query */
        @media (max-width: 576px) {
            .zh-header_shop {
                margin-left: 0% !important;
            }

            .yk-info .yk-tootips {
                border: 2px solid #680606;
                background: #730d18;
                color: white;
                padding: 10px;
                width: 314px;
                position: absolute;
                left: 14px;
                z-index: 2222;
                visibility: hidden;
                font-family: 'Myanmar3', Sans-Serif !important;
                line-height: 1.5;


            }
        }
    </style>
    @stack('css')
</head>

<body onbeforeunload="useroffline()" class="hold-transition sidebar-mini">
    @php
        use App\Models\Shops;
        use App\Models\Manager;
        if ($is_chat_on) {
            $current_shop = Shops::where('id', Auth::guard('shop_owners_and_staffs')->user()->shop_id)->first();
            $roleid = Auth::guard('shop_owners_and_staffs')->user()->role->id;

            if ($roleid == 4) {
                $shop_role = Auth::guard('shop_owners_and_staffs')->user()->name . ' (Owner)';
            } elseif ($roleid == 1) {
                $shop_role = Auth::guard('shop_owners_and_staffs')->user()->name . ' (Admin)';
            } elseif ($roleid == 2) {
                $shop_role = Auth::guard('shop_owners_and_staffs')->user()->name . ' (Manager)';
            } elseif ($roleid == 3) {
                $shop_role = Auth::guard('shop_owners_and_staffs')->user()->name . ' (Staff)';
            }
        }

    @endphp
    <div class="wrapper" id="backend" style="height: 100%;">
        @if ($is_chat_on = 'on')

            @if (isset(Auth::guard('shop_owners_and_staffs')->user()->id))
                <shopownerchatwrapper ref="chatwrapper" v-on:getfromid="getfromidparent"
                    v-bind:shopid="{{ $current_shop->id }}"></shopownerchatwrapper>
                <shopownerchattemplate ref="chatref" v-on:openmain="toopenmainchatwrapper"
                    v-bind:chatdatafromparent="this.chatdata" v-bind:shopdatafromparent="{{ $current_shop }}"
                    v-bind:shop_role="'{{ $shop_role }}'"></shopownerchattemplate>
            @endif
        @endif

        @yield('content')


    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->

    <script type='text/javascript' src="{{ url('js/backend.js') }}"></script>
    <script src="{{ url('test/js/fancybox.js') }}"></script>
    <script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ url('js/be7d01d228.js') }}" crossorigin="anonymous"></script>
    <script src="{{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-select/js/select.bootstrap4.js') }}"></script>

    <script src="{{ url('plugins/datatables-select/js/dataTables.select.js') }}"></script>
    <script src="{{ url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script src="{{ url('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ url('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ url('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('plugins/summernote/summernote-bs4.min.css') }}">
    <script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('dist/js/demo.js') }}"></script>
    <!-- Page specific script -->
    <script src="{{ url('plugins/sweetalert2/sweetalert2.all.js') }}"></script>
    <link rel="stylesheet" href="{{ url('test/css/sntable.css') }}">

    {{-- Sweet Alert --}}
    <script src="{{ url('plugins/sweetalert2/sweetalert2.all.js') }}"></script>
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>

    {{-- select2 --}}
    <script src="{{ asset('assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

    @push('scripts')
        <script type="text/javascript">
            //test

            // Customize Fancybox
            Fancybox.bind('[data-fancybox="gallery"]', {
                Carousel: {
                    on: {
                        change: (that) => {
                            mainCarousel.slideTo(mainCarousel.findPageForSlide(that.page), {
                                friction: 0,
                            });
                        },
                    },
                },
            });

            function useroffline() {
                if (typeof Window.userid != undefined) {
                    return Window.allfrommsg.sendwhatuserisoffline(window.userid);

                }
            }

            let data = new Array();
            let localData = new Array();
            let item_id = new Array();
            let boxes = new Array();

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $.fn.dataTable
                    .tables({
                        visible: true,
                        api: true
                    })
                    .columns.adjust().responsive.recalc();
            })


            if (window.performance) {
                localStorage.removeItem('localData');
            }
        </script>

        <script src="{{ url('test/js/bootstrap-toggle.js') }}"></script>
    @endpush

    @stack('scripts')

</body>

</html>
