@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
{{--MENU--}}
@include('layouts.frontend.allpart.upper_menu')
@include('layouts.frontend.allpart.menu')
{{-- @include('layouts.frontend.allpart.mobile_search') --}}
{{-- end Menu--}}

    <div id="page" class="site my-0 py-0">


    <!--.site-content-contain -->

        <div class="mx-4 mx-md-0 ">

                <div id="contact-us" class="h-100 mt-2 mb-5 mb-lg-0 col-sm-12 col-xs-12 ">

                    <div class="upper text-center d-flex justify-content-center align-items-center flex-column my-5 py-md-3">
                        <h1>Contact Us</h1>
                        <p>{!! $contact->top_text !!}</p>
                        <div class=" d-flex justify-content-center align-items-center ">
                            <div class="d-flex justify-content-center align-items-center me-2">
                                <i class="fa-solid fa-phone pe-1 me-1"></i>{{ $contact->phone }}
                            </div>
                            <div class="d-flex justify-content-center align-items-center ms-2">
                                <i class="fa-solid fa-envelope pe-1 me-1"></i>{!! $contact->email !!}
                            </div>
                        </div>
                    </div>
                    <div class="h-100 my-5 mid d-flex justify-content-center align-items-center">
                        <div class="h-100 pe-5 mid-img col-md-6 d-none d-md-block">
                            <img src="{{ asset('images/contactus/'.$contact->image) }}" alt="">
                        </div>
                        <div class="h-100  px-xl-5 col-md-6 ">
                            <div class=" px-lg-5 d-flex justify-content-center align-items-center flex-column">
                                <h1>How to<br> Contact Us</h1>
                            <p>{!! $contact->mid_text !!}</p>
                            <a href="http://m.me/shweshops123" class=" justify contact-btm">စုံစမ်းရန်</a>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 pt-md-5 bottom d-flex justify-content-center align-items-center">

                        <div class="px-xl-5 text-center col-md-6">
                            <div class="mx-lg-5 px-md-5 d-flex justify-content-center align-items-center flex-column">
                                <h1>Address</h1>
                                <p>{!! $contact->address !!}</p>
                            </div>

                        </div>
                        <div class="ps-5 d-none d-md-block col-md-6 d-flex justify-content-center align-items-center flex-column">
                            <iframe src="{{ $contact->map }}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>



                </div>
                <div class="col-12" style="height: 222px !important;position:relative !important">
                    @include('layouts.frontend.allpart.loading_wrapper')

                </div>




                {{-- <!-- Right Sidebar -->--}}

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


</script>
@endpush
@push('css')
    <style>
        #contact-us{
            font-weight: 600;
            color: rgb(90, 90, 90);
            line-height: 30px;
            font-size: 1.1em;
        }
        .upper a, .upper i{
            color: #780116!important;
        }
        .mid-img img{
            min-height: 400px;
            max-height: 500px;
            width: 100%;
            object-fit: cover;
        }
        #contact-us h1{
            color: #000000!important;
            font-size: 2.5rem;
            font-weight: 800;
            padding-bottom:1rem;
        }

        .contact-btm{
            background-color: #780116;
            color: white!important;
            padding: 8px 30px;
            border-radius:8px;
            border: 1px solid #780116;
        }
        .contact-btm:hover{
            background-color: #f3f3f3b9;
            color:#780116!important;
            border: 1px solid #780116;
        }

        @media only screen and (max-width: 768px){
            .contact-btm{
                align-self: center;
            }
            .upper br {
                display: none;
            }
            .mid br {
                display: none;
            }
            .mid {
                text-align: center;
            }
            .bottom{
                text-align: center;
            }
        }
        @media only screen and (min-width: 768px){
            .contact-btm{
                align-self: flex-start;
            }
            .mid p{
                text-align: left;
                align-self: flex-start;
            }
            .mid h1{
                text-align: left!important;
                align-self: flex-start;
            }
            .bottom p{
                text-align: left;
                align-self: flex-start;
            }
            .bottom h1{
                text-align: left!important;
                align-self: flex-start;
            }
        }

    </style>
@endpush
