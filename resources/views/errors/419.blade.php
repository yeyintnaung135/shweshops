@extends('layouts.app ')
@section('title', __('Not Found'))
@section('content')

    <div class="container vertical-center">
        <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center ">
                <img src="{{asset('images/icons/refresh.png')}}" alt="" srcset="" style="width: 100px" class="icon-rotate">
            </div>
            <div class="col-12 d-flex justify-content-center align-items-center pt-5">
                <h3 class="text-center">ဤ Page ကို <span class="highlight-text">refresh</span> လုပ်ပြီး <span class="highlight-text">Shwe Shops Website</span> အားပြန်လည်အသုံးပြုနိုင်ပါသည်။</h3>
            </div>
            <div class="col-12 d-flex justify-content-center align-items-center pt-5">
                <button class="btn btn-refresh px-5 py-2" id="refresh_btn" onclick="reload()">Refresh</button>
            </div>
        </div>
    </div>

    <!-- <div id="notfound">
        <div class="notfound">
            <div class="notfound-404 mb-5">
                <h1>4<span>0</span>4</h1>
            </div>
            <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
            <a href="/">home page</a>
        </div>
    </div> -->

@endsection
@push('scripts')
    <script>
        console.log('ffffffxxxxx')
        console.log(location.href.indexOf('login'))
        function reload(){

            if(location.href.indexOf('login') > -1 || location.href.indexOf('logout') > -1 ){
                location.assign( "https://" + window.location.hostname)

            }else{
                location.assign("{{url()->current()}}")

            }
        }
    </script>
    @endpush
