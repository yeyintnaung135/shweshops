@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('backside.shop_owner.send_reset_code') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Input Reset
                                    Code</label>

                                <div class="col-md-6">
                                    <input id="email" type="text"
                                           class="form-control @if(!empty($error)) is-invalid @enderror" name="code"
                                           value="@if(!empty($code)){{$code}}@endif" required autocomplete="email" autofocus>
                                    <input type="hidden" name="emailorphone" value="{{$emailorphone}}"/>
                                    @if(!empty($error))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $error }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @method('PUT')
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
