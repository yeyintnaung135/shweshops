@extends('layouts.frontend.frontend')
@section('content')
@include('layouts.frontend.allpart.for_mobile')
@include('layouts.frontend.allpart.upper_menu')
@include('layouts.frontend.allpart.menu')

    <div id="page" class="site my-0 py-0">

    {{--MENU--}}

    {{-- end Menu--}}

    <div class="mb-5 pb-5">
         <addtocart
            :userid="{{(Auth::guard('web')->user())}}"
            :usertype='"Users"'
            :localkey="'fav'"
            :headertext="'My Favorite Items'"
            :checkauth='{{Auth::guard('web')->check()}}'
            :username="'{{\Illuminate\Support\Facades\Auth::guard('web')->check() == 1 ? \Illuminate\Support\Facades\Auth::guard('web')->user()->username : '' }}'"
            :fordate="'{{\Carbon\Carbon::now()}}'"
          ></addtocart>

    </div>


    </div>
    <div class="pt-5">
      @include('layouts.frontend.allpart.footer')
  </div>
    {{--    <!-- .site-content-contain -->--}}
    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

    <div id="to-top" class="scroll-button">
      <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>

@endsection
@push('custom-scripts')
<script src="{{url('test/js/fancybox.js')}}"></script>

@endpush
