@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5 card-border">
                {{-- <div class="card-header">{{ __('Reset') }}</div> --}}

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="logo d-none" style="margin-left:280px;">
                        <img src="https://cdn-icons-png.flaticon.com/512/6783/6783360.png" alt="" width="80" height="80" class="mt-2 ml-2">
                    </div>
                    <div class="logo1 d-none" style="margin-left:100px;">
                        <img src="https://cdn-icons-png.flaticon.com/512/6783/6783360.png" alt="" width="80" height="80" class="mt-2 ml-2">
                    </div>
                    <h3 class="font-weight-bold text-center mt-3">Forgot Password?</h3>
                    <h4 class="font-weight-normal text-center">Don't Worry, You can reset your password</h4>
                        <div class="row justify-content-center">

                           <div class="col-8 mt-4">
                            <form method="POST" action="{{ route('backside.shop_owner.send_reset_code') }}">
                                @csrf

                                <div class="form-group row">
                                    {{-- <label for="email" class="col-md-4 col-form-label text-md-right">Input Your Phone Number</label> --}}

                                    <div class="col-md-12">
                                        <input id="email" type="text" class="form-control @error('emailorphone') is-invalid @enderror  border" name="emailorphone" value="{{ old('emailorphone') }}" required autocomplete="email" autofocus placeholder="Please enter phone number">

                                        @error('emailorphone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mt-5">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn_color form-control border">
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>

                            </form>
                           </div>
                        </div>
                </div>
                <a href="{{url('/backside/shop_owner/pos/login')}}" class="text-center mb-4"><u>Back</u></a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
<style>
    .btn_color{
        background-color: #780116;
        color: white;
    }
    .border{
        border:none;
        border-radius: 7px;
    }
    .logo{
        width:100px;
        height:100px;
        background-color: rgba(220, 220, 220, 0.39);
        border:none;
        border-radius: 70px;
    }
    .card-border{
        border:3px solid whitesmoke;
        border-radius: 7px;
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
            $('.logo').show();
            $('.logo').removeClass('d-none');
            $('.logo1').hide();

        }
        }, 1);
    })
</script>
@endpush
