@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    {{--MENU--}}
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu', ['display' => "hide"])
    
    {{-- end Menu--}}
    
  
    {{--<!-- #content -->--}}
    <div class="container-fluid">
        @if(isset(Auth::guard('web')->user()->id))
        <h3 class="baydin-h3">{{Auth::guard('web')->user()->username}} {{ \Carbon\Carbon::now()->format('F') }} Tarot Horoscopes</h3>
        @elseif(isset(Auth::guard('super_admin')->user()->id))
        <h3 class="baydin-h3">{{Auth::guard('super_admin')->user()->name}} {{ \Carbon\Carbon::now()->format('F') }} Tarot Horoscopes</h3>
        @elseif(isset(Auth::guard('shop_role')->user()->id))
        <h3 class="baydin-h3">{{Auth::guard('shop_role')->user()->name}} {{ \Carbon\Carbon::now()->format('F') }} Tarot Horoscopes</h3>
        @else
        <h3 class="baydin-h3">Your {{ \Carbon\Carbon::now()->format('F') }} Tarot Horoscopes</h3>
        @endif

        <div class="justify-content-center row">
            @foreach($baydins as $baydin)
        
            <div class="baydin_card card" style="width: 26rem;">
            @if(isset(Auth::guard('web')->user()->id))
                <a href="{{route('baydin_detail',$baydin->id)}}">
                <img class="card-img-top" src="{{'/images/baydin/'. $baydin->photo}}" alt="Card image cap">
                </a>
            @else
                <a data-toggle="modal" data-target="#orangeModalSubscription">
                <img class="card-img-top" src="{{'/images/baydin/'. $baydin->photo}}" alt="Card image cap">
                </a>
            @endif
                <img class="sign_img" src="{{'/images/baydin/sign/'. $baydin->sign_logo}}" alt="Card image cap">
                <div class="card-body">
                    <h2 class="b-title">{{$baydin->title}}</h2>
                    <h4 class="detail-subtitle card-subtitle mb-2 text-muted">Credit By::{{$baydin->credit}}</h4>
                    <p class="card-text">{!! Str::limit($baydin->description, 100) !!}</p>
                </div>
            </div>
                
            @endforeach

        
    
        </div>
    
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
 @include('layouts.frontend.birthdaypopup', ['display' => "show"])
 @include('layouts.frontend.birthday_thank', ['display' => "show"])
@push('custom-scripts')
    <script>
        // Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

document.addEventListener("DOMContentLoaded", function(event) { 
  modal.style.display = "block";
});

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == baydin_modal) {
        modal.style.display = "none";
    }
}

    </script>
@endpush
@push('css')
<style>
    .baydin-h3{
        color: #780116 !important;
        margin-top:2.2% !important;
        margin-left: 3% !important;
    }

    .b-title{
        margin-top: 4.2% !important;
        font-size: 150%;
    }
    .baydin_card{
        margin-top: 3% !important;
        border: none !important;
        width: 18rem;
        margin-left: 1%;
    }

    .row{
        --bs-gutter-x: 0rem !important;
    }

    .card-img-top{
        width: 95% !important;
    }

    .card-body{
        color: #780116 !important;
        margin-top: 40% !important;
        padding: 0rem 0rem !important;
    }

    .card-text p{
        width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sign_img{
        width: 33px !important;
    height: 33px !important;
    margin-top: -49.5%;
    margin-left: 80%;
    }

    .detail-subtitle{
        font-size: 100%;
        margin-top: 0.5% !important;
    }

    @media only screen and (max-width: 1280px){
       .baydin_card{
        width: 24rem !important;
       }
    }

    @media only screen and (max-width: 1211px){
        .baydin_card{
        width: 23rem !important;
       }
    }

    @media only screen and (max-width: 1162px){
        .baydin_card{
        width: 22rem !important;
       }
    }

    @media only screen and (max-width: 1113px){
        .baydin_card{
        width: 21rem !important;
       }
    }

    @media only screen and (max-width: 1063px){
        .baydin_card{
        width: 20rem !important;
       }
    }

    @media only screen and (max-width: 1013px){
        .baydin_card{
        width: 19rem !important;
       }

       .card-body{
        margin-top: 37% !important;
       }
    }

    @media only screen and (max-width: 964px){
        .baydin_card{
        width: 18rem !important;
       }
    }

    @media only screen and (max-width: 914px){
        .baydin_card{
        width: 17rem !important;
       }
    }

    @media only screen and (max-width: 865px){
        .baydin_card{
        width: 50rem !important;
       }

       .card-body{
        margin-top: 45% !important;
       }
    }

     @media only screen and (max-width: 568px){
        .baydin_card{
        width: 32rem !important;
       }
       .card-body{
        margin-top: 42% !important;
       }
    }
/* The Modal (background) */
.baydin_modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1000; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.baydin_modal .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50% !important;
    text-align: center;
}

