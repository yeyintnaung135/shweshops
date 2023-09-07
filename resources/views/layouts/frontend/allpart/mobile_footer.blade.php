<div class="footer-mobile">
    <div class="mobile-home">
        <a href="{{url('/')}}">
            <i class="zh-icon fa fa-home" style="@if(Request::path() == "/" || Request::path() == "unittest/index") color:#780116 !important; @else color:#666666 !important; @endif"></i>
            Home </a>
    </div>
    <div class="mobile-home">
        <a href="{{url('see_by_categories')}}">

            <i class="zh-icon fa-solid fa-magnifying-glass" style="@if(Request::path() == "see_by_categories") color:#780116 !important; @else color:#666666 !important; @endif"></i>
            Search</a>
    </div>
    <div
        class="sop-mobile-nav ">
        <a2cicon-com></a2cicon-com>
    </div>



    <div class="mobile-home">
        <a href="{{url('/shops')}}">
            <div class="position-relative">
                <i class="fas fa-store" style="@if(Request::path() == "shops") color:#780116 !important; @else color:#666666 !important; @endif" id="mobileFootHeart"></i>
                {{-- <span id="favm-a2c-count" class="position-absolute" style="top:0;right:5px;color:#780116 !important;">0</span> --}}
            </div>

            Shop</a>

    </div>

    @if(isset(Auth::guard('web')->user()->id))
        <form type="hidden" id="fav-server"  method="POST" style="display: none;">
            @csrf
        </form>
        <form type="hidden" id="selection-server"  method="POST" style="display: none;">
            @csrf
        </form>
        <div class="mobile-account">
            <a href="{{route('backside.user.user_profile')}}">
                <!--<i class="zh-icon fa-solid fa-arrow-right-from-bracket" style="color:#780116 !important;"></i>-->
                <!--Logout-->
                <i class="zh-icon fa-solid fa-user-gear a-arrow-right-from-bracket" style="color:#666666 !important;"></i>
                Profile
            </a>
        </div>

    @elseif(isset(Auth::guard('shop_owners_and_staffs')->user()->id))
        <div class="mobile-account">
            <a href="{{url('backside/shop_owner/detail')}}">
                <i class="zh-icon fa-solid fa-user-gear" style="color:#666666 !important;"></i>
                Shop Owner
            </a>
        </div>

    @elseif(isset(Auth::guard('shop_owners_and_staffs')->user()->id))
        <div class="mobile-account">
            <a href="{{url('backside/shop_owner/detail')}}" title="Logout">
                <i class="zh-icon fa-solid fa-user-gear" style="color:#666666 !important;"></i>
                Shop
            </a>
        </div>
    @else
        <div class="mobile-account">

            <a href="" class="checkForm" title="checkForm" data-toggle="modal" data-target="#orangeModalSubscription">
                <i class="zh-icon fa fa-user" style="color:#666666 !important;"></i>
                Login</a>

        </div>
    @endif


</div>
{{-- noti --}}
@include('layouts.frontend.allpart.noti')
{{-- noti --}}
{{-- confirm logout --}}
@include('layouts.frontend.allpart.confirm_logout')
{{-- confirm logout --}}
<!-- zh pop up -->
@include('layouts.frontend.allpart.popup')
<!-- end zh pop up -->
@push('custom-scripts')
   
@endpush
