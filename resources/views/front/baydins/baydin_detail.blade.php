@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    {{--MENU--}}
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu', ['display' => "hide"])
    {{-- @include('layouts.frontend.allpart.mobile_search', ['display' => "hide"]) --}}
    {{-- end Menu--}}

    <div id="page" class="site my-0 py-0">


        <!--.site-content-contain -->
        <div class="site-content-contain">

        </div>
        <div class="mx-4 px-md-5 show_breadcrumb">
            <div class="row">


                <div id="main-content" class="mt-2 mb-5 col-sm-12 col-xs-12 ">

                <!-- <live-wrapper></live-wrapper> -->
                    <div class="row">
                        <div id="detail" class="col-9">
                        <img class="baydin-img" src="{{'/images/baydin/'. $baydin->photo}}" alt="Card image cap">
                        <!--<h2 class="result_h2"><span class="result_of">Result of</span> " Scorpio Monthly Career and Business and finance Horoscopes</h2>-->

                        <div class="d-flex">
                            <img class="baydin-sign" src="{{'/images/baydin/sign/'. $baydin->sign_logo}}" alt="Card image cap">
                            <h3 class="sign-h3">{{$baydin->title}}</h3>

                        </div>
                        <h4 class="detail-subtitle card-subtitle mb-2 text-muted">Credit By::{{$baydin->credit}}</h4>
                        <ul class="list">
                            <li>{!! $baydin->description  !!}</li>
                        </ul>

                        </div>

                        <div class="recommend col-3">
                            @if(count($baydins)  == 0)
                                <h3 class="d-none recom_h3">Lwel</h3>
                                @else
                                <h3 class="recom_h3">Other Related Tarot</h3>
                            @endif

                            @foreach($baydins as $baydin)
                            <div class="baydin_card card" style="width: 18rem;">
                            <a href="{{route('baydin_detail',$baydin->id)}}">
                                <img class="card-img-top" src="{{'/images/baydin/'. $baydin->photo}}" alt="Card image cap">
                                </a>
                                <img class="sign_img" src="{{'/images/baydin/sign/'. $baydin->sign_logo}}" alt="Card image cap">
                                <div class="card-body">
                                <h3 class="sign-h3">{{$baydin->title}}</h3>
                                <h4 class="related-subtitle card-subtitle mb-2 text-muted">Credit By::{{$baydin->credit}}</h4>
                                    <p class="card-text">{!! Str::limit($baydin->description, 100) !!}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>

                </div>
                <!-- <div class="col-12" style="height: 222px !important;position:relative !important">
                    @include('layouts.frontend.allpart.loading_wrapper')

                </div> -->




                {{-- <!-- Right Sidebar -->--}}
            </div>
        </div>
    </div>
    {{--<!-- #content -->--}}

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
@push('custom-scripts')
    <script>
        function responsive(maxWidth){


        if (maxWidth.matches) { // If media query matches
            element.classList.add("col-12");
            element.classList.remove("col-9");

        } else {
            element.classList.add("col-9");
            element.classList.remove("col-12");
        }
        }

        var element = document.getElementById("detail");
        var maxWidth= window.matchMedia("(max-width: 991px)");
        var y = window.matchMedia("(max-width: 992px)");
        responsive(maxWidth);
        maxWidth.addListener(responsive);

    </script>
@endpush
@push('css')
<style>
    .recom_h3{
        font-size: 19px !important;
        margin-top: 15% !important;
    }

    .baydin_card{
        margin-top: 10% !important;
        border: none !important;
    }

    .card-text{
        margin-left: -5%;
    }


    .card-body{
        color: #780116 !important;
        margin-top: 8rem !important;
        padding: 0rem 0rem !important;
        margin-left: 5%;
    }


    .baydin-img{
        margin-top: 4%;
        height: auto;
        width: 93%;
        border-radius: 5px;
    }

    .result_h2{
        margin-top: 2%;
        font-size: 2px;
        margin-top: 4%;
        font-size: 30px;
    }

    .result_of{
        color: #780116;
    }

    .baydin-sign{
        width: 33px !important;
        height: 33px !important;
        margin-top: 3.5%;
    }


    .list{
        list-style-type: "-";
        margin-top: 3%;

    }

    .sign-h3{
        font-size: 125%;
        margin-top: 4%;
        margin-left: 2%;
    }

    .sign_img{
        width: 33px !important;
    height: 33px !important;
    margin-top: -49.5%;
    margin-left: 80%;
    }

    .detail-subtitle{
        font-size: 100%;
        margin-left: 5.5%;
    }

    .related-subtitle{
        margin-top: 1% !important;
        font-size: 100%;
        margin-left: 0.5%;
    }

    @media only screen and (max-width: 1080px){
        .baydin_card{
        width: 15rem !important;
       }
       .card-body{
        margin-top: 6rem !important;
       }
    }

    @media only screen and (max-width: 992px){
        .recommend{
        /* width: 15rem !important; */
        display: block !important;
       }
    }
    @media only screen and (max-width: 991px){
        .recommend{
        /* width: 15rem !important; */
        display: none !important;
       }
    }
</style>
@endpush