/* The Close Button */
.close {
    color: #666161;
    float: left;
    font-size: 34px;
    font-weight: bold;
    margin-left: 93.1%;
    margin-top: -2%;
}

.result_link{
    color: #780116;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.gift_birth{
    width: 10%;
    margin-bottom: 4%;
    margin-top: -5%;
}

.alert-heading{
    font-size: 1.2rem;
    font-weight: bold;
    color: #780116 !important;
}

.birth-in{
    background-color: #fefefe !important;
    border: none !important;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    color: rgba(0, 0, 0, 0);
    opacity: 1;
    display: block;
    background: url('{{ asset("images/baydin/popup/Date.png")}}') no-repeat;
    width: 30px;
    height: 30px;
    border-width: thin;
}

.input-group-text{
    color: #7c7e81 !important;
}

.birth-btn{
    margin-left: 41%;
    width: 20%;
    background-color: #780116;
    color: #fefefe;
}

@media only screen and (max-width: 845px){
    .birth-btn{
        margin-left: 41%;
        width: 21%;
    }
    }
@media only screen and (max-width: 809px){
    .birth-btn{
        margin-left: 41%;
        width: 22%;
    }
    }
@media only screen and (max-width: 777px){
    .birth-btn{
        margin-left: 41%;
        width: 23%;
    }
    }
@media only screen and (max-width: 747px){
    .birth-btn{
        margin-left: 41%;
        width: 24%;
    }
    }
@media only screen and (max-width: 720px){
    .birth-btn{
        margin-left: 41%;
        width: 25%;
    }
    }
@media only screen and (max-width: 694px){
    .birth-btn{
        margin-left: 41%;
        width: 26%;
    }
    }
@media only screen and (max-width: 671px){
    .birth-btn{
        margin-left: 41%;
        width: 27%;
    }
    }
@media only screen and (max-width: 650px){
    .birth-btn{
        margin-left: 41%;
        width: 28%;
    }
    }
@media only screen and (max-width: 630px){
    .birth-btn{
        margin-left: 41%;
        width: 29%;
    }
    }
@media only screen and (max-width: 611px){
    .birth-btn{
        margin-left: 41%;
        width: 30%;
    }
    }
@media only screen and (max-width: 594px){
    .birth-btn{
        margin-left: 41%;
        width: 31%;
    }
    }
@media only screen and (max-width: 578px){
    .birth-btn{
        margin-left: 36%;
        width: 32%;
    }
    }
@media only screen and (max-width: 563px){
    .birth-btn{
        margin-left: 36%;
        width: 33%;
    }
    }
@media only screen and (max-width: 548px){
    .birth-btn{
        margin-left: 36%;
        width: 34%;
    }
    }
@media only screen and (max-width: 535px){
    .birth-btn{
        margin-left: 36%;
        width: 35%;
    }
    }
@media only screen and (max-width: 522px){
    .birth-btn{
        margin-left: 36%;
        width: 36%;
    }
    }
@media only screen and (max-width: 510px){
    .birth-btn{
        margin-left: 36%;
        width: 37%;
    }
    }
@media only screen and (max-width: 499px){
    .birth-btn{
        margin-left: 36%;
        width: 38%;
    }
    }
@media only screen and (max-width: 488px){
    .birth-btn{
        margin-left: 36%;
        width: 39%;
    }
    }
@media only screen and (max-width: 478px){
    .birth-btn{
        margin-left: 36%;
        width: 40%;
    }
    }
@media only screen and (max-width: 468px){
    .birth-btn{
        margin-left: 36%;
        width: 41%;
    }
    }
@media only screen and (max-width: 459px){
    .birth-btn{
        margin-left: 36%;
        width: 42%;
    }
    }
@media only screen and (max-width: 450px){
    .birth-btn{
        margin-left: 36%;
        width: 43%;
    }
    }
    
@media only screen and (max-width: 442px){
    .birth-btn{
        margin-left: 36%;
        width: 44%;
    }
    }
@media only screen and (max-width: 434px){
    .birth-btn{
        margin-left: 36%;
        width: 45%;
    }
    }
@media only screen and (max-width: 426px){
    .birth-btn{
        margin-left: 28%;
        width: 46%;
    }
    }
@media only screen and (max-width: 419px){
    .birth-btn{
        margin-left: 28%;
        width: 47%;
    }
    }
@media only screen and (max-width: 412px){
    .birth-btn{
        margin-left: 28%;
        width: 48%;
    }
    }

    .thank-icon{
        width: 29%;
    margin-left: 36%;
    margin-bottom: 6%
    }

    .gp-bicon{
        margin-left: 33%;
        margin-top: 1%;
        margin-bottom: 5%;
    }

    .thank-bicon{
        margin-left: 3%;
        width: 7%;
    }
    .first-thank{
        margin-bottom: 0rem !important;
    }
    .second-thank{
        margin-bottom: 2rem !important;
    }
    .thank-h4{
        margin-bottom: 2%!important;
    }

</style>
@endpush
