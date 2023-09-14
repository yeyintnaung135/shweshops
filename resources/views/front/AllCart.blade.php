@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')

    <div id="page" class="site my-0 py-0">

        {{-- MENU --}}

        {{-- end Menu --}}

        <div class="mb-5 pb-5">
            @if (Auth::check())
                <?php
                $logined = 'true';
                $userdata = 'null';
                if (session()->has('logined')) {
                    $checkloginnow = 'true';
                    $userdata = Auth::guard('web')->user();
                } else {
                    $checkloginnow = 'false';
                }
                ?>
            @else
                <?php $userdata = 'null';
                $logined = 'false';
                $checkloginnow = 'false'; ?>
            @endif
            <my-cart :userid="{{ $userdata }}" :checkloginnow="{{ $checkloginnow }}" :localkey="'cart'" :headertext="'My Cart Items'"
                :checkauth="{{ $logined }}" :fordate="'{{ \Carbon\Carbon::now() }}'"></my-cart>

        </div>


    </div>
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
@push('custom-scripts')
    <script src="{{ url('test/js/fancybox.js') }}"></script>
@endpush
