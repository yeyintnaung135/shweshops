@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')

    <div id="page" class="site ms-md-5 me-md-5 my-0 py-0">
        <?php
        if(\Illuminate\Support\Facades\Auth::guard('shop_owner')->check() or \Illuminate\Support\Facades\Auth::guard('shop_role')->check()){
            $shoploginned='yes';
        }else{
            $shoploginned='no';
        }
        ?>
            <support-help :data="{{$data}}" :cats="{{$cats}}" :shopauth="'{{$shoploginned}}'"></support-help>

    </div>

    <div class="pt-5">
        @include('layouts.frontend.allpart.footer')
    </div>
    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

    <div id="to-top" class="scroll-button">
        <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>

@endsection
@push('custom-scripts')

@endpush
@push('css')
    <style>
        .yksupport{
            padding:43px;
        }

        .yksupport .no-gutters div:nth-child(1){
            font-size: 20px;
            display: flex;
            /* width:195px; */
            align-items: center;
        }

        .yksupport .no-gutters div:nth-child(2){
            font-size: 25px;
            display: flex;
            width:200px;
            align-items: center;
        }
        @media only screen and (max-width: 900px) {
            .yksupport {
               padding:15px;
            }

            .yksupport .no-gutters div:nth-child(1){
              font-size: 20px;
              margin-bottom: 10px;

            }


        }


    </style>
@endpush


