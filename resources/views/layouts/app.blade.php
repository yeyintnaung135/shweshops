<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

     <!-- Font Awesome -->
     <link rel="stylesheet" href="{{url('fonts/css/all.min.css')}}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Myanmar3';
            src: local('Myanmar3'), url("{{url('mmfont/PyidaungsuZawDecode.woff2?93a8fffb927d8bfcaac5683829dcd048')}}") format('woff2'), url("{{url('PyidaungsuZawDecode.woff?0e8dd9ee5f902f7ff573524de8b4f94d')}}") format('woff');
        }
        .yk-font{
            font-family: 'Myanmar3', Sans-Serif !important;

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

        .yk-circle{
            border: 2px solid black;
            width: 36px;
            height: 36px;
            border-radius: 20px;
            text-align: center;
         }
        .yk-background{
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
        html, body {
            height: 100%;
            margin: 0;
            overflow: auto;
        }

        .highlight-text {
            color: #780116;
        }

        .btn-refresh {
            background-color: #780116;
            color: #fff;
            font-size: 1rem;
        }
        
        .vertical-center {
            min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
            min-height: 100vh; /* These two lines are counted as one :-)       */

            display: flex;
            align-items: center;
        }

        .icon-rotate {
            /* width: 100px; */
            animation: rotation 12s infinite linear;
        }

        @keyframes rotation {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(359deg);
            }
        }

    </style>

    @stack('css')
</head>
<body style="background-color:white;" class="yk-font">
<div style=""></div>
    <div id="app" >
{{--        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">--}}
{{--            <div class="container">--}}
{{--                <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--                    {{ config('app.name', 'Laravel') }}--}}
{{--                </a>--}}
{{--                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">--}}
{{--                    <span class="navbar-toggler-icon"></span>--}}
{{--                </button>--}}

{{--                <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--                    <!-- Left Side Of Navbar -->--}}
{{--                    <ul class="navbar-nav mr-auto">--}}

{{--                    </ul>--}}

{{--                    <!-- Right Side Of Navbar -->--}}
{{--                    <ul class="navbar-nav ml-auto">--}}
{{--                        <!-- Authentication Links -->--}}
{{--                        @guest--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
{{--                            </li>--}}
{{--                            @if (Route::has('register'))--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
{{--                        @else--}}
{{--                            <li class="nav-item dropdown">--}}
{{--                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                                    {{ Auth::user()->name }}--}}
{{--                                </a>--}}

{{--                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
{{--                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault()">--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                                        {{ __('Logout') }}--}}
{{--                                    </a>--}}

{{--                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--                                        @csrf--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                        @endguest--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </nav>--}}


        <main >
            @yield('content')
        </main>
        <script src="{{url('plugins/jquery/jquery.min.js')}}"></script>

        @stack('scripts')

    </div>
</body>
</html>
