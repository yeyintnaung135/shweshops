@extends('layouts.frontend.frontend')
@section('content')
@include('layouts.frontend.allpart.for_mobile')
@include('layouts.frontend.allpart.upper_menu')
@include('layouts.frontend.allpart.menu')

    <div id="page" class="site my-0 py-0">

    
    <!--.site-content-contain -->
        <div class="site-content-contain">

        </div>
        <div class="page-container container pl-0 pr-0 show_breadcrumb_">
            <div class="row">
                <div id="main-content" class="mt-2 col-sm-12 col-xs-12 ">
                    <div class="col-12" style="height: 222px !important;position:relative !important">
                        @include('layouts.frontend.allpart.loading_wrapper')
                    </div>
                    {{--                    new item--}}
                    <seeallnews-collections :newitems="{{$collection}}" :uri="'get_collection'"></seeallnews-collections>
                    {{--                    new item--}}
                </div>
                <div class="col-12" style="height: 222px !important;position:relative !important">
                    @include('layouts.frontend.allpart.loading_wrapper')

                </div>




                {{-- <!-- Right Sidebar -->--}}
            </div>
        </div>
    </div>
    {{--<!-- #content -->--}}
    </div>
    {{--    <!-- .site-content-contain -->--}}

    <div class="pt-5">
        @include('layouts.frontend.allpart.footer')
    </div>
    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

    <div id="to-top" class="scroll-button">
      <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>

    <div class="popupshadow" style="display:none"></div>



@endsection
@push('script')
@endpush
