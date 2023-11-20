@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.order_upper_menu')

<div class="d-flex aligns-items-center justify-content-center card mx-auto mt-3" style="width: 50rem;height: 47rem;">
  <div class="card-body">
        <h4 class="text-center">Review Order</h4><br><br>
        <div class="d-flex justify-content-between">
        <h5>Shipping Information</h5>
        <a href="" style="color: #780116 !important;">Edit</a>
        </div>
        <br><br>
        <div class="row">
        <h6 class="col-3">Name:</h6>
        <h6 class="col-9">Daw Mya Yamone</h6>
        </div>
        <div class="row">
        <h6 class="col-3">Phone:</h6>
        <h6 class="col-9">09887766554</h6>
        </div>
        <div class="row">
        <h6 class="col-3">Address:</h6>
        <h6 class="col-9">No(71) Sagawar Pin St,Kyee Myin Dine Tsp</h6>
        </div>
        <br><br>
        <h5>Order Summary</h5>
        <br>
        <div class="row">
            
            <div class="col-4 mt-4 mb-4">
                <img src="https://test.shweshops.com/test/img/logo-m.png"  alt="">
            </div>
            <div class="col-8 mt-4 mb-4">
                <h5>Lucky Diamond Ring</h5><br>
                <span>Code: &nbsp;&nbsp;&nbsp;&nbsp;FCCEFG</span><br>
                <span>Shop Name: &nbsp;&nbsp;&nbsp;&nbsp;Take Sein</span><br>
                <span>Gold quality: &nbsp;&nbsp;&nbsp;&nbsp;23K</span><br>
                <span>Product weight: &nbsp;&nbsp;&nbsp;&nbsp;6.59 g</span><br>
                <span>Price: &nbsp;&nbsp;&nbsp;&nbsp;2000,000 MMK</span>
            </div>
            <div class="col-12 mt-3 form-group">
            <label for="remark">မှတ်ချက်</label>
            <input type="checkbox" id="remark">
            
            </div>
            <div class="col-12 form-group mt-2">
            <textarea name="remark" id="" cols="30" rows="1"></textarea>
            </div>
            <div class="col-4 d-flex justify-content-between mt-2">
            <button type="button" style="padding: 5px 25px;">Cancel</button>
            <button type="button" class="btn text-center" style="background: #780116;color: white;padding: 5px 25px;">Place Order</button>
            </div>
        </div>
  </div>
</div>
@endsection()

@push('css')
    
@endpush