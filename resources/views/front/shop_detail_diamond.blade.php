@extends('layouts.frontend.frontend')
@section('content')
@push('css')
<style>
    .contact-modal-header{
        background-color: #fff !important;
    }

    .contact-modal-body{
        background-color: #fff !important;

    }
    .contact-modal{
        background-color: #fff !important ;
    }
</style>

@endpush
@include('layouts.frontend.allpart.for_mobile')
@include('layouts.frontend.allpart.upper_menu')
@include('layouts.frontend.allpart.menu')

<div id="page" class="site my-0 py-0" style="background-color: #f1f7fb;">
    {{--MENU--}}
    {{-- end Menu--}}
    <!-- .site-content-contain -->
    <div class="site-content-contain sop-font">
        {{-- breadcum--}}
        {{--banner pic --}}     
        <div class="px-lg-5 mx-lg-3 py-0 my-0">
            <div class="position-relative">
                <div id='main_slide' class="text-center owl-carousel owl-theme w-100" style="z-index: -1">
                    @if((count($shop_data->getPhotos) != 0))
                        @foreach ( $shop_data->getPhotos as $img)
                        <img class="item zh-main_slide" 
                        src="{{ url('images/banner/'.$img->location)}}"/>
                        @endforeach
                    @elseif(!empty($shop_data->shop_banner))
                        <img class="item zh-main_slide"
                        src="{{ url('images/banner/'.$shop_data->shop_banner)}}"/>
                    @else
                        <img class="item zh-main_slide"
                        src="{{ url('images/banner/default.png')}}"/>
                    @endif
                </div>
            </div>
        </div>
        {{--banner pic --}}
        <div id="content" class="site-content">
            {{-- profile --}}
            <div class="px-2 px-lg-5 mx-lg-3 mx-1 pb-lg-0 pb-3 text-left">
                
                <div class="row ms-lg-5 ms-1" style="min-height: 80px;">
                    <div class="col-12 col-lg-6 d-flex p-0">
                        {{-- Shop Logo --}}
                        <div class="premium-logo-wrap">
                            <img src="{{url('/images/logo/'.$shop_data->shop_logo)}}" class="premium-logo" alt="shop logo">
                                <div class="premium-logo">
                                    <img src="{{url('/images/directory/banner/Corner_1_Diamond.png')}}" alt="" srcset="" class="profile-kanote profile-kanote-1">
                                    <img src="{{url('/images/directory/banner/Corner_2_Diamond.png')}}" alt="" srcset="" class="profile-kanote profile-kanote-2">
                                </div>
                        </div>
                        {{-- End Shop Logo --}}

                        <div class="sop-font ps-lg-4 ps-2 pt-3 ">
                            {{-- Shop Name --}}
                            <div class="ps-3 pt-1">
                                <div class="row g-0">
                                    <p class="premium-title premium-title-diamond">
                                        {{$shop_data->shop_name}}
                                        {{-- Eaint Yadanar Phyo Diamond Gold & Jewellery --}}
                                        <img src="{{url('/images/directory/banner/Diamond_Mark.png')}}" alt="" srcset="" class="premium-badge ms-1">
                                    </p>
                                    
                                </div>
                                <div class="row g-0">
                                    <p class="premium-title-myan pt-sm-1">
                                        ({{$shop_data->shop_name_myan}})
                                    </p>
                                </div>
                                <div class="d-flex mb-1">
                                    <div class="d-flex d-lg-none ms-2">
                                        <div class="d-flex text-center position-relative">
                                            <div class="icon-bg mx-auto icon-bg-diamond " style="width:24px; height:24px;">
                                                <i class="fa-regular fa-eye text-secondary text-diamond" style="font-size: 12px; margin-top:6px;"></i>
                                            </div>                   
                                            <p class="mt-1 ms-lg-3 ms-2 me-lg-4 me-3 text-diamond" style="font-size: 14px;">{{ $view_count }}</p>
                                        </div>
                                        <div class="d-flex text-center position-relative">
                                            <div class="icon-bg mx-auto icon-bg-diamond" style="width:24px; height:24px;">
                                                <i class="fa-regular fa-heart text-secondary" style="font-size: 12px; margin-top:6px;"></i>
                                            </div>
                                            <p class="mt-1 ms-lg-3 ms-2 me-lg-4 me-3 text-diamond" style="font-size: 14px;">{{ $favcount }}</p>             
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Shop Name --}}
                        </div>
                    </div>
                </div>

                
                <!-- Contact buttons section -->
                <div class="d-flex justify-content-between ms-lg-5 ms-2" style="max-height: 60px;">
                    <div class="d-flex">
                        <span class="d-none d-xl-inline" style="width: 180px;">
                        </span>
                        {{-- FB & Messenger --}}
                        <div class="social-wrap d-flex justify-content-center">
                            <div class="pt-lg-2 pt-1 pe-lg-5 pe-4">
                                <a href="{{$shop_data->page_link}}" class="">
                                    <i class="fa-brands fa-facebook pt-1" style="font-size:24px !important;"></i>
                                </a>
                            </div>
                            <div class="pt-lg-2 pt-1">
                                <a href="{{$shop_data->messenger_link}}" class="">
                                    {{-- <i class="fab fa-facebook-messenger pt-1" style="font-size:24px !important;"></i> --}}
                                    <img src="{{url('images/icons/messenger.png')}}" alt="" srcset="" width="24px" class="pt-1">
                                </a>
                            </div> 
                        </div>   
                        {{-- End FB & Messenger --}}
                    </div>

                    <div class="d-flex flex-fill">
                        {{-- Email --}}
                            <div class="ps-4 me-2 flex-grow-1 flex-sm-grow-0">
                                @if(!empty($shop_data->email))
                                <a href="mailto:{{$shop_data->email}}" data-toggle="modal" data-target="#email" class="sop-social btn px-3 px-lg-5 py-2 btn-premium-grey justify-content-center" id="email-button">
                                    <i class="sop-social-i far fa-envelope pe-1 pe-md-2 sn-phone text-secondary" style="margin-top:3px;"></i>
                                    <div class="sop-social-i text-secondary">Email</div>
                                </a>
                                <!-- Email Modal -->
                                <div class="modal fade contact-modal-backside" id="email" tabindex="-1" aria-labelledby="emailModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header ">
                                                <h5 class="modal-title mx-auto" id="emailModal">Email</h5>
                                                <a type="button" class="close-style2" data-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></a>
                                            </div>
                                            <div class="modal-body mx-3" id="email_modal">
                                                <a href="mailto:{{$shop_data->email}}" class=" sop-social">
                                                    <i class="sop-social-i far fa-envelope pe-1 pe-md-2 sn-phone pt-1"></i>
                                                    {!!nl2br($shop_data->email)!!}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Email Modal --}}
                                @else
                                <a href="mailto:{{$shop_data->email}}" data-toggle="modal" data-target="#email" class="sop-social btn px-3 px-lg-5 py-2 btn-premium-grey justify-content-center" id="email-button">
                                    <i class="sop-social-i far fa-envelope pe-1 pe-md-2 sn-phone text-secondary" style="margin-top:3px;"></i>
                                    <div class="sop-social-i text-secondary">Email</div>
                                </a>

                                <div class="modal fade contact-modal-backside" id="email" tabindex="-1" aria-labelledby="emailModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header ">
                                                <h5 class="modal-title" id="emailModal">Email</h5>
                                                <a type="button" class="close-style2" data-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></a>
                                            </div>
                                            <div class="modal-body mx-3">
                                                <a href="#" class=" sop-social">
                                                    No email.
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                        {{-- Phone --}}
                            <div class="ps-2 flex-grow-1 flex-sm-grow-0">
                                @if(!empty($shop_data->main_phone))
                                <a href="tel:{{$shop_data->main_phone}}" data-toggle="modal" data-target="#phone" class="sop-social btn px-3 px-lg-5 py-2 btn-premium-diamond justify-content-center" id="phone-button">
                                    <i class="sop-social-i fa-solid fa-phone pe-1 pe-md-2" style="margin-top:3px;"></i>
                                    <div class="sop-social-i">Call Now</div>
                                </a>
                                <!-- Phone Modal -->
                                <div class="modal fade contact-modal-backside" id="phone" tabindex="-1" aria-labelledby="phoneModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header position-relative">
                                                <img src="/images/directory/banner/TitleIcons.png" alt="" srcset="" class="title-icons">
                                                <h3 class="modal-title mx-auto ps-5" id="phoneTitle" style="font-weight: 700; color:black; font-size: 20px;">ဖုန်းနံပတ်များ</h3>
                                                <a type="button" class="close-style2" data-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></a>
                                            </div>


                                            <div class="modal-body mx-3" id="phone_modal">
                                                <div class="address-header mt-3 mb-3">
                                                    <h3 class="address-title pb-1 d-inline" style="font-weight: 700; color:black; font-size: 18px; border-bottom:2px solid #780116">Phone 1</h3>
                                                </div>
                                                <a href="tel:{{$shop_data->main_phone}}" class=" sop-social">
                                                    <i class="sop-social-i fa-solid fa-phone pe-1 pe-md-4 sn-phone pt-1"></i>
                                                    {!!nl2br($shop_data->main_phone)!!}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Phone Modal --}}
                                @else
                                <a href="tel:{{$shop_data->main_phone}}" data-toggle="modal" data-target="#phone" class="sop-social btn px-3 px-lg-5 py-2 btn-premium-diamond justify-content-center" id="phone-button">
                                    <i class="sop-social-i fa-solid fa-phone pe-1 pe-md-2 text-secondary" style="margin-top:3px;"></i>
                                    <div class="sop-social-i">Call Now</div>
                                </a>

                                <div class="modal fade contact-modal-backside" id="phone" tabindex="-1" aria-labelledby="phoneModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header ">
                                                <h3 class="modal-title ms-auto" id="phoneTitle" style="font-weight: 700; color:black; font-size: 20px;">ဖုန်းနံပတ်များ</h3>
                                                <a type="button" class="close-style2" data-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></a>
                                            </div>
                                            <div class="modal-body mx-3">
                                                    No Phone.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    {{-- End Phone --}}
                    {{-- Contact --}}
                    {{-- <div>
                        
                        <a href="#contact" data-toggle="modal" data-target="#contact" class="sop-social premium-btn-main" id="contact-button">
                            <i class="sop-social-i fa-solid fa-location-dot pe-1 pe-md-2"></i>
                            <div class="d-none d-sm-block">Contact</div>
                        </a>
                        <!-- Contact Modal -->
                        <div class="modal fade contact-modal-backside" id="contact" tabindex="-1" aria-labelledby="contactModal" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content contact-modal">
                                    <div class="modal-header contact-modal-header">
                                        <h3 class="modal-title mx-3" id="contactModal" style="font-weight: 700; color:black">Shop <span style="color:#780116">Address</span></h3>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body mx-3 contact-modal-body" id="phone_modal">
                                        @if(!empty($shop_data->address))
                                        <p class="text-break" style="text-align: left; font-size: 18px;height: auto; overflow: auto; line-height: 30px">
                                            {!! $shop_data->address !!}
                                        </p>
                                        @endif
                                    </div>

                                    {{-- more address -a-}}
                                    @if(isset($shop_data->other_address) || !is_null($shop_data->other_address) || !empty($shop_data->other_address))
                                    <a class="w-100" data-toggle="collapse" href="#collapseMoreAddr" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="d-flex justify-content-between modal-body mx-3 py-0 sop-chevron " id="address-class">
                                            <p class="text-break" style="text-align: left; font-size: 20px;height: auto; overflow: auto; line-height: 32px;color:black;font-weight:700">
                                                Other Address
                                            </p>
                                            <i id="address-class-i" class="sop-arrow fa-solid fa-chevron-down"></i>
                                        </div>
                                    </a>
                                    <div class="collapse" id="collapseMoreAddr">
                                        <div class="modal-body py-0  mx-3">
                                            <p class="text-break" style="text-align: left; font-size: 18px;height: auto; overflow: auto; line-height: 30px;color:#212529">
                                                {!! $shop_data->other_address !!}
                                            </p>
                                        </div>
                                    </div>


                                    @endif
                                    {{-- more address -a-}}
                                    {{-- Map -a-}}
                                    <a class="w-100 mt-2" data-toggle="collapse" href="#collapseMap" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div  class="d-flex justify-content-between modal-body mx-3 py-0 sop-chevron " id="map-class">
                                            <p class="font-weight-bold text-break" style="text-align: left; font-size: 20px;height: auto; overflow: auto; line-height: 32px; color:black;font-weight:700" >
                                                Google Map
                                            </p>
                                            <i id="map-class-i" class="sop-arrow fa-solid fa-chevron-down"></i>
                                        </div>
                                    </a>
                                    <div class="collapse" id="collapseMap">
                                        <div class="">
                                            @if(!isset($shop_data->map) || is_null($shop_data->map) || empty($shop_data->map))
                                            <iframe class="sop-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15472351.946258605!2d87.60098124688682!3d18.778995379761387!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x305652a7714e2907%3A0xba7b0ee41c622b11!2sMyanmar%20(Burma)!5e0!3m2!1sen!2smm!4v1657253955978!5m2!1sen!2smm" width="2000" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            @else
                                            <iframe class="sop-map" src="{{ $shop_data->map }}" width="2000" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- map -a-}}
                                </div>
                            </div>
                        </div>
                        {{-- End Contact Modal -a-}}
                    </div> --}}
                    {{-- End Contact --}}
                    <div class="d-lg-flex d-none" style="margin-top:-30px;">
                        <div class="text-center position-relative" style="width:150px; ">
                            <div class="icon-bg text-center mx-auto icon-bg-diamond" style="width:46px; height:46px;">
                                <i class="fa-regular fa-eye text-diamond" style="margin-top:14px;"></i>
                            </div>
                            <p class="mt-3 text-diamond">
                                {{ $view_count }} 
                                <span class="text-diamond-2">
                                    Visitors
                                </span>
                            </p>
                        </div>
                        <div class="text-center d-md-inline d-none position-relative" style="width:150px;">
                            <div class="icon-bg text-center mx-auto icon-bg-diamond" style="width:46px; height:46px;">
                                <i class="fa-regular fa-heart mt-3 text-diamond" style="margin-top:14px;"></i>
                            </div>
                            <p class="mt-3 text-diamond">
                                {{$favcount}} 
                                <span class="text-diamond-2">
                                    Likes
                                </span>
                            </p>
                        </div>
                    </div>
                    <!-- End Contact buttons section -->
                </div>

                <div class="mx-lg-4 m-1 my-lg-4 my-3">
                    <div class="diamond-hr"></div>
                </div>

                <div class="contact-wrap ms-lg-5 ms-1">
                    {{-- description --}}
                    <div class="content sop-opacity-8 m-0 ps-1 animation" style="font-size: 1em;">
                        {!! $shop_data->description !!}
                    </div>
                    <div class="txtcol">
                        <a class="text-muted">... See More</a>
                    </div>

                    {{-- address --}}
                    <div class="d-flex pt-4">
                        <i class="fas fa-map-marker-alt text-secondary" style="font-size: 30px"></i>
                        <div class="ps-4 pt-1 flex-fill">
                            <div class="address-text d-inline">{!! $shop_data->address !!}</div>
                            @if(isset($shop_data->other_address) || !is_null($shop_data->other_address) || !empty($shop_data->other_address))
                                <a href="#contact" data-toggle="modal" data-target="#contact" class="text-muted pt-1 ps-4 d-inline" id="contact-button">... See More</a>
                            @endif
                        </div>

                        

                        <!-- Modal -->
                        {{-- <div class="modal fade" id="contact" tabindex="-1" aria-labelledby="contactModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-left">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title mx-3" id="contactModal" style="font-weight: 700; color:black">Shop <span style="color:#780116">Address</span></h3>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body mx-3 contact-modal-body" id="phone_modal">
                                        @if(!empty($shop_data->address))
                                        <p class="text-break" style="text-align: left; font-size: 18px;height: auto; overflow: auto; line-height: 30px">
                                            {!! $shop_data->address !!}
                                        </p>
                                        @endif
                                    </div>

                                    {{-- more address -a-}}
                                    @if(isset($shop_data->other_address) || !is_null($shop_data->other_address) || !empty($shop_data->other_address))
                                    <a class="w-100" data-toggle="collapse" href="#collapseMoreAddr" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="d-flex justify-content-between modal-body mx-3 py-0 sop-chevron " id="address-class">
                                            <p class="text-break" style="text-align: left; font-size: 20px;height: auto; overflow: auto; line-height: 32px;color:black;font-weight:700">
                                                Other Address
                                            </p>
                                            <i id="address-class-i" class="sop-arrow fa-solid fa-chevron-down"></i>
                                        </div>
                                    </a>
                                    <div class="collapse" id="collapseMoreAddr">
                                        <div class="modal-body py-0  mx-3">
                                            <p class="text-break" style="text-align: left; font-size: 18px;height: auto; overflow: auto; line-height: 30px;color:#212529">
                                                {!! $shop_data->other_address !!}
                                            </p>
                                        </div>
                                    </div>
                                    @endif
                                    {{-- more address -a-}}
                                </div>
                            </div>
                        </div> --}}

                        <div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="contactModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-left" role="document">
                                <div class="modal-content">
                                    <div class="modal-header position-relative">
                                        <img src="/images/directory/banner/TitleIcons.png" alt="" srcset="" class="title-icons">
                                        <h3 class="modal-title mx-auto ps-5" id="contactModal" style="font-weight: 700; color:black; font-size: 20px;">ဆိုင်ခွဲလိပ်စာများ</h3>
                                        <a type="button" class="close-style2 d-sm-block d-none" data-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></a>
                                        <button type="button" class="close rounded-circle me-2 p-0 d-sm-none d-block" data-dismiss="modal" aria-label="Close" style="border: 2px solid #666; width:30px; height:30px;">
                                            <i class="fa-solid fa-xmark pb-2"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body pt-3 mx-3 mt-2" id="address_modal">
                                        <h3 class="address-title d-inline" style="font-weight: 700; color:black; font-size: 20px; border-bottom:2px solid #780116">ဆိုင်ခွဲ (၁)</h3>
                                        @if(!empty($shop_data->address))
                                        <p class="text-break mt-3" style="text-align: left; font-size: 18px;height: auto; overflow: auto; line-height: 30px">
                                            {!! $shop_data->address !!}
                                        </p>
                                        @else
                                        <p class="text-break mt-3" style="text-align: left; font-size: 18px;height: auto; overflow: auto; line-height: 30px">
                                            No Address
                                        </p>
                                        @endif
                                        <hr>
                                    </div>
                                    
                                    {{-- more address --}}
                                    {{-- @if(isset($shop_data->other_address) and !is_null($shop_data->other_address) and !empty($shop_data->other_address))
                                        @foreach ($shop_data as $sd)
                                            <div class="address-header mx-3 mt-3">
                                            <h3 class="address-title mx-3 pb-1 d-inline" style="font-weight: 700; color:black; font-size: 20px; border-bottom:2px solid #780116">ဆိုင်ခွဲ (၂)</h3>
                                        </div>
                                        <div class="modal-body py-0 mx-3 mt-2">
                                            <p class="text-break" style="text-align: left; font-size: 18px;height: auto; overflow: auto; line-height: 30px">
                                                {!! $sd->other_address !!}
                                            </p>
                                            <hr>
                                        </div>
                                        @endforeach
                                    @endif --}}
                                    {{-- more address --}}
                                </div>
                            </div>
                        </div>
                        {{-- modal --}}
                    </div>

                    {{-- opening time --}}
                    @if(!empty($opening->opening_time))
                    <div class="d-flex pt-3">
                        <i class="fas fa-clock text-secondary" style="font-size: 26px"></i>
                        <div class="ps-4 pt-1">{!! $opening->opening_time !!}</div>
                    </div>
                    @endif
                </div>
            </div>
            {{-- profile --}}
        </div>
        {{-- loading --}}

        {{-- loading --}}
        {{-- Categories--}}
        <div class="show_breadcrumb d-none show_dev position-relative ">
            <div class="d-flex justify-content-around position-absolute confetti-container w-100 overflow-hidden">
                <img src="/images/directory/banner/Snow.gif" class="" style="width: 130px;">
                <img src="/images/directory/banner/Snow.gif" class="d-md-inline d-none" style="width: 140px;">
                <img src="/images/directory/banner/Snow.gif" class="d-lg-inline d-none" style="width: 150px;">
            </div>
            @if($allcatcount != "[]")
            <div class="px-4 px-lg-5 mx-lg-3 mt-3">
                <div class="m-lg-5 m-1 pt-2 position-relative category-bg category-bg-diamond">
                    <img src="/images/directory/banner/Corner_1_Diamond.png" alt="" class="corner-kanote corner-kanote-1 d-none d-lg-block">
                        <div class="py-1">@include('layouts.frontend.allpart.shop_detail.categories_shop_details',['shop_data'=>$shop_data])</div>
                    <img src="/images/directory/banner/Corner_2_Diamond.png" alt="" class="corner-kanote corner-kanote-2 d-none d-lg-block">
                </div>
            </div>
            @endif
        </div>
        {{-- Categories--}}

        <div class="px-4 px-lg-5 mx-lg-3">
            @if($collections->count()!=0)
            {{--collections--}}
                @include('layouts.frontend.allpart.shop_detail.collections')
            {{--collecstions--}}
            @endif
        </div>
        
        <div class="px-4 px-lg-5 mx-lg-3 my-lg-4 my-3 "> 
            <div class="mx-lg-4 m-1 my-lg-4 my-3 ">
                    <div class="diamond-hr"></div>
                </div>
        </div>
        
        <div class="px-4 px-lg-5 mx-lg-3 mt-5">
            <nav class="navbar navbar-expand-sm justify-content-between mb-3 px-md-3">
                <ul class="navbar-nav">
                    <li class="newest_nav nav-item active">
                        <a class="nav-link nav-link-diamond text-center px-3" id="newest">Newest</a>
                    </li>
                    <li class="popular_nav nav-item">
                        <a class="nav-link nav-link-diamond text-center px-3" id="popular" style="">Popular</a>
                    </li>
                    <li class="nav-item discount_nav">
                        <a class="nav-link nav-link-diamond text-center px-3" id="discount_pannel">Discount</a>
                    </li>
                    {{-- <li class="nav-item shop_nav">
                        <a class="nav-link" id="official_store">Shops</a>
                    </li> --}}
                </ul>
                <a href="/see_all_for_shop/popular/{{$shop_data->id}}" class="icon-bg text-center icon-bg-diamond d-sm-block d-none" style="width:40px; height:40px;">
                    <i class="fas fa-arrow-right text-secondary" style="padding-top:13px;"></i>
                </a>
                <a href="/see_all_for_shop/popular/{{$shop_data->id}}" class="d-block d-sm-none">
                    <i class="fas fa-long-arrow-alt-right mt-3 text-secondary pb-2" style="font-size:24px;"></i>
                </a>
            </nav>
            
            {{--new item--}}
            <div class="zh-new_item sop-font px-md-3">
                @if (count($items) == 0)
                <div class="sn-no-items">
                    <div class="sn-cross-sign"></div>
                    <i class="fa-solid fa-box-open"></i>
                    <span>ပစ္စည်းမရှိသေးပါ</span>
                </div>
                @else
                <newitems-forshop :newitems="{{$items}}" :uri="'get_newitems_forshop_ajax'"></newitems-forshop>                    
                @endif
            </div>
            {{--new item--}}
            
            {{-- pop item--}}
            <div class="zh-pop_items sop-font px-md-3">
                @if (count($get_pop_items) == 0)
                <div class="sn-no-items">
                    <div class="sn-cross-sign"></div>
                    <i class="fa-solid fa-box-open"></i>
                    <span>ပစ္စည်းမရှိသေးပါ</span>
                </div>
                @else
                <pop-items-forshop :allitems="{{$get_pop_items}}" :forcheck_count="{{$forcheck_count}}" :uri="'get_popitems_forshop_ajax'"></pop-items-forshop>
                @endif
            </div>

            {{-- discount item--}}
            <div class="zh-discount_items sop-font px-md-3">

                @if (count($discount) == 0)
                <div class="sn-no-items">
                    <div class="sn-cross-sign"></div>
                    <i class="fa-solid fa-box-open"></i>
                    <span>ပစ္စည်းမရှိသေးပါ</span>
                </div>
                @else
                {{-- <discount-items :discountitems="{{$discount}}" :shop_id="{{$shop_data->id}}"></discount-items> --}}
                <discount-items-for-shop :discountitems="{{$discount}}" :shop_id="{{$shop_data->id}}"></discount-items-for-shop>
                @endif
            </div>
            {{-- discount item--}}
        </div>

        <div class="px-4 px-lg-5 mx-lg-3 mb-3 ">
            <div class="mx-lg-4 m-1 my-lg-4 my-3 ">
                <div class="diamond-hr"></div>
            </div>
        </div>

        <div class="px-4 px-lg-5 mx-lg-3 pb-3" style="border-bottom: 2px solid rgba(160, 121, 54, 0.08);">
            @if($newsNevents->count() != 0)
            {{--News&Events--}}
                @include('layouts.frontend.allpart.shop_detail.news_and_events')
            {{--News&Events--}}
            @endif
        </div>

        {{-- map (change with dynamic degrees) --}}
        {{-- <div class="px-0 px-md-5 pt-3 w-100">
            <div class="px-lg-5 d-none show_dev">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d238.60995656534973!2d96.1980297770541!3d16.887797136151246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smm!4v1644909675991!5m2!1sen!2smm" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div> --}}
        {{-- map --}}
    </div>
    @if(!empty($popup->video_name))
        {{-- Popup Modal --}}
        <div class="modal" id="popup-onload" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content position-relative">
                    <div class="d-flex position-absolute" style="z-index: 999; top:30px; pointer-events: none;">
                        <img src="/images/directory/banner/boom.gif" alt="" srcset="" style="width: 33%; ">
                        <img src="/images/directory/banner/sparkles.gif" alt="" srcset="" style="width: 34%;">
                        <img src="/images/directory/banner/boom.gif" alt="" srcset="" style="width: 33%;">
                    </div>
                    <button type="button" class="close rounded-circle mt-3 me-3 ms-auto p-0" data-dismiss="modal" aria-label="Close" style="border: 2px solid #666; width:30px; height:30px;">
                        <i class="fa-solid fa-xmark pb-2"></i>
                    </button>
                    <div class="modal-header justify-content-center py-0">
                        <h4 class="modal-title">{!! $popup->ad_title !!}</h4>
                    </div>

                    <div class="modal-body">
                        {{-- <img src="/images/baydin/9SK6sqSgmgsWrVZ9o7OwPVooFf4NZNTful9cKVHE.jpg" alt="" srcset="" class="popup-video"> <!--Temp--> --}}
                        <video class="popup-video" controls>
                            <source src="{{ asset('test/video/'.$popup->video_name) }}" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
        {{-- Popup Modal --}}
    @endif
</div>

{{--        <!-- #content -->--}}
<div class="">
    @include('layouts.frontend.allpart.footer')
</div>
{{--    <!-- .site-content-contain -->--}}
<div class="ftc-close-popup"></div>
    @include('layouts.frontend.allpart.mobile_footer')
<div id="to-top" class="scroll-button">
    <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
</div>



@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $(".zh-new_item").show();
        $(".zh-pop_items").hide();
        $(".zh-discount_items").hide();
        $(".shops_pannel").hide();

        $("#newest").click(function () {
            $(".zh-new_item").show();
            $(".zh-pop_items").hide();
            $(".zh-discount_items ").hide();

            $(".newest_nav").addClass('active');
            $(".popular_nav").removeClass('active');
            $(".discount_nav").removeClass('active');

            $(".shops_pannel ").hide();
            $(".shops ").removeClass('active');
            $(".shop_nav ").removeClass('active');

        });

        $("#popular").click(function () {
            $(".zh-pop_items").show();
            $(".zh-new_item").hide();
            $(".zh-discount_items ").hide();

            $(".popular_nav").addClass('active');
            $(".newest_nav").removeClass('active');
            $(".discount_nav").removeClass('active');

            $(".shops_pannel ").hide();
            $(".shops ").removeClass('active');
            $(".shop_nav ").removeClass('active');

        });

        $("#discount_pannel").click(function () {
            $(".zh-discount_items ").show();
            $(".zh-new_item").hide();
            $(".zh-pop_items").hide();

            $(".discount_nav").addClass('active');
            $(".popular_nav").removeClass('active');
            $(".newest_nav").removeClass('active');

            $(".shops_pannel ").hide();
            $(".shops ").removeClass('active');
            $(".shop_nav ").removeClass('active');
        });

        // $("#phone-button").click(function(){
        //     $("#phone").modal({backdrop: false});
        // });

        // $("#contact-button").click(function(){
        //     $("#contact").modal({backdrop: false});
        // });
    });
//    ` @if(!empty($shop_data->additional_phones))`
//     $(document).ready(function () {
//         var additionalPhones = `{!! $shop_data->additional_phones !!}`;
//         additionalPhones.forEach(phone => {
//             $("#phone_modal").append(`<a href="tel:` + shop + `" class=" sop-social">
//                     <i class="sop-social-i fa-solid fa-phone pe-1 pe-md-4 sn-phone"></i>
//                     ` + shop + `
//                 </a>`);
//         });
//     });
//    ` @endif`


    $(document).ready(function () {
        $(".content").each(function () {
            let height = Math.ceil($(this).height()) + 1;
            let overflow_height = $(this)[0].scrollHeight;
            console.log(height);
            console.log(overflow_height);
            if (height < overflow_height) {

                $(this).parent().find(".txtcol").show();
                $(this).toggleClass("truncate").toggleClass("animation");
            }
        });
        $(".txtcol").click(function () {
            if ($(this).prev().hasClass("truncate")) {
                $(this).parent().find(".content").css("max-height", $(this).parent().find(".content")[0].scrollHeight);
                $(this).children('a').text("See Less");
            } else {
                $(this).parent().find(".content").css("max-height", "3em");
                $(this).children('a').text("... See More");
            }
            $(this).prev().toggleClass("truncate").toggleClass("animation");

        });
    });
    $(document).ready(function () {

        $("#address-class").click(function () {
            $("#address-class-i").toggleClass('fa-chevron-up fa-chevron-down ');
        });
        $("#map-class").click(function () {
            $("#map-class-i").toggleClass('fa-chevron-up fa-chevron-down ');
        });
    });

    $('#pshop_slide').owlCarousel({
        loop: false,
        margin: 20,
        responsiveClass: true,
        autoplay: true,
        dots: false,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,

        responsive: {
            0: {
                items: 1.5,
                stagePadding: 20,
            },
            600: {
                items: 2,
                stagePadding: 0,
            },
            900: {
                items: 3,
                stagePadding: 0,
            },
            1200: {
                items: 4,
                stagePadding: 0,
            },
            1400: {
                items: 5,
                stagePadding: 0,
            }
        }
    });

    $(window).on('load', function() {
        $('#popup-onload').modal('show');
    });

    $('#popup-onload').on('hidden.bs.modal', function () {
        $(this).remove();
    });

</script>

<script>
    $(document).ready(function () {
        var additionalPhones = {!! $shop_data->additional_phones !!};
        var n = 2;
        additionalPhones.forEach(phone => {
            $("#phone_modal").append(
                `<hr>
                <div class="address-header mt-4 mb-3">
                    <h3 class="address-title pb-1 d-inline" style="font-weight: 700; color:black; font-size: 18px; border-bottom:2px solid #780116">Phone` + n + `</h3>
                </div>
                <a href="tel:` + phone + `" class=" sop-social">
                    <i class="sop-social-i fa-solid fa-phone pe-1 pe-md-4 sn-phone"></i>
                    ` + phone + `
                </a>`
            )
            n++;
        });

        var otherAddresses = {!! $shop_data->other_address !!};
        var o = 2;
        otherAddresses.forEach(address => {
            var mmNum = myanmarNumberConvert(o);
            $("#address_modal").append(
                `<h3 class="address-title d-inline" style="font-weight: 700; color:black; font-size: 20px; border-bottom:2px solid #780116">ဆိုင်ခွဲ (` + mmNum + `)</h3>
                <p class="text-break mt-3" style="text-align: left; font-size: 18px;height: auto; overflow: auto; line-height: 30px">`
                    + address.value +
                `</p>
                <hr>`
            )
            o++;
        });
    });

    function myanmarNumberConvert(num) {
        var mmNums = ['၀','၁','၂','၃','၄','၅','၆','၇','၈','၉'];
        var inputNum = num.toString();
        var tmp = Array.from(inputNum);
        var convertedNum = '';
        for(let i=0; i < inputNum.length; i++) {
            convertedNum += mmNums[tmp[i]];
        } 
        return convertedNum;
    }
</script>

@endpush
@push('css')
<style>
    .content {
        /* width:100px; */
        overflow: hidden;
        white-space: normal;
        text-overflow: ellipsis;
        line-height: 1.5em;
        max-height: 3em;
    }

    .txtcol {
        display: none;
        cursor: pointer;
        opacity: 0.8;

    }

    .truncate {
        transition: 0.5s ease-in-out;
    }

    .animation {
        transition: 0.5s ease-in-out;
    }

    @media only screen and (max-width: 576px) {
        #main_slide img {
            width: 100%;
            /* max-height: 240px!important; */
            object-fit: cover;
            object-position: center;
            /* aspect-ratio: 32/9; */
            /* aspect-ratio: 32/11; */
            aspect-ratio: 2/1;
        }

        @supports not (aspect-ratio: auto) {
            #main_slide img {
                width: 100%;
                max-height: 160px !important;
            }
        }
    }

    @media only screen and (min-width: 576px) {
        #main_slide img {
            width: 100%;
            /* max-height: 500px!important; */
            object-fit: cover;
            object-position: center;
            /* aspect-ratio: 32/9; */
            /* aspect-ratio: 32/11; */
            aspect-ratio: 3/1;
        }

        @supports not (aspect-ratio: auto) {
            #main_slide img {
                width: 100%;
                max-height: 450px !important;
            }
        }
    }

    @media only screen and (min-width: 992px) {
        #main_slide img {
            width: 100%;
            /* max-height: 550px!important; */
            object-fit: cover;
            object-position: center;
            /* aspect-ratio: 32/9; */
            /* aspect-ratio: 32/11; */
            aspect-ratio: 3/1;
        }

        @supports not (aspect-ratio: auto) {
            #main_slide img {
                width: 100%;
                max-height: 450px !important;
            }
        }
    }


    .sop-social {
        display: flex !important;

        /* font-family: sans-serif; */

        font-size: 1.1em !important;
        display: inline-block;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 1.2rem 0.375rem 0;
        font-size: 1rem;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .fa-facebook {
        color: #1877f2 !important;
    }
    .fa-facebook-messenger {
        /* color: rgb(255,105,104); */
        color: #0695ff;
    }
    .sn-phone, .fa-location-dot {
        color: #780116 !important;
    }

    .title-icons {
        width: 14em;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
    }

    @media only screen and (min-width: 576px) {
        .sop-social-i {
            /* color: #780116 !important; */
            font-size: 20px !important;
        }
    }

    @media only screen and (max-width: 576px) {
        .sop-social {
            font-size: 0.9em !important;
        }

        .sop-social-i {
            /* color: #780116 !important; */
            font-size: 12px !important;
        }
        .premium-logo-wrap {
            z-index: 1;
            width: 130px !important;
            height: 130px !important;
            min-width: 130px !important;
            min-height: 130px !important;
            margin-top: -25px !important;
        }
        .premium-logo {
            
            width: 100% !important;
            height: 100% !important;
        }
        .premium-logo-frame{
            position: absolute;
            width: 134px !important;
            height: 134px !important;
            margin-left: -130px !important;
        }

        .corner-kanote {
            width: 120px !important;
            height: 120px !important;
            position: absolute;
        }
        .profile-kanote{
            width: 90px !important;
            height: 90px !important;
            position: absolute;
        }

        .profile-kanote-1 {
            top: -20px !important;
            left: -20px !important;
            rotate: 90deg;
        }

        .profile-kanote-2 {
            bottom: -20px !important;
            right: -20px !important;
            rotate: 90deg;
        }
        .social-wrap {
            width: 110px !important;
            height: 110px !important;
            min-width: 110px !important;
        }

        .contact-btns-section{
            margin-left: 10px !important;
        }

        .contact-wrap {
            width: 80% !important; 
        }

        .premium-title{
            font-size: 18px !important;
        }

        .premium-title-myan{
            font-size: 16px !important; 
        }

        .premium-badge{
            width: 22px !important;
            height: 22px !important;
        }
    }
    .collapsing {

        height: 0;
        overflow: hidden;
        -webkit-transition-property: height, visibility;
        transition-property: height, visibility;
        -webkit-transition-duration: 0.35s;
        transition-duration: 0.35s;
        -webkit-transition-timing-function: ease;
        transition-timing-function: ease;
    }
    /* button:hover, button:focus, input[type="button"]:hover, input[type="button"]:focus, input[type="submit"]:hover, input[type="submit"]:focus {
        background-color: white!important;
        color: #fff;
        transform: scale(1.1)
    } */

    .premium-logo-wrap {
        z-index: 999;
        width: 180px;
        height: 180px;
        min-width: 180px;
        min-height: 180px;
        margin-top: -90px;
        position: relative;
    }
    .premium-logo {
        width: 100%;
        height: 100%;
    }
    .premium-logo-frame{
        position: absolute;
        width: 184px;
        height: 184px;
        margin-left: -180px;
        bottom: -2px;
    }

    .social-wrap {
        width: 180px;
        height: 180px;
        min-width: 180px;
    }

    .close {
        color: #666 !important;
        background-color: #fff !important;
        font-size: 21px !important;
        font-weight: normal !important;
    }

    .close:hover,
    .close:focus {
        background-color: #ddd !important;
        color: #666 !important;
        cursor: pointer !important;
    }

    .close-style2 {
        color: #780116 !important;
        background-color: #fff !important;
        font-size: 26px !important;
        font-weight: normal !important;
        margin-right: 0.5em;
    }

    .close-style2:hover,
    .close-style2:focus {
        background-color: #fff !important;
        color: #420001 !important;
        cursor: pointer !important;
    }

    .btn-premium {
        border: 2px solid !important;
        border-radius: 10px !important;
    }

    .btn-premium:hover {
        color: #fff !important;
        background-color: #fdf8d8 !important;
        border-color: #fdf8d8 !important;
    }
    
    .btn-premium:focus, .btn-premium.focus {
        color: #fff !important;
        background-color: #fdf8d8 !important;
        border-color: #fdf8d8 !important;
        box-shadow: 0 0 0 0.2rem #fdf8d880 !important;
    }

    .btn-premium-grey {
        color: #898989;
        background-color: #edeff0 !important;
    }

    .btn-premium-grey:hover {
        color: #898989 !important;
        background-color: #d1d1d1 !important;
        border-color: #747474 !important;
    }

    .btn-premium-diamond {
        color: #fff !important; 
        background-color: #58b5e4 !important;
        border-color: #58b5e4 !important;
    }

    .btn-premium-diamond:hover {
        color: #fff !important;
        background-color: #4ba1cc !important;
        border-color: #4ba1cc !important;
    }

    .btn-premium-diamond:focus, .btn-premium-diamond.focus {
        color: #fff !important;
        background-color: #4ba1cc !important;
        border-color: #4ba1cc !important;
        box-shadow: 0 0 0 0.2rem #fdf8d880 !important;
    }
    .contact-btns-section{
        margin-left: 230px;
    }

    .premium-title{
        font-weight: bold;
        font-size: 26px;
        line-height: 24px;
        text-decoration: underline;
    }

    .premium-title-diamond {
        color: #58b5e4;
    }

    .premium-title-myan{
        font-size: 20px;
    }

    .premium-badge{
        width: 28px;
        height: 28px;
    }

    .diamond-hr {
        height:3px;
        background-color: #d9ebf4;
        box-shadow: 0 2px 4px 0px #d9ebf4;
    }

    .font-fam{
        font-family: 'Myanmar3', Sans-Serif !important;
    }
    #main_slide .owl-dots {
        display: none !important; 
    }

    .nav-link {
        border-radius: 14px;
        margin-right: 10px;
        padding: 8px 20px !important;
    }

    .active .nav-link {
        position: relative;
    }

    @media (max-width: 576px) {
        .nav-link {
            margin-right: 4px;
            padding-right: 20px !important;
            padding-left: 20px !important;
        }
    }

    .nav-link-diamond {
        background-color: #ffffff;
        border: 1px solid #58b5e4;
        color: #666666 !important;
    }

    .active .nav-link-diamond {
        background-color: #58b5e4;
        color: #ffffff !important;
    }

    .nav-link-np {
        color: #666666 !important;
        margin-right: 10px;
        padding: 8px 20px !important;
    }

    .active .nav-link-np {
        /* background-color: #780116 !important; */
        color: #780116 !important;
        position: relative;
    }

    

    .category-bg {
        border-radius: 10px;
    }

    .category-bg-diamond{
        background-color: #ebf8fe;
        box-shadow: 3px 3px 5px 0px #add0e2;
    }
    .icon-bg {
        border-radius: 100%;
    }

    .icon-bg-diamond {
        background-color: #deebf1;
        box-shadow: 3px 3px 5px 0px #add0e2;
    }

    .icon-bg-diamond:hover {
        box-shadow: 3px 3px 5px 0px #6bb1d4; !important;
        transition: 0.25s ease-in-out;
    }

    .corner-kanote {
        width: 180px;
        height: 180px;
        position: absolute;
    }

    .corner-kanote-1 {
        bottom: -26px;
        left: -26px;
    }

    .corner-kanote-2 {
        top: -26px;
        right: -26px;
    }

    .profile-kanote{
        width: 120px;
        height: 120px;
        position: absolute;
    }

    .profile-kanote-1 {
        top: -20px;
        left: -20px;
        rotate: 90deg;
    }

    .profile-kanote-2 {
        bottom: -20px;
        right: -20px;
        rotate: 90deg;
    }

    .contact-wrap {
        width: 60%;
    }

    .confetti-container {
        bottom: -20px;
        position: absolute;
        pointer-events: none;
        z-index: 1;
    }

    .popup-video {
        object-fit: cover;
        width: 100%;
    }

    .modal-dialog-left {
        margin-left: 0 !important;
    }

    .text-diamond {
        color: #6bbde7;
        font-size: 20px;
    }

    .text-diamond-2 {
        color: #420001;
        font-size: 16px;
    }

    .premium-title{
        width: 80%;
    }

    div.address-text > p {
        display: inline !important;
    }
    /* * {
            background: #000 !important;
            color: #0f0 !important;
            outline: solid #f00 1px !important;
        } */
</style>
@endpush
