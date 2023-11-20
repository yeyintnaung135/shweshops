@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.order_upper_menu')

<div class="d-flex aligns-items-center justify-content-center card mx-auto mt-3" style="width: 50rem;height: 59rem;">
  <div class="card-body">
        <h4 class="text-center">Order Review</h4><br><br>
        <h5>Personal Details</h5>
        <br>
        <div class="row">
            <div class="form-group col-6">
                <label for="name" class="col-form-label" >Name</label>
                <input type="text" class="form-control rounded" required name="name" value="{{Auth::user()->username}}">
            </div>
            <div class="form-group col-6">
                <label for="phone" class="col-form-label">Phone</label>
                <input type="text" class="form-control rounded" required name="phone" value="{{Auth::user()->phone}}">
            </div>
            <div class="form-group col-12">
                <label for="name" class="col-form-label">Address</label>
                <textarea name="address" class="rounded" id="" cols="30" rows="2"></textarea>
            </div>
        </div>
        <br>
        <h5>Product Infomation</h5>
        <br>
        <div class="row">
            {{-- <div class="form-group col-6">
                <label for="quality" class="col-form-label">Gold Quality</label>
                <input type="text" class="form-control rounded" name="quality">
            </div>
            <div class="form-group col-6">
                <label for="size" class="col-form-label">Product Size</label>
                <input type="text" class="form-control rounded" name="size">
            </div> --}}
            <div class="col-4 mt-4 mb-4">
                <img src="https://test.shweshops.com/test/img/logo-m.png"  alt="">
            </div>
            <div class="col-8 mt-4 mb-4">
                <h5>Lucky Diamond Ring</h5><br>
                <span>Code: &nbsp;&nbsp;&nbsp;&nbsp;{{$product_data->product_code}}</span><br>
                <span>Shop Name: &nbsp;&nbsp;&nbsp;&nbsp;{{$product_data->shop->shop_name}}</span><br>
                <span>Gold quality: &nbsp;&nbsp;&nbsp;&nbsp;{{$product_data->gold_quality}}</span><br>
                <?php
                $weight = json_decode($product_data->weight, true);
                ?>
                @if(!empty($weight))
                <span>Product weight: &nbsp;&nbsp;&nbsp;&nbsp;{{ $weight[0]['value'] }}
                    {{ $weight[0]['name'] }}</span><br>
                @endif
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
            <button type="button" class="btn text-center" style="background: #780116;color: white;padding: 5px 25px;">Next</button>
            </div>
        </div>
  </div>
</div>
@endsection()

@push('css')
    
@endpush