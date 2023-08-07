@extends('layouts.app')
@section('content')
    <div class="container-fluid" >
        <div class="row">
            <div class="d-none col-12 col-lg-6  vh-100 d-lg-flex justify-content-center align-items-center super_admin_background">
            <a href="{{url('/')}}">
                <div class="p-3 d-flex align-items-center">
                  <div class="">
                   
                        <img src="{{ asset('test/img/logo-m.png')}}" alt="" width="100px">
                    
                  
                  </div>
                  <div class="ml-3">
                     <h1 class="font-weight-bolder text-light mt-3">Shweshops</h1>
                  </div>
                </div>
                </a>
            </div>
            <div class="col-12 col-lg-6  mt-lg-0 d-flex justify-content-center align-items-center p-0 mt-5">
                <div class="col-12 col-lg-6 p-lg-0 p-3">
                    <div class="col-12 mobile_super_admin_login_header">
                        <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('test/img/logo-m.png')}}" alt="" width="70px">
                            <h1 class="ml-3 mt-3 font-weight-bolder super_admin_secondary_text_color">Shweshops</h1>
                        </div>
                    </div>
                   <div class="login-header mb-5">
                      <h3 class="font-weight-bolder mobile_super_admin_login_font_size ">Login As Pos Super Admin</h3>
                   </div>
                   <div class="login-form">
                    <form method="POST" action="{{ route('backside.pos_super_admin.login') }}">
                       @csrf
                        <div class="form-group">
                             <label for="email" class="font-weight-bolder">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control-lg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror                          
                        </div>
                        <div class="form-group">
                            <label for="password" class="font-weight-bolder">{{ __('Password') }}</label>
                               <div class="position-relative ">
                               <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <i class="fas fa-eye-slash " id="togglePassword" onclick="toggleEye(this)"></i>
                               </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            
                        </div>
                        <div class="form-group mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label text-black-50" for="remember">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>
                                <div class="">
                                @if (Route::has('password.request'))
                               {{--   <a class="btn btn-link text-black-50" href="{{ route('password.request') }}"> --}}
                                    <a class=" text-black-50" href="#">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif 
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="admin_login_btn font-weight-bolder rounded-3">Login</button>

                                
                            {{--  <a class="btn btn-link text-black-50" href="{{ route('backside.super_admin.register') }}">
                                        {{ __('No Account Yet?') }}
                                </a> --}}
                            </div>
                        </div>
                    </form>
                   </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
<style>
    form i {
        position: absolute;
        top :15px;
        right: 10px;
        cursor: pointer;
    }
    .login-header{
        position: relative;
    }
    .login-header::before{
        content: '';
        position: absolute;
        top: -20px;
        left: 0;
        width: 50px;
        height: 4px;
        background: #770016;
    }
    .super_admin_background{
        background-color: #770016;
    }

    .super_admin_secondary_text_color{
        color: #770016;
    }

    .admin_login_btn{
        width: 100%;
        height: auto;
        padding: 10px;
        background-color: #770016;
        border:0;
        color: #fff;
        font-weight: bolder;
        font-size: 17px;
    }

    .mobile_super_admin_login_header{
        display: none;
    }  

    .circle_height{
        height: 130px;
    }


    @media screen and (max-width: 990px) {
        .login-header{
         text-align: center;
         font-size: 15px;
        }
        .login-header::before{
            display:none;
        }
        .mobile_super_admin_login_header{
            display: block;
        }
        .mobile_super_admin_login_font_size{
            font-size: 20px;
            font-weight: bolder;
        }
    }

    a:hover{
        text-decoration: none;
    }
</style>
@endpush
@push('scripts')
<script>
    function toggleEye(e){
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
            } else {
                x.type = "password";
            }
            $(e).toggleClass('fas fa-eye-slash fas fa-eye');
    }
  
</script>  
@endpush
