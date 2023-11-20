@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.order_upper_menu')

<div class="d-flex aligns-items-center justify-content-center card mx-auto mt-3" style="width: 50rem;height: 25rem;">
  <div class="card-body">
        <img src="{{ url('test/img/success.png') }}" style="display: block;margin-left: auto;margin-right: auto;" alt="">
        <h4 class="text-center fontweight-bold mt-4">Thank You !</h4><br>
        <h6 class="text-center">Your Order #100024 has been placed.</h6><br><br>
        <div class="center">
        <button type="button" class="btn" style="background: #780116;color: white;padding: 5px 25px;margin-top:340px;">Back</button>
        </div>
  </div>
</div>
@endsection()

@push('css')
<style>

.center {
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}
</style> 
@endpush