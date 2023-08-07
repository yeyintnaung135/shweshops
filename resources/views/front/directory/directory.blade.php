@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    {{--MENU--}}
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')
    {{-- @include('layouts.frontend.allpart.mobile_search') --}}
    {{-- end Menu--}}
    <div id="page" class="site my-0 py-0">

      <div>
        <see-all-shop-directory :shops="{{ $data }}" :states="{{ $states }}"></see-all-shop-directory>
      </div>

      <div class="mx-4 mx-md-3">
        <div class="col-12" style="height: 222px !important;position:relative !important">
            @include('layouts.frontend.allpart.loading_wrapper')
        </div>

      </div>
    </div>
    {{--<!-- #content -->--}}
    <div class="pt-5">
        @include('layouts.frontend.allpart.footer')
    </div>


    {{--    <!-- .site-content-contain -->--}}
    <div class="ftc-close-popup"></div>
    @include('layouts.frontend.allpart.mobile_footer')
    {{-- <div id="to-top" class="scroll-button">
        <a class="" href="javascript:void(0)" title="Back to Top">Back to Top</a>
    </div> --}}
    <div id="to-top" class="scroll-button">
        <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>
    <div class="popupshadow" style="display:none"></div>


@endsection

@push('css')
    <style>
      .sop-filter-search {
        padding: 0rem 1rem 0 0rem !important;
      }
        @media (min-width: 576px) {

        }


        @media (min-width: 576px) {
            .sop-nav .navbar-expand-sm .navbar-nav .nav-link {
                padding-right: 1.5rem !important;
                padding-left: 0rem !important;
            }

            .zh_nav a {
                font-size: 1.3rem;
            }
        }

    </style>
@endpush
