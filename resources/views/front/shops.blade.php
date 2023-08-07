@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    {{--MENU--}}
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')
    @include('layouts.frontend.allpart.mobile_search')

<div class="sop-font py-3 mx-4 px-md-5">
    <shops-all :latest_shops='{{$shops}}' :default="'{{$active}}'"></shops-all>
</div>

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
