
@extends('layouts.backend.datatable')

@section('content')
    <div class="container py-2" >
        {{--    <div class="row justify-content-center" style="font-weight:bolder;">LOGO</div>--}}
        {{--    <div class="row justify-content-center" >fffffffff</div>--}}
        {{--    <div class="row justify-content-center">fffffff</div>--}}
        <div class="row mt-5">
            <div class=" offset-1 col-5 card card-color d-none">
                <div class="g-0 card-body">
                    <h4 class="font-weight-bold mt-3">Login Account</h4>
                    <h4 class="font-weight-normal mt-5">POS Features:</h4>
                    <h6 class="mt-3"><i class="fa fa-plus-square-o icon" aria-hidden="true"></i><span class="ml-3">Create product sale list</span></h6>
                    <h6 class="mt-2"><i class="fa fa-list-ul icon" aria-hidden="true"></i><span class="ml-3">Track your daily sales</span></h6>
                    <h6 class="mt-2"><i class="fa fa-paper-plane-o icon" aria-hidden="true"></i><span class="ml-3">One-Click features</span></h6>
                    <h6 class="mt-2"><i class="fa fa-calendar-check-o icon" aria-hidden="true"></i><span class="ml-3">Easily to check monthly sales</span></h6>
                    <h4 class="font-weight-normal mt-5">What Can Do:</h4>
                    <h6 class="mt-3"><i class="fa fa-check icon" aria-hidden="true"></i><span class="ml-3">Improve in-store sales.</span></h6>
                    <h6 class="mt-2"><i class="fa fa-check icon" aria-hidden="true"></i><span class="ml-3">Quick Payment.</span></h6>
                    <h6 class="mt-2"><i class="fa fa-check icon" aria-hidden="true"></i><span class="ml-3">Better Customer Management.</span></h6>
                    <h6 class="mt-2"><i class="fa fa-check icon" aria-hidden="true"></i><span class="ml-3">Manage your inventory in one place</span></h6>
                    <h6 class="mt-2"><i class="fa fa-check icon" aria-hidden="true"></i><span class="ml-3">See online and store reporting in one place</span></h6>
                </div>
            </div>
            <div class="col-md-5 card">
                <div class="row justify-content-center g-0 card-body">
                    <div class="col-0 col-md-3">&nbsp;</div>
                    <div class="col-12 col-md-6 mt-3">
                        {{-- <p class="text-uppercase font-weight-bolder text-left" style="font-weight: 1700 !important;"><h1 style="font-weight: 700;">Login</h1></p> --}}

                        {{-- <p class=" font-weight-bolder text-left">{{ __('Shwe Shops') }}<span class="font-weight-normal">{{ __('မှ ကြိုဆိုပါသည်') }}</span></p> --}}
                        <div class="logo d-none" style="margin-left: 60px">
                            <img src="https://test.shweshops.com/test/img/logo-m.png" alt="" class="mt-4">
                        </div>
                        <div class="logo1 d-none" style="margin-left: 125px">
                            <img src="https://test.shweshops.com/test/img/logo-m.png" alt="" class="mt-4">
                        </div>

                        <p class=" font-weight-bolder">
                            <h6 class="font-weight-normal text-center">{{ __('Developed By') }}</h6>
                            <h6 class="font-weight-bold text-center">{{ __('SHWESHOPS') }}</h6>
                        </p>
                    </div>
                    <div class="col-0 col-md-3 d-none d-md-inline">&nbsp;</div>
                    <div class="col-0 col-md-3 d-none d-md-inline">&nbsp;</div>


                    <div class="col-12 col-md-10 mt-1">
                        <div class="">
                            <div class="">
                                <form method="POST" action="{{ route('backside.shop_owner.pos_logined') }}">
                                    @csrf
                                    <input type="hidden" value="{{$from}}" name="from"/>

                                    <div class="form-group row">

                                        <div class="col-md-12">
                                            <label for="exampleInputEmail1">Phone</label>

                                            <div class="input-group ">


                                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="value" placeholder="Enter Your Phone" value="{{ old('email') }}" required autocomplete="email" autofocus>
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
                                            <label for="exampleInputEmail1">Password</label>

                                            <div class="input-group mb-3">

                                                <input type="password" id="password"  class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Your Password" required autocomplete="current-password">
                                            </div>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">


                                        <div class="col-md-12">
                                            <label for="exampleInputEmail1">Role</label>

                                            <select
                                                  class="selectpicker form-control sop-form-control select2"
                                                  name="role_id"
                                                  style="width: 100%"
                                              >   
                                              <option value="4">shopowner</option>
                                              @foreach($role as $role)
                                              
                                                  <option value="{{$role -> id}}" selected>
                                                    {{$role -> name}}
                                                  </option>
                                              @endforeach
                                                  
                                              </select> 
                                        </div>
                                    </div>
                                    

                                    <div class="form-check mb-4 d-flex flex-row no-gutters mt-2">
                                        <div class="col-6 justify-content-start">

                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Keep Me Logged In</label>
                                        </div>
                                        <div class="col-6 align-items-end">

                                            <a href="{{'forgot_password'}}" class="float-right">Forgot Password?</a>
                                        </div>
                                    </div>



                                    <div class="text-center">
                                            <button type="submit" class="btn btn_color w-100">
                                                {{-- {{ __('အကောင့်ဝင်ရန်') }} --}}
                                                LOGIN
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
        </div>
        {{-- start --}}

        {{-- end --}}
    </div>
@endsection
@push('css')
<style>
    .btn_color{
        background-color: #780116;
        color: white;
    }
    .btn_color:hover{
        color: white;
    }
    .icon{
        color: #780116;
    }
    .card-color{
        background-color: rgba(220, 220, 220, 0.39);
    }

    .logo{
        width:80px;
        height:80px;
        background-color: #780116;
        border:none;
        border-radius: 70px;
    }
    .logo1{
        width:80px;
        height:80px;
        background-color: #780116;
        border:none;
        border-radius: 70px;
    }
    .card{
        width: 1200px;
    }

</style>

@endpush
@push('scripts')
<script>
 $(document).ready(function () {
    setInterval(() => {
            if(screen.width <= 605){
            $('.logo1').show();
            $('.logo1').removeClass('d-none');
            $('.logo').hide();
        }else{
            $('.card-color').removeClass('d-none');
            $('.logo').show();
            $('.logo').removeClass('d-none');
            $('.logo1').hide();

        }
        }, 1);
    })
</script>
@endpush
