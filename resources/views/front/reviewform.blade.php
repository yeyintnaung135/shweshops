@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.order_upper_menu')

    <div class="container d-flex aligns-items-center justify-content-center card mx-auto mt-3">
        <div class="card-body">
            <h4 class="text-center">Review Order</h4><br><br>
            <div class="d-flex justify-content-between">
                <h5>Shipping Information</h5>
                <a href="{{ url()->previous() }}" style="color: #780116 !important;">Edit</a>
            </div>
            <br><br>
            <div class="row">
                <h6 class="col-3">Name:</h6>
                <h6 class="col-9">{{ $order_data->user_name }}</h6>
            </div>
            <div class="row">
                <h6 class="col-3">Phone:</h6>
                <h6 class="col-9">{{ $order_data->user_phone }}</h6>
            </div>
            <div class="row">
                <h6 class="col-3">Address:</h6>
                <h6 class="col-9">{{ $order_data->address }}</h6>
            </div>
            <br><br>
            <h5>Order Summary</h5>
            <br>
            <div class="row">
                @if ($product_data->check_discount != 'no')
                    <?php
                    $get_dis = \App\Models\Discount::where('id', $product_data->check_discount)->first();
                    ?>
                    {{-- <h3 class="product_title entry-title yk-jello-horizontal sn-discount-badge">
                            {{$get_dis->percent}}% <span class="sn-off-text">OFF</span></h3> --}}
                @endif
                <div class="col-12 col-sm-4 mt-4 mb-4">

                    <img src="{{ filedopath($product_data->check_photo) }}" alt="">

                </div>
                <div class="col-12 col-sm-8 mt-4 mb-4">
                    <h6>{{ $product_data->name }}</h6><br>
                    <span>Code: &nbsp;&nbsp;&nbsp;&nbsp;{{ $product_data->product_code }}</span><br>
                    <span>Shop Name: &nbsp;&nbsp;&nbsp;&nbsp;{{ $product_data->shop->shop_name }}</span><br>
                    <span>Gold quality: &nbsp;&nbsp;&nbsp;&nbsp;{{ $product_data->gold_quality }}</span><br>
                    {{-- <?php
                    $weight = json_decode($product_data->weight, true);
                    ?>
                <span>Product weight: &nbsp;&nbsp;&nbsp;&nbsp;{{{ $weight[0]['value'] }}}{{ $weight[0]['name'] }}</span><br>
               --}}

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
                                    {{ number_format($get_dis->discount_min) }}-{{ number_format($get_dis->discount_max) }}MMK

                            </span>
                        @endif
                        (Discount)
                    @else
                        @if ($product_data->price != 0)
                            <span class="woocommerce-Price-amount amount yk-amount" style="margin-left:0px !important;"><bdi
                                    class=""><span class="woocommerce-Price-currencySymbol"></span>
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
                    <label for="remark">မှတ်ချက်</label>

                </div>
                <div class="col-12 form-group mt-2">
                    {{ $order_data->note }}
                </div>
                <form action="{{ url('orderform/' . $product_data->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="col-4 d-flex justify-content-between mt-2">
                        <a href='{{ url()->previous() }}' type="button" style="padding: 5px 25px;">Cancel</a>


                        <input type="hidden" name="order_id" value="{{ $order_data->id }}">

                        <input type="submit" class="btn text-center" value="place order"
                            style="background: #780116;color: white;padding: 5px 25px;" />

                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection()

@push('css')
    <style>
        .mprice {
            text-decoration: line-through !important;
        }

        .sop-ribbon-pd span {
            width: 136px;
            height: 30px;
            top: 13px;
            right: -46px;
            position: absolute;
            display: block;
            background: #FF0000;
            color: #333;
            font-family: arial;
            font-size: 14px;
            color: white;
            text-align: center;
            line-height: 30px;
            transform: rotate(45deg);
            -webkit-transform: rotate(52deg);
        }

        .sop-ribbon-pd {
            height: 110px;
            display: block;
            position: absolute;
            overflow: hidden;
            z-index: 111;
            top: 0;
            right: 0;
        }
    </style>
@endpush
