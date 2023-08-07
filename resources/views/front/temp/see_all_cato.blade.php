@extends('layouts.frontend.frontend')
@section('content')
@include('layouts.frontend.allpart.for_mobile')
@include('layouts.frontend.allpart.upper_menu')
@include('layouts.frontend.allpart.menu')
@include('layouts.frontend.allpart.mobile_search')

<div id="page" class="site my-0 py-0">
    {{--MENU--}}
    @include('layouts.frontend.allpart.menu')
    {{-- end Menu--}}
    <!--.site-content-contain -->
        
            <div id="main-content" class="mt-2 col-sm-12 col-xs-12 ">
                <div class="col-12" style="height: 222px !important;position:relative !important">
                    @include('layouts.frontend.allpart.loading_wrapper')
                </div>
                <div class="px-0 mx-0 px-md-5 mx-md-5">
                    <div class="py-3 px-3 px-md-0">
                        @include('front.temp.parts.filter')
                    </div>
                    <div class="py-3 ps-3 ps-md-0">
                        @include('front.temp.parts.shops')
                    </div>
                    <div class="py-3 px-3 px-md-0">
                        @include('front.temp.parts.results')
                    </div>
                </div>
            </div>
</div>
<div class="py-3 px-3 px-md-0">
    @include('front.temp.parts.discount_items')
</div>
<div class="pt-5">
    @include('layouts.frontend.allpart.footer')
</div>
{{--<!-- #content -->--}}
<div class="ftc-close-popup"></div>
@include('layouts.frontend.allpart.mobile_footer')
<div id="to-top" class="scroll-button">
  <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
</div>
<div class="popupshadow" style="display:none"></div>
@endsection

@push('custom-scripts')
<script src="{{url('test/js/fancybox.js')}}"></script>

@endpush