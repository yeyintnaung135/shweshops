@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.order_upper_menu')

    <div class="container d-flex aligns-items-center justify-content-center card mx-auto mt-3">
        <form method="post" action="{{ url('orderform/' . $product_data->id) }}">
            @csrf
            <div class="card-body">
                <h4 class="text-center">Order Create</h4><br><br>
                <h5>Personal Details</h5>
                <br>
                <input type='hidden' value="{{ $product_data->id }}" name='product_id'>
                <div class="row">
                    <div class="form-group col-12 col-sm-6">
                        <label for="name" class="col-form-label">Name</label>
                        <input type="text" class="form-control rounded" required name="user_name"
                            value="{{ empty($order_data->user_name) ? Auth::user()->username : $order_data->user_name }}">
                    </div>
                    <div class="form-group col-12 col-sm-6">
                        <label for="phone" class="col-form-label">Phone</label>
                        <input type="text" class="form-control rounded" required required name="user_phone"
                            value="{{ empty($order_data->user_phone) ? Auth::user()->phone : $order_data->user_phone }}">
                    </div>
                    <div class="form-group col-12">
                        <label for="name" class="col-form-label">Address</label>
                        <textarea name="address" class="rounded" id="" required cols="30" rows="2">{{ empty($order_data->address) ? '' : $order_data->address }}</textarea>
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
                    <div class="col-11 col-sm-4 mt-4 mb-4">
                        <img src="{{ filedopath($product_data->check_photo) }}" alt="">
                    </div>
                    <div class="col-12 col-sm-8 mt-4 mb-4">
                        <h6>{{ $product_data->name }}</h6><br>
                        <span>Code: &nbsp;&nbsp;&nbsp;&nbsp;{{ $product_data->product_code }}</span><br>
                        <span>Shop Name: &nbsp;&nbsp;&nbsp;&nbsp;{{ $product_data->shop->shop_name }}</span><br>
                        <span>Gold quality: &nbsp;&nbsp;&nbsp;&nbsp;{{ $product_data->gold_quality }}</span><br>
                        <?php
                        $weight = json_decode($product_data->weight, true);
                        ?>
                        @if ($product_data->check_discount != 'no')
                            <?php
                            $get_dis = \App\Models\Discount::where('id', $product_data->check_discount)->first();
                            ?>
                            {{-- <h3 class="product_title entry-title yk-jello-horizontal sn-discount-badge">
                                    {{$get_dis->percent}}% <span class="sn-off-text">OFF</span></h3> --}}
                        @endif
                        @if (!empty($weight))
                            <span>Product weight: &nbsp;&nbsp;&nbsp;&nbsp;{{ $weight[0]['value'] }}
                                {{ $weight[0]['name'] }}</span><br>
                        @endif
                        @if ($product_data->check_discount != '0')
                            @if ($product_data->price != 0)
                                <span class="mprice">
                                    Price: {{ number_format($product_data->price) }}MMK
                                </span>
                            @else
                                <span class="mprice">
                                    Price:
                                    {{ number_format($product_data->min_price) }}-{{ number_format($product_data->max_price) }}
                                    MMK
                                </span>
                            @endif
                            @if ($get_dis->discount_price != 0)
                                <span class="woocommerce-Price-amount amount yk-amount"
                                    style="margin-left:0px !important;"><bdi><span
                                            class="woocommerce-Price-currencySymbol"></span>
                                        {{ number_format($get_dis->discount_price) }}MMK
                                </span>
                            @else
                                <span class="woocommerce-Price-amount amount yk-amount"
                                    style="margin-left:0px !important;"><bdi><span
                                            class="woocommerce-Price-currencySymbol"></span>
                                        {{ number_format($get_dis->discount_min) }}-{{ number_format($get_dis->discount_max) }}
                                        MMK

                                </span>
                            @endif
                            (Discount)
                        @else
                            @if ($product_data->price != 0)
                                <span class="woocommerce-Price-amount amount yk-amount"
                                    style="margin-left:0px !important;"><bdi class=""><span
                                            class="woocommerce-Price-currencySymbol"></span>
                                        Price: {{ number_format($product_data->price) }}MMK
                                </span>
                            @else
                                <span class="woocommerce-Price-amount amount yk-amount"
                                    style="margin-left:0px !important;"><bdi><span
                                            class="woocommerce-Price-currencySymbol"></span>
                                        Price:
                                        {{ number_format($product_data->min_price) }}-{{ number_format($product_data->max_price) }}MMK
                                </span>
                            @endif
                        @endif
                    </div>
                    <div class="col-12 mt-3 form-group">
                        <label for="note">မှတ်ချက်</label>
                    </div>
                    <div class="col-12 col-sm-12 form-group mt-2">
                        <textarea name="note" id="" cols="30" rows="4">{{ empty($order_data->note) ? '' : $order_data->note }}</textarea>
                    </div>
                    <div class="col-4 d-flex justify-content-between mt-2">
                        <a type="button" class="btn text-center me-1" href="{{ url()->previous() }}"
                            style="padding: 5px 25px;background:#38262638;color:white;">Cancel</a>
                        <input type="submit" class="btn text-center" value='Next'
                            style="background: #780116;color: white;padding: 5px 25px;"></input>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection()

@push('css')
@endpush
