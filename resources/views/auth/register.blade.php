@extends('layouts.backend.datatable')
@section('content')
    <div class="container-fluid no-gutters p-0">


        {{--//for mobile--}}
        <div class="col-12 text-left yk-background d-block d-md-none">
            <div class="fs pt-5 pb-5 pl-4 ">
                <div><span style="font-weight: bolder;font-size: 32px;">ShweShops</span> <span style="font-size: 18px;">မှ ကြိုဆိုပါသည်</span>
                </div>
                <div style="color: white;" class="mt-2">လူကြီးမင်းရဲ့ အကောင့်ကိုစတင်အသုံးပြုနိင်ရန်အတွက်
                    အောက်ပါအချက်အလက်များကိုဖြည့်သွင်း‌ပေးပါ။
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
                        <div style="color: white;text-align: center;">လူကြီးမင်းရဲ့
                            ‌အကောင့်ကိုစတင်အသုံးပြုနိင်ရန်အတွက်
                            အောက်ပါအချက်အလက်များကိုဖြည့်သွင်း‌ပေးပါ။
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
                                  action="{{ route('register') }}">
                                @csrf

                                <div class="fs form-group row">


                                    <div class="col-md-12 col-12">
                                        <label for="exampleInputUsername">အမည် <span
                                                    style="color: red;">*</span></label>

                                        <div class="input-group mb-3">

                                            <input id="username" type="text"
                                                   class="form-control @error('username') is-invalid @enderror"
                                                   name="username" value="{{ old('username') }}" placeholder="အမည်"
                                                   autocomplete="username" required>
                                        </div>
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                                    </div>


                                </div>
                                <div class="fs form-group row">

                                    <div class="col-md-12 col-12">
                                        <label for="exampleInputGender">Gender <span
                                                    style="color: red;">*</span></label>

                                        <div class="input-group mb-3">

                                           
                                    
                                            <div class="form-check">
                                                <input class="form-check-input @error('gender') is-invalid @enderror" 
                                                        type="radio" name="gender" id="flexRadioDefault1" value="male" checked>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Male
                                                </label>
                                            </div>
                                            
                                            <div class="form-check" style="
                                                                        padding-left: 2.25rem;
                                                                    ">
                                                <input class="form-check-input @error('gender') is-invalid @enderror" 
                                                type="radio" name="gender" id="flexRadioDefault2"  value="female">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Female
                                                </label>
                                            </div>

                                        </div>
                                        @error('gender')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>

                                </div>
                              
                                <div class="fs form-group row">

                                    <div class="col-md-12 col-12">
                                        <label for="exampleInputAge">Age <span
                                                    style="color: red;">*</span></label>

                                        <div class="input-group mb-3">

                                            <input id="age" type="age"
                                                   class="form-control @error('age') is-invalid @enderror"
                                                   name="age" value="{{ old('age') }}" placeholder="Age"
                                                   autocomplete="age">
                                        </div>
                                        @error('age')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>

                                </div>
                                <div class="fs form-group row">


                                    <div class="col-md-12">
                                        <label for="exampleInputEmail1">စကားဝှက် အသစ် <span
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
                                </div>
                                <div class="fs form-group row">


                                    <div class="col-md-12">
                                        <label for="exampleInputEmail1">စကားဝှက်ကို အတည်ပြုပါ<span
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
                               


                                {{--//address--}}


                                {{--//address--}}

                                <div class="form-check mb-4 d-flex flex-row no-gutters pl-0">

                                    <div class="col-12 align-items-end">
                                     
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
@endsection @push('scripts')
    <script src="{{url('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

@endpush
