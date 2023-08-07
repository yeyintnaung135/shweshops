@extends('layouts.backend.datatable')
@section('content')
    <div class="container-fluid no-gutters p-0">


        {{--        //for mobile--}}
        <div class="col-12 text-left yk-background d-block d-md-none">
            <div class="fs pt-5 pb-5 pl-4 ">
                <div><span style="font-weight: bolder;font-size: 32px;">ShweShops</span> <span style="font-size: 18px;">မှ ကြိုဆိုပါသည်</span>
                </div>
                <div style="color: white;" class="mt-2">လူကြီးမင်းရဲ့ Admin ‌အကောင့်ကိုစတင်အသုံးပြုနိင်ရန်အတွက်
                    အောက်ပါအချက်အလက်များကိုဖြည့်သွင်း‌ပေးပါ။
                </div>
            </div>
            <div class="se pt-5 pb-5 pl-4 ">
                <div><span style="font-weight: bolder;font-size: 32px;">ဆိုင်မှတ်ပုံတင်ရန်</span></div>
                <div style="color: white;" class="mt-2">လူကြီးမင်း၏ဆိုင်ကို website ပေါ်တွင် offical store အဖြစ်
                    တည်‌ဆောက်နိုင်ရန်အတွက်အောက်ပါအချက်အလက်များကို
                    ဖြည့်သွင်း‌ပေးပါ
                </div>
            </div>
            <div class="yk pt-5 pb-5 pl-4 ">
                <div>
                <span style="font-weight: bolder;font-size: 32px;">ဆိုင်အကြောင်းဖြည့်ရန်
                </span>
                </div>
                <div style="color: white;" class="mt-2">လူကြီးမင်းတို့ဆိုင်မှ ရရှိနိုင်သော ၀န်ဆောင်မှုများနှင့်
                    ဆိုင်အကြောင်းကို၀ယ်သူများသိရှိနိုင်ရန်အတွက််အောက်ပါ
                    အချက်အလက်များကိုဖြည့်သွင်း‌ပေးပါ။
                </div>
            </div>
        </div>
        {{--        //for mobile--}}

        <div class="row no-gutters ">
             {{--for desktop--}}
            <div class="col-0 col-md-6 d-none d-md-inline yk-background fill " style="height:1000px;">
                <div style="padding-right: 32px;padding-left: 32px;padding-top:163px;">
                    <div class="fs pt-5 pb-5 pl-4 ">
                        <div style="text-align: center;"><span
                                    style="font-weight: bolder;font-size: 32px; ">ShweShops</span> <span
                                    style="font-size: 18px; ">မှ ကြိုဆိုပါသည်</span></div>
                        <br>
                        <div style="color: white;text-align: center;">လူကြီးမင်းရဲ့ Admin
                            ‌အကောင့်ကိုစတင်အသုံးပြုနိင်ရန်အတွက်
                            အောက်ပါအချက်အလက်များကိုဖြည့်သွင်း‌ပေးပါ။
                        </div>
                    </div>
                    <div class="se pt-5 pb-5 pl-4 ">
                        <div style="text-align: center;"><span style="font-weight: bolder;font-size: 32px;">ဆိုင်မှတ်ပုံတင်ရန်</span>
                        </div>
                        <br>
                        <div style="color: white;text-align: center;" class="mt-2">လူကြီးမင်း၏ဆိုင်ကို website ပေါ်တွင်
                            offical store အဖြစ်
                            တည်‌ဆောက်နိုင်ရန်အတွက်အောက်ပါအချက်အလက်များကို
                            ဖြည့်သွင်း‌ပေးပါ
                        </div>
                    </div>
                    <div class="yk pt-5 pb-5 pl-4 ">
                        <div style="text-align: center;"><span style="font-weight: bolder;font-size: 32px;">ဆိုင်အကြောင်းဖြည့်ရန်
                   </span></div>
                        <br>
                        <div style="color: white;text-align: center;" class="mt-2">လူကြီးမင်းတို့ဆိုင်မှ ရရှိနိုင်သော
                            ၀န်ဆောင်မှုများနှင့်
                            ဆိုင်အကြောင်းကို၀ယ်သူများသိရှိနိုင်ရန်အတွက််အောက်ပါ
                            အချက်အလက်များကိုဖြည့်သွင်း‌ပေးပါ။
                        </div>
                    </div>
                </div>
            </div>
            {{--for desktop--}}


            <div class=" col-12 col-md-6 row justify-content-center">

                <div class="col-12 ">
                    <div class="">

                        <div class="card-body">
                            <div class="fs"><span
                                        style="font-weight: bolder;font-size: 32px;">Account Information</span>
                            </div>

                            <div class="se"><span
                                        style="font-weight: bolder;font-size: 32px;">Shop Information</span></div>

                            <br>


                            <form method="POST" enctype="multipart/form-data"
                                  action="{{ route('backside.shop_owner.registered') }}">
                                @csrf

                                <div class="fs form-group row">


                                    <div class="col-md-12 col-12">
                                        <label for="exampleInputEmail1">အမည် <span
                                                    style="color: red;">*</span></label>

                                        <div class="input-group mb-3">

                                            <input id="name" type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   name="name" value="{{ old('name') }}" placeholder="အမည်"
                                                   autocomplete="name" required>
                                        </div>
                                        <h5 id="usercheck" style="color: red;" >
                                                **Username is missing
                                        </h5>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                                    </div>


                                </div>
                                <div class="fs form-group row">

                                    <div class="col-md-12 col-12">
                                        <label for="exampleInputEmail1">Email <span
                                                    style="color: red;">*</span></label>

                                        <div class="input-group mb-3">

                                            <input id="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   name="email" value="{{ old('email') }}" placeholder="Email"
                                                   autocomplete="email">
                                        </div>
                                        <h5 id="emailcheck" style="color: red;" >
                                                **Email is missing
                                        </h5>
                                        <small id="emailvalid" class="form-text
                                            text-muted invalid-feedback">
                                                Your email must be a valid email
                                        </small>
                                        @error('email')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>

                                </div>
                                <div class="fs form-group row">


                                    <div class="col-md-12">
                                        <label for="exampleInputEmail1">Pin နံပါတ် <span
                                                    style="color: red;">*</span></label>

                                        <div class="input-group mb-3">

                                            <input id="password" type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password" placeholder="စကားဝှက် အသစ်"
                                                   autocomplete="new-password">
                                        </div>
                                        @error('password')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>
                                    <div class="col-md-12"><button type="button" class="sn_generate_password btn btn-secondary d-block">Generate Password</button></div>
                                </div>
                                <div class="fs form-group row">


                                    <div class="col-md-12">
                                        <label for="exampleInputEmail1">Pin နံပါတ်ကိုအတည်ပြုပါ<span
                                                    style="color: red;">*</span></label>

                                        <div class="input-group mb-3">

                                            <input id="password-confirm" type="password" class="form-control"
                                                   name="password_confirmation" placeholder="စကားဝှက်ကို အတည်ပြုပါ"
                                                   autocomplete="new-password">
                                        </div>
                                    </div>
                                    @error('password_confirmation')
                                    <x-error>
                                        {{$message}}
                                    </x-error>
                                    @enderror
                                </div>
                                <div class="se form-group row">
                                    <div class="col-12 col-md-6">
                                        <label for="exampleInputEmail1">ဆိုင် အမည် english<span
                                                    style="color: red;">*</span></label>


                                        <div class="input-group mb-3">

                                            <input id="shop_name" type="text"
                                                   class="form-control @error('shop_name') is-invalid @enderror"
                                                   name="shop_name" value="{{ old('shop_name') }}"
                                                   placeholder="ဆိုင် အမည်" autocomplete="name" autofocus>
                                        </div>
                                        @error('shop_name')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="exampleInputEmail1">ဆိုင် အမည် myanmar<span
                                                    style="color: red;"></span></label>


                                        <div class="input-group mb-3">

                                            <input id="shop_name_myan" type="text"
                                                   class="form-control @error('shop_name_myan') is-invalid @enderror"
                                                   name="shop_name_myan" value="{{ old('shop_name_myan') }}"
                                                   placeholder="ဆိုင် အမည် myanmar" autocomplete="name" autofocus>
                                        </div>
                                        @error('shop_name_myan')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>



                                </div>

                                <div class="se form-group row">


                                    <div class="col-12 col-md-6">

                                        <!-- <label for="password" class="col-md-4 col-form-label text-md-right">Shop NAME</label> -->
                                        <label for="exampleInputEmail1">Main Phone<span
                                                    style="color: red;">*</span></label>


                                        <div class="input-group mb-3">

                                            <input id="main_phone" value="{{ old('main_phone') }}"
                                                   min="0" type="text" type="text"
                                                   class="form-control @error('main_phone') is-invalid @enderror"
                                                   name="main_phone" placeholder="Main Phone"
                                                   autocomplete="new-password">
                                        </div>
                                        @error('main_phone')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>





                                </div>


                                <div class="se form-group row">
                                    <div class="col-12 col-md-6">
                                        <label for="exampleInputEmail1">Address<span
                                                    style="color: red;">*</span></label>

                                        <textarea id="address" type="description"
                                                  class="form-control @error('address') is-invalid @enderror"
                                                  name="address" placeholder="Address" autocomplete="new-password" value="fefe">{{old('address')}}</textarea>
                                        @error('address')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="exampleInputEmail1">Your Facebook messenger Link<span
                                                    style="color: red;">*</span></label>

                                        <div class="input-group mb-3">

                                            <!-- <div class="dropdown"> -->
                                            <!-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                            Dropdown button
                                            </button> -->
                                            <!-- <div class="dropdown-menu"> -->
                                            <input id="messenger_link" value="{{ old('messenger_link') }}" min="0"
                                                   type="text"
                                                   class="form-control @error('messenger_link') is-invalid @enderror"
                                                   name="messenger_link" placeholder="Your Facebook Messenger link">
                                            <!-- </div> -->
                                            <!-- </div> -->

                                        </div>
                                        @error('phone_no')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>

                                </div>




                                {{-- //page--}}
                                <div class="se form-group row">

                                    <div class="col-12 col-md-6">
                                        <label for="exampleInputEmail1">Your Facebook Page Link<span
                                                    style="color: red;">*</span></label>

                                        <div class="input-group mb-3">

                                            <!-- <div class="dropdown"> -->
                                            <!-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                            Dropdown button
                                            </button> -->
                                            <!-- <div class="dropdown-menu"> -->
                                            <input id="phone_no" value="{{ old('page_link') }}" min="0" type="text"
                                                   class="form-control @error('messenger_link') is-invalid @enderror"
                                                   name="page_link" placeholder="Your Facebook Page link">
                                            <!-- </div> -->
                                            <!-- </div> -->

                                        </div>
                                        @error('page_link')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6">

                                    <label for="exampleInputEmail1">ဆိုင်logoတင်ရန်<span
                                                style="color: red;">*</span></label>

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name='shop_logo'
                                               id="logo">
                                        <label class="custom-file-label"
                                               for="exampleInputFile">ဆိုင်logoတင်ရန်</label>

                                    </div>
                                    @error('shop_logo')
                                    <x-error>
                                        {{$message}}
                                    </x-error>
                                    @enderror
                                    </div>

                                </div>
                                {{-- //page--}}


                                <div class="se form-group row">


                                    <div class="col-md-12 col-12">
                                        <label for="exampleInputEmail1">ဆိုင်bannerတင်ရန်<span
                                                    style="color: red;">*</span></label>

                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" name='shop_banner' class="custom-file-input"
                                                       id="banner">
                                                <label class="custom-file-label" for="exampleInputFile">ဆိုင်bannerတင်ရန်</label>
                                            </div>

                                        </div>
                                        @error('shop_banner')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>


                                </div>



                                <div class="yk form-group row">
                                    <div class="col-md-12 col-12">
                                        <div class="input-group mb-3">

                                            <input id="အထည်မပျက်_ပြန်သွင်း" value="{{ old('အထည်မပျက်_ပြန်သွင်း') }}"
                                                   min="0" type="number"
                                                   class="form-control @error('အထည်မပျက်_ပြန်သွင်း') is-invalid @enderror"
                                                   name="အထည်မပျက်_ပြန်သွင်း" placeholder="အထည်မပျက် ပြန်သွင်း %"
                                                   autocomplete="new-password">
                                        </div>
                                        @error('အထည်မပျက်_ပြန်သွင်း')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>
                                </div>
                                <div class="yk form-group row">
                                    <div class="col-md-12 col-12">
                                        <div class="input-group mb-3">
                                            <input value="{{ old('တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ') }}"
                                                   min="0" type="number" id="တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ"

                                                   class="form-control @error('တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ') is-invalid @enderror"
                                                   name="တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ"
                                                   placeholder="တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ %"
                                                   >
                                        </div>
                                        @error('တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>

                                </div>
                                <div class="yk form-group row">
                                    <!-- <label for="password" class="col-md-4 col-form-label text-md-right">Shop NAME</label> -->

                                    <div class="col-md-12 col-12">
                                        <div class="input-group mb-3">

                                            <input id="အထည်ပျက်စီးချို့ယွင်း"
                                                   value="{{ old('အထည်ပျက်စီးချို့ယွင်း') }}" min="0" type="number"
                                                   type="text"
                                                   class="form-control @error('အထည်ပျက်စီးချို့ယွင်း') is-invalid @enderror"
                                                   name="အထည်ပျက်စီးချို့ယွင်း"
                                                   placeholder="အထည်ပျက်စီးချို့ယွင်း %"
                                                   autocomplete="new-password">
                                        </div>
                                        @error('အထည်ပျက်စီးချို့ယွင်း')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>

                                </div>
                                <div class="yk form-group row">
                                    <!-- <label for="password" class="col-md-4 col-form-label text-md-right">Shop NAME</label> -->

                                    <div class="col-md-12 col-12">
                                        <div class="input-group mb-3">

                                            <input id="အထည်ပျက်စီးချို့ယွင်း"
                                                   value="{{ old('အထည်ပျက်စီးချို့ယွင်း') }}" min="0" type="number"
                                                   type="text"
                                                   class="form-control @error('အထည်ပျက်စီးချို့ယွင်း') is-invalid @enderror"
                                                   name="အထည်ပျက်စီးချို့ယွင်း"
                                                   placeholder="အထည်ပျက်စီးချို့ယွင်း %"
                                                   autocomplete="new-password">
                                        </div>
                                        @error('အထည်ပျက်စီးချို့ယွင်း')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>

                                </div>
                                <div class="yk form-group row">

                                    <div class="col-md-12 col-12">
                                            <textarea id="description" type="description"
                                                      class="form-control @error('description') is-invalid @enderror"
                                                      name="description" placeholder="ဆိုင်အကြောင်း"
                                                      autocomplete="new-password">{{ old('description') }}</textarea> @error('description')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>

                                </div>


                                {{--//address--}}


                                {{--//address--}}

                                <div class="form-check mb-4 d-flex flex-row no-gutters pl-0">

                                    <div class="col-12 align-items-end">
                                        <a id= "zh_btn_one" type="button" href="javascript:void(0);"
                                           style="color: #7a7979;font-weight: bolder;" class="next float-right">Next
                                            <span class="fa fa-arrow-right"></span> </a>
                                        <a type="button" name="previous" href="javascript:void(0);"
                                           style="color: #7a7979;font-weight: bolder;"
                                           class="previous float-left"><span class="fa fa-arrow-left"></span>
                                            Previous </a>
                                        <a id= "zh_btn_two" type="button" href="javascript:void(0);"
                                           style="color: #7a7979;font-weight: bolder;" class="next_yk float-right">Next
                                            <span class="fa fa-arrow-right"></span> </a>
                                        <a type="button" name="previous" href="javascript:void(0);"
                                           style="color: #7a7979;font-weight: bolder;"
                                           class="previous_yk float-left"><span class="fa fa-arrow-left"></span>
                                            Previous </a>
                                        <button type="submit" name="previous" href="javascript:void(0);"
                                                style="font-weight: bolder;" class="btn yk-btn-success float-right">
                                            Submit
                                        </button>


                                    </div>
                                </div>


                                <div class="form-group row">


                                    <div class="col-md-12 text-center">


                                        <a href="{{route('backside.shop_owner.login')}}"
                                           aria-pressed="true"> {{ __('အကောင့်ရှိလျှင် အကောင့်ဝင်ရန်') }}</a>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script src="{{url('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });

        // zawhtetnaung
        //shopowner register form js
        $(document).ready(function () {


            $('.se').hide();
            $('.btn').hide();
            $('.previous').hide();
            $('.yk').hide();
            $('.next_yk').hide();
            $('.previous_yk').hide();


            $(".next").click(function () {
                $('.fs').hide();
                $('.next').hide();
                $('.yk').hide();
                $('.se').show();
                $('.btn').hide();
                $('.previous').show();
                $('.previous_yk').hide();
                $('.next_yk').show();
                $("html, body").animate({ scrollTop: 0 }, "slow");

            })
            $(".previous").click(function () {
                $('.fs').show();
                $('.se').hide();
                $('.btn').hide();
                $('.next').show();
                $('.previous').hide();
                $('.yk').hide();
                $('.next_yk').hide();

                $("html, body").animate({ scrollTop: 0 }, "slow");

            })
            $(".next_yk").click(function () {
                $('.fs').hide();
                $('.se').hide();
                $('.btn').show();
                $('.next').hide();
                $('.previous').hide();
                $('.yk').show();
                $('.next_yk').hide();
                $('.previous_yk').show();
                $("html, body").animate({ scrollTop: 0 }, "slow");


            })
            $(".previous_yk").click(function () {
                $('.fs').hide();
                $('.se').show();
                $('.btn').hide();
                $('.next').hide();
                $('.previous').show();
                $('.yk').hide();
                $('.next_yk').show();
                $('.previous_yk').hide();

                $("html, body").animate({ scrollTop: 0 }, "slow");

            })

            //Generate Password

            $('.sn_generate_password').click(function () {
              var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%&^*ABCDEFGHIJKLMNOPQRSTUVWXYZ";
              var passwordLength = 6;
              var generated_password = "";
              for (var i = 1; i <= passwordLength; i++) {
                var randomNumber = Math.floor(Math.random() * chars.length);
                generated_password += chars.substring(randomNumber, randomNumber +1);
              }
              document.getElementById("password").type = 'text';
              document.getElementById("password-confirm").type = 'text';

              document.getElementById("password").value = generated_password;
              document.getElementById("password-confirm").value = generated_password;
            })

            // zh validation


                $('#zh_btn_one').click(function () {
                    validateUsername();
                    validateEmail();

                });

                // validate name
                $('#usercheck').hide();
                $('#emailcheck').hide();
                function validateUsername(){
                    let usernameValue = $('#name').val();

                    if (usernameValue.length == '') {
                    $('#usercheck').show();
                    $('.fs').show();
                    $('.se').hide();
                    $('.btn').hide();
                    $('.next').show();
                    $('.previous').hide();
                    $('.yk').hide();
                    $('.next_yk').hide();


                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                    else if((usernameValue.length < 3)||
                        (usernameValue.length > 20)){
                                $('#usercheck').show();
                                $('.fs').show();
                                $('.se').hide();
                                $('.btn').hide();
                                $('.next').show();
                                $('.previous').hide();
                                $('.yk').hide();
                                $('.next_yk').hide();
                                $('#usercheck').html
                                ("**length of username must be between 3 and 10");
                             }
                             else {
                                        $('#usercheck').hide();
                                    }

                }

                // email valid
                function validateEmail(){
                    let usernameEmail = $('#email').val();
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                    if(usernameEmail.length == '') {
                        $('#emailcheck').show();
                        $('.fs').show();
                        $('.se').hide();
                        $('.btn').hide();
                        $('.next').show();
                        $('.previous').hide();
                        $('.yk').hide();
                        $('.next_yk').hide();
                    }else if(!regex.test(usernameEmail)){
                        $('#emailcheck').show();
                        $('.fs').show();
                        $('.se').hide();
                        $('.btn').hide();
                        $('.next').show();
                        $('.previous').hide();
                        $('.yk').hide();
                        $('.next_yk').hide();
                        $('#emailcheck').html
                                ("**email is invalid");
                    }else {
                        $('#emailcheck').hide();
                    }


            }

            // password valid
            function validatePassword(){

            }

            // photo
            function validateLogo(){
                let usernameValue = $('#logo').val();
            }




        })
    </script>
@endpush
