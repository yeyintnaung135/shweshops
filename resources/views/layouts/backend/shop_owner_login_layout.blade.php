<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" sizes="19x19" href="{{ url('images/logo/favicon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" type="text/css" href="{{ url('plugins/jquery-ui/jquery-ui.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ url('fonts/ssp.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ url('test/css/bootstrap-toggle.css') }}">


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

<body class="hold-transition sidebar-mini">

    <div class="wrapper" id="backend" style="height: 100%;">
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
    <!-- AdminLTE App -->
    <script src="{{ url('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('dist/js/demo.js') }}"></script>

    <link rel="stylesheet" href="{{ url('test/css/sntable.css') }}">

    @stack('scripts')

</body>

</html>
