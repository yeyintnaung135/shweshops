<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('images/logo/favicon.gif') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ url('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ url('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('plugins/summernote/summernote-bs4.min.css') }}">
    <!-- image-cropping  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/cropperjs/dist/cropper.css">
    <!-- image-cropping  -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
    <style>
        a {
            text-decoration: none;
        }

        .custom-info {
            background-color: #17a2b8;
            color: #ffffff;
        }

        @media only screen and (max-width: 600px) {
            .dashboard .card {
                width: 17rem !important;
                margin-right: 10px !important;
                margin-left: 49px !important;
            }
        }

        @media only screen and (max-width: 992px) {
            .dashboard .card {
                width: 17rem !important;
                margin-right: 10px !important;
                margin-left: 49px !important;
            }

            .daily {
                margin-right: -15px !important;
                margin-left: -15px !important;
            }
        }
    </style>
    @php
        use Illuminate\Support\Carbon;
    @endphp
    @stack('css')
</head>

<body class="hold-transition sidebar-mini">
    <div id="app">
        @yield('content')
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ url('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <!-- Summernote -->
    <script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
    <!-- CodeMirror -->
    <script src="{{ url('plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ url('plugins/codemirror/mode/css/css.js') }}"></script>
    <script src="{{ url('plugins/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ url('plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/cropperjs"></script>
    <script src="{{ asset('js/tz.js') }}"></script>
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <!-- chart.js  -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
@stack('scripts')

</html>
