@extends('layouts.backend.datatable')

@section('content')
    <div class="container py-2" >
        {{--    <div class="row justify-content-center" style="font-weight:bolder;">LOGO</div>--}}
        {{--    <div class="row justify-content-center" >fffffffff</div>--}}
        {{--    <div class="row justify-content-center">fffffff</div>--}}
        <div class="row justify-content-center g-0">
            <div class="col-0 col-md-3">&nbsp;</div>
            <div class="col-12 col-md-6">
                <p class="text-uppercase font-weight-bolder text-left" style="font-weight: 1700 !important;"><h1 style="font-weight: 700;">Login</h1></p>

                <p class=" font-weight-bolder text-left">{{ __('Shwe Shops') }}<span class="font-weight-normal">{{ __('မှ ကြိုဆိုပါသည်') }}</span></p>
            </div>
            <div class="col-0 col-md-3 d-none d-md-inline">&nbsp;</div>
            <div class="col-0 col-md-3 d-none d-md-inline">&nbsp;</div>


            <div class="col-12 col-md-6 mt-4">
                <div class="">
                    <div class="">
                        <form method="POST" action="{{ route('backside.shop_owner.logined') }}">
                            @csrf
                            <input type="hidden" value="{{$from}}" name="from"/>

                            <div class="form-group row">


                                <div class="col-md-12">
                                    <label for="exampleInputEmail1">Phone</label>

                                    <div class="input-group ">


                                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="value" placeholder="Your Phone" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-1">


                                <div class="col-md-12">
                                    <label for="exampleInputEmail1">စကားဝှက်</label>

                                    <div class="input-group mb-3">

                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="စကားဝှက်" required autocomplete="current-password">
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-check mb-4 d-flex flex-row no-gutters">
                                <div class="col-6 justify-content-start
">

                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                                </div>
                                <div class="col-6 align-items-end">

                                    <a href="{{'forgot_password'}}" class="float-right">Forgot Password?</a>
                                </div>
                            </div>



                            <div class="text-center">


                                    <button type="submit" class="btn yk-btn-success w-100">
                                        {{ __('အကောင့်ဝင်ရန်') }}
                                    </button>
                                <br>
                                <br>

{{--                                <a href="{{route('register')}}"  aria-pressed="true"> {{ __('အကောင့်မရှိလျှင်') }} {{ __('အကောင့်သစ်ဖွင့်ရန်') }}</a>--}}

{{--                          <a href="{{route('backside.shop_owner.register')}}"  aria-pressed="true"> {{ __('အကောင့်မရှိလျှင်') }} {{ __('အကောင့်သစ်ဖွင့်ရန်') }}</a>--}}



                            </div>
                            <br>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-0 col-md-3">&nbsp;</div>

        </div>
    </div>
@endsection
