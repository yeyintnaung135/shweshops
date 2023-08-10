@extends('backend.super_admin.layout')
@section('content')
<div class="wrapper">
@include('backend.pos_super_admin.navbar')
@include('backend.pos_super_admin.sidebar')
    <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>Create Shops</x-title>
            </section>
        <div class="container">
            <div class="row">

                <div id="" class="col-12">

                    <form  method="POST" enctype="multipart/form-data"
                                    action="{{ route('pos_super_admin_shops.store') }}">
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
                                            <label for="exampleInputEmail1">Password <span
                                                        style="color: red;">*</span></label>

                                            <div class="input-group mb-3">

                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" placeholder="စကားဝှက် အသစ်"
                                                    autocomplete="new-password">
                                            </div>
                                            <h5 id="passwordcheck" style="color: red;" >
                                                    **Password is missing
                                            </h5>
                                            <small id="passwordvalid" class="form-text
                                                text-muted">
                                                    Your pin must be 6
                                            </small>
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
                                            <label for="exampleInputEmail1">Password နံပါတ်ကိုအတည်ပြုပါ<span
                                                        style="color: red;">*</span></label>

                                            <div class="input-group mb-3">

                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" placeholder="စကားဝှက်ကို အတည်ပြုပါ"
                                                    autocomplete="new-password">
                                            </div>
                                            <h5 id="confirm" style="color: red;" >

                                            </h5>
                                        </div>
                                        @error('password_confirmation')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>
                                    <div class="se form-group row">
                                        <div class="col-12 col-md-6">
                                            <label for="exampleInputEmail1">ဆိုင် အမည် english<span style="color: red;">*</span></label>
                                            <div class="input-group mb-3">
                                              <input id="shop_name" type="text"
                                                class="form-control @error('shop_name') is-invalid @enderror"
                                                name="shop_name" value="{{ old('shop_name') }}"
                                                placeholder="ဆိုင် အမည်" autocomplete="name" autofocus>
                                            </div>
                                            <h5 id="shopname_check" style="color: red;" >
                                                    **Shopname is missing
                                            </h5>
                                            @error('shop_name')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="exampleInputEmail1">ဆိုင် အမည် myanmar<span
                                                        style="color: red;">*</span></label>


                                            <div class="input-group mb-3">

                                                <input id="shop_name_myan" type="text"
                                                    class="form-control @error('shop_name_myan') is-invalid @enderror"
                                                    name="shop_name_myan" value="{{ old('shop_name_myan') }}"
                                                    placeholder="ဆိုင် အမည် myanmar" autocomplete="name" autofocus>
                                            </div>
                                            <h5 id="shopname_myan_check" style="color: red;" >
                                                    **Shopname is missing
                                            </h5>
                                            @error('shop_name_myan')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="se form-group row">

                                    <div class="col-12 col-md-6">
                                            <label for="exampleInputEmail1">Shop Link Name<span
                                                        style="color: red;">*</span></label>


                                        <div class="input-group mb-3">

                                                <input id="shop_name_url" type="text"
                                                    class="form-control @error('shop_name_url') is-invalid @enderror"
                                                    name="shop_name_url" value="{{ old('shop_name_url') }}"
                                                    placeholder="Shop Link Name"autofocus>
                                            </div>
                                            <h5 id="shoplink_check" style="color: red;" >
                                                    **Shoplink is missing
                                            </h5>
                                            @error('shop_name_url')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>
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
                                            <h5 id="mainphone_check" style="color: red;" >
                                                    **Mainphone is missing
                                            </h5>
                                            @error('main_phone')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror

                                        </div>
                                        <div class="col-12 col-md-6">

                                            <!-- <label for="password" class="col-md-4 col-form-label text-md-right">Shop NAME</label> -->
                                            <label for="exampleInputEmail1">Other Phones</label>


                                            <div class="input-group mb-3">
                                                <input type="text" class=" form-control-tags js-tagify" id="sub_phones" placeholder="Press Enter after each phones"
                                                name="additional_phones" value="{{ old( 'additional_phones') }}" >
                                            </div>
                                            @error('additional_phones')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                          <label for="state">State<span style="color: red;">*</span></label>
                                          <select id="state" name="state" class="form-control @error('state') is-invalid @enderror">
                                            <option selected disabled hidden>Select a state</option>
                                            @foreach($states as $state)
                                              @if (old('state') == $state->id)
                                                <option value="{{ $state->id }}" selected>{{ $state->name . ' (' . $state->myan_name . ')' }}</option>
                                              @else
                                                <option value="{{ $state->id }}">{{ $state->name . ' (' . $state->myan_name . ')' }}</option>
                                              @endif
                                            @endforeach
                                          </select>

                                          @error('state')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                          @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                          <label for="township">Township<span style="color: red;">*</span></label>
                                          <input type="hidden" id="hiddentownship" name="" value="{{ old('township') }}">
                                          <select id="township" name="township" class="form-control @error('township') is-invalid @enderror">
                                          </select>

                                          @error('township')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                          @enderror
                                        </div>
                                      </div>





                                    {{-- //page--}}
                                    <div class="se form-group row">
                                        <div class="col-12 col-md-6">
                                            <label for="exampleInputEmail1">Facebook messenger Link<span
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
                                            <h5 id="messangerlink_check" style="color: red;" >
                                                    **Messanger Link is missing
                                            </h5>
                                            @error('phone_no')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="exampleInputEmail1">Facebook Page Link<span
                                                        style="color: red;">*</span></label>

                                            <div class="input-group mb-3">

                                                <!-- <div class="dropdown"> -->
                                                <!-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                Dropdown button
                                                </button> -->
                                                <!-- <div class="dropdown-menu"> -->
                                                <input id="fb_link" value="{{ old('page_link') }}" min="0" type="text"
                                                    class="form-control @error('messenger_link') is-invalid @enderror"
                                                    name="page_link" placeholder="Your Facebook Page link">
                                                <!-- </div> -->
                                                <!-- </div> -->

                                            </div>
                                            <h5 id="fblink_check" style="color: red;" >
                                                    **Facebook Link is missing
                                            </h5>
                                            @error('page_link')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-12">

                                            <label for="Premium">Premium</label>
                                            <select class="custom-select rounded-0" name="premium" id="premium">
                                                <option value="yes">Yes</option>
                                                <option value="no" selected>No</option>

                                            </select>
                                        </div>

                                        <div class="col-12 col-md-6 mt-3">
                                            <label for="">ဆိုင်logoတင်ရန်<span style="color: red;">*</span></label>
                                            <input type="file" class="form-control" name='shop_logo'>
                                            @error('shop_logo')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>

                                    </div>
                                    {{-- //page--}}


                                    <div class="se form-group row">


                                        <div class="col-md-12 col-12" id="banner">
                                            <label for="exampleInputEmail1">ဆိုင်bannerတင်ရန်<span
                                                        style="color: red;">*</span></label>

                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" name='banner[]' class="custom-file-input"
                                                        id="banner" multiple>
                                                    <label class="custom-file-label" for="exampleInputFile">ဆိုင်bannerတင်ရန်</label>
                                                </div>

                                            </div>
                                            <h5 id="banner_check" style="color: red;" >
                                                    **Banner is missing
                                            </h5>
                                            @error('banner.*')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>


                                    </div>



                                    <div class="se form-group row">
                                        <div class="col-md-12 col-12">
                                            <label for="undamaged_product">အထည်မပျက် ပြန်သွင်း</label>
                                            <div class="input-group mb-3">

                                                <input id="undamaged_product" value="{{ old('undamaged_product') }}"
                                                    min="0"
                                                    class="form-control @error('undamaged_product') is-invalid @enderror"
                                                    name="undamaged_product" placeholder="10 % or 10000ကျပ် "
                                                    autocomplete="new-password">
                                            </div>
                                            @error('undamaged_product')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="se form-group row">
                                        <div class="col-md-12 col-12">
                                            <label for="valuable_product">တန်ဖိုးမြင့်အထည် နှင့် အထည်မပျက်ပြန်လဲ</label>
                                            <div class="input-group mb-3">

                                                <input value="{{ old('valuable_product') }}"
                                                    min="0"  id="valuable_product"

                                                    class="form-control @error('valuable_product') is-invalid @enderror"
                                                    name="valuable_product"
                                                    placeholder="10 % or 10000ကျပ် "
                                                    >
                                            </div>
                                            @error('valuable_product')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="se form-group row">
                                        <!-- <label for="password" class="col-md-4 col-form-label text-md-right">Shop NAME</label> -->

                                        <div class="col-md-12 col-12">
                                            <label for="damaged_product">အထည်ပျက်စီး ချို့ယွင်း</label>
                                            <div class="input-group mb-3">

                                                <input id="damaged_product"
                                                    value="{{ old('damaged_product') }}" min="0"
                                                    type="text"
                                                    class="form-control @error('damaged_product') is-invalid @enderror"
                                                    name="damaged_product"
                                                    placeholder="10 % or 10000ကျပ် "
                                                    autocomplete="new-password">
                                            </div>
                                            @error('damaged_product')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="yk form-group row">

                                        <div class="col-md-12 col-12">
                                            <label for="summernoteDescription">Description<span
                                                    style="color: red;">*</span></label>
                                            <textarea id="summernoteDescription" type="description"
                                                        class="form-control @error('description') is-invalid @enderror"
                                                        name="description" placeholder="ဆိုင်အကြောင်း"
                                                        autocomplete="new-password">{{ old('description') }}</textarea> @error('description')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="yk form-group row">
                            <div class="col-12 col-md-6">
                                <label for="summernoteAddress">Address<span
                                        style="color: red;">*</span></label>
                                <textarea id="summernoteAddress" type="description"
                                          class="form-control @error('address') is-invalid @enderror"
                                          name="address" placeholder="Address" rows="4">{{old('address')}}</textarea>
                                <h5 id="address_check" style="color: red;" >
                                    **Address is missing
                                </h5>
                                @error('address')
                                <x-error>
                                    {{$message}}
                                </x-error>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="summernoteOtherAddress">Other Address<span
                                        style="color: red;">*</span></label>
                                <textarea id="summernoteOtherAddress" type="description"
                                          class="form-control @error('other_address') is-invalid @enderror"
                                          name="other_address" placeholder="More Address" rows="4">{{old('other_address')}}</textarea>

                            </div>
                            <div class="col-12 col-md-6">
                                <label for="address">Map</label>
                                <textarea id="map" type="description"
                                          class="form-control"
                                          name="map" placeholder="GoogleMap" rows="4">{{old('map')}}</textarea>
                            </div>
                        </div>
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
                    </form>
{{--                    <shopscreatevalidate></shopscreatevalidate>--}}
                </div>
            </div>
        </div>

    </section>
</div>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
@endsection
@push('css')
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
<style>
    .tagify{
            --tag-inset-shadow-size:2em!important;
        }
    .tagify__input:empty::before {
        position: static;
    }
    .tagify{
        width: 100%;
        background: white;
        border: 1px solid #ced4da;
        border-top-color: rgb(206, 212, 218);
        border-top-style: solid;
        border-top-width: 1px;
        border-right-color: rgb(206, 212, 218);
        border-right-style: solid;
        border-right-width: 1px;
        border-bottom-color: rgb(206, 212, 218);
        border-bottom-style: solid;
        border-bottom-width: 1px;
        border-left-color: rgb(206, 212, 218);
        border-left-style: solid;
        border-left-width: 1px;
        border-image-source: initial;
        border-image-slice: initial;
        border-image-width: initial;
        border-image-outset: initial;
        border-image-repeat: initial;
    }
</style>
@endpush
@push('scripts')
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
        var input = document.querySelector('input[name=additional_phones]');
        new Tagify(input)
    </script>
    <script>
        $('#summernoteAddress').summernote({
            height: 200
        });
        $('#summernoteOtherAddress').summernote({
            height: 200
        });
        $('#summernoteDescription').summernote({
            height:200
        });
      $(function () {
        bsCustomFileInput.init();
        getTownship($('#hiddentownship').val());



        $(document).on('change', '#state', function() {
          getTownship('');
        });

        function getTownship (township) {
          var state_id = $("#state").val();
          console.log('Yangon', state_id);
          var op = " ";
          $.ajax({
              url: "{{ url('backside/pos_super_admin/get_township')}}",
              type: "get",
              data: {'id':state_id},
              success: function(data){
                op += '<option selected disabled hidden>Select a township</option>';
                if(data.length != 0) {
                  for (var i = 0; i < data.length; i++){
                    if(township == data[i].id) {
                      op += '<option value="'+data[i].id+'" selected>'+data[i].name +' (' + data[i].myan_name + ')</option>';
                    } else {
                      op += '<option value="'+data[i].id+'">'+data[i].name +' (' + data[i].myan_name + ')</option>';
                    }
                  }
                } else {
                  op += '<option selected disabled hidden>Select a state first</option>';
                }

                console.log('Worked', data)
                $('#township').html(" ");
                $('#township').append(op);
              },
              error: function(){
                  console.log('error');
              },
          });
        }

      })

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
                    validatePassword();
                    checkPasswordMatch();

                });

                $('#zh_btn_two').click(function () {
                    validateShopname();
                    validateShopnamemyan();
                    validateShoplink();
                    validateMainphone();
                    validateAddress();
                    validateMessangerlink();
                    validateFblink();
                    validateLogo();
                    validateBanner();

                });

                // validate name
                $('#usercheck').hide();
                $('#emailcheck').hide();
                $('#passwordcheck').hide();
                $('#passwordvalid').hide();
                $('#shopname_check').hide();
                $('#shopname_myan_check').hide();
                $('#shoplink_check').hide();
                $('#mainphone_check').hide();
                $('#address_check').hide();
                $('#messangerlink_check').hide();
                $('#fblink_check').hide();
                $('#logo_check').hide();
                $('#banner_check').hide();

                $('#banner').hide();
                // $('#banner').show($('#premium').value == "yes");
                $('#premium').on('change', function() {
                    $("#banner").toggle(this.value == "yes")
                });

                // username valid
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
                        (usernameValue.length > 500)){
                                $('#usercheck').show();
                                $('.fs').show();
                                $('.se').hide();
                                $('.btn').hide();
                                $('.next').show();
                                $('.previous').hide();
                                $('.yk').hide();
                                $('.next_yk').hide();
                                $('#usercheck').html
                                ("**length of username must be between 3 and 500");
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
                    let pinValue = $('#password').val();

                    if(pinValue.length == ''){
                        $('#passwordcheck').show();
                        $('.fs').show();
                        $('.se').hide();
                        $('.btn').hide();
                        $('.next').show();
                        $('.previous').hide();
                        $('.yk').hide();
                        $('.next_yk').hide();


                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }else if(pinValue.length < 6){
                        $('#passwordcheck').hide();
                        $('.fs').show();
                        $('.se').hide();
                        $('.btn').hide();
                        $('.next').show();
                        $('.previous').hide();
                        $('.yk').hide();
                        $('.next_yk').hide();
                        $('#passwordvalid').show();


                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                }

                // confirm password
                function checkPasswordMatch() {
                    var password = $("#password").val();
                    var confirmPassword = $("#password-confirm").val();
                    if (password != confirmPassword){
                        $('.fs').show();
                        $('.se').hide();
                        $('.btn').hide();
                        $('.next').show();
                        $('.previous').hide();
                        $('.yk').hide();
                        $('.next_yk').hide();
                        $("#confirm").html("Passwords does not match!");
                    }else{
                        $('#confirm').hide();
                    }

                }

                // shopname valid
                function  validateShopname() {
                        let shopnameValue = $('#shop_name').val();

                        if (shopnameValue.length == '') {
                        $('#shopname_check').show();
                        $('.fs').hide();
                        $('.se').show();
                        $('.btn').hide();
                        $('.next').hide();
                        $('.previous').hide();
                        $('.yk').hide();
                        $('.previous_yk').show();
                        $('.next_yk').show();


                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }else{
                        $('#shopname_check').hide();
                    }
                }

                // shopnamemyan valid
                function  validateShopnamemyan() {
                    let shopnamemyanValue = $('#shop_name_myan').val();

                    if (shopnamemyanValue.length == '') {
                    $('#shopname_myan_check').show();
                    $('.fs').hide();
                    $('.se').show();
                    $('.btn').hide();
                    $('.next').hide();
                    $('.previous').hide();
                    $('.yk').hide();
                    $('.previous_yk').show();
                    $('.next_yk').show();


                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    }else{
                    $('#shopname_myan_check').hide();
                    }
                }
                // shoplink valid
                function  validateShoplink() {
                    let shoplink = $('#shop_name_url').val();

                    if (shoplink.length == '') {
                    $('#shoplink_check').show();
                    $('.fs').hide();
                    $('.se').show();
                    $('.btn').hide();
                    $('.next').hide();
                    $('.previous').hide();
                    $('.yk').hide();
                    $('.previous_yk').show();
                    $('.next_yk').show();


                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    }else{
                    $('#shoplink_check').hide();
                    }
                }
                // mainphone valid
                function  validateMainphone() {
                    let mainphone = $('#main_phone').val();

                    if (mainphone.length == '') {
                    $('#mainphone_check').show();
                    $('.fs').hide();
                    $('.se').show();
                    $('.btn').hide();
                    $('.next').hide();
                    $('.previous').hide();
                    $('.yk').hide();
                    $('.previous_yk').show();
                    $('.next_yk').show();


                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    }else{
                    $('#mainphone_check').hide();
                    }
                }
                // address valid
                function  validateAddress() {
                    let address = $('#address').val();

                    if (address.length == '') {
                    $('#address_check').show();
                    $('.fs').hide();
                    $('.se').show();
                    $('.btn').hide();
                    $('.next').hide();
                    $('.previous').hide();
                    $('.yk').hide();
                    $('.previous_yk').show();
                    $('.next_yk').show();


                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    }else{
                    $('#address_check').hide();
                    }
                }
                // messangerlink valid
                function  validateMessangerlink() {
                    let messangerlink = $('#messenger_link').val();

                    if (messangerlink.length == '') {
                    $('#messangerlink_check').show();
                    $('.fs').hide();
                    $('.se').show();
                    $('.btn').hide();
                    $('.next').hide();
                    $('.previous').hide();
                    $('.yk').hide();
                    $('.previous_yk').show();
                    $('.next_yk').show();


                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    }else{
                    $('#messangerlink_check').hide();
                    }
                }
                // Fblink valid
                function  validateFblink() {
                    let fblink = $('#fb_link').val();

                    if (fblink.length == '') {
                    $('#fblink_check').show();
                    $('.fs').hide();
                    $('.se').show();
                    $('.btn').hide();
                    $('.next').hide();
                    $('.previous').hide();
                    $('.yk').hide();
                    $('.previous_yk').show();
                    $('.next_yk').show();


                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    }else{
                    $('#fblink_check').hide();
                    }
                }
                // logo valid
                function  validateLogo() {
                    let logo = $('#logo').val();

                    if (logo.length == '') {
                    $('#logo_check').show();
                    $('.fs').hide();
                    $('.se').show();
                    $('.btn').hide();
                    $('.next').hide();
                    $('.previous').hide();
                    $('.yk').hide();
                    $('.previous_yk').show();
                    $('.next_yk').show();


                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    }else{
                    $('#logo_check').hide();
                    }
                }
                // banner valid
                function  validateBanner() {

                }



        })

    </script>


@endpush

